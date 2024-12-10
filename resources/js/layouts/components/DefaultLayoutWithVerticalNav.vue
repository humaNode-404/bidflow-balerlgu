<script setup>
import Footer from '@/layouts/components/Footer.vue';
import NavbarNotifications from '@/layouts/components/NavbarNotifications.vue';
import NavbarThemeSwitcher from '@/layouts/components/NavbarThemeSwitcher.vue';
import NavItems from '@/layouts/components/NavItems.vue';
import UserProfile from '@/layouts/components/UserProfile.vue';
import logo from '@images/logo.svg?raw';
import { router, usePage } from '@inertiajs/vue3';
import VerticalNavLayout from '@layouts/components/VerticalNavLayout.vue';
import { useDisplay } from 'vuetify';
const { mdAndDown } = useDisplay();

// Create a reactive variables for the URL
const url = reactive({
  prev: usePage().url,
  page: usePage().url,
  aw: false,
});

// Listen to Inertia's navigation event
onMounted(() => {
  router.on('navigate', (event) => {
    url.page = event.detail.page.url;
  });
  router.on('before', () => {
    url.prev = url.page;
  });
  setTimeout(() => {
    url.aw = true;
  }, 4000);
});
</script>

<template>
  <VerticalNavLayout>
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center">
        <Link v-if="$page.component.includes('Error')" :href="url.prev || ''">
          <IconBtn class="ms-0">
            <VIcon icon="mdi-arrow-left" color="muted" />
          </IconBtn>
        </Link>
        <IconBtn
          v-if="mdAndDown"
          class="ms-0"
          @click="toggleVerticalOverlayNavActive(true)"
        >
          <VIcon icon="bx-menu" />
        </IconBtn>
        <Transition name="slide-fade">
          <div v-if="mdAndDown" class="d-flex flex-row">
            <Link href="/dashboard" class="app-logo app-title-wrapper">
              <IconBtn class="mx-0">
                <VIcon icon="bi-cart4" color="primary" />
              </IconBtn>
            </Link>
            <h5 class="d-inline text-h5 text-capitalize ms-1 pt-2">
              {{ $page.component.split('/')[0] }}
            </h5>
          </div>
        </Transition>

        <!--
          <div
          class="d-flex align-center cursor-pointer ms-lg-n3"
          style="user-select: none;"
          >
          <IconBtn>
          <VIcon icon="bx-search" />
          </IconBtn>

          <span class="d-none d-md-flex align-center text-disabled ms-2">
          <span class="me-2">Search</span>
          <span class="meta-key">&#8984;K</span>
          </span>
          </div> 
        -->

        <VSpacer />
        <NavbarThemeSwitcher class="me-1" />

        <NavbarNotifications class="me-1" />

        <UserProfile />
      </div>
    </template>

    <template #vertical-nav-header="{ toggleIsOverlayNavActive }">
      <Link href="/dashboard" class="app-logo app-title-wrapper">
        <!-- eslint-disable vue/no-v-html -->
        <div class="d-flex" v-html="logo" />
        <!-- eslint-enable -->

        <h1 class="app-logo-title mt-2">bidflow</h1>
      </Link>

      <IconBtn
        class="d-block d-lg-none"
        @click="toggleIsOverlayNavActive(false)"
      >
        <VIcon icon="bx-x" />
      </IconBtn>
    </template>

    <template #vertical-nav-content>
      <NavItems />
    </template>

    <!-- 👉 Pages -->
    <slot />

    <!-- 👉 Footer -->
    <template #footer>
      <Footer />
    </template>
  </VerticalNavLayout>
</template>

<style lang="scss" scoped>
.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 6px;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}

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

/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateX(20px);
}
</style>
