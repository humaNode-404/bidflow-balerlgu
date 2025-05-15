<script setup>
import { Deferred, router } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { ref } from 'vue';

dayjs.extend(relativeTime);

defineProps({
  backup: Object,
  output: String,
});

const search = ref('');
const headers = [
  {
    align: 'start',
    key: 'name',
    title: 'File Name ',
  },

  { key: 'created_at', title: 'Date' },
  {
    align: 'end',
    title: '',
    key: 'actions',
    sortable: false,
  },
];

const msg = {
  title: {
    run: 'Backup Taking',
    clean: 'Backup Cleanup',
  },
  text: {
    run: 'This will run full backups which contains files or databases. Do you want to continue?',
    clean:
      'This will permanently delete old backup files based on your cleanup settings. Do you want to continue?',
  },
};

const dialog = reactive({
  title: '',
  text: '',
  open: false,
  resolve: null,
  reject: null,

  async confirm(title, text) {
    this.title = title;
    this.text = text;
    this.open = true;

    return new Promise((resolve, reject) => {
      this.resolve = resolve;
      this.reject = reject;
    });
  },

  continue() {
    this.open = false;
    if (this.resolve) this.resolve(true);
  },

  cancel() {
    this.open = false;
    if (this.reject) this.reject(false);
  },
});
let objReq = {
  data: Object,
  onProgress: false,
  onSuccess: false,
  onError: false,
  controller: new AbortController(),
};

const runReq = reactive({ ...objReq });

const cleanReq = reactive({ ...objReq });

const run = async () => {
  try {
    const confirmed = await dialog.confirm(msg.title.run, msg.text.run);

    if (!confirmed) return;
    reqReset();
    runReq.onProgress = true;

    await window.axios
      .post(route('backup.run'), {
        signal: runReq.controller.signal,
      })
      .then(function (response) {
        runReq.data = response.data;
        runReq.onSuccess = true;
        router.reload();
      })
      .catch(function (error) {
        if (error.response) {
          if (error.response.status === 429) {
            runReq.data = {
              output: error.response.data.message.concat(
                '\r\nDaily backup limit reach',
              ),
            };
            runReq.onSuccess = true;
          } else {
            runReq.data = { output: error.response.data.message };
            runReq.onSuccess = true;
          }
        } else {
          runReq.data = { output: 'Something went wrong' };
          runReq.onSuccess = true;
        }
      });
  } catch (e) {
    console.log('User cancelled Backup Taking operation.');
  }
};

const clean = async () => {
  try {
    const confirmed = await dialog.confirm(msg.title.clean, msg.text.clean);

    if (!confirmed) return;
    reqReset();
    cleanReq.onProgress = true;

    await window.axios
      .post(route('backup.clean'), {
        signal: cleanReq.controller.signal,
      })
      .then(function (response) {
        cleanReq.data = response.data;
        cleanReq.onSuccess = true;
        router.reload();
      })
      .catch(function (error) {
        if (error.response) {
          cleanReq.data = { output: error.response.data.message };
          cleanReq.onSuccess = true;
        } else {
          cleanReq.data = { output: 'Something went wrong' };
          cleanReq.onSuccess = true;
        }
      });
  } catch (e) {
    console.log('User cancelled Backup Cleanup operation.');
  }
};

const reqReset = () => {
  Object.assign(runReq, { ...objReq });
  Object.assign(cleanReq, { ...objReq });
};
</script>

<template>
  <v-card>
    <v-card-title class="d-flex align-center pe-2">
      <v-icon icon="mdi-cloud-cog-outline"></v-icon>
      <span class="ms-2"> Backup{{ backup?.length > 1 ? 's' : '' }} </span>
      <v-chip v-if="backup?.length" class="ms-2">{{ backup?.length }}</v-chip>

      <v-spacer></v-spacer>
      <IconBtn @click="run" v-tooltip:bottom="'Add Backup'">
        <VIcon color="info" icon="mdi-cloud-plus-outline"> </VIcon>
      </IconBtn>
      <IconBtn @click="clean" v-tooltip:bottom="'Clean'">
        <VIcon color="warning" icon="bx-brush"> </VIcon>
      </IconBtn>

      <v-dialog v-model="dialog.open" max-width="500">
        <v-card :title="dialog.title">
          <v-card-text>
            {{ dialog.text }}
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="reset"
              text="Dismiss"
              @click="dialog.cancel()"
            ></v-btn>
            <v-btn text="Continue" @click="dialog.continue()"></v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-text-field
        class="ms-2"
        v-model="search"
        label="Search"
        prepend-inner-icon="mdi-magnify"
        variant="outlined"
        hide-details
        single-line
      ></v-text-field>
    </v-card-title>

    <v-card-text class="pb-0 pt-2">
      <Deferred data="output">
        <template #fallback>
          <v-skeleton-loader type="list-item-two-line"> </v-skeleton-loader>
        </template>

        <v-alert
          style="min-inline-size: 356px"
          class="overflow-x-auto"
          color="info"
          variant="tonal"
          closable
        >
          <template v-slot:text>
            <pre>{{ output }} </pre>
          </template>
        </v-alert>
      </Deferred>
      <TransitionGroup name="list-move">
        <v-alert
          key="cleanReq"
          v-model="cleanReq.onProgress"
          variant="tonal"
          title="Logs"
          style="min-inline-size: 356px"
          class="mt-2 overflow-x-auto"
          closable
        >
          <template v-slot:text>
            <pre
              >{{
                cleanReq.data.output
                  ? cleanReq.data.output
                  : 'Starting cleanup...'
              }} </pre
            >
          </template>
          <v-progress-linear
            v-if="!cleanReq.onSuccess"
            color="warning"
            class="mt-2"
            indeterminate
          />
        </v-alert>

        <v-alert
          key="runReq"
          v-model="runReq.onProgress"
          variant="tonal"
          title="Logs"
          closable
          style="min-inline-size: 356px"
          class="mt-2"
        >
          <template v-slot:text>
            <pre>{{
              runReq.data.output ? runReq.data.output : 'Starting backup...'
            }}</pre>
          </template>
          <v-progress-linear
            v-if="!runReq.onSuccess"
            color="info"
            class="mt-2"
            indeterminate
          />
        </v-alert>
      </TransitionGroup>
    </v-card-text>

    <Deferred data="backup">
      <template #fallback>
        <v-skeleton-loader
          type="table-thead, text, table-row-divider@3, table-tfoot"
        ></v-skeleton-loader>
      </template>

      <v-data-table
        :headers="headers"
        :items="backup"
        :search="search"
        hide-default-footer
        mobile-breakpoint="0"
      >
        <!-- Actions -->
        <template #item.name="{ item }">
          <div class="d-flex gap-1">
            <v-list-item :title="item.name">
              <template v-slot:prepend>
                <VAvatar
                  color="primary"
                  icon="mdi-folder-zip-outline"
                ></VAvatar>
              </template>
              <template v-slot:subtitle>
                <span class="text-caption"
                  >{{ item.size }} •
                  {{ dayjs(item.created_at).format('D MMM, YY') }}</span
                >
              </template>
            </v-list-item>
          </div>
        </template>
        <template #item.actions="{ item }">
          <IconBtn
            :href="route('backup.download', item.name)"
            v-tooltip:start="'Download'"
            variant="tonal"
            color="primary"
          >
            <VIcon icon="mdi-cloud-download-outline"> </VIcon>
          </IconBtn>
        </template>
      </v-data-table>
    </Deferred>
  </v-card>
</template>

<style lang="scss" scoped>
pre {
  overflow-x: auto;
}

.list-move,
/* apply transition to moving elements */
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

/* ensure leaving items are taken out of layout flow so that moving
   animations can be calculated correctly. */
.list-leave-active {
  position: absolute;
}
</style>
}}
