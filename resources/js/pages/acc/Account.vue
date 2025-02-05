<script setup>
import { router } from '@inertiajs/vue3';
import Info from './partials/Info.vue';
import Security from './partials/Security.vue';

const props = defineProps({
  filters: Object,
  offices: Object,
  acc: Object,
  can: Object,
});

const activeTab = ref(props.filters.tab);

watch(activeTab, (value) => {
  router.get(
    '/account',
    { tab: value },
    {
      preserveScroll: true,
      preserveState: true,
      replace: true,
    },
  );
});

const tabs = [
  {
    title: 'Profile',
    icon: 'bx-user',
    tab: 'profile',
  },
  {
    title: 'Security',
    icon: 'bx-lock-open',
    tab: 'security',
  },
  // {
  //   title: 'Notifications',
  //   icon: 'bx-bell',
  //   tab: 'notification',
  // },
];
</script>

<template>
  <div>
    <VTabs v-model="activeTab" class="v-tabs-pill">
      <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
        <VIcon size="20" start :icon="item.icon" />
        {{ item.title }}
      </VTab>
    </VTabs>

    <VWindow v-model="activeTab" class="disable-tab-transition mt-5">
      <!-- Account -->
      <VWindowItem value="profile">
        <Info :acc="acc" :offices="offices" :can="can" />
      </VWindowItem>

      <!-- Security -->
      <VWindowItem value="security">
        <Security />
      </VWindowItem>

      <!-- Notification 
      <VWindowItem value="notification">
        <Notification />
      </VWindowItem>-->
    </VWindow>
  </div>
</template>
