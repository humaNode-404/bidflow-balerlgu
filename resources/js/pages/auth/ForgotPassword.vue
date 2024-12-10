<script setup>
import Auth from '@/layouts/Auth.vue';
import { useForm } from '@inertiajs/vue3';

defineOptions({ layout: null });

defineProps({
  status: {
    type: String,
  },
});

const form = useForm({
  email: '',
});

const rules = {
  required: (value) => !!value || 'Field is required',
};

const submit = () => {
  form.post(route('password.email'));
};
</script>

<template>
  <Auth>
    <Head title="Forgot Password" />

    <VCardText>
      <h4 class="text-h4 mb-1">Forgotten?</h4>
      <p class="mb-0">
        No problem. Just let us know your email address and we will email you a
        password reset link that will allow you to choose a new one.
      </p>
    </VCardText>

    <VAlert
      v-if="status"
      type="warning"
      variant="tonal"
      icon="bx-error"
      :text="status"
      class="text-small mx-2 mb-4"
    ></VAlert>

    <VCardText>
      <VForm @submit.prevent="submit" validate-on="lazy">
        <VRow>
          <VAlert
            v-if="
              form.errors.email &&
              form.errors.email != 'The email field is required.'
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
              label="Email"
              type="email"
              placeholder="username@email.com"
              autocomplete="username"
              :rules="[rules.required]"
            />

            <div class="mt-4">
              <!-- Submit button -->
              <VBtn
                block
                type="submit"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Email Password Reset Link
              </VBtn>
            </div>
          </VCol>
        </VRow>
      </VForm>
    </VCardText>
  </Auth>
</template>
