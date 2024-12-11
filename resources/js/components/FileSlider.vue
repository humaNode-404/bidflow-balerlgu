<script setup>
import { useDisplay } from 'vuetify';

const { mobile } = useDisplay();
defineProps({
  files: { type: Object, required: true },
});
</script>

<template>
  <v-window :show-arrows="mobile ? mobile : 'hover'">
    <v-window-item>
      <VCard>
        <object
          :data="files.original.fileUrl"
          type="application/pdf"
          width="100%"
          height="500px"
        >
          <p>Your browser does not support viewing this file.</p>
        </object>
      </VCard>
    </v-window-item>
    <v-window-item>
      <VCard height="500px">
        <VEmptyState
          class="mx-auto"
          v-if="!files.original.fileUrlc"
          width="368"
          icon="bi-file-earmark-x"
          title="File Not Found"
          text="Oops! The file you're looking for seems to have been moved or no longer exists."
        ></VEmptyState>
        <object
          v-else
          :data="files.original.fileUrlc"
          type="application/pdf"
          width="100%"
          height="500px"
        >
          <p>
            Your browser does not support PDFs.
            <a :href="files.original.fileUrl" target="_blank">View PDF</a>
          </p>
        </object>
      </VCard>
    </v-window-item>
    <v-window-item>
      <VCard>
        <object
          :data="files.original.fileUrl"
          type="application/pdf"
          width="100%"
          height="500px"
        >
          <p>Your browser does not support viewing this file.</p>
        </object>
      </VCard>
    </v-window-item>
  </v-window>
</template>
