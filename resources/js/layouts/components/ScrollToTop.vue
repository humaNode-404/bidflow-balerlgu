<script setup>
import { onMounted, onUnmounted } from 'vue';

let debounceTimeout = null;
const isVisible = ref(false);

// Function to scroll the window to the top
const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
};

// Function to handle scroll events
const handleScroll = () => {
  clearTimeout(debounceTimeout);
  debounceTimeout = setTimeout(() => {
    isVisible.value =
      window.scrollY >
      (document.documentElement.scrollHeight - window.innerHeight) * 0.2;
  }, 75);
};

// Attach scroll listener on mount
onMounted(() => {
  window.addEventListener('scroll', handleScroll);
  handleScroll(); // Initialize visibility state on load
});

// Detach scroll listener on unmount
onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
  clearTimeout(debounceTimeout);
});
</script>

<template>
  <transition appear name="bounce">
    <IconBtn
      v-if="isVisible"
      color="primary"
      variant="elevated"
      @click="scrollToTop"
      class="scroll-to-top"
    >
      <VIcon icon="bx-up-arrow-alt"></VIcon>
    </IconBtn>
  </transition>
</template>

<style lang="scss" scoped>
.scroll-to-top {
  position: fixed;
  z-index: 1000;
  inset-block-end: 2.5rem;
  inset-inline-end: 1.5rem;
  transition: opacity 0.3s ease;
}

.bounce-enter-active {
  animation: bounce-in 0.5s;
}

.bounce-leave-active {
  animation: bounce-in 0.5s reverse;
}

@keyframes bounce-in {
  0% {
    transform: scale(0);
  }

  50% {
    transform: scale(1.25);
  }

  100% {
    transform: scale(1);
  }
}
</style>
