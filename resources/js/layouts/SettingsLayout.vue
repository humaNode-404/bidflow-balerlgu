<script setup>
import { router, usePage } from '@inertiajs/vue3';

const items = [
  {
    title: 'Users',
    href: route('users'),
    icon: 'bxs-user',
    active: usePage().url.includes('users'),
  },
  {
    title: 'Backup',
    href: route('backup'),
    icon: 'mdi-cloud-cog-outline',
    active: usePage().url.includes('backup'),
  },
];
const link = (href) => {
  router.visit(href);
};

const active = ref(true);

onMounted(() => {
  active.value = false;
});

onBeforeUnmount(() => {
  active.value = true;
});
</script>

<template>
  <Teleport :disabled="active" defer to="#app-bc-div">
    <v-menu location="bottom" offset="5px">
      <template v-slot:activator="{ props }">
        <IconBtn v-bind="props">
          <VIcon icon="mdi-chevron-right"></VIcon>
        </IconBtn>
      </template>
      <v-list width="146">
        <VListItem
          v-for="item in items"
          :key="item.title"
          color="primary"
          :active="item.active"
          :title="item.title"
          :prepend-icon="item.icon"
          @click="link(item.href)"
        >
        </VListItem>
      </v-list>
    </v-menu>
  </Teleport>
  <slot />
</template>
