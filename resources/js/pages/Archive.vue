<script setup>
import { Deferred, router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { useDisplay } from 'vuetify';

const { xs } = useDisplay();

let props = defineProps({
  prdocs: Object,
  filters: Object,
  prModes: Object,
  offices: Object,
  users: Object,
  can: Object,
});

const search = ref(props.filters.search);

onMounted(() => {
  router.reload({
    only: ['prdocs', 'filters', 'prModes', 'offices', 'users'],
    replace: true,
  });
});

watch(
  search,
  debounce((value) => {
    if (value) {
      router.get(
        route('archive'),
        { search: value },
        { only: ['prdocs'], preserveState: true, replace: true },
      );
    } else {
      router.get(route('archive'));
    }
  }, 500),
);
</script>

<template>
  <Head :title="$page.component.split('/').at(-1)" />
  <VRow>
    <VCol v-if="can.prFilter" cols="12">
      <VCard density="compact" class="m-0 p-0">
        <VListItem>
          <VTextField
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
    </VCol>
    <Deferred data="prdocs">
      <template #fallback>
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
      </template>

      <PrCard v-if="prdocs.length" :prdocs="prdocs" />
      <VCol v-else cols="12">
        <VEmptyState
          icon="bx-file"
          title="No Records Found"
          text="There are no data to show at the moment. Check back later
                for updates."
        ></VEmptyState>
      </VCol>
    </Deferred>
  </VRow>
</template>
