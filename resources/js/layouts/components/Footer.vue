<!-- eslint-disable prettier/prettier -->
<script setup>
import logoIcon from '@images/logo-icon.svg?raw';
</script>

<template>
  <div
    class="h-100 d-flex align-center justify-md-space-between justify-center"
  >
    <!-- 👉 Footer: left content -->
    <span class="d-flex align-center">
      <span class="pt-2">&copy; {{ new Date().getFullYear() }}</span>
      <div class="d-flex mx-2" v-html="logoIcon" />
      <Link href="/dashboard" class="text-button pt-2">Bidflow</Link>
    </span>
    <!-- 👉 Footer: right content -->
    <!-- <span class="d-md-flex text-primary d-none gap-x-4">
      <Link href="/#">Privacy Policy</Link>
      <Link href="/#">Terms of Service</Link>
    </span> -->
  </div>
</template>
