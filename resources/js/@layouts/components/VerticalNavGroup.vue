<script setup>
import { Inertia } from '@inertiajs/inertia'; // Import Inertia to hook into page navigation events

defineProps({
  item: {
    type: Object,
    required: true,
  },
});

const isOpen = ref(false);
const isActive = ref(false);
const navRef = ref(null);

// Function to check if any child of the nav-group has active classes
const checkActiveChild = () => {
  if (!navRef.value) return false;

  return Array.from(navRef.value.querySelectorAll('*')).some(
    (child) =>
      child.classList.contains('router-link-active') &&
      child.classList.contains('router-link-exact-active'),
  );
};

// Automatically check the active child and update the state
const updateActiveState = () => {
  let has = checkActiveChild();

  isActive.value = has;

  if (!has) {
    isOpen.value = false;
  }
};

// Handle the manual toggle of the group
const toggleGroup = () => {
  isOpen.value = !isOpen.value; // Toggle the group open/close manually
};

// Handle Inertia navigation event to check if the group should be active or closed
onMounted(() => {
  Inertia.on('navigate', () => {
    updateActiveState();
  });
});
</script>

<template>
  <li ref="navRef" class="nav-group" :class="{ open: isOpen }">
    <div
      class="nav-group-label"
      :class="{ 'bg-primary': isActive }"
      @click="toggleGroup"
    >
      <VIcon :icon="item.icon || 'bxs-circle'" class="nav-item-icon" />
      <span class="nav-item-title">{{ item.title }}</span>
      <span class="nav-item-badge" :class="item.badgeClass">
        {{ item.badgeContent }}
      </span>
      <VIcon icon="bx-chevron-right" class="nav-group-arrow" />
    </div>
    <div class="nav-group-children-wrapper">
      <ul class="nav-group-children">
        <slot />
      </ul>
    </div>
  </li>
</template>

<style lang="scss">
.layout-vertical-nav {
  .nav-group {
    &-label {
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .nav-group-children-wrapper {
      display: grid;
      grid-template-rows: 0fr;
      transition: grid-template-rows 0.3s ease-in-out;

      .nav-group-children {
        overflow: hidden;
      }
    }

    &.open {
      .nav-group-children-wrapper {
        grid-template-rows: 1fr;
      }
    }
  }
}
</style>
