<script setup>
defineProps({
  files: String,
});
</script>

<template>
  <VEmptyState
    class="mx-auto"
    v-if="!files"
    width="368"
    icon="bi-file-earmark-x"
    title="File Not Found"
    text="Oops! The file you're looking for seems to have been moved or no longer exists."
  ></VEmptyState>
  <embed v-else :src="files" type="application/pdf" width="100%" height="600" />
</template>
