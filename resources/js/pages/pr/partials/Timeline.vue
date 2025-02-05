<script setup>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { inject } from 'vue';
import { PerfectScrollbar } from 'vue3-perfect-scrollbar';

dayjs.extend(relativeTime);
const pr = inject('pr');

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
  <PerfectScrollbar tag="div">
    <v-timeline side="end">
      <v-timeline-item
        v-for="stage in pr.stages"
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
              dayjs(stage.updated_at).fromNow()
            }}</span>
          </template>
        </VListItem>
      </v-timeline-item>
    </v-timeline>
  </PerfectScrollbar>
</template>

<style lang="scss" scoped>
.v-timeline {
  max-block-size: 600px;
  min-block-size: 500px;
}
</style>
