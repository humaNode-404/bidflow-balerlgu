<script setup>
import FileSlider from '@/components/FileSlider.vue';
import { inject } from 'vue';

const activeTab = ref('attache');
const pr = inject('pr');

// tabs
const tabs = [
  {
    title: 'Tracking',
    icon: 'mdi-timeline-text-outline',
    tab: 'tracks',
  },
  {
    title: 'Attachments',
    icon: 'bx-link',
    tab: 'attache',
  },
  {
    title: 'Notes',
    icon: 'bx-notepad',
    tab: 'notes',
  },
];
</script>

<template>
  <div>
    <VTabs density="compact" v-model="activeTab" class="v-tabs-pill">
      <VTab
        class="ms-3"
        v-for="item in tabs"
        :key="item.icon"
        :value="item.tab"
      >
        <VIcon size="20" start :icon="item.icon" />
        {{ item.title }}
      </VTab>
    </VTabs>

    <VWindow v-model="activeTab" class="disable-tab-transition mt-5">
      <VWindowItem value="tracks"> </VWindowItem>

      <VWindowItem value="attache">
        <FileSlider :files="pr.files" />
      </VWindowItem>

      <VWindowItem value="notes"> </VWindowItem>
    </VWindow>
  </div>
</template>
