<script setup>
import PrTabs from '@/components/pr/PrTabs.vue';
import Stage from '@/components/pr/Stage.vue';
import QrCode from '@/components/QrCode.vue';
import useAuth from '@/useAuth';
import { Deferred, router } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { useDisplay } from 'vuetify';

const { hasAnyRole } = useAuth();

dayjs.extend(relativeTime);

const { md } = useDisplay();
const panel = ref();

defineProps({
  prdoc: Object,
  prModes: Object,
});

const archiving = ref(false);
const toggleArchive = (number) => {
  router.post(
    route(
      'pr.delete',
      { number: number },
      {
        only: ['prdoc'],
        preserveState: true,
        onProgress: (progress) => {
          archiving.value = true;
          console.log(progress);
        },
        onSuccess: (page) => {
          archiving.value = false;
        },
      },
    ),
  );
};
</script>

<template>
  <Deferred data="prdoc">
    <template #fallback>
      <VContainer fluid class="mx-0 px-0">
        <VRow justify="space-between">
          <VCol cols="12" :md="hasAnyRole(['admin', 'bac']) ? '8' : '12'">
            <VCard>
              <v-skeleton-loader type="list-item, subtitle"></v-skeleton-loader>

              <div>
                <v-skeleton-loader type="button"></v-skeleton-loader>
                <v-spacer></v-spacer>
              </div>
            </VCard>
          </VCol>
          <VCol>
            <div class="position-sticky">
              <v-skeleton-loader type="list-item, subtitle"></v-skeleton-loader>

              <VDivider class="mx-2 mb-5" />
              <VCard elevation="24">
                <VCardText>
                  <v-skeleton-loader type="heading"></v-skeleton-loader>
                  <v-skeleton-loader type="heading"></v-skeleton-loader>
                </VCardText>
              </VCard>
            </div>
          </VCol>
        </VRow>
      </VContainer>
    </template>

    <VContainer fluid class="mx-0 px-0">
      <VRow justify="space-between">
        <VCol
          cols="12"
          :md="hasAnyRole(['admin', 'bac']) && prdoc.can_update ? '8' : '12'"
        >
          <VCard class="pr-detail">
            <VExpansionPanels v-model="panel" elevation="0" variant="accordion">
              <VExpansionPanel :hide-actions="md">
                <v-expansion-panel-title class="ms-0" disable-icon-rotate>
                  <VListItem class="px-0">
                    <VCardTitle class="text-h5 text-wrap px-0 pb-0">
                      {{ prdoc.desc }}
                    </VCardTitle>
                    <VCardSubtitle class="text-body-2 px-0">
                      {{ prdoc.user.name }} of {{ prdoc.office.abbr }} •
                      {{ prdoc.number }}
                      <div>
                        <span v-if="prdoc.deleted_at">
                          Completed at ({{
                            dayjs(prdoc.deleted_at).format('D MMM, YY')
                          }})
                        </span>
                        <span v-else-if="prdoc.failed_at">
                          Failed at ({{
                            dayjs(prdoc.failed_at).format('D MMM, YY')
                          }})
                        </span>
                      </div>
                    </VCardSubtitle>
                    <template #prepend>
                      <Avatar
                        :item="{
                          id: prdoc.user.uuid,
                          status: prdoc.user.status,
                          name: prdoc.user.name,
                          role: prdoc.user.role,
                          avatar: prdoc.user.avatar ? prdoc.user.avatar : '',
                          tooltipTitle: prdoc.user.name,
                        }"
                      ></Avatar>
                    </template>
                  </VListItem>
                  <template v-slot:actions>
                    <IconBtn
                      v-if="
                        false /*hasAnyRole(['admin']) && prdoc.failed_at === null*/
                      "
                      @click.stop
                    >
                      <VIcon
                        icon="bx-archive"
                        @click="toggleArchive(prdoc.number)"
                      ></VIcon>
                    </IconBtn>
                    <IconBtn class="me-1">
                      <VIcon icon="bx-share-alt"></VIcon>
                      <VMenu
                        activator="parent"
                        width="250"
                        location="bottom end"
                        offset="20px"
                        :close-on-content-click="false"
                      >
                        <QrCode
                          :item="{ scale: 5, link: route('pr', prdoc.uuid) }"
                        ></QrCode>
                      </VMenu>
                    </IconBtn>
                    <IconBtn
                      ><v-icon
                        color="primary"
                        icon="bx-info-circle"
                        size="x-large"
                      >
                      </v-icon
                    ></IconBtn>
                  </template>
                </v-expansion-panel-title>
                <VExpansionPanel-text class="mb-3">
                  <v-card density="compact">
                    <PrForm :prdoc="prdoc" :prModes="prModes" />
                  </v-card>
                </VExpansionPanel-text>
              </VExpansionPanel>
            </VExpansionPanels>

            <PrTabs class="mb-3" :stages="prdoc.stages" />
          </VCard>
        </VCol>
        <VCol v-if="prdoc.can_update">
          <Stage :stage="prdoc.assigned_stage"></Stage>
        </VCol>
      </VRow>
    </VContainer>
  </Deferred>
</template>

<style lang="scss" scoped>
.position-sticky {
  position: sticky;
  inset-block-start: 6rem;
}
</style>
