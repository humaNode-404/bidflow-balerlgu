<script setup>
import { useTheme } from 'vuetify';

const props = defineProps({
  themes: {
    type: Array,
    required: true,
  },
});

const { global: globalTheme } = useTheme();

// Check if a theme is stored in localStorage
const savedTheme = localStorage.getItem('theme');

// If a theme is saved in localStorage, use it, otherwise use the system's preferred theme
const initialTheme =
  savedTheme ||
  (window.matchMedia('(prefers-color-scheme: dark)').matches
    ? 'dark'
    : 'light');

// Set up the theme cycle list based on the props
const {
  state: currentThemeName,
  next: getNextThemeName,
  index: currentThemeIndex,
} = useCycleList(
  props.themes.map((t) => t.name),
  { initialValue: initialTheme }, // Use the initialTheme here
);

// Function to change the theme and save it to localStorage
const changeTheme = () => {
  const newTheme = getNextThemeName();
  globalTheme.name.value = newTheme;
  localStorage.setItem('theme', newTheme); // Save the new theme to localStorage
};

// Update icon if theme is changed from other sources
watch(
  () => globalTheme.name.value,
  (val) => {
    currentThemeName.value = val;
  },
);

// Set the initial theme based on localStorage or system preference
onMounted(() => {
  if (savedTheme) {
    globalTheme.name.value = savedTheme; // Apply the saved theme if available
  } else {
    globalTheme.name.value = initialTheme; // Use system preference if not saved
  }
});
</script>

<template>
  <IconBtn @click="changeTheme">
    <VIcon :icon="props.themes[currentThemeIndex].icon" />
    <VTooltip activator="parent" open-delay="1000" scroll-strategy="close">
      <span class="text-capitalize">{{ currentThemeName }}</span>
    </VTooltip>
  </IconBtn>
</template>
