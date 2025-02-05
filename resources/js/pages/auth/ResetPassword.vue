<script setup>
import Auth from '@/layouts/Auth.vue';
import blankLayout from '@/layouts/Blank.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineOptions({ layout: blankLayout });

const props = defineProps({
  email: {
    type: String,
    required: true,
  },
  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const rules = {
  required: (value) => !!value || 'Field is required',
};

const submit = () => {
  form.post(route('password.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};

const isPasswordVisible = ref(false);
</script>

<template>
  <Auth>
    <Head title="Reset Password" />

    <VCardText>
      <VForm @submit.prevent="submit" validate-on="lazy">
        <VRow>
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
              :rules="[rules.required]"
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
              :rules="
                form.errors.password ? [form.errors.password] : [rules.required]
              "
            />
          </VCol>

          <!-- confirm password -->
          <VCol cols="12" class="mb-4">
            <VTextField
              variant="outlined"
              v-model="form.password_confirmation"
              label="Confirm Password"
              placeholder="············"
              type="password"
              autocomplete="confirm-password"
              :rules="
                form.errors.password_confirmation
                  ? [form.errors.password_confirmation]
                  : [rules.required]
              "
            />
            <div class="mt-6">
              <VBtn
                block
                type="submit"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Reset Password
              </VBtn>
            </div>
          </VCol>
        </VRow>
      </VForm>
    </VCardText>
  </Auth>
</template>
