<!-- eslint-disable prettier/prettier -->
<script setup>
import { createUserDialog } from '@/stores/dialogStore';
import { useForm } from '@inertiajs/vue3';

defineProps({
  offices: Object,
});

const createDialog = createUserDialog();

const initialFormState = {
  office_id: null,
  role: null,
  first_name: '',
  last_name: '',
  email: '',
};

const form = useForm({ ...initialFormState });
const close = () => {
  Object.assign(form, { ...initialFormState });
      form.clearErrors();
      createDialog.closeDialog();
};


const submitForm = () => {
  form.post(route('users.create'), {
    only: ['users'],
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
    max-width="800"
    class="user-select-none"
  >
    <template #activator="{ props }">
      <IconBtn v-bind="props" variant="tonal" color="primary"
        ><VIcon icon="bx-plus"></VIcon
      ></IconBtn>
    </template>
    <VCard title="Create New User">
      <VCardText>
        <VForm @submit.prevent="submitForm" class="mt-6">
          <VRow>
            <VCol cols="12">
              <VListItemTitle class="text-button text-capitalize">
                Access
              </VListItemTitle>
            </VCol>

            <VCol cols="12">
              <v-select
                v-model="form.office_id"
                :items="offices"
                item-title="name"
                item-value="id"
                label="Baler-LGU Offices"
                persistent-placeholder
                outlined
                :error-messages="form.errors.office_id"
              >
              </v-select>
            </VCol>

            <VCol cols="12">
              <v-select
                v-model="form.role"
                :items="['user', 'mod', 'admin']"
                persistent-placeholder
                label="User Role"
                outlined
                :error-messages="form.errors.role"
              >
              </v-select>
            </VCol>

            <VCol cols="12" class="mt-4">
              <VListItemTitle class="text-button text-capitalize">
                Account Details
              </VListItemTitle>
            </VCol>

            <!-- 👉 First Name -->
            <VCol cols="12">
              <VTextField
                clearable
                v-model="form.first_name"
                placeholder="John"
                persistent-placeholder
                label="First Name"
                :error-messages="form.errors.first_name"
              />
            </VCol>

            <!-- 👉 Last Name -->
            <VCol cols="12">
              <VTextField
                clearable
                v-model="form.last_name"
                placeholder="Doe"
                persistent-placeholder
                label="Last Name"
                :error-messages="form.errors.last_name"
              />
            </VCol>

            <!-- 👉 Email -->
            <VCol cols="12">
              <VTextField
                clearable
                v-model="form.email"
                label="Email"
                placeholder="username@gmail.com"
                persistent-placeholder
                type="email"
                :error-messages="form.errors.email"
              />
            </VCol>

            <VCol v-if="form.email && form.office_id" cols="12">
              <VAlert
                type="info"
                variant="tonal"
                icon="bx-error"
                text="Password Information"
                class="text-small mx-2 mb-4"
              >
                <p>
                  The default value uses the combination of your email and
                  office ID
                </p>
                <VTextField
                  hint="separated by undescore (_)"
                  persistent-hint
                  :placeholder="form.email + '_' + form.office_id"
                  persistent-placeholder
                  readonly
                  label="Password"
                  :model-value="form.email + '_' + form.office_id"
                />
              </VAlert>
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
