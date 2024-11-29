<script setup>
import misc404 from '@images/pages/404.png'
</script>

<template>
  <div class="misc-wrapper">
    <ErrorHeader
      status-code="404"
      title="Page Not Found ⚠️"
      description="We couldn't find the page you are looking for."
    />

    <div>
      <Link
        href="/"
        as="button"
        class="d-block mx-auto"
      >
        <VBtn class="mb-6">
          Back to Home
        </VBtn>
      </Link>
      <div class="demo-space-y">
        <VAlert
          color="primary"
          icon="bx-happy"
        >
          Suspendisse enim turpis, dictum sed, iaculis a, condimentum nec, nisi.
        </VAlert>

        <VAlert
          color="primary"
          icon="bx-bolt-circle"
          variant="tonal"
        >
          Phasellus blandit leo ut odio. Morbi mattis ullamcorper velit.
        </VAlert>

        <VAlert
          color="primary"
          icon="bx-bxl-nodejs"
          variant="outlined"
        >
          Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
        </VAlert>
      </div>
    </div>

    <!-- 👉 Image -->
    <div class="misc-avatar w-100 text-center">
      <VImg
        :src="misc404"
        alt="Page Not Found"
        :max-width="500"
        class="mx-auto"
      />
    </div>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/misc.scss";
</style>
