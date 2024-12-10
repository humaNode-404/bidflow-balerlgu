<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
  item: {
    type: null,
    required: true,
  },
});

const rolemode = {
  admin: {
    color: 'primary',
  },
  mod: {
    color: 'info',
  },
  user: {
    color: 'warning',
  },
};

// const statusmode = {
//   active: {
//     color: 'success',
//   },
//   inactive: {
//     color: 'secondary',
//   },
//   restricted: {
//     color: 'error',
//   },
// };

const goto = () => {
  if (!props.item.id) return;
  router.get(
    `/profile/${props.item.id}`,
    {},
    {
      preserveScroll: true,
      preserveState: true,
      onError: (errors) => {
        console.error(errors);
      },
    },
  );
};
</script>

<template>
  <VAvatar
    @click="goto"
    class="cursor-pointer"
    :color="item.role ? rolemode[item.role].color : 'warning'"
    variant="tonal"
  >
    <VTooltip
      v-if="item.tooltipTitle"
      location="bottom"
      activator="parent"
      open-delay="250"
    >
      <span class="text-capitalize">{{ item.tooltipTitle }}</span>
      <span v-if="item.tooltipSubtitle" class="text-capitalize">
        <br />{{ item.tooltipSubtitle }}
      </span>
    </VTooltip>
    <VImg v-if="item.avatar" :src="item.avatar" />
    <span v-else class="text-body-2 initialism">
      {{ item.name.split(' ').at(0)[0] + item.name.split(' ').at(-1)[0] }}
    </span>
    <slot></slot>
  </VAvatar>
</template>
