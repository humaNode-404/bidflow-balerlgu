<!-- eslint-disable prettier/prettier -->
<script setup>
import GoBackBtn from '@/components/GoBackBtn.vue';
import Footer from '@/layouts/components/Footer.vue';
import NavbarNotifications from '@/layouts/components/NavbarNotifications.vue';
import NavbarThemeSwitcher from '@/layouts/components/NavbarThemeSwitcher.vue';
import NavItems from '@/layouts/components/NavItems.vue';
import UserProfile from '@/layouts/components/UserProfile.vue';
import logoIcon from '@images/logo-icon.svg?raw';
import logo from '@images/logo.svg?raw';
import VerticalNavLayout from '@layouts/components/VerticalNavLayout.vue';
import { useDisplay } from 'vuetify';

const { mdAndDown } = useDisplay();
</script>

<template>
  <VerticalNavLayout>
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center">
        <Transition name="slide-fade">
          <GoBackBtn />
        </Transition>
        <IconBtn
          v-if="mdAndDown"
          class="ms-0"
          @click="toggleVerticalOverlayNavActive(true)"
        >
          <VIcon icon="bx-menu" />
          <VTooltip location="bottom" activator="parent" open-delay="250">
            <span class="text-capitalize">Menu</span>
          </VTooltip>
        </IconBtn>
        <Transition name="slide-fade">
          <div v-if="mdAndDown" class="d-flex flex-row">
            <Link href="/dashboard" class="app-logo app-title-wrapper">
              <IconBtn class="mx-0">
                <div class="d-flex" v-html="logoIcon" />
                <VTooltip location="bottom" activator="parent" open-delay="250">
                  <span class="text-capitalize">Home</span>
                </VTooltip>
              </IconBtn>
            </Link>
            <h5 class="d-inline text-h5 text-capitalize ms-1 pt-2">
              {{ $page.component.split('/').at(-1) }}
            </h5>
          </div>
        </Transition>

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
