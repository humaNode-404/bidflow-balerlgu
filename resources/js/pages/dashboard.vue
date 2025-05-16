<script setup>
import NewPr from '@/components/dashboard/NewPr.vue';
import useAuth from '@/useAuth';
import { Deferred, router, usePage } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { useDisplay } from 'vuetify';

const { can } = useAuth();

const { xs } = useDisplay();

defineProps({
  prdocs: Object,
  priorities: Object,
  prModes: Object,
  offices: Object,
  users: Object,
});

const tabs = [
  {
    title: 'All',
    icon: 'bx-border-all',
    tab: 'all',
  },
  {
    title: 'High Priority',
    icon: 'mdi-priority-high',
    tab: 'priority',
  },
];

const flash = reactive({
  search: usePage().props.flash.search,
  tab: tabs.some((t) => t.tab === usePage().props.flash.tab)
    ? usePage().props.flash.tab
    : 'all',
});

watch(
  () => flash.search,
  debounce((value) => {
    if (value) {
      router.get(
        route('dashboard'),
        { search: value, tab: flash.tab },
        {
          only: ['prdocs', 'priorities'],
          preserveScroll: true,
          preserveState: true,
          replace: true,
        },
      );
    } else {
      router.get(
        route('dashboard'),
        { tab: flash.tab },
        {
          only: ['flash', 'priorities'],
          preserveScroll: true,
          preserveState: true,
          replace: true,
        },
      );
    }
  }, 500),
);

watch(
  () => flash.tab,
  (value) => {
    router.get(
      route('dashboard'),
      { search: flash.search, tab: value },
      {
        only: ['flash', 'priorities'],
        showProgress: false,
        preserveScroll: true,
        preserveState: true,
        replace: true,
      },
    );
  },
);

onMounted(() => {
  let tab = usePage().props.flash.tab;
  if (tab == 'priority') {
    router.get(
      route('dashboard'),
      { tab: tab },
      {
        only: ['flash', 'priorities'],
        showProgress: false,
        preserveScroll: true,
        preserveState: true,
        replace: true,
      },
    );
  }
});
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard density="compact" class="m-0 p-0">
        <VListItem>
          <template #prepend>
            <NewPr
              v-if="can('create-prdoc')"
              :item="{
                prModes: prModes,
                offices: offices,
                users: users,
              }"
            />
          </template>
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
        <VWindowItem value="all">
          <Deferred data="prdocs">
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
              <PrCard v-if="prdocs.length" :prdocs="prdocs" />
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

        <VWindowItem value="priority">
          <Deferred data="priorities">
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
              <PrCard v-if="priorities" :prdocs="priorities" />
              <VCol v-if="priorities.length == 0" cols="12">
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
