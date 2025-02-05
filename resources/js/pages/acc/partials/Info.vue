<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
  acc: Object,
  can: Object,
  offices: Array,
});

const page = usePage().props;
let user = page.auth.user;

watch(usePage, () => {
  user = usePage().props.auth.user;
});

const form = useForm({
  avatar: props.acc.avatar,
  first_name: props.acc.first_name,
  middle_name: props.acc.middle_name,
  last_name: props.acc.last_name,
  email: props.acc.email,
  office_id: props.acc.office_id,
  phone: props.acc.phone,
  address: props.acc.address,
});

const refInputEl = ref(null);
const fileMsg = reactive({
  value: 'File size exceeds 3MB or invalid file type.',
  visible: false,
});
const avatarPreview = ref('/storage/' + form.avatar);
let initialAvatar = '';

onMounted(() => {
  initialAvatar = '/storage/' + form.avatar;
});

function changeAvatar(event) {
  const file = event.target.files[0];
  if (file && file.size <= 3 * 1024 * 1024) {
    const reader = new FileReader();
    reader.onload = (e) => {
      avatarPreview.value = e.target.result;
    };
    reader.readAsDataURL(file);

    // Store the file in form (for uploading to server)
    form.avatar = file;
  } else {
    fileMsg.visible = true;
    setTimeout(() => {
      fileMsg.visible = false;
    }, 5000);
  }
}

function resetAvatar() {
  //form.avatar = initialAvatar; // Restore the initial avatar value
  avatarPreview.value = initialAvatar; // Clear the preview
  if (refInputEl.value) refInputEl.value.value = ''; // Clear the file input
}
const submitForm = () => {
  form.post(route('updateInfo'), {
    only: ['acc'],
    preserveState: true,
    preserveScroll: true,
    replace: true,
  });
};
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Account Details">
        <VCardText class="d-flex">
          <!-- 👉 Avatar -->
          <VAvatar
            rounded="lg"
            size="200"
            class="me-6"
            :image="avatarPreview"
          />

          <!-- 👉 Upload Photo -->
          <form
            class="d-flex flex-column justify-center gap-5"
            @submit.prevent="submitForm"
          >
            <div class="d-flex flex-wrap gap-2">
              <VBtn color="primary" @click="refInputEl?.click()">
                <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                <span class="d-none d-sm-block">Upload new photo</span>
              </VBtn>

              <input
                ref="refInputEl"
                type="file"
                name="file"
                accept=".jpeg,.png,.jpg,.gif"
                hidden
                @input="changeAvatar"
              />

              <VBtn
                type="reset"
                color="error"
                variant="tonal"
                @click="resetAvatar"
              >
                <span class="d-none d-sm-block">Reset</span>
                <VIcon icon="bx-refresh" class="d-sm-none" />
              </VBtn>
            </div>

            <p v-if="fileMsg.visible" class="text-body-2 text-error mb-0">
              {{ fileMsg.value }}
            </p>
            <p v-else class="text-body-2 mb-0">
              Allowed JPG, GIF, or PNG. Max size of 3MB.
            </p>
          </form>
        </VCardText>

        <VDivider />

        <VCardText class="pt-0">
          <!-- 👉 Form -->
          <VForm @submit.prevent="submitForm" class="mt-6">
            <VRow>
              <VCol cols="12">
                <VListItemTitle class="text-button text-capitalize">
                  Account Details
                </VListItemTitle>
              </VCol>
              <VCol v-if="user.email_verified_at === null" cols="12">
                <VAlert
                  type="warning"
                  variant="tonal"
                  icon="bx-error"
                  text="Unverified Email"
                  class="text-small mx-2 mb-4"
                >
                  <p>
                    Your email address is unverified.
                    <Link
                      :href="route('verification.send')"
                      method="post"
                      as="button"
                      class="fw-bolder"
                    >
                      Click here to re-send the verification email.
                    </Link>
                  </p>
                </VAlert>
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
              <VCol cols="12" md="6">
                <VTextField
                  clearable
                  v-model="form.email"
                  label="Email"
                  placeholder="username@gmail.com"
                  type="email"
                  :error-messages="form.errors.email"
                />
              </VCol>

              <VCol cols="12" md="6">
                <v-select
                  :readonly="!can.editOffice"
                  :hint="!can.editOffice ? 'Access denied: Admin only' : ''"
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
              <VCol cols="12" md="6">
                <VTextField
                  clearable
                  v-model="form.phone"
                  label="Phone Number"
                  hint="format: 09 #### ### #### (ignore white space)"
                  :error-messages="form.errors.phone"
                />
              </VCol>

              <!-- 👉 Address -->
              <VCol cols="12" md="6">
                <VTextField
                  clearable
                  v-model="form.address"
                  label="Address"
                  placeholder="123 Main St, Baler, Aurora"
                  :error-messages="form.errors.address"
                />
              </VCol>

              <!-- 👉 Form Actions -->
              <VCol cols="12" class="d-flex mt-5 flex-wrap gap-4">
                <VBtn
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
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
