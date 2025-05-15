<script setup>
import useAuth from '@/useAuth';
import { router, useForm } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
const { hasAnyRole } = useAuth();

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
  form.post(route('stage.submit', { stageaction: props.stage.uuid }), {
    only: ['prdoc'],
    replace: true,
    preserveState: true,
    preserveScroll: true,
  });
};

const proceed = (uuid) => {
  submitting.value = true;
  router.post(
    route('stage.proceed', {
      stageaction: uuid,
    }),
    {
      replace: true,
      preserveState: false,
      preserveScroll: true,
      onSuccess: () => {
        submitting.value = false;
      },
    },
  );
};
</script>

<template>
  <div class="position-sticky">
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
    <VCard elevation="24">
      <VCardText>
        <!-- <v-textarea
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
      /> -->

        <v-file-input
          v-if="stage.is_received && !stage.attachment"
          :readonly="stage.status == 'on hold' || stage.is_completed"
          v-model="form.attachment"
          :show-size="true"
          label="Attach File"
          variant="outlined"
          class="mb-4"
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
          v-if="hasAnyRole(['admin']) && !stage.is_completed"
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
  </div>
</template>
