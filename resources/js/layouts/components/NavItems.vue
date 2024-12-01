<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue';
import VerticalNavGroup from '@layouts/components/VerticalNavGroup.vue';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';
</script>

<template>
  <!-- 👉 Dashboards -->
  <VerticalNavGroup
    :item="{
      title: 'Home',
      badgeContent: '5',
      badgeClass: 'bg-error',
      icon: 'bx-home-smile',
    }"
  >
    <VerticalNavLink
      :item="{
        title: 'Dashboard',
        href: '/dashboard',
        active: $page.component.includes('Dashboard'),
      }"
    />
  </VerticalNavGroup>

  <!-- 👉 Starred PR -->
  <VerticalNavGroup
    :item="{
      title: 'Starred PR',
      icon: 'bx-star',
      badgeContent: '7',
      badgeClass: 'bg-light-warning text-warning',
    }"
  >
    <VerticalNavLink
      :item="{
        title: 'Landing',
        href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/front-pages/landing-page',
        target: '_blank',
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Pricing',
        href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/front-pages/pricing',
        target: '_blank',
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Payment',
        href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/front-pages/payment',
        target: '_blank',
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Checkout',
        href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/front-pages/checkout',
        target: '_blank',
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Help Center',
        href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/front-pages/help-center',
        target: '_blank',
      }"
    />
  </VerticalNavGroup>

  <!-- 👉 Apps & Pages -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Apps & Pages',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Email',
      icon: 'bx-envelope',
      href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/apps/email',
      target: '_blank',
      badgeContent: 'Pro',
      badgeClass: 'bg-light-primary text-primary',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Chat',
      icon: 'bx-chat',
      href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/apps/chat',
      target: '_blank',
      badgeContent: 'Pro',
      badgeClass: 'bg-light-primary text-primary',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Calendar',
      icon: 'bx-calendar',
      href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/apps/calendar',
      target: '_blank',
      badgeContent: 'Pro',
      badgeClass: 'bg-light-primary text-primary',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Kanban',
      icon: 'bx-grid',
      href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/apps/kanban',
      target: '_blank',
      badgeContent: 'Pro',
      badgeClass: 'bg-light-primary text-primary',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Users',
      icon: 'bx-user',
      href: '/users',
      active: $page.component.includes('users'),
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Profile',
      icon: 'bx-user',
      href: '/profile',
      active: $page.component.includes('Profile'),
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Login',
      icon: 'bx-log-in',
      href: '/login',
      active: $page.component.includes('login'),
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Register',
      icon: 'bx-user-plus',
      href: '/register',
      active: $page.component.includes('register'),
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Error',
      icon: 'bx-info-circle',
      href: '/no-existence',
      active: $page.component.includes('error'),
    }"
  />

  <!-- 👉 User Interface -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'User Interface',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Typography',
      icon: 'bx-text',
      href: '/typography',
      active: $page.component.includes('typography'),
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Icons',
      icon: 'bx-package',
      href: '/icons',
      active: $page.component.includes('icons'),
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Cards',
      icon: 'bx-credit-card',
      href: '/cards',
      active: $page.component.includes('cards'),
    }"
  />

  <!-- 👉 Forms & Tables -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Forms & Tables',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Form Layouts',
      icon: 'bx-layout',
      href: '/form-layouts',
      active: $page.component.includes('form-layouts'),
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Form Validation',
      icon: 'bx-check-circle',
      href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/forms/form-validation',
      target: '_blank',
      badgeContent: 'Pro',
      badgeClass: 'bg-light-primary text-primary',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Form Wizard',
      icon: 'bx-align-middle',
      href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/forms/form-wizard-numbered',
      target: '_blank',
      badgeContent: 'Pro',
      badgeClass: 'bg-light-primary text-primary',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Tables',
      icon: 'bx-table',
      href: '/tables',
      active: $page.component.includes('tables'),
    }"
  />

  <!-- 👉 Others -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Others',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Access Control',
      icon: 'bx-command',
      href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-laravel-admin-template/demo-1/access-control',
      target: '_blank',
      badgeContent: 'Pro',
      badgeClass: 'bg-light-primary text-primary',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Documentation',
      icon: 'bx-file',
      href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-admin-template/documentation/',
      target: '_blank',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Raise Support',
      href: 'https://github.com/themeselection/sneat-vuetify-vuejs-laravel-admin-template-free/issues',
      icon: 'bx-phone',
      target: '_blank',
    }"
  />
</template>
