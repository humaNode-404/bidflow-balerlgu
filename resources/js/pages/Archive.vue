<script setup>
import useAuth from '@/useAuth';
import { Deferred, router, usePage } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { useDisplay } from 'vuetify';

const { hasAnyRole, can } = useAuth();

const { xs } = useDisplay();

defineProps({
  completed: Object,
  failed: Object,
});

const tabs = [
  {
    title: 'Completed',
    icon: 'bx-check-circle',
    tab: 'completed',
  },
  {
    title: 'Failed',
    icon: 'bx-error-circle',
    tab: 'failed',
  },
];

const flash = reactive({
  search: usePage().props.flash.search,
  tab: tabs.some((t) => t.tab === usePage().props.flash.tab)
    ? usePage().props.flash.tab
    : 'completed',
});

watch(
  () => flash.search,
  debounce(() => {
    pageReload();
  }, 500),
);

watch(
  () => flash.tab,
  () => {
    pageReload();
  },
);

onMounted(() => {
  if (flash.tab == 'failed') {
    pageReload();
  }
});

const pageReload = () => {
  router.get(
    route('archive'),
    flash.search
      ? { search: flash.search, tab: flash.tab }
      : { tab: flash.tab },
    {
      only: [flash.tab, 'flash'],
      showProgress: false,
      preserveScroll: true,
      preserveState: true,
      replace: true,
    },
  );
};
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard density="compact" class="m-0 p-0">
        <VListItem>
          <VTextField
            v-if="can('use-filter')"
            class="mx-2"
            hint="Search scope to PR (Mode, Description, Number)"
            v-model="flash.search"
            clearable
            prepend-inner-icon="bx-search"
            placeholder="Search..."
            max-width="450px"
          />
        </VListItem>
      </VCard>

      <VTabs v-model="flash.tab" class="v-tabs-pill mt-1 pb-0">
        <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
          <VIcon size="20" start :icon="item.icon" />
          {{ item.title }}
        </VTab>
      </VTabs>
    </VCol>
    <VCol>
      <VWindow v-model="flash.tab" class="mt-5">
        <VWindowItem value="completed">
          <Deferred data="completed">
            <template #fallback>
              <VRow>
                <VCol
                  v-for="n in 5"
                  :key="n"
                  cols="12"
                  sm="6"
                  md="4"
                  :class="{ 'mx-0 px-0 pt-0': xs }"
                >
                  <v-skeleton-loader
                    class="mx-auto"
                    elevation="12"
                    max-width="400"
                    type="list-item-avatar-two-line, image, paragraph, paragraph, avatar, chip "
                  ></v-skeleton-loader>
                </VCol>
              </VRow>
            </template>

            <VRow>
              <PrCardArchive v-if="completed.length" :prdocs="completed" />
              <VCol v-else cols="12">
                <VEmptyState
                  icon="bx-file"
                  title="No Records Found"
                  text="There are no data to show at the moment. Check back later for updates."
                ></VEmptyState>
              </VCol>
            </VRow>
          </Deferred>
        </VWindowItem>

        <VWindowItem value="failed">
          <Deferred data="failed">
            <template #fallback>
              <VRow>
                <VCol
                  v-for="n in 5"
                  :key="n"
                  cols="12"
                  sm="6"
                  md="4"
                  :class="{ 'mx-0 px-0 pt-0': xs }"
                >
                  <v-skeleton-loader
                    class="mx-auto"
                    elevation="12"
                    max-width="400"
                    type="list-item-avatar-two-line, image, paragraph, paragraph, avatar, chip "
                  ></v-skeleton-loader>
                </VCol>
              </VRow>
            </template>

            <VRow>
              <PrCardArchive v-if="failed" :prdocs="failed" />
              <VCol v-if="failed.length == 0" cols="12">
                <VEmptyState
                  icon="bx-file"
                  title="No Records Found"
                  text="There are no data to show at the moment. Check back later for updates."
                ></VEmptyState>
              </VCol>
            </VRow>
          </Deferred>
        </VWindowItem>
      </VWindow>
    </VCol>
  </VRow>
</template>
