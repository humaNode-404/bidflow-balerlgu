<script setup>
import Avatar from '@/components/Avatar.vue';
import { router } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import updateLocale from 'dayjs/plugin/updateLocale';
import { useDisplay } from 'vuetify';

const { xs } = useDisplay();
dayjs.extend(relativeTime);
dayjs.extend(updateLocale);
dayjs.updateLocale('en', {
  relativeTime: {
    future: 'in %s',
    past: '%s ago',
    s: 'a few seconds',
    m: '1m',
    mm: '%dm',
    h: '1h',
    hh: '%dh',
    d: '1d',
    dd: '%dd',
    M: '1mo',
    MM: '%dmos',
    y: '1y',
    yy: '%dy',
  },
});

defineProps({
  prdocs: Object,
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

const link = (href) => {
  router.get(
    href,
    {},
    {
      preserveState: true,
    },
  );
};
</script>

<template>
  <TransitionGroup name="list">
    <VCol
      v-for="pr in prdocs"
      :key="pr.number"
      cols="12"
      sm="6"
      md="4"
      :class="{ 'mx-0 px-0 pt-0': xs }"
    >
      <VCard
        density="compact"
        rounded="medium"
        height="100%"
        elevation="4"
        :class="{ 'mx-0 px-0': xs }"
      >
        <VListItem hover class="px-6 py-2" @click="link(`/pr/${pr.number}`)">
          <template #prepend>
            <VListItemAction>
              <Avatar
                :item="{
                  id: pr.user_id.uuid,
                  status: pr.user_id.status,
                  name: pr.user_id.name,
                  role: pr.user_id.role,
                  avatar: pr.user_id.avatar ? pr.user_id.avatar : '',
                  tooltipTitle: pr.user_id.name,
                }"
              ></Avatar>
            </VListItemAction>
          </template>
          <VListItemTitle class="text-button text-capitalize">
            {{ pr.user_id.name }}
          </VListItemTitle>
          <VListItemSubtitle>
            <VChip
              class="text-overline cursor-help px-1 ps-2"
              prepend-icon="bi-buildings"
              variant="text"
              color="secondary"
            >
              {{ pr.office_id.abbr }}
              <VTooltip location="bottom" activator="parent" open-delay="250">
                <span class="text-capitalize">{{ pr.office_id.name }}</span>
              </VTooltip>
            </VChip>
            •
            <VChip class="text-caption px-1" variant="text" color="secondary">
              {{ dayjs(pr.created_at).fromNow() }}
            </VChip>
          </VListItemSubtitle>
        </VListItem>
        <!-- <VSheet :height="100" color="info"></VSheet> -->
        <VCardText class="position-relative me-6 mt-8">
          <VSheet
            rounded="lg"
            :width="75"
            :height="75"
            elevation="10"
            class="avatar-center"
          >
            <div class="vstack text-center">
              <div class="text-h3">
                {{ dayjs(pr.event_need).format('D MMM').split(' ')[0] }}
              </div>
              <div class="text-primary">
                {{ dayjs(pr.event_need).format('D MMM').split(' ')[1] }}
              </div>
            </div>
          </VSheet>
          <VSheet
            rounded="lg"
            :width="75"
            :height="75"
            elevation="10"
            class="avatar-left"
          >
            <div class="vstack text-center">
              <div class="text-h4 mb-1">
                <v-icon
                  v-if="pr.completed_at"
                  color="success"
                  icon="bx-check-circle"
                ></v-icon>
                <v-icon
                  v-else-if="pr.failed_at"
                  color="error"
                  icon="bx-error-circle"
                ></v-icon>
              </div>
              <div class="text-caption">
                <small v-if="pr.completed_at">{{
                  dayjs(pr.completed_at).format('D MMM, YY')
                }}</small>
                <small v-else>{{
                  dayjs(pr.failed_at).format('D MMM, YY')
                }}</small>
              </div>
            </div>
          </VSheet>
        </VCardText>
        <VContainer class="w-100 mx-2 mb-2">
          <VChip
            density="compact"
            size="small"
            prepend-icon="mdi-gavel"
            variant="text"
            class="tex-caption"
          >
            &nbsp;{{ pr.mode }}
          </VChip>
          <VCardTitle class="text-h5 pa-0 text-wrap">
            {{ pr.desc }}
          </VCardTitle>
          <VCardSubtitle class="text-body-2 pa-0">
            {{ pr.number }}
          </VCardSubtitle>
        </VContainer>
        <VContainer class="mb-4">
          <VRow>
            <VCol cols="12">
              <VTextField
                :hint="
                  pr.stage.incharge ? `In-Charge: ${pr.stage.incharge}` : ''
                "
                persistent-hint
                readonly
                :label="
                  pr.stage.main_proc
                    ? `Process • ${pr.stage.main_proc}`
                    : 'Process'
                "
                :model-value="pr.stage.proc"
                type="input"
              />
            </VCol>
            <VCol cols="12">
              <VProgressCircular
                color="info"
                :model-value="pr.progress"
                class="text-caption me-2"
                :size="50"
              >
                <small>{{ pr.current_progress }}/{{ pr.count_progress }}</small>
              </VProgressCircular>
              <VChip
                :color="prstatus[pr.stage.status].color"
                :prepend-icon="prstatus[pr.stage.status].icon"
                :text="pr.stage.status"
                variant="outlined"
                rounded="xl"
              ></VChip>
            </VCol>
          </VRow>
        </VContainer>
      </VCard>
    </VCol>
  </TransitionGroup>
</template>

<style lang="scss" scoped>
.avatar-center {
  position: absolute;
  border: 3px solid rgb(var(--v-theme-surface));
  inset-block-start: -2rem;
  inset-inline-start: 75%;
}

.avatar-left {
  position: absolute;
  border: 3px solid rgb(var(--v-theme-surface));
  inset-block-start: -2rem;
  inset-inline-start: 57%;
}

.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>
