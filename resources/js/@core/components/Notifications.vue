<script setup>
const handleMenuClick = (event) => {
  event.stopPropagation();
};
const allRead = ref(false);
</script>

<template>
  <IconBtn>
    <VIcon icon="bx-bell" />
    <VTooltip location="bottom" activator="parent" open-delay="1000">
      <span class="text-capitalize">Notifications</span>
    </VTooltip>
    <VMenu activator="parent" width="400" location="bottom end" offset="20px">
      <VCard @click.stop="handleMenuClick">
        <!-- Stops click from closing menu -->
        <VCardItem>
          <VCardTitle class="text-h6"> Notifications </VCardTitle>
          <template v-slot:append>
            <VChip color="primary" class="me-2">2 New</VChip>
            <IconBtn @click="allRead = !allRead">
              <VIcon :icon="allRead ? 'bx-envelope' : 'bx-envelope-open'" />
              <VTooltip location="bottom" activator="parent" open-delay="1000">
                <span v-if="allRead" class="text-capitalize"
                  >Mark all as read</span
                >
                <span v-else class="text-capitalize">Mark all as unread</span>
              </VTooltip>
            </IconBtn>
          </template>
        </VCardItem>
        <VDivider />
        <VCardItem />
        <VDivider />
        <Link href="/notifications">
          <VBtn block class="rounded-t-0"> View all Notifications </VBtn>
        </Link>
      </VCard>
    </VMenu>
  </IconBtn>
</template>
