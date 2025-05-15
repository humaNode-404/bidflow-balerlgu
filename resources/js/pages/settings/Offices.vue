<script setup>
import { editOfficeDialog } from '@/stores/dialogStore';
import { Deferred, useForm } from '@inertiajs/vue3';

defineProps({
  offices: Object,
});

const search = ref('');
const editDialog = editOfficeDialog();

const initialFormState = {
  id: null,
  name: '',
  abbr: '',
};

const form = useForm({ ...initialFormState });

onMounted(() => {
  if (form.id === null) {
    editDialog.closeDialog();
  }
});

const headers = [
  {
    title: 'NAME',
    key: 'name',
  },
  {
    title: 'ABBR',
    key: 'abbr',
    hidden: true,
  },
  {
    align: 'end',
    title: '',
    key: 'actions',
    sortable: false,
  },
];

const editItem = (item) => {
  Object.assign(form, { ...item });
  editDialog.openDialog();
};

const close = () => {
  Object.assign(form, { ...initialFormState });
  form.reset();
  form.clearErrors();
  editDialog.closeDialog();
};

const submitForm = (id) => {
  form.put(route('offices.update', { office: id }), {
    only: ['offices'],
    replace: true,
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      form.clearErrors();
      editDialog.closeDialog();
    },
  });
};
</script>

<template>
  <v-card>
    <v-card-title class="d-flex align-center pe-2">
      <v-icon icon="bi-buildings"></v-icon>
      <span class="ms-2"> Offices{{ offices?.length > 1 ? 's' : '' }} </span>
      <v-chip v-if="offices?.length" class="ms-2">{{ offices?.length }}</v-chip>

      <v-spacer></v-spacer>
      <NewOffice />
      <v-text-field
        class="mx-2"
        v-model="search"
        label="Search"
        prepend-inner-icon="mdi-magnify"
        variant="solo-filled"
        hide-details
        single-line
        clearable
      ></v-text-field>
    </v-card-title>

    <v-divider></v-divider>

    <Deferred data="offices">
      <template #fallback>
        <v-skeleton-loader
          type="table-thead, text, table-row-divider@3, table-tfoot"
        ></v-skeleton-loader>
      </template>

      <VDataTable
        :headers="headers.filter((header) => !header.hidden)"
        :items="offices"
        v-model:search="search"
        mobile-breakpoint="0"
        :show-current-page="true"
      >
        <!-- full name -->
        <template #item.name="{ item }">
          <VListItem :title="item.name" :subtitle="item.abbr"></VListItem>
        </template>

        <!-- Actions -->
        <template #item.actions="{ item }">
          <IconBtn @click="editItem(item)" v-tooltip:start="'Edit'">
            <VIcon icon="bx-edit" />
          </IconBtn>
        </template>
      </VDataTable>
    </Deferred>
  </v-card>

  <!-- 👉 Edit Dialog  -->
  <VDialog v-model="editDialog.isOpen" max-width="600px">
    <VCard title="Office Details">
      <VCardText>
        <VForm @submit.prevent="submitForm(form.id)" class="mt-6">
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
              <VBtn type="submit" :disabled="form.processing">
                <span v-if="form.processing">Saving</span>
                <span v-else>Save</span>
              </VBtn>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>

  <!-- 👉 Delete Dialog  -->
  <!-- <VDialog v-model="deleteDialog" max-width="500px">
    <VCard title="Are you sure you want to delete this item?">
      <VCardText>
        <div class="d-flex justify-center gap-4">
          <VBtn color="error" variant="outlined" @click="closeDelete">
            Cancel
          </VBtn>
          <VBtn color="success" variant="elevated" @click="deleteItemConfirm">
            OK
          </VBtn>
        </div>
      </VCardText>
    </VCard>
  </VDialog> -->
</template>
