<!-- eslint-disable prettier/prettier -->
<script setup>
// eslint-disable-next-line prettier/prettier
import logo from '@images/logo.svg?raw';
import authV1BottomShape from '@images/svg/auth-v1-bottom-shape.svg?url';
import authV1TopShape from '@images/svg/auth-v1-top-shape.svg?url';

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
            <h1 class="app-logo-title mt-2">bidflow</h1>
          </Link>
        </VCardItem>

        <slot />
      </VCard>
    </div>
  </div>
</template>

<style lang="scss">
/* stylelint-disable-next-line @stylistic/string-quotes */
@use '@core-scss/template/pages/page-auth';

.app-logo {
  display: flex;
  align-items: center;
  column-gap: 0.75rem;

  .app-logo-title {
    font-size: 1.25rem;
    font-weight: 500;
    line-height: 1.75rem;
    text-transform: uppercase;
  }
}
</style>
