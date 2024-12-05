<script setup>
import DefaultLayoutWithVerticalNav from './components/DefaultLayoutWithVerticalNav.vue';
import ScrollToTop from './components/ScrollToTop.vue';
</script>

<template>
  <DefaultLayoutWithVerticalNav>
    <slot />
    <ScrollToTop />
  </DefaultLayoutWithVerticalNav>
</template>

<style lang="scss">
// As we are using `layouts` plugin we need its styles to be imported
/* stylelint-disable-next-line @stylistic/string-quotes */
@use '@layouts/styles/default-layout';
</style>
