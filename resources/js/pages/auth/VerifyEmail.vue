<script setup>
import Auth from '@/layouts/Auth.vue';
import blankLayout from '@/layouts/Blank.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

defineOptions({ layout: blankLayout });

const props = defineProps({
  status: {
    type: String,
  },
});

const form = useForm({});

const submit = () => {
  form.post(route('verification.send'));
};

const verificationLinkSent = computed(
  () => props.status === 'verification-link-sent',
);
</script>

<template>
  <Auth>
    <Head title="Email Verification" />

    <VCardText>
      <p class="mb-3">
        Before getting started, could you verify your email address by clicking
        on the link we just emailed to you? If you didn't receive the email, we
        will gladly send you another.
      </p>
    </VCardText>

    <VAlert
      v-if="verificationLinkSent"
      type="success"
      variant="tonal"
      icon="bx-check"
      text="A new verification link has been sent to the email address you provided."
      class="text-small mx-2 mb-4"
    ></VAlert>

    <VForm @submit.prevent="submit">
      <VRow justify="space-between">
        <VCol order="2">
          <VBtn
            block
            type="submit"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Resend Verification Email
          </VBtn>
        </VCol>
        <VCol cols="3">
          <VBtn block>
            <Link as="button" :href="route('logout')" method="post">
              Cancel
            </Link>
          </VBtn>
        </VCol>
      </VRow>
    </VForm>
  </Auth>
</template>
