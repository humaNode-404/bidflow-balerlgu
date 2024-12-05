<!-- eslint-disable no-useless-escape -->
<script setup>
import QRCode from 'qrcode';
import { useTheme } from 'vuetify';
const { global } = useTheme();

const props = defineProps({
  item: {
    type: null,
    required: true,
  },
});

const qrContainer = ref(null);
const copyInfo = ref([false, 'Copy']);
const isDark = computed(() => (global.name.value === 'dark' ? true : false));
const scale = ref(props.item.scale);

let opts = [
  {
    errorCorrectionLevel: 'H',
    maskPattern: 1,
    scale: scale.value,
    quality: 1,
    margin: 0,
    color: {
      dark: '#2b2c40',
      light: '#0000',
    },
  },
  {
    errorCorrectionLevel: 'H',
    type: 'image/jpeg',
    maskPattern: 1,
    scale: 8,
    quality: 1,
    margin: 0.5,
  },
];

watchEffect(() => {
  opts[0].color.dark = isDark.value ? '#e6e6f1e6' : '#2b2c40';
});

watch(isDark, () => {
  QRCode.toCanvas(qrContainer.value, props.item.link, opts[0], (error) => {
    if (error) console.error(error);
  });
});

// Generate QR code when the component is mounted
onMounted(() => {
  QRCode.toCanvas(qrContainer.value, props.item.link, opts[0], (error) => {
    if (error) console.error(error);
  });
});

// Function to copy the QR code link
const copyQRCodeLink = () => {
  try {
    navigator.clipboard.writeText(props.item.link).then(() => {
      copyInfo.value = [true, 'Copied'];
    });
  } catch {
    copyInfo.value = [false, 'Failed'];
  }
  setInterval(() => {
    copyInfo.value = [true, 'Copy'];
  }, 2000);
};

// Function to download the QR code as an image
const downloadQRCode = () => {
  QRCode.toDataURL(props.item.link, opts[1], (error, url) => {
    if (error) {
      console.error(error);
    } else {
      const a = document.createElement('a');
      a.href = url;
      a.download =
        props.item.link
          .replace(/https?:\/\//, 'qr-')
          .replace(/[\/\\]/g, '-')
          .replace(/[^a-zA-Z0-9.-]/g, '')
          .replace(/-+/g, '-')
          .replace(/^-|-$/g, '') + '.jfif';
      a.click();
    }
  });
};
</script>

<template>
  <VCard title="PR QR-code" class="mb-7">
    <VCardText class="d-flex">
      <canvas ref="qrContainer"></canvas>

      <div class="d-flex flex-column ms-4 justify-center gap-5">
        <div class="d-flex flex-wrap gap-2">
          <VBtn
            @click="copyQRCodeLink"
            :color="!copyInfo[0] ? 'error' : 'primary'"
            variant="tonal"
          >
            <VIcon icon="bx-copy" class="d-sm-none" />
            <span class="d-none d-sm-block">{{ copyInfo[1] }}</span>
          </VBtn>

          <VBtn @click="downloadQRCode" color="info" variant="tonal">
            <span class="d-none d-sm-block">Download</span>
            <VIcon icon="bx-download" class="d-sm-none" />
          </VBtn>
        </div>
      </div>
    </VCardText>
  </VCard>
</template>
