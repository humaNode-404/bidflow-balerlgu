<script setup>
import { router, useForm, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

let user = usePage().props.auth.user;
watch(usePage, () => {
  user = usePage().props.auth.user;
});

dayjs.extend(relativeTime);
const props = defineProps({
  stage: Object,
});

const submitting = ref(false);

const form = useForm({
  notes: props.stage.notes,
  attachment: null,
});

const handleFileUpload = (e) => {
  form.attachment = e.target.files[0];
};

const submitForm = () => {
  console.log(form);
  form.post(route('stage.submit', { stageaction: props.stage.uuid }), {
    only: ['stage'],
  });
};

const proceed = (uuid) => {
  submitting.value = true;
  router.post(
    route('stage.proceed', {
      stageaction: uuid,
    }),
    {},
    {
      onSuccess: () => {
        submitting.value = false;
      },
    },
  );
};
</script>

<template>
  <VRow>
    <VCol cols="12" lg="8">
      <VListItem
        :subtitle="`${stage.incharge} • ${dayjs(stage.created_at).fromNow()}`"
      >
        <template #title>
          <h5 class="text-h5">
            {{ (stage.main_proc ? `${stage.main_proc}: ` : '') + stage.proc }}
          </h5>
        </template>
      </VListItem>

      <VDivider class="mx-2 mb-5" />

      <v-row>
        <v-col cols="12" class="mt-5">
          <v-textarea
            v-if="stage.is_received"
            :readonly="stage.status == 'on hold' || stage.is_completed"
            v-model="form.notes"
            label="Notes"
            :placeholder="
              stage.status == 'on hold'
                ? 'Nothing to show'
                : 'Write your notes here...'
            "
            persistent-placeholder
            :error-messages="form.errors.notes"
            counter
            auto-grow
            rows="2"
            outlined
          />
        </v-col>
      </v-row>
    </VCol>

    <VCol cols="12" lg="4">
      <VCard elevation="24">
        <VCardText>
          <v-file-input
            v-if="stage.is_received && !stage.attachment"
            :readonly="stage.status == 'on hold' || stage.is_completed"
            v-model="form.attachment"
            :show-size="1000"
            label="Attach File"
            variant="outlined"
            class="mb-4"
            counter
            :error-messages="form.errors.attachment"
            @change="handleFileUpload"
          >
            <template v-slot:selection="{ fileNames }">
              <template v-for="(fileName, index) in fileNames" :key="fileName">
                <v-chip
                  v-if="index < 2"
                  class="me-2"
                  color="info"
                  size="small"
                  label
                >
                  {{ fileName }}
                </v-chip>
              </template>
            </template>
          </v-file-input>

          <VBtn
            v-if="!stage.is_received"
            class="mb-3"
            variant="flat"
            block
            @click="
              router.post(
                route('stage.received', {
                  stageaction: stage.uuid,
                }),
              )
            "
          >
            Documents Received
          </VBtn>

          <VBtn
            v-if="
              stage.is_received &&
              stage.status != 'on hold' &&
              !stage.is_completed
            "
            class="mb-3"
            variant="flat"
            block
            @click="submitForm"
          >
            Submit
          </VBtn>

          <VBtn
            v-if="user.role == 'admin' && !stage.is_completed"
            class="mb-3"
            variant="flat"
            :color="stage.is_completed ? 'success' : 'primary'"
            :disabled="submitting"
            block
            @click="proceed(stage.uuid)"
          >
            Mark as Done
          </VBtn>

          <VBtn
            v-if="stage.is_completed"
            class="mb-3"
            variant="flat"
            color="success"
            block
          >
            Completed
          </VBtn>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
