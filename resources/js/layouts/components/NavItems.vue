<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue';
import Bookmarks from '@/components/Bookmarks.vue';
import { usePage } from '@inertiajs/vue3';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';

const page = usePage();
</script>

<template>
  <VerticalNavLink
    :item="{
      title: 'Home',
      icon: 'bx-home-smile',
      href: '/dashboard',
      active: $page.component.includes('Dashboard'),
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Calendar',
      icon: 'bx-calendar',
      href: '/calendar',
      active: $page.component.includes('Calendar'),
    }"
  />

  <!-- 👉 Purchase Requests -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Purchase Requests',
    }"
  />

  <VerticalNavLink
    key="1"
    :item="{
      title: page.props.auth.user.role == 'user' ? 'My PR' : 'PR Docs',
      icon: 'bx-file',
      href: '/pr',
    }"
  />
  <Bookmarks key="2" />
  <!-- 👉 Starred PR -->
  <VerticalNavLink
    key="3"
    :item="{
      title: 'To-do',
      icon: 'bx-check-circle',
      href: '/todos',
    }"
  />
  <VerticalNavLink
    key="4"
    :item="{
      title: 'Archive',
      icon: 'bx-archive',
      href: '/archive',
      active: $page.component.includes('Profile'),
    }"
  />

  <!-- 👉 Managements -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Managements',
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Users',
      icon: 'bi-people',
      href: '/users',
      active: $page.component.includes('Users'),
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Account',
      icon: 'bx-cog',
      href: '/account',
      active: $page.component.includes('account'),
    }"
  />
</template>

<style lang="scss">
.list-move, /* apply transition to moving elements */
.list-enter-active,
.list-leave-active {
  transition: all 1s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

/* ensure leaving items are taken out of layout flow so that moving
   animations can be calculated correctly. */
.list-leave-active {
  position: absolute;
}
</style>
