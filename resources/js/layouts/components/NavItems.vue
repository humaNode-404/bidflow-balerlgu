<!-- eslint-disable prettier/prettier -->
<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue';
import useAuth from '@/useAuth';
import VerticalNavGroup from '@layouts/components/VerticalNavGroup.vue';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';

const { can } = useAuth();

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
      href: route('dashboard'),
      active: $page.component.includes('Dashboard'),
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Archive',
      icon: 'bx-archive',
      href: route('archive'),
      active: $page.component.includes('Archive'),
    }"
  />

  <!-- <VerticalNavLink
    :item="{
      title: 'Dashboard',
      icon: 'bi-speedometer',
      href: router('dashboard'),
      active: $page.component.includes('Dashboard'),
    }"
  /> -->

  <!-- 👉 Managements -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Managements',
    }"
  />

  <!--<VerticalNavLink
    :item="{
      title: 'Analytics',
      icon: 'bx-chart',
      href: route('analytics'),
      active: $page.component.includes('Analytics'),
    }"
  /> -->

  <VerticalNavGroup
    v-if="can('modify-settings')"
    :item="{
      icon: 'bx-cog',
      title: 'Settings',
    }"
  >
    <VerticalNavLink
      :item="{
        title: 'Users',
        href: route('users.index'),
        active: $page.component.includes('Users'),
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Offices',
        href: route('offices.index'),
        active: $page.component.includes('Offices'),
      }"
    />

    <VerticalNavLink
      v-if="false"
      :item="{
        title: 'Stages',
        href: '/stages',
        active: $page.component.includes('Stages'),
      }"
    />

    <VerticalNavLink
      :item="{
        title: 'Backup',
        href: route('backup'),
        active: $page.component.includes('Backup'),
      }"
    />
  </VerticalNavGroup>

  <VerticalNavLink
    :item="{
      title: 'Account',
      icon: 'bi-person-circle',
      href: route('account'),
      active: $page.component.includes('Account'),
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
