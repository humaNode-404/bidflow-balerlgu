<script setup>
import Auth from '@/layouts/Auth.vue';
import blankLayout from '@/layouts/Blank.vue';
import { useForm } from '@inertiajs/vue3';

defineOptions({ layout: blankLayout });

const form = useForm({
  first_name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const rules = {
  required: (value) => !!value || 'Field is required',
};

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};

const isPasswordVisible = ref(false);
</script>

<template>
  <Auth>
    <Head title="Register" />

    <VCardText>
      <VForm @submit.prevent="submit" validate-on="lazy">
        <VRow>
          <VCol cols="12" class="mt-4">
            <VTextField
              variant="outlined"
              v-model="form.first_name"
              autofocus
              label="First Name"
              placeholder="Your Name"
              autocomplete="first-name"
              :rules="
                form.errors.first_name
                  ? [form.errors.first_name]
                  : [rules.required]
              "
            />
          </VCol>

          <VCol cols="12">
            <VTextField
              variant="outlined"
              v-model="form.email"
              label="Email"
              type="email"
              placeholder="username@email.com"
              autocomplete="username"
              :rules="
                form.errors.email ? [form.errors.email] : [rules.required]
              "
            />
          </VCol>

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
              :rules="
                form.errors.password ? [form.errors.password] : [rules.required]
              "
            />
          </VCol>

          <VCol cols="12">
            <VTextField
              variant="outlined"
              v-model="form.password_confirmation"
              label="Confirm Password"
              placeholder="············"
              type="password"
              autocomplete="confirm-password"
              hint="Automatically cleared when submit"
              :rules="
                form.errors.password_confirmation
                  ? [form.errors.password_confirmation]
                  : [rules.required]
              "
            />

            <div
              class="d-flex align-center justify-space-between my-6 flex-wrap"
            >
              <Link :href="route('login')" class="text-primary">
                Already registered?
              </Link>
            </div>

            <!-- Register button -->
            <VBtn
              block
              type="submit"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Register
            </VBtn>
          </VCol>
        </VRow>
      </VForm>
    </VCardText>
  </Auth>
</template>
