<script setup>
import { router, useForm } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);
const props = defineProps({
  prdoc: Object,
  prModes: Object,
});

const initialFormState = {
  value: props.prdoc.value,
  mode: props.prdoc.mode,
  desc: props.prdoc.desc,
  purpose: props.prdoc.purpose,
  event_need: props.prdoc.event_need,
  event_loc: props.prdoc.event_loc,
};

const readonly = ref(true);
const agreed = ref(false);
const form = useForm({ ...initialFormState });

const edit = () => {
  if (!readonly.value) {
    form.reset();
    form.clearErrors();
    readonly.value = true;
  } else {
    agreed.value = false;
    readonly.value = false;
  }
};

const submit = () => {
  form.put(route('prdocs.update', { prdoc: props.prdoc.number }), {
    only: ['prdoc'],
    replace: true,
    preserveState: true,
    onSuccess: () => {
      // form.reset();
      // form.clearErrors();
      // agreed.value = false;
      // readonly.value = false;
    },
  });
};

function markAsFailed() {
  router.delete(route('prdocs.destroy', { prdoc: props.prdoc.number }), {
    only: ['prdoc'],
    replace: true,
    preserveState: false,
    onSuccess: () => {
      form.reset();
      form.clearErrors();
      agreed.value = false;
      readonly.value = false;
    },
  });
}
</script>

<template>
  <VCardText>
    <VForm @submit.prevent="submit" validate-on="lazy">
      <v-row>
        <!-- PR Value -->
        <v-col cols="12" md="6">
          <v-text-field
            :readonly="readonly"
            v-model="form.value"
            label="PR Value"
            placeholder="1234.56"
            persistent-placeholder
            prefix="₱"
            :error-messages="form.errors.value"
            outlined
          />
        </v-col>
        <!-- PR Mode -->
        <v-col cols="12" md="6">
          <V-Select
            :readonly="readonly"
            v-model="form.mode"
            :items="prModes"
            item-text="mode"
            item-value="mode"
            prepend-icon="mdi-gavel"
            placeholder="PR Mode"
            persistent-placeholder
            :error-messages="form.errors.mode"
          />
        </v-col>
      </v-row>

      <v-row>
        <!-- PR Desc -->
        <v-col cols="12">
          <v-textarea
            :clearable="!readonly"
            :readonly="readonly"
            v-model="form.desc"
            label="Description"
            placeholder="Brief description of the PR."
            persistent-placeholder
            counter
            auto-grow
            rows="1"
            :error-messages="form.errors.desc"
            outlined
          />
        </v-col>

        <!-- PR Purpose -->
        <v-col cols="12">
          <v-textarea
            :clearable="!readonly"
            :readonly="readonly"
            v-model="form.purpose"
            label="Purpose"
            placeholder="The purpose or reason for the request."
            persistent-placeholder
            counter
            auto-grow
            rows="2"
            :error-messages="form.errors.purpose"
            outlined
          />
        </v-col>
      </v-row>

      <v-row justify="space-around">
        <v-col cols="12" md="6">
          <!-- PR Event Need -->
          <v-text-field
            :readonly="readonly"
            v-model="form.event_need"
            label="Event Date"
            placeholder="Target date to have the request."
            persistent-placeholder
            :error-messages="form.errors.event_need"
            outlined
          />
        </v-col>

        <v-col cols="12" md="6">
          <!-- PR Event Location -->
          <v-text-field
            :readonly="readonly"
            v-model="form.event_loc"
            label="Event Location"
            placeholder="Location of the event."
            persistent-placeholder
            :error-messages="form.errors.event_loc"
            outlined
          />
        </v-col>

        <VContainer v-if="prdoc.can_update">
          <VDivider></VDivider>
          <v-col v-if="!readonly" cols="12">
            <v-checkbox
              :readonly="readonly"
              v-model="agreed"
              label="I understand that this action cannot be undone."
            />
          </v-col>
          <v-col v-if="!readonly" cols="12" class="pt-0">
            <VBtn color="error" :disabled="!agreed" @click="markAsFailed">
              Mark as failed
            </VBtn>
          </v-col>

          <VCol cols="12" class="d-flex flex-wrap gap-4">
            <v-spacer></v-spacer>

            <VBtn color="primary" variant="tonal" @click="edit">
              <span v-if="!readonly">Cancel</span>
              <span v-else> Edit</span>
            </VBtn>
            <VBtn
              v-if="form.isDirty"
              color="secondary"
              variant="tonal"
              type="reset"
              @click.prevent="
                () => {
                  form.reset();
                  form.clearErrors();
                }
              "
            >
              Reset
            </VBtn>

            <VBtn
              v-if="form.isDirty"
              type="submit"
              :disabled="form.processing || !form.isDirty"
            >
              <span v-if="form.isDirty">Save changes</span>
              <span v-else-if="form.processing">
                <v-progress-circular indeterminate />
                &nbsp; Saving
              </span>
              <span v-else-if="form.recentlySuccessful">Saved</span>
              <span v-else> Save</span>
            </VBtn>
          </VCol>
        </VContainer>
      </v-row>
    </VForm>
  </VCardText>
</template>
