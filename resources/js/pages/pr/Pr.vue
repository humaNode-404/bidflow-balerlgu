<script setup>
import QrCode from '@/components/QrCode.vue';
import { router, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { provide } from 'vue';
import { useDisplay } from 'vuetify';
import PrTabs from './partials/PrTabs.vue';

dayjs.extend(relativeTime);

const { md, mdAndDown } = useDisplay();

const props = defineProps({
  prdoc: Object,
  can: Object,
});

const pr = ref(props.prdoc[0]);
const stages = ref(props.prdoc[0].stages);

let user = usePage().props.auth.user;

watch(usePage, () => {
  user = usePage().props.auth.user;
});

const assigned_stages = computed(() => {
  if (user.role != 'admin') return props.prdoc[0].assigned_stages;
  else return props.prdoc[0].stages;
});

provide('pr', pr);
provide('stages', stages);

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
    color: 'error',
  },
  'in progress': {
    icon: 'mdi-progress-clock',
    color: 'info',
  },
  'on hold': {
    icon: 'mdi-pause-circle-outline',
    color: 'warning',
  },
  completed: {
    icon: 'mdi-check-circle-outline',
    color: 'success',
  },
};

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

const toggleArchive = (uuid) => {
  router.post(`/pr/${uuid}/delete`);
};
</script>

<template>
  <VContainer fluid class="mx-0 px-0">
    <VRow justify="space-between">
      <VCol cols="12" :md="can.view_stages ? '8' : '12'">
        <VCard class="pr-detail position-sticky h-screen">
          <VExpansionPanels elevation="0" variant="accordion">
            <VExpansionPanel :hide-actions="md">
              <v-expansion-panel-title class="ms-0" disable-icon-rotate>
                <VListItem class="px-0">
                  <VCardTitle class="text-h5 text-wrap px-0 pb-0">
                    {{ pr.desc }}
                  </VCardTitle>
                  <VCardSubtitle class="text-body-2 px-0">
                    {{ pr.number }}
                  </VCardSubtitle>
                </VListItem>
                <template v-slot:actions>
                  <IconBtn
                    class="me-1"
                    v-if="can.archive"
                    @click="toggleArchive(pr.uuid)"
                  >
                    <VIcon icon="bx-archive"></VIcon>
                  </IconBtn>
                  <IconBtn class="me-2">
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
                  <v-icon
                    class="mt-1"
                    color="primary"
                    icon="bx-info-circle"
                    size="x-large"
                  >
                  </v-icon>
                </template>
              </v-expansion-panel-title>
              <VExpansionPanel-text class="mb-3">
                <v-card density="compact">
                  <VCardText>
                    <v-row>
                      <!-- PR Value -->
                      <v-col cols="12" md="6">
                        <v-text-field
                          readonly
                          v-model="pr.value"
                          label="PR Value"
                          placeholder="1234.56"
                          persistent-placeholder
                          prefix="₱"
                          outlined
                        />
                      </v-col>
                      <!-- PR Mode -->
                      <v-col cols="12" md="6">
                        <V-Select
                          readonly
                          v-model="pr.mode"
                          prepend-icon="mdi-gavel"
                          placeholder="PR Mode"
                          persistent-placeholder
                        />
                      </v-col>
                    </v-row>

                    <v-row>
                      <!-- PR Purpose -->
                      <v-col cols="12">
                        <v-textarea
                          readonly
                          hide-details
                          v-model="pr.purpose"
                          label="Purpose"
                          placeholder="The purpose or reason for the request."
                          persistent-placeholder
                          counter
                          auto-grow
                          rows="2"
                          outlined
                        />
                      </v-col>
                    </v-row>

                    <v-row justify="space-around">
                      <v-col cols="12" md="6">
                        <!-- PR Event Need -->
                        <v-text-field
                          readonly
                          v-model="pr.event_need"
                          label="Event Date"
                          placeholder="Target date to have the request."
                          persistent-placeholder
                          outlined
                        />
                      </v-col>

                      <v-col cols="12" md="6">
                        <!-- PR Event Location -->
                        <v-text-field
                          readonly
                          hide-details
                          v-model="pr.event_loc"
                          label="Event Location"
                          placeholder="Location of the event."
                          persistent-placeholder
                          outlined
                        />
                      </v-col>
                    </v-row>
                  </VCardText>
                </v-card>
              </VExpansionPanel-text>
            </VExpansionPanel>
          </VExpansionPanels>

          <PrTabs class="mb-3" />
        </VCard>
      </VCol>
      <VCol v-if="can.view_stages" cols="12" md="4">
        <VListItem prepend-icon="bi-check2-circle" class="mb-3 ps-1">
          <VListItemTitle class="text-h5"> Assigned Process </VListItemTitle>
        </VListItem>

        <VCard v-for="stage in assigned_stages" :key="stage.uuid" class="mb-3">
          <VListItem
            class="py-2"
            :title="
              (stage.main_proc ? `${stage.main_proc}: ` : '') + stage.proc
            "
            @click="
              link(
                route('stage.show', {
                  prdoc: pr.number,
                  stageaction: stage.uuid,
                }),
              )
            "
          >
            <VListItemSubtitle class="text-caption pa-0">
              {{ dayjs(stage.created_at).fromNow() }}
            </VListItemSubtitle>
          </VListItem>
        </VCard>
      </VCol>
    </VRow>
  </VContainer>
</template>

<style lang="scss" scoped>
.pr-detail {
  inset-block-start: 5.8rem;
}
</style>
