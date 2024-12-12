<script setup>
import { router, usePage } from '@inertiajs/vue3';

const url = reactive({
  prev: usePage().url,
  curr: usePage().url,
  que: [],
  comp: [],
  btnShow: false,
});

url.btnShow = url.que.length > 1;

watch(usePage(), (page) => {
  url.prev = url.curr;
  url.curr = page.url;

  if (url.comp.at(-1) != page.component) {
    url.que.push(url.curr);
    url.comp.push(page.component);
  }

  if (url.que.length > 20) {
    url.que.shift();
    url.comp.shift();
  }

  url.btnShow = url.que.length > 1;
  url.prev = url.que.at(-2);
});

function goBack() {
  if (url.prev) {
    router.visit(url.prev);
    url.que.pop();
    url.comp.pop();
  } else {
    router.visit(route('dashboard'));
  }
}
</script>

<template>
  <IconBtn v-if="url.btnShow" class="ms-0" @click="goBack">
    <VIcon icon="mdi-arrow-left" />
  </IconBtn>
</template>
