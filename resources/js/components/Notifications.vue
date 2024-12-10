/* stylelint-disable @stylistic/declaration-block-trailing-semicolon */
<script setup>
// eslint-disable-next-line prettier/prettier
import { PerfectScrollbar } from 'vue3-perfect-scrollbar';

// Define the events
const emit = defineEmits(['remove', 'allread', 'click:notification']);

// Sample notifications array passed as a prop
const props = defineProps({
  notifications: {
    type: Array,
    required: true,
  },
});

const unSeenNo = ref(0);
const prevState = ref(false);
const hoveredId = ref(null);

watchEffect(() => {
  unSeenNo.value = 0;
  props.notifications.forEach((item) => {
    if (!item.isSeen) unSeenNo.value++;
  });
});

// Functions to emit events
const removeNotification = (id) => {
  emit('remove', id); // Trigger 'remove' event
};

const toggleAllRead = (prev) => {
  prevState.value = !prevState.value;
  emit('allread', prev); // Trigger 'remove' event
};

const notificationClicked = (notification) => {
  emit('click:notification', notification); // Trigger 'click:notification' event
};
</script>

<template>
  <IconBtn class="me-0">
    <slot name="notif-icon">
      <VIcon icon="bx-bell" />
      <VTooltip location="bottom" activator="parent" open-delay="1000">
        <span class="text-capitalize">Notifications</span>
      </VTooltip>
    </slot>
    <VBadge
      v-if="unSeenNo"
      dot
      location="top right"
      offset-x="2"
      offset-y="-9"
      color="error"
      ><slot for="notif-icon"></slot>
    </VBadge>
    <slot v-else for="notif-icon"></slot>
    <VMenu
      activator="parent"
      width="400"
      location="bottom end"
      offset="20px"
      :close-on-content-click="false"
    >
      <VCard>
        <!-- Stops click from closing menu -->
        <VCardItem class="px-4 py-2">
          <VCardTitle class="text-h6">
            <strong>Notifications</strong>
          </VCardTitle>
          <template #append>
            <VChip v-if="unSeenNo" color="primary" class="me-2">
              {{ unSeenNo + ' new' }}
            </VChip>
            <IconBtn @click="toggleAllRead(prevState)">
              <VIcon :icon="unSeenNo ? 'bx-envelope' : 'bx-envelope-open'" />
              <VTooltip location="bottom" activator="parent" open-delay="1000">
                <span v-if="notifications.length">
                  {{ unSeenNo ? 'Mark all as read' : 'Mark all as unread' }}
                </span>
                <span v-else>Empty</span>
              </VTooltip>
            </IconBtn>
          </template>
        </VCardItem>
        <VDivider />
        <PerfectScrollbar
          tag="div"
          :options="{ wheelPropagation: false, suppressScrollX: true }"
        >
          <VList class="notification-list rounded-0 py-0">
            <TransitionGroup
              appear
              name="list"
              tag="div"
              class="tg-list"
              mode="out-in"
            >
              <VListItem
                v-for="notif in notifications"
                :key="notif.id"
                @click="notificationClicked(notif)"
                @mouseover="hoveredId = notif.id"
                @mouseleave="hoveredId = null"
              >
                <template #prepend>
                  <VAvatar color="info" variant="tonal">
                    <VImg v-if="notif.avatar" :src="notif.avatar" />
                    <span v-else class="text-h5">{{ notif.avatarName }}</span>
                  </VAvatar>
                </template>
                <template #append>
                  <slot name="remove-notif">
                    <VBtn
                      v-show="hoveredId === notif.id"
                      color="muted"
                      icon="bx-x"
                      variant="text"
                      @click="removeNotification(notif.id)"
                    />
                  </slot>
                  <VBadge
                    v-if="!notif.isSeen"
                    dot
                    color="primary"
                    location="top right"
                    offset-x="0"
                    offset-y="-20"
                  />
                </template>
                <template #title>
                  <p class="font-weight-medium text-md mb-1">
                    {{ notif.title }}
                  </p>
                </template>
                <template #subtitle>
                  <p class="text-caption text-medium-emphasis mb-2">
                    {{ notif.subtitle }}
                  </p>
                </template>
                <p class="text-caption mb-0">{{ notif.time }}</p>
              </VListItem>
              <VEmptyState
                v-if="!notifications.length"
                icon="bx-bell-off"
                title="You're All Caught Up!"
                text="There are no new notifications at the moment. Check back later
                for updates."
              ></VEmptyState>
            </TransitionGroup>
          </VList>
        </PerfectScrollbar>
        <VDivider />
        <Link href="/notifications">
          <VBtn block class="rounded-t-0"> View all Notifications </VBtn>
        </Link>
      </VCard>
    </VMenu>
  </IconBtn>
</template>

<style lang="scss" scoped>
.tg-list {
  overflow: hidden; /* Prevent scrollbar flickering during transition */
}

.notification-list {
  max-block-size: 100%; /* Ensure consistent height for the list */
}

.ps {
  max-block-size: 22.5rem;
}

.v-list-item {
  min-block-size: 66px;
}

.list-move, /* apply transition to moving elements */
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

/* ensure leaving items are taken out of layout flow so that moving
   animations can be calculated correctly. */
.list-leave-active {
  position: absolute;
}
</style>
