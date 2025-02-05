<script setup>
import Auth from '@/layouts/Auth.vue';
import blankLayout from '@/layouts/Blank.vue';
import { useForm } from '@inertiajs/vue3';

defineOptions({ layout: blankLayout });

const form = useForm({
  password: '',
});

const rules = {
  required: (value) => !!value || 'Field is required',
};

const submit = () => {
  form.post(route('password.confirm'), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <Auth>
    <Head title="Confirm Password" />

    <VCardText>
      <p class="mb-0">
        This is a secure area of the application. Please confirm your password
        before continuing.
      </p>
    </VCardText>

    <VForm @submit.prevent="submit" validate-on="lazy">
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

        <VBtn
          block
          type="submit"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Confirm
        </VBtn>
      </VCol>
    </VForm>
  </Auth>
</template>
