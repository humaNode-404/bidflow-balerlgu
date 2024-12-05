<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue';
import VerticalNavGroup from '@layouts/components/VerticalNavGroup.vue';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';
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
      title: 'Profile',
      icon: 'bx-user',
      href: '/profile',
      active: $page.component.startsWith('profile'),
    }"
  />

  <!-- 👉 Purchase Requests -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Purchase Requests',
    }"
  />

  <!-- 👉 Starred PR -->
  <VerticalNavGroup
    :item="{
      title: 'Bookmarks',
      icon: 'bx-bookmark',
      //badgeContent: '7',
      //badgeClass: 'bg-warning',
    }"
  >
    <VerticalNavLink
      :item="{
        title: 'Landing',
        href: '',
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Pricing',
        href: '',
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Payment',
        href: '',
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Checkout',
        href: '',
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Help Center',
        href: '',
      }"
    />
  </VerticalNavGroup>

  <VerticalNavLink
    :item="{
      title: 'To-do',
      icon: 'bx-check-circle',
      href: '/todos',
    }"
  />

  <VerticalNavLink
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
      title: 'Settings',
      icon: 'bx-cog',
      href: '/settings',
      active: $page.component.includes('settings'),
    }"
  />
</template>
