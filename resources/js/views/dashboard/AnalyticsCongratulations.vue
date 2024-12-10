<script setup>
import illustrationJohnDark from '@images/cards/illustration-john-dark.png';
import illustrationJohnLight from '@images/cards/illustration-john-light.png';
import { usePage } from '@inertiajs/vue3';
import { useTheme } from 'vuetify';

const { global } = useTheme();
const illustrationJohn = computed(() =>
  global.name.value === 'dark' ? illustrationJohnDark : illustrationJohnLight,
);
</script>

<template>
  <VCard class="text-sm-start text-center">
    <VRow no-gutters>
      <VCol cols="12" sm="8" order="2" order-sm="1">
        <VCardItem class="pb-3">
          <VCardTitle class="text-primary">
            Welcome back {{ usePage().props.auth.user.first_name }}!
          </VCardTitle>
        </VCardItem>

        <VCardText>
          You have done 72% more sales today.
          <br />
          Check your new raising badge in your profile.
          <br />
          <VBtn variant="tonal" class="mt-6" size="small"> View Badges </VBtn>
        </VCardText>
      </VCol>

      <VCol cols="12" sm="4" order="1" order-sm="2" class="text-center">
        <img
          :src="illustrationJohn"
          :height="$vuetify.display.xs ? '150' : '182'"
          :class="$vuetify.display.xs ? 'mb-n2 mt-6' : 'position-absolute'"
          class="john-illustration flip-in-rtl mx-auto"
        />
      </VCol>
    </VRow>
  </VCard>
</template>

<style lang="scss" scoped>
.john-illustration {
  inset-block-end: -0.125rem;
  inset-inline-end: 3.5rem;
  max-block-size: 182px;
}
</style>
