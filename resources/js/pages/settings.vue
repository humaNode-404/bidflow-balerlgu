<script setup>
import AccountSettingsAccount from '@/views/pages/account-settings/AccountSettingsAccount.vue';
import AccountSettingsNotification from '@/views/pages/account-settings/AccountSettingsNotification.vue';
import AccountSettingsSecurity from '@/views/pages/account-settings/AccountSettingsSecurity.vue';
import QrCode from './QrCode.vue';

const activeTab = ref('');

// tabs
const tabs = [
  {
    title: 'Account',
    icon: 'bx-user',
    tab: 'account',
  },
  {
    title: 'Security',
    icon: 'bx-lock-open',
    tab: 'security',
  },
  {
    title: 'Notifications',
    icon: 'bx-bell',
    tab: 'notification',
  },
];
</script>

<template>
  <QrCode :item="{ scale: 5, link: `http://127.0.0.1:8000/settings` }"></QrCode>

  <div>
    <VTabs v-model="activeTab" show-arrows class="v-tabs-pill">
      <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
        <VIcon size="20" start :icon="item.icon" />
        {{ item.title }}
      </VTab>
    </VTabs>

    <VWindow v-model="activeTab" class="disable-tab-transition mt-5">
      <!-- Account -->
      <VWindowItem value="account">
        <AccountSettingsAccount />
      </VWindowItem>

      <!-- Security -->
      <VWindowItem value="security">
        <AccountSettingsSecurity />
      </VWindowItem>

      <!-- Notification -->
      <VWindowItem value="notification">
        <AccountSettingsNotification />
      </VWindowItem>
    </VWindow>
  </div>
</template>
