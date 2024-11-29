<template>
  <div class="h-100 d-flex align-center justify-md-space-between justify-center">
    <!-- 👉 Footer: left content -->
    <span class="d-flex align-center">
      &copy;
      {{ new Date().getFullYear() }}
      <VIcon
        icon="bi-cart4"
        size="1rem"
        class="ms-2"
      /> <Link
        href="/"
        class="text-primary ms-2"
      >Bidflow</Link>
    </span>
    <!-- 👉 Footer: right content -->
    <span class="d-md-flex gap-x-4 text-primary d-none">
      <Link href="/">Privacy Policy</Link>
      <Link href="/">Terms of Service</Link>
    </span>
  </div>
</template>
