<!-- eslint-disable prettier/prettier -->
<script setup>
import GoBackBtn from '@/components/GoBackBtn.vue';
import Notifications from '@/components/Notifications.vue';
import Footer from '@/layouts/components/Footer.vue';
import NavbarThemeSwitcher from '@/layouts/components/NavbarThemeSwitcher.vue';
import NavItems from '@/layouts/components/NavItems.vue';
import UserProfile from '@/layouts/components/UserProfile.vue';
import logo from '@images/logo.svg?raw';
import { Deferred } from '@inertiajs/vue3';
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
          <GoBackBtn v-if="false" />
        </Transition>
        <Transition name="slide-fade">
          <div v-if="mdAndDown" class="d-flex flex-row">
            <IconBtn class="ms-0" @click="toggleVerticalOverlayNavActive(true)">
              <VIcon icon="bx-menu" />
              <VTooltip location="bottom" activator="parent" open-delay="250">
                <span class="text-capitalize">Menu</span>
              </VTooltip>
            </IconBtn>
          </div>
        </Transition>

        <Head :title="$page.component.split('/').at(-1)" />

        <v-breadcrumbs
          :items="$page.url.substr(1).split('?')[0].split('/')"
          class="text-h5 text-capitalize ps-0"
        >
          <!-- <template v-slot:divider>
            <v-icon icon="bx-chevron-right" />
          </template> -->
        </v-breadcrumbs>

        <VSpacer />
        <NavbarThemeSwitcher class="me-1" />

        <Deferred data="notifs">
          <template #fallback>
            <IconBtn class="me-1">
              <VIcon icon="bx-bell" />
              <VTooltip location="bottom" activator="parent">
                <span class="text-capitalize">Notifications</span>
              </VTooltip>
            </IconBtn>
          </template>
          <keep-alive>
            <component :is="Notifications" />
          </keep-alive>
        </Deferred>

        <Deferred data="auth">
          <template #fallback>
            <VAvatar class="cursor-pointer" color="primary" variant="tonal">
              <VIcon icon="bi-person" />
            </VAvatar>
          </template>
          <UserProfile />
        </Deferred>
      </div>
    </template>

    <template #vertical-nav-header="{ toggleIsOverlayNavActive }">
      <Link href="/dashboard" class="app-logo app-title-wrapper">
        <!-- eslint-disable vue/no-v-html -->
        <div class="d-flex" v-html="logo" />
        <!-- eslint-enable -->

        <h1 class="app-logo-title mt-2">bidflow</h1>
      </Link>

      <div class="position-relative">
        <IconBtn class="ms-4 mt-3" @click="toggleIsOverlayNavActive(false)">
          <VIcon icon="bx-x" />
        </IconBtn>
      </div>
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
