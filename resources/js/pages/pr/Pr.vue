<script setup>
import Avatar from '@/components/Avatar.vue';
import { router, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

const page = usePage();
const pageUser = page.props.auth.user;
dayjs.extend(relativeTime);

const props = defineProps({
  prdoc: Object,
});

const pr = ref(props.prdoc[0]);

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
    only: ['prdoc'],
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
  <VContainer>
    <VRow>
      <VCol cols="8">
        <VCard>
          <VListItem class="px-6 py-2" @click="link(`/pr/${pr.uuid}`)">
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
        </VCard>
      </VCol>
      <VCol></VCol>
    </VRow>
  </VContainer>
</template>
