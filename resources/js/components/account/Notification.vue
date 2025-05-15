<script setup>
const recentDevices = ref([
  {
    type: 'Account activity',
    email: true,
    browser: true,
  },
  {
    type: 'A new browser used to sign in',
    email: true,
    browser: true,
  },
]);

const selectedNotification = ref("Only when I'm online");

const requestPermission = () => {
  if (Notification.permission === 'default') {
    Notification.requestPermission().then((permission) => {
      if (permission === 'granted') {
        console.log('Notifications granted.');
      } else {
        console.log('Notifications denied.');
      }
    });
  } else {
    console.log('Notifications permission already requested.');
  }
};
</script>

<template>
  <VCard title="Recent Devices">
    <VCardText>
      We need permission from your browser to show notifications.
      <a class="cursor-pointer" @click="requestPermission"
        >Request Permission</a
      >
    </VCardText>

    <VTable class="text-no-wrap">
      <thead>
        <tr>
          <th scope="col">Type</th>
          <th scope="col">EMAIL</th>
          <th scope="col">BROWSER</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="device in recentDevices" :key="device.type">
          <td>
            {{ device.type }}
          </td>
          <td>
            <VCheckbox v-model="device.email" />
          </td>
          <td>
            <VCheckbox v-model="device.browser" />
          </td>
        </tr>
      </tbody>
    </VTable>
    <VDivider />

    <VCardText>
      <VForm @submit.prevent="() => {}">
        <div class="d-flex mt-4 flex-wrap gap-4">
          <VBtn type="submit"> Save Changes </VBtn>
          <VBtn color="secondary" variant="tonal" type="reset"> Reset </VBtn>
        </div>
      </VForm>
    </VCardText>
  </VCard>
</template>

<style lang="scss" scoped>
.v-table {
  th {
    text-align: start !important;
  }
}
</style>
