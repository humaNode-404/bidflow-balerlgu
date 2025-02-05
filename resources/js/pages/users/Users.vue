<script setup>
import { editUserDialog } from '@/stores/dialogStore';
import { useForm } from '@inertiajs/vue3';
import NewUser from './partials/NewUser.vue';

defineProps({
  offices: Object,
  users: Object,
});

const search = ref('');
const editDialog = editUserDialog();

const initialFormState = {
  id: null,
  first_name: '',
  middle_name: '',
  last_name: '',
  email: '',
  office_id: null,
  phone: '',
  address: '',
};

const form = useForm({ ...initialFormState });

onMounted(() => {
  if (form.id === null) {
    editDialog.closeDialog();
  }
});

const filter = reactive({
  model: null,
  list: ['All User', 'Active Status', 'Verified Status'],
  groupBy: [],
});

const headers = [
  {
    title: 'STATUS',
    key: 'status',
    hidden: true,
  },
  {
    title: 'VERIFIED STATUS',
    key: 'verified_status',
    hidden: true,
  },
  {
    title: 'NAME',
    key: 'name',
  },
  {
    title: 'OFFICE',
    key: 'office_id',
  },
  {
    title: 'EMAIL',
    key: 'email',
  },
  {
    title: 'ROLE',
    key: 'role',
  },
  {
    title: 'ACTIONS',
    key: 'actions',
    sortable: false,
  },
];

filter.groupBy = computed(() => {
  switch (filter.model) {
    case 'Active Status':
      return [{ key: 'status' }];
    case 'Verified Status':
      return [{ key: 'verified_status' }];
    default:
      return [];
  }
});

const resolveStatusVariant = (role) => {
  if (role === 'admin')
    return {
      color: 'primary',
      text: 'Admin',
    };
  else if (role === 'mod')
    return {
      color: 'info',
      text: 'Moderator',
    };
  else if (role === 'user')
    return {
      color: 'warning',
      text: 'User',
    };
  else
    return {
      color: 'warning',
      text: 'User',
    };
};

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

const submitForm = () => {
  form.post(route('users.update'), {
    only: ['users'],
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

const toggleActive = () => {
  form.post(route('users.delete'), {
    only: ['users'],
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

const getIcon = (props) => {
  return props.icon || null; // Return null if no icon is present
};
</script>

<template>
  <v-card>
    <v-card-title class="d-flex align-center pe-2">
      <v-icon icon="bi-people"></v-icon> &nbsp; Users ({{ users.length }})

      <v-spacer></v-spacer>
      <NewUser :offices="offices" />
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

    <v-card-text>
      <V-Select
        clearable
        v-model="filter.model"
        :items="filter.list"
        prepend-inner-icon="mdi-format-list-group"
        label="Group by"
        placeholder="All User"
        persistent-placeholder
      />
    </v-card-text>

    <v-divider></v-divider>

    <!-- 👉 Datatable  -->
    <VDataTable
      :headers="headers.filter((header) => !header.hidden)"
      :group-by="filter.groupBy"
      :items="users"
      :items-per-page="20"
      v-model:search="search"
      mobile-breakpoint="0"
    >
      <template #data-table-group="{ props, item, count }">
        <td>
          <VBtn v-bind="props" variant="text" density="comfortable">
            <VIcon class="flip-in-rtl" :icon="getIcon(props)" />
          </VBtn>

          <span class="text-capitalize">{{ item.value }}</span>
          <span>({{ count }})</span>
        </td>
      </template>
      <!-- full name -->
      <template #item.name="{ item }">
        <div class="d-flex align-center">
          <!-- avatar -->
          <VBadge
            dot
            location="bottom right"
            offset-x="3"
            offset-y="3"
            :color="item.status == 'active' ? 'success' : 'error'"
            bordered
            class="me-2"
          >
            <VAvatar
              size="32"
              :color="item.avatar ? '' : 'primary'"
              :class="item.avatar ? '' : 'v-avatar-light-bg primary--text'"
              :variant="!item.avatar ? 'tonal' : undefined"
            >
              <VImg v-if="item.avatar" :src="`/storage/${item.avatar}`" />
              <span v-else class="initialism">{{
                `${item.name.split(' ').at(0)[0]}${item.name.split(' ').at(-1)[0]}`
              }}</span>
            </VAvatar>
          </VBadge>

          <div class="d-flex flex-column ms-3">
            <span
              class="d-block font-weight-medium text-high-emphasis text-truncate"
              >{{ item.name }}</span
            >
          </div>
        </div>
      </template>

      <template #item.office_id="{ item }">
        <VChip class="cursor-help" size="small" variant="text">
          {{ offices[item.office_id - 1].abbr }}
          <span class="text-caption"> &nbsp; id: {{ item.office_id }}</span>
          <VTooltip location="bottom" activator="parent" open-delay="250">
            <span class="text-capitalize">{{
              offices[item.office_id - 1].name
            }}</span>
          </VTooltip>
        </VChip>
      </template>

      <!-- email -->
      <template #item.email="{ item }">
        <div class="text-truncate" style="max-inline-size: 220px">
          <VIcon
            :icon="
              item.email_verified_at ? 'bi-patch-check' : 'bi-patch-exclamation'
            "
            :color="item.email_verified_at ? 'primary' : 'error'"
            size="small"
            class="me-1"
            v-tooltip:bottom="
              item.email_verified_at ? 'Verified User' : 'Not Verified User'
            "
          />
          <span v-tooltip="item.email">{{ item.email }}</span>
        </div>
      </template>

      <!-- role -->
      <template #item.role="{ item }">
        <VChip :color="resolveStatusVariant(item.role).color" size="small">
          {{ resolveStatusVariant(item.role).text }}
        </VChip>
      </template>

      <!-- Actions -->
      <template #item.actions="{ item }">
        <div class="d-flex gap-1">
          <IconBtn @click="editItem(item)">
            <VIcon icon="bx-edit" />
          </IconBtn>
        </div>
      </template>
    </VDataTable>
  </v-card>

  <!-- 👉 Edit Dialog  -->
  <VDialog v-model="editDialog.isOpen" max-width="600px">
    <VCard title="Edit User">
      <VCardText>
        <VListItem class="mb-4">
          <template #prepend>
            <VBadge
              dot
              location="bottom right"
              offset-x="3"
              offset-y="3"
              :color="form.status == 'active' ? 'success' : 'error'"
              bordered
              class="me-2"
            >
              <VAvatar
                size="32"
                :color="form.avatar ? '' : 'primary'"
                :class="form.avatar ? '' : 'v-avatar-light-bg primary--text'"
                :variant="!form.avatar ? 'tonal' : undefined"
              >
                <VImg v-if="form.avatar" :src="`/storage/${form.avatar}`" />
                <span v-else class="initialism">{{
                  `${form.first_name.at(0)}${form.last_name.at(0)}`
                }}</span>
              </VAvatar>
            </VBadge>
          </template>

          <VListItemTitle class="text-button text-capitalize text-wrap">
            {{ form.name }}
          </VListItemTitle>
          <VListItemSubtitle>
            <VIcon
              :icon="
                form.email_verified_at
                  ? 'bi-patch-check'
                  : 'bi-patch-exclamation'
              "
              :color="form.email_verified_at ? 'primary' : 'error'"
              size="small"
              class="me-1"
              v-tooltip:bottom="
                form.email_verified_at ? 'Verified User' : 'Not Verified User'
              "
            />
            <VChip :color="resolveStatusVariant(form.role).color" size="small">
              {{ resolveStatusVariant(form.role).text }}
            </VChip>
            • {{ form.email }}
          </VListItemSubtitle>
        </VListItem>
        <VForm @submit.prevent="submitForm" class="mt-6">
          <VRow>
            <VCol cols="12">
              <VListItemTitle class="text-button text-capitalize">
                Account Details
              </VListItemTitle>
            </VCol>

            <!-- 👉 First Name -->
            <VCol md="4" sm="6" cols="12">
              <VTextField
                clearable
                v-model="form.first_name"
                placeholder="John"
                label="First Name"
                :error-messages="form.errors.first_name"
              />
            </VCol>

            <!-- 👉 Middle Name -->
            <VCol md="4" sm="6" cols="12">
              <VTextField
                clearable
                v-model="form.middle_name"
                placeholder="Doe"
                label="Middle Name"
                :error-messages="form.errors.middle_name"
              />
            </VCol>

            <!-- 👉 Last Name -->
            <VCol md="4" sm="6" cols="12">
              <VTextField
                clearable
                v-model="form.last_name"
                placeholder="Doe"
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
                type="email"
                :error-messages="form.errors.email"
              />
            </VCol>

            <VCol cols="12">
              <v-select
                v-model="form.office_id"
                :items="offices"
                item-title="name"
                item-value="id"
                label="Baler-LGU Offices"
                outlined
                :error-messages="form.errors.office_id"
              >
              </v-select>
            </VCol>

            <VCol class="mt-5" cols="12">
              <VListItemTitle class="text-button text-capitalize">
                Contact Information
              </VListItemTitle>
            </VCol>

            <!-- 👉 Phone -->
            <VCol cols="12">
              <VTextField
                clearable
                v-model="form.phone"
                label="Phone Number"
                hint="format: 09 #### ### #### (ignore white space)"
                :error-messages="form.errors.phone"
              />
            </VCol>

            <!-- 👉 Address -->
            <VCol cols="12">
              <VTextField
                clearable
                v-model="form.address"
                label="Address"
                placeholder="123 Main St, Baler, Aurora"
                :error-messages="form.errors.address"
              />
            </VCol>

            <VCol class="mt-5" cols="12">
              <VListItemTitle class="text-button text-capitalize">
                Account
                {{ form.status != 'active' ? 'Reactivation' : 'Deactivation' }}
              </VListItemTitle>
              <VCol cols="12">
                <VAlert
                  type="warning"
                  variant="tonal"
                  icon="bx-error"
                  text="This feature lets you temporarily disable or reactivate accounts without permanently deleting them, keeping all data safe."
                  class="text-small"
                />
              </VCol>
              <VBtn
                :color="form.status == 'active' ? 'error' : 'info'"
                class="mt-2"
                variant="outlined"
                @click="toggleActive"
              >
                {{ form.status != 'active' ? 'Reactivate' : 'Deactivate' }}
              </VBtn>
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
