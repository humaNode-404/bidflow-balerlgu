<!-- eslint-disable prettier/prettier -->
<script setup>
import { createOfficeDialog } from '@/stores/dialogStore';
import { useForm } from '@inertiajs/vue3';


const createDialog = createOfficeDialog();

const initialFormState = {
  id: null,
  name: '',
  abbr: '',
};

const form = useForm({ ...initialFormState });
const close = () => {
  Object.assign(form, { ...initialFormState });
      form.clearErrors();
      createDialog.closeDialog();
};


const submitForm = () => {
  form.post(route('offices.store'), {
    only: ['offices'],
    replace: true,
    onSuccess: () => {
      form.reset();
      form.clearErrors();
      createDialog.closeDialog();
    },
  });
};

</script>

<template>
  <VDialog
    overflow="hidden"
    persistent
    v-model="createDialog.isOpen"
    max-width="500"
    class="user-select-none"
  >
    <template #activator="{ props }">
      <IconBtn v-bind="props" variant="tonal" color="primary"
        ><VIcon icon="bx-plus"></VIcon
      ></IconBtn>
    </template>
    <VCard title="Create New Office">
      <VCardText>
        <VForm @submit.prevent="submitForm" class="mt-4">
          <VRow>
            <VCol cols="12">
              <VTextField
                counter
                clearable
                v-model="form.name"
                placeholder="My Office"
                label="Office Name"
                :error-messages="form.errors.name"
              />
            </VCol>

            <VCol cols="12">
              <VTextField
                counter
                clearable
                v-model="form.abbr"
                placeholder="MO"
                label="Office Abbreviation"
                :error-messages="form.errors.abbr"
              />
            </VCol>

            <!-- 👉 Form Actions -->
            <VCol cols="12" class="self-align-end d-flex justify-end gap-4">
              <VBtn color="error" variant="outlined" @click="close">
                Cancel
              </VBtn>
              <VBtn
                type="submit"
                :disabled="form.processing || !form.isDirty"
                color="success"
                variant="elevated"
              >
                Create
              </VBtn>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>
</template>
