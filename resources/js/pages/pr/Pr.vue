<script setup>
import QrCode from '@/components/QrCode.vue';
import { router, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { provide } from 'vue';
import { useDisplay } from 'vuetify';
import PrTabs from './partials/PrTabs.vue';

const { md, mdAndDown } = useDisplay();

const page = usePage();
const pageUser = page.props.auth.user;
dayjs.extend(relativeTime);

const props = defineProps({
  prdoc: Object,
});

const pr = ref(props.prdoc[0]);

provide(/* key */ 'pr', /* value */ pr);
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
  <VContainer fluid class="mx-0 px-0">
    <VRow justify="space-between">
      <VCol cols="12" md="8">
        <VCard>
          <VListItem class="px-4 py-2" :class="{ 'px-3': mdAndDown }">
            <template #append>
              <IconBtn>
                <VIcon icon="bx-share-alt"></VIcon>
                <VMenu
                  activator="parent"
                  width="250"
                  location="bottom end"
                  offset="20px"
                  :close-on-content-click="false"
                >
                  <QrCode
                    :item="{ scale: 5, link: route('pr', pr.uuid) }"
                  ></QrCode>
                </VMenu>
              </IconBtn>
              <IconBtn>
                <VIcon icon="bx-bookmark"></VIcon>
              </IconBtn>
            </template>
            <VCardTitle class="text-h5 pa-0 text-wrap">
              {{ pr.desc }}
            </VCardTitle>
            <VCardSubtitle class="text-body-2 pa-0">
              {{ pr.number }}
            </VCardSubtitle>
          </VListItem>
          <PrTabs />
          <VExpansionPanels variant="accordion">
            <VExpansionPanel :hide-actions="md">
              <v-expansion-panel-title disable-icon-rotate>
                <h4 class="text-h5">About this PR</h4>
                <template v-slot:actions>
                  <v-icon color="primary" icon="bx-info-circle" size="x-large">
                  </v-icon>
                </template>
              </v-expansion-panel-title>
              <VExpansionPanel-text
                >Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat.</VExpansionPanel-text
              >
            </VExpansionPanel>
          </VExpansionPanels>
        </VCard>
      </VCol>
      <VCol cols="12" md="4">
        <VCard>
          <VListItem class="px-3 py-2 pe-1" @click="link(`/pr/${pr.uuid}`)">
            <template #append>
              <IconBtn>
                <VIcon icon="bx-dots-vertical"></VIcon>
              </IconBtn>
            </template>
            <VCardTitle class="text-h5 pa-0 text-wrap">
              {{ pr.desc }}
            </VCardTitle>
            <VCardSubtitle class="text-caption pa-0">
              {{ pr.number }}
            </VCardSubtitle>
          </VListItem>
        </VCard>
      </VCol>
    </VRow>
  </VContainer>
</template>
