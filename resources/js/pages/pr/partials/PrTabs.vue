<script setup>
import FileSlider from './FileSlider.vue';
import Timeline from './Timeline.vue';

const activeTab = ref('tracks');

const tabs = [
  {
    title: 'Timeline',
    icon: 'mdi-timeline-text-outline',
    tab: 'timeline',
  },
  {
    title: 'Attachments',
    icon: 'bx-link',
    tab: 'attache',
  },
  // {
  //   title: 'Notes',
  //   icon: 'bx-notepad',
  //   tab: 'notes',
  // },
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

    <VWindow v-model="activeTab" class="disable-tab-transition mt-3">
      <VWindowItem value="timeline">
        <Timeline />
      </VWindowItem>

      <VWindowItem value="attache">
        <FileSlider />
      </VWindowItem>

      <!-- <VWindowItem value="notes"> </VWindowItem> -->
    </VWindow>
  </div>
</template>
