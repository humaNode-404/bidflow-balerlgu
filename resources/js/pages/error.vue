<!-- eslint-disable prettier/prettier -->
<script setup>
import misc404 from '@images/pages/404.png';

defineOptions({ layout: null });
const props = defineProps({ status: Number })

const title = computed(() => {
  return {
    503: '503: Service Unavailable',
    500: '500: Server Error',
    404: '404: Page Not Found',
    403: '403: Forbidden',
  }[props.status|| 404]
})

const description = computed(() => {
  return {
    503: 'Sorry, we are doing some maintenance. Please check back soon.',
    500: 'Whoops, something went wrong on our servers.',
    404: 'Sorry, the page you are looking for could not be found.',
    403: 'Sorry, you are forbidden from accessing this page.',
  }[props.status|| 404]
})

</script>

<template>
  <div class="misc-wrapper mt-3">
    <ErrorHeader
      :status-code="status || 404"
      :title="title"
      :description="description"
    />

    <div>
      <Link href="/" as="button" class="d-block mx-auto">
        <VBtn class="mb-6"> Back to Home </VBtn>
      </Link>
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
/* stylelint-disable-next-line @stylistic/string-quotes */
@use '@core-scss/template/pages/misc.scss';
</style>
