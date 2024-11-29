<script setup>
import { ref } from 'vue'

import { PerfectScrollbar } from 'vue3-perfect-scrollbar'

const isMenuOpen = ref(false)

// Prevent menu from closing when interacting inside it
const handleMenuClick = event => {
  event.stopPropagation()
}
</script>

<template>
  <IconBtn>
    <VIcon icon="bx-bell" />
    <VTooltip
      location="bottom"
      activator="parent"
      open-delay="1000"
    >
      <span class="text-capitalize">Notifications</span>
    </VTooltip>
    <VMenu
      v-model="isMenuOpen"
      activator="parent"
      width="400"
      location="bottom end"
      offset="20px"
    >
      <VCard @click.stop="handleMenuClick">
        <!-- Stops click from closing menu -->
        <VCardActions class="justify-space-between my-2 py-0">
          <VCardTitle class="text-h6 fw-bolder">
            <h4>Notifications</h4> 
          </VCardTitle>
          <IconBtn>
            <VIcon icon="bx-envelope" />
            <VTooltip
              location="bottom"
              activator="parent"
              open-delay="500"
            >
              <span class="text-capitalize">Mark all as read</span>
            </VTooltip>
          </IconBtn>
        </VCardActions>
        <VDivider />
        <VCardItem>
          <PerfectScrollbar
            tag="div"
            :options="{ wheelPropagation: false }"
          >
            cvdsfgcvx <br>zfgsdfgsdfgdf <br>xvsdfgsdfgcvc <br>xzcgsdfgsdgsr <br>
          </PerfectScrollbar>
        </VCardItem>
        <VDivider />
        <Link href="/notifications">
          <VBtn
            block
            class="rounded-t-0"
          >
            View all Notifications
          </VBtn>
        </Link>
      </VCard>
    </VMenu>
  </IconBtn>
</template>
