<script setup>
import DefaultLayoutWithVerticalNav from './components/DefaultLayoutWithVerticalNav.vue';
</script>

<template>
  <Head>
    <title>{{ $page.component }}</title>
  </Head>
  <DefaultLayoutWithVerticalNav>
    <!-- <RouterView /> -->
    <slot />
  </DefaultLayoutWithVerticalNav>
</template>

<style lang="scss">
// As we are using `layouts` plugin we need its styles to be imported
@use '@layouts/styles/default-layout';
</style>
