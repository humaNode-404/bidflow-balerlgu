<script setup>
import Info from '@/components/account/Info.vue';
import InfoLoader from '@/components/account/loader/Info.vue';
import Security from '@/components/account/Security.vue';
import useAuth from '@/useAuth';
import { Deferred, router, usePage } from '@inertiajs/vue3';

const { hasRole } = useAuth();

defineProps({
  offices: Object,
  acc: Object,
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
];

const activeTab = ref(
  tabs.some((t) => t.tab === usePage().props.flash.tab)
    ? usePage().props.flash.tab
    : 'profile',
);

watch(activeTab, (value) => {
  router.get(
    route('account'),
    { tab: value },
    {
      only: ['flash'],
      showProgress: false,
      preserveScroll: true,
      preserveState: true,
      replace: true,
    },
  );
});
</script>

<template>
  <div>
    <VTabs v-model="activeTab" class="v-tabs-pill">
      <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
        <VIcon size="20" start :icon="item.icon" />
        {{ item.title }}
      </VTab>
    </VTabs>

    <VWindow v-model="activeTab" class="mt-5">
      <!-- Account -->
      <VWindowItem value="profile">
        <Deferred data="acc">
          <template #fallback>
            <InfoLoader />
          </template>

          <Info :acc="acc" :offices="offices" :can="hasRole('admin')" />
        </Deferred>
      </VWindowItem>

      <!-- Security -->
      <VWindowItem value="security">
        <Security />
      </VWindowItem>
    </VWindow>
  </div>
</template>
