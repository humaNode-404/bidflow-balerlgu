<script>
export default {
  layout: null,
};
</script>

<script setup>
// eslint-disable-next-line prettier/prettier
import logo from '@images/logo.svg?raw';
import { useForm } from '@inertiajs/vue3';

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};

const isPasswordVisible = ref(false);
</script>

<template>
  <div class="auth-wrapper d-flex align-center pa-4 justify-center">
    <div class="position-relative my-sm-16">
      <VImg
        :src="authV1TopShape"
        class="text-primary auth-v1-top-shape d-none d-sm-block"
      />

      <VImg
        :src="authV1BottomShape"
        class="text-primary auth-v1-bottom-shape d-none d-sm-block"
      />

      <VCard
        class="auth-card"
        max-width="460"
        :class="$vuetify.display.smAndUp ? 'pa-6' : 'pa-0'"
      >
        <VCardItem class="justify-center">
          <Link href="/" class="app-logo">
            <!-- eslint-disable vue/no-v-html -->
            <div class="d-flex" v-html="logo" />
            <h1 class="app-logo-title">bidflow</h1>
          </Link>
        </VCardItem>

        <VCardText>
          <h4 class="text-h4 mb-1">Welcome to Bidflow!</h4>
          <p class="mb-0">
            Please sign-in to your account and start the adventure
          </p>
        </VCardText>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
          {{ status }}
        </div>

        <VCardText>
          <VForm @submit.prevent="submit" validate-on="submit lazy">
            <VRow>
              <VAlert
                v-if="form.errors.email"
                type="error"
                variant="tonal"
                icon="bx-error"
                :text="form.errors.email"
                class="text-small m-3 mb-4"
                required
              ></VAlert>

              <!-- email -->
              <VCol cols="12">
                <VTextField
                  variant="outlined"
                  v-model="form.email"
                  autofocus
                  label="Email or Username"
                  type="email"
                  placeholder="johndoe@email.com"
                  autocomplete="username"
                />
              </VCol>

              <!-- password -->
              <VCol cols="12">
                <VTextField
                  variant="outlined"
                  v-model="form.password"
                  label="Password"
                  placeholder="············"
                  autocomplete="current-password"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />

                <!-- remember me checkbox -->
                <div
                  class="d-flex align-center justify-space-between my-6 flex-wrap"
                >
                  <VCheckbox v-model="form.remember" label="Remember me" />

                  <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-primary"
                  >
                    Forgot Password?
                  </Link>
                </div>

                <!-- login button -->
                <VBtn
                  block
                  type="submit"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
                  Log in
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </div>
  </div>
</template>

<style lang="scss">
/* stylelint-disable-next-line @stylistic/string-quotes */
@use '@core-scss/template/pages/page-auth.scss';
</style>
