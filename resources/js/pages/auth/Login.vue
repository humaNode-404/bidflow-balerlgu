<script setup>
import Auth from '@/layouts/Auth.vue';
import blankLayout from '@/layouts/Blank.vue';
import { useForm } from '@inertiajs/vue3';

defineOptions({ layout: blankLayout });

defineProps({
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
  form.post(route('login'), {});
};

const isPasswordVisible = ref(false);
</script>

<template>
  <Auth>
    <Head title="Login" />

    <VCardText>
      <h4 class="text-h4 mb-1">Login</h4>
      <p class="mb-0">Sign-in to your account and start the adventure</p>
    </VCardText>

    <VAlert
      v-if="status"
      type="success"
      variant="tonal"
      icon="bx-check"
      :text="status"
      class="text-small mx-2 mb-4"
    ></VAlert>

    <VCardText>
      <VForm @submit.prevent="submit" validate-on="lazy">
        <VRow>
          <VAlert
            v-if="
              form.errors.email == 'These credentials do not match our records.'
            "
            type="error"
            variant="tonal"
            icon="bx-error"
            :text="form.errors.email"
            class="text-small mx-2 mb-4"
          ></VAlert>

          <!-- email -->
          <VCol cols="12">
            <VTextField
              variant="outlined"
              v-model="form.email"
              autofocus
              label="Email or Username"
              type="email"
              placeholder="username@email.com"
              autocomplete="username"
              :error-messages="
                form.errors.email ==
                'These credentials do not match our records.'
                  ? ''
                  : form.errors.email
              "
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
              :error-messages="form.errors.password"
            />

            <!-- remember me checkbox -->
            <div
              class="d-flex align-center justify-space-between my-6 flex-wrap"
            >
              <VCheckbox v-model="form.remember" label="Remember me" />

              <Link :href="route('password.request')" class="text-primary">
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
  </Auth>
</template>
