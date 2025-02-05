<!-- eslint-disable prettier/prettier -->
<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue';
import { usePage } from '@inertiajs/vue3';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';
import VerticalNavGroup from '@layouts/components/VerticalNavGroup.vue';

const can = usePage().props.auth.can;
</script>

<template>
  <!-- 👉 Purchase Requests -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Purchase Requests',
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Dashboard',
      icon: 'bi-speedometer',
      href: '/dashboard',
      active: $page.component.includes('Dashboard'),
    }"
  />

  <VerticalNavGroup
    :item="{
      icon: 'bx-archive',
      title: 'PR Archive',
    }"
  >
    <VerticalNavLink
      :item="{
        title: 'Completed',
        href: '/archive',
        active: $page.component.includes('Archive'),
      }"
    />

    <VerticalNavLink
      :item="{
        title: 'Failed',
        href: '/failed',
        active: $page.component.includes('Failed'),
      }"
    />
  </VerticalNavGroup>

  <!-- <VerticalNavLink
    :item="{
      title: 'Dashboard',
      icon: 'bi-speedometer',
      href: '/dashboard',
      active: $page.component.includes('Dashboard'),
    }"
  /> -->

  <!-- 👉 Managements -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Managements',
    }"
  />

  <VerticalNavGroup
    v-if="can.userCreate"
    :item="{
      icon: 'bx-cog',
      title: 'Settings',
    }"
  >
    <VerticalNavLink
      :item="{
        title: 'Users',
        href: route('users.show'),
        active: $page.component.includes('users'),
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Entities',
        href: '/Entities',
        active: $page.component.includes('Entities'),
      }"
    />

    <VerticalNavLink
      :item="{
        title: 'Officials',
        href: '/officials',
        active: $page.component.includes('Officials'),
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Purchase Request',
        href: '/process',
        active: $page.component.includes('PrProcess'),
      }"
    />

    <VerticalNavLink
      :item="{
        title: 'Backups',
        href: '/backup',
        active: $page.component.includes('Backup'),
      }"
    />
  </VerticalNavGroup>

  <VerticalNavLink
    :item="{
      title: 'Account',
      icon: 'bi-person-circle',
      href: route('account.show'),
      active: $page.component.includes('acc'),
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
