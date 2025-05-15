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

const search = ref(usePage().props.flash.search);
const activeTab = ref(usePage().props.flash.tab || 'all');

watch(
  search,
  debounce((value) => {
    if (value) {
      router.get(
        route('archive'),
        { search: value, tab: activeTab.value },
        {
          only: ['completed', 'failed'],
          preserveScroll: true,
          preserveState: true,
          replace: true,
        },
      );
    } else {
      router.get(
        route('archive'),
        { tab: activeTab.value },
        {
          preserveScroll: true,
          preserveState: true,
          replace: true,
        },
      );
    }
  }, 500),
);

watch(activeTab, (value) => {
  router.get(
    route('archive'),
    { search: search.value, tab: value },
    {
      only: ['flash', 'failed'],
      showProgress: false,
      preserveScroll: true,
      preserveState: true,
      replace: true,
    },
  );
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

onMounted(() => {
  if (activeTab.value == 'priority')
    router.get(
      route('archive'),
      { search: search.value, tab: activeTab.value },
      {
        only: ['flash', 'failed'],
        showProgress: false,
        preserveScroll: true,
        preserveState: true,
        replace: true,
      },
    );
});
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard
        v-if="hasAnyRole(['admin', 'bac'])"
        density="compact"
        class="m-0 p-0"
      >
        <VListItem>
          <VTextField
            v-if="can('use-filter')"
            class="mx-2"
            hint="Search scope to PR (Mode, Description, Number)"
            v-model="search"
            clearable
            prepend-inner-icon="bx-search"
            placeholder="Search..."
            max-width="450px"
          />
        </VListItem>
      </VCard>

      <VTabs v-model="activeTab" class="v-tabs-pill mt-1 pb-0">
        <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
          <VIcon size="20" start :icon="item.icon" />
          {{ item.title }}
        </VTab>
      </VTabs>
    </VCol>
    <VCol>
      <VWindow v-model="activeTab" class="mt-5">
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
