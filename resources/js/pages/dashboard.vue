<script setup>
import Avatar from '@/components/Avatar.vue';
import { router, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

const pageUser = usePage().props.auth.user;
dayjs.extend(relativeTime);

defineProps({
  prdocs: Array,
});

// onMounted(() => {
//   console.log('mounted');
// });

// onUnmounted(() => {
//   console.log('unmounted');
// });

const modes = {
  0: {
    icon: 'mdi-gavel', // Default icon
    color: 'info', // Default color (Vuetify info color)
  },
  'Competitive Bidding': {
    icon: 'mdi-gavel',
    color: 'success', // Success color for trust and professionalism
  },
  'Selective Bidding': {
    icon: 'bx bx-check-circle',
    color: 'success', // Success color for approval
  },
  'Direct Contracting': {
    icon: 'bx bxs-hand',
    color: 'warning', // Warning color for exclusivity and care
  },
  'Repeat Order': {
    icon: 'bi-arrow-repeat',
    color: 'info', // Info color for ongoing processes
  },
  Shopping: {
    icon: 'bx bx-cart',
    color: 'success', // Success color for straightforward actions
  },
  'Negotiated Procurement': {
    icon: 'mdi-handshake',
    color: 'error', // Error color for high stakes or urgency
  },
};

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

// const rolemode = {
//   admin: {
//     icon: 'bx-crown',
//     color: 'primary',
//   },
//   mod: {
//     icon: 'bx-award',
//     color: 'info',
//   },
//   user: {
//     icon: 'bx-user',
//     color: 'warning',
//   },
// };

const getModeIcon = (mode) => modes[mode]?.icon || modes[0].icon;

onMounted(() => {
  router.reload({
    only: ['prdocs'],
  });
});

const link = (href) => {
  router.get(
    href,
    {},
    {
      preserveState: true,
      preserveScroll: true,
    },
  );
};
</script>

<template>
  <VRow>
    <VCol v-for="pr in prdocs" :key="pr.number" cols="12" sm="6" md="4">
      <VCard density="compact" rounded="medium" elevation="4">
        <VListItem hover class="px-6 py-2" @click="link(`/pr/${pr.uuid}`)">
          <template #prepend>
            <VListItemAction>
              <VBadge
                dot
                location="bottom right"
                offset-x="3"
                offset-y="3"
                color="success"
                bordered
              >
                <Avatar
                  :item="{
                    id: pr.user.uuid,
                    name: pr.user.name,
                    role: pr.user.role,
                    avatar: pr.user.avatar,
                    tooltipTitle: pr.user.name,
                  }"
                ></Avatar>
              </VBadge>
            </VListItemAction>
          </template>
          <VListItemTitle class="text-button text-capitalize">
            {{ pr.user.name }}
            <span v-if="pr.user.uuid == pageUser.uuid" class="text-caption">
              - You
            </span>
          </VListItemTitle>
          <VListItemSubtitle>
            <VChip
              class="text-overline cursor-help px-1 ps-2"
              prepend-icon="bi-buildings"
              variant="text"
              color="secondary"
            >
              {{ pr.office.abbr }}
              <VTooltip location="bottom" activator="parent" open-delay="250">
                <span class="text-capitalize">{{ pr.office.name }}</span>
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
        </VCardText>

        <VContainer class="w-100 mx-2 mb-2">
          <VChip
            density="compact"
            size="small"
            :prepend-icon="getModeIcon(pr.mode)"
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
                hint="In-Charge: HRMO "
                persistent-hint
                readonly
                label="Process Detail"
                model-value="RFQ Recieved at BAC Office"
                type="input"
              ></VTextField>
            </VCol>
            <VCol cols="12">
              <VFab
                density="compact"
                :color="prstatus[pr.status].color"
                extended
                :prepend-icon="prstatus[pr.status].icon"
                :text="pr.status"
                variant="outlined"
              ></VFab>
            </VCol>
          </VRow>
        </VContainer>
      </VCard>
    </VCol>
  </VRow>
</template>

<style lang="scss" scoped>
.avatar-center {
  position: absolute;
  border: 3px solid rgb(var(--v-theme-surface));
  inset-block-start: -2rem;
  inset-inline-start: 75%;
}
</style>
