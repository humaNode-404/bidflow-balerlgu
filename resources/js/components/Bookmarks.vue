/* stylelint-disable @stylistic/declaration-block-trailing-semicolon */
<script setup>
import { router, usePage } from '@inertiajs/vue3';
import VerticalNavGroup from '@layouts/components/VerticalNavGroup.vue';

const bookmarks = ref(usePage().props.auth.bookmarks);

const bm = reactive({
  no: bookmarks.value.length,
  visible: bookmarks.value.length ? true : false,
});

watch(usePage(), () => {
  bookmarks.value = usePage().props.auth.bookmarks;
  bm.no = bookmarks.value.length;
  bm.visible = bookmarks.value.length ? true : false;
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
  <VerticalNavGroup
    v-if="bm.visible"
    :item="{
      title: bm.no > 1 ? 'Bookmarks' : 'Bookmark',
      icon: 'bx-bookmark',
    }"
  >
    <VList>
      <VListItem
        v-for="bookmark in bookmarks"
        :key="bookmark.id"
        color="primary"
        rounded="lg"
        class="mx-4"
        :class="{
          'router-link-active router-link-exact-active':
            $page.url === `/pr/${bookmark.number}`,
        }"
        :active="$page.url === `/pr/${bookmark.number}`"
        @click="link(`/pr/${bookmark.uuid}`)"
      >
        <template #title>
          <span class="text-capitalize">{{ bookmark.desc }}</span>
        </template>

        <template #subtitle>
          <span class="text-caption">{{ bookmark.number }}</span>
        </template>

        <v-tooltip activator="parent" location="end" open-delay="750">
          <span class="text-capitalize">{{ bookmark.desc }} </span><br />
          {{ bookmark.number }}
        </v-tooltip>
      </VListItem>
    </VList>
  </VerticalNavGroup>
</template>

<style lang="scss" scoped>
.tg-list {
  overflow: hidden; /* Prevent scrollbar flickering during transition */
}

.list-move, /* apply transition to moving elements */
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

/* ensure leaving items are taken out of layout flow so that moving
   animations can be calculated correctly. */
.list-leave-active {
  position: absolute;
}
</style>
