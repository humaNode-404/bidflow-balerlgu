<script setup>
import { Inertia } from '@inertiajs/inertia'; // Import Inertia to hook into page navigation events
import { onMounted, ref } from 'vue';

defineProps({
  item: {
    type: Object,
    required: true,
  },
});

const isOpen = ref(false); // Whether the nav group is open
const isActive = ref(false); // Whether the nav group has an active child
const navGroupRef = ref(null); // Ref to the current `nav-group` element

// Function to check if any child of the nav-group has active classes
const checkActiveChild = () => {
  if (!navGroupRef.value) return false;

  // Check if any child has the active class
  return Array.from(navGroupRef.value.querySelectorAll('*')).some(
    (child) =>
      child.classList.contains('router-link-active') &&
      child.classList.contains('router-link-exact-active'),
  );
};

// Automatically check the active child and update the state
const updateActiveState = () => {
  const hasActiveChild = checkActiveChild();

  isActive.value = hasActiveChild;

  // Automatically close the group if no active child is found
  if (!hasActiveChild) {
    isOpen.value = false;
  }
};

// Handle the manual toggle of the group
const toggleGroup = () => {
  isOpen.value = !isOpen.value; // Toggle the group open/close manually
};

// Handle Inertia navigation event to check if the group should be active or closed
onMounted(() => {
  // Set initial state on mount
  updateActiveState();

  // Listen for Inertia navigation events
  Inertia.on('navigate', () => {
    updateActiveState(); // Recheck active state after page navigation
  });
});
</script>

<template>
  <li
    ref="navGroupRef"
    class="nav-group"
    :class="{ active: isActive, open: isOpen }"
  >
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
