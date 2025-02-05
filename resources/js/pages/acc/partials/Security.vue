<!-- eslint-disable vue/valid-v-slot -->
<script setup>
import { useForm } from '@inertiajs/vue3';

const isCurrentPasswordVisible = ref(false);
const isNewPasswordVisible = ref(false);
const isConfirmPasswordVisible = ref(false);

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
});

const passwordRequirements = [
  'The password must be at least 8 characters.',
  'The password must contain at least one uppercase letter.',
  'The password must contain at least one lowercase letter.',
  'The password must contain at least one numeric digit.',
  'The password must contain at least one special character (e.g., @, #, !, $, etc.).',
];

const recentDevicesHeaders = [
  {
    title: 'BROWSER',
    key: 'browser',
  },
  {
    title: 'DEVICE',
    key: 'device',
  },
  {
    title: 'LOCATION',
    key: 'location',
  },
  {
    title: 'RECENT ACTIVITY',
    key: 'recentActivity',
  },
];

const recentDevices = [
  {
    browser: 'Chrome on Windows',
    device: 'HP Spectre 360',
    location: 'New York, NY',
    recentActivity: '28 Apr 2022, 18:20',
    deviceIcon: {
      icon: 'bxl-windows',
      color: 'primary',
    },
  },
  {
    browser: 'Chrome on iPhone',
    device: 'iPhone 12x',
    location: 'Los Angeles, CA',
    recentActivity: '20 Apr 2022, 10:20',
    deviceIcon: {
      icon: 'bx-mobile',
      color: 'error',
    },
  },
  {
    browser: 'Chrome on Android',
    device: 'Oneplus 9 Pro',
    location: 'San Francisco, CA',
    recentActivity: '16 Apr 2022, 04:20',
    deviceIcon: {
      icon: 'bxl-android',
      color: 'success',
    },
  },
  {
    browser: 'Chrome on macOS',
    device: 'Apple iMac',
    location: 'New York, NY',
    recentActivity: '28 Apr 2022, 18:20',
    deviceIcon: {
      icon: 'bxl-apple',
      color: 'secondary',
    },
  },
  {
    browser: 'Chrome on Windows',
    device: 'HP Spectre 360',
    location: 'Los Angeles, CA',
    recentActivity: '20 Apr 2022, 10:20',
    deviceIcon: {
      icon: 'bxl-windows',
      color: 'primary',
    },
  },
  {
    browser: 'Chrome on Android',
    device: 'Oneplus 9 Pro',
    location: 'San Francisco, CA',
    recentActivity: '16 Apr 2022, 04:20',
    deviceIcon: {
      icon: 'bxl-android',
      color: 'success',
    },
  },
];

const submitForm = () => {
  form.post(route('updatePassword'), {
    only: ['acc'],
    preserveState: true,
    preserveScroll: true,
    replace: true,
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <VRow>
    <!-- SECTION: Change Password -->
    <VCol cols="12">
      <VCard title="Change Password">
        <VForm @submit.prevent="submitForm">
          <VCardText>
            <!-- 👉 Current Password -->
            <VRow>
              <!-- 👉 Password Requirements -->
              <!--
              <VCol cols="12" md="6">
                <p class="font-weight-medium text-base">
                  Password Requirements:
                </p>

                <ul class="d-flex flex-column gap-y-3">
                  <li
                    v-for="item in passwordRequirements"
                    :key="item"
                    class="d-flex text-body-2"
                  >
                    <div>
                      <VIcon size="7" icon="bxs-circle" class="me-3" />
                    </div>
                    <span class="font-weight-medium">{{ item }}</span>
                  </li>
                </ul>
              </VCol>-->

              <VCol cols="12" md="6">
                <!-- 👉 current password -->
                <VTextField
                  class="mb-4"
                  v-model="form.current_password"
                  :type="isCurrentPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="
                    isCurrentPasswordVisible ? 'bx-hide' : 'bx-show'
                  "
                  label="Current Password"
                  placeholder="············"
                  @click:append-inner="
                    isCurrentPasswordVisible = !isCurrentPasswordVisible
                  "
                  :error-messages="form.errors.current_password"
                />

                <!-- 👉 new password -->
                <VTextField
                  class="mb-4"
                  v-model="form.password"
                  :type="isNewPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="
                    isNewPasswordVisible ? 'bx-hide' : 'bx-show'
                  "
                  label="New Password"
                  autocomplete="on"
                  placeholder="············"
                  @click:append-inner="
                    isNewPasswordVisible = !isNewPasswordVisible
                  "
                  :error-messages="form.errors.password"
                />

                <!-- 👉 confirm password -->
                <VTextField
                  v-model="form.password_confirmation"
                  :type="isConfirmPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="
                    isConfirmPasswordVisible ? 'bx-hide' : 'bx-show'
                  "
                  label="Confirm New Password"
                  placeholder="············"
                  @click:append-inner="
                    isConfirmPasswordVisible = !isConfirmPasswordVisible
                  "
                  :error-messages="form.errors.password_confirmation"
                />
              </VCol>
            </VRow>
          </VCardText>

          <!-- 👉 Form Actions -->
          <VCol cols="12" class="d-flex mt-5 flex-wrap gap-4">
            <VBtn type="submit" :disabled="form.processing || !form.isDirty">
              <span v-if="form.isDirty">Save changes</span>
              <span v-else-if="form.processing">
                <v-progress-circular indeterminate />
                &nbsp; Saving
              </span>
              <span v-else-if="form.recentlySuccessful">Saved</span>
              <span v-else> Save</span>
            </VBtn>

            <VBtn
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
          </VCol>
        </VForm>
      </VCard>
    </VCol>
    <!-- !SECTION -->

    <!-- SECTION Recent Devices -->
    <VCol v-if="false" cols="12">
      <!-- 👉 Table -->
      <VCard title="Recent Devices">
        <VDataTable
          :headers="recentDevicesHeaders"
          :items="recentDevices"
          class="text-no-wrap rounded-0 text-sm"
        >
          <template #item.browser="{ item }">
            <div class="d-flex">
              <VIcon
                start
                :icon="item.deviceIcon.icon"
                :color="item.deviceIcon.color"
              />
              <span class="text-high-emphasis text-base">
                {{ item.browser }}
              </span>
            </div>
          </template>
        </VDataTable>
      </VCard>
    </VCol>
    <!-- !SECTION -->
  </VRow>
</template>
