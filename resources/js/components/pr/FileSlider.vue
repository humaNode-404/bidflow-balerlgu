<script setup>
import { useDisplay } from 'vuetify';
import PDFViewer from './components/PDFViewer.vue';

const props = defineProps({
  stages: Object,
});

const { mobile } = useDisplay();
const files = ref(
  props.stages.filter((x) => {
    return x.attachment !== null;
  }),
);
</script>

<template>
  <v-window :show-arrows="mobile ? mobile : 'hover'">
    <v-window-item v-for="(file, x) in files" :key="x">
      <VCard>
        <PDFViewer v-if="file.attachment" :files="file.attachment" />
      </VCard>
    </v-window-item>
    <v-window-item v-if="files.length == 0">
      <VEmptyState
        class="mx-auto my-5"
        width="368"
        icon="bi-folder-x"
        title="No Files Available"
        text="There are currently no files to show. Please check back later or upload new files."
      ></VEmptyState>
    </v-window-item>
  </v-window>
</template>

<style lang="scss" scoped>
.v-window-item {
  max-block-size: 600px;
  min-block-size: 500px;
}
</style>
