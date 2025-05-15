<script setup>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);
defineProps({
  stages: Object,
});

const prstatus = {
  pending: {
    icon: 'bx-dots-horizontal',
    color: 'info',
  },
  'in progress': {
    icon: 'mdi-progress-clock',
    color: 'warning',
  },
  'on hold': {
    icon: 'mdi-pause-circle-outline',
    color: 'error',
  },
  completed: {
    icon: 'mdi-check-circle-outline',
    color: 'success',
  },
};
</script>

<template>
  <v-timeline side="end">
    <v-timeline-item
      v-for="stage in stages"
      :key="stage.uuid"
      :dot-color="prstatus[stage.status].color"
      size="small"
    >
      <VListItem>
        <VListItemTitle class="text-h6 pa-0 text-wrap">
          {{ (stage.main_proc ? `${stage.main_proc}: ` : '') + stage.proc }}
        </VListItemTitle>
        <VListItemSubtitle class="text-caption mx-2">
          {{ stage.desc }}
        </VListItemSubtitle>
        <template v-slot:append>
          <span class="text-caption">{{
            dayjs(stage.updated_at).format('D MMM YYYY HH:MM a')
          }}</span>
        </template>
      </VListItem>
    </v-timeline-item>
  </v-timeline>
</template>

<style lang="scss" scoped>
.v-timeline {
  min-block-size: 500px;
}
</style>
