/* stylelint-disable @stylistic/declaration-block-trailing-semicolon */
<script setup>
// eslint-disable-next-line prettier/prettier
import { router, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import updateLocale from 'dayjs/plugin/updateLocale';
import { PerfectScrollbar } from 'vue3-perfect-scrollbar';

dayjs.extend(relativeTime);
dayjs.extend(updateLocale);
dayjs.updateLocale('en', {
  relativeTime: {
    future: 'in %s',
    past: '%s ago',
    s: 'now',
    m: '1m',
    mm: '%dm',
    h: '1h',
    hh: '%dh',
    d: '1d',
    dd: '%dd',
    M: '1mo',
    MM: '%dmos',
    y: '1y',
    yy: '%dy',
  },
});

const unReadNo = ref(usePage().props.notifs.unReadNo);
const notif_pages = ref(usePage().props.notifs.pages);
const notifs = ref(usePage().props.notifs.pages.data);
const notif = reactive({
  hasmore: !(notif_pages.value.next_page_url == null),
  isfetching: false,
});

watchEffect(async () => {
  notif.hasmore = !(notif_pages.value.next_page_url == null);
});

// const x = ref(1);

// onMounted(() => {
//   // window.Echo.channel('notifications') // Ensure the channel matches your backend setup
//   //   .listen('.App\\Events\\NotificationSent', (data) => {
//   //     notifications.value.unshift(data); // This will push the new notification at the front
//   //   });
//   console.log('in');
//   console.log(++x.value);
// });

// onUnmounted(() => {
//   // window.Echo.leave('notifications');
//   console.log('out');
//   console.log(++x.value);
// });

const onVisible = (isIntersecting, entries, observer) => {
  if (isIntersecting && !notif.isfetching) {
    notif.isfetching = true;
    router.reload({
      only: ['notifs'],
      data: {
        page: new URL(notif_pages.value.next_page_url).searchParams.get(
          'notifpage',
        ),
      },
      preserveScroll: true,
      preserveState: true,
      preserveUrl: true,
      showProgress: false,
      onSuccess: () => {
        notifs.value.unshift(...usePage().props.notifs.pages.data);
        notif_pages.value = usePage().props.notifs.pages;
        notif.isfetching = false;
      },
    });
  }
};

const actionVisit = (id, action) => {
  router.put(route('notif.update', { notif: id }), {
    only: ['notifs'],
    replace: true,
    preserveState: true,
    preserveScroll: true,
  });
  if (action) {
    router.visit(action);
  }
};

const markAllAsRead = () => {
  router.visit(route('notif.markAllAsRead'), {
    method: 'post',
    only: ['notifs'],
    replace: true,
    preserveState: true,
    preserveScroll: true,
    showProgress: false,
    onSuccess: () => {
      console.log('Marked all as read');
      notifs.value = usePage().props.notifs.pages.data;
      unReadNo.value = usePage().props.notifs.unReadNo;
    },
  });
};

const deleteAll = () => {
  router.visit(route('notif.deleteAll'), {
    method: 'post',
    only: ['notifs'],
    replace: true,
    preserveState: true,
    preserveScroll: true,
    showProgress: false,
    onSuccess: () => {
      console.log('Deleted All notification');
      notifs.value = usePage().props.notifs.pages.data;
      unReadNo.value = usePage().props.notifs.unReadNo;
    },
  });
};

const toggleRead = (id) => {
  router.visit(route('notif.update', { notif: id }), {
    method: 'patch',
    only: ['notifs'],
    replace: true,
    preserveState: true,
    preserveScroll: true,
    showProgress: false,
    onSuccess: () => {
      notifs.value = usePage().props.notifs.pages.data;
      unReadNo.value = usePage().props.notifs.unReadNo;
    },
  });
};

const deleteNotif = (id) => {
  router.delete(route('notif.destroy', { notif: id }), {
    only: ['notifs'],
    replace: true,
    preserveScroll: true,
    showProgress: false,
    onSuccess: () => {
      let notif = notifs.value.find((n) => n.id === id);
      if (notif.read_at === null) {
        unReadNo.value--;
      }
      notifs.value = notifs.value.filter((n) => n.id !== id);
    },
  });
};
</script>

<template>
  <IconBtn class="me-0">
    <slot name="notif-icon">
      <VIcon icon="bx-bell" />
      <VTooltip location="bottom" activator="parent">
        <span class="text-capitalize">Notifications</span>
      </VTooltip>
    </slot>
    <VBadge
      v-if="unReadNo >= 1"
      location="top right"
      offset-x="2"
      offset-y="-9"
      color="error"
      dot
    >
      <slot for="notif-icon"></slot>
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
            <VChip v-if="unReadNo" color="primary" class="me-2">
              {{ unReadNo }} unread
            </VChip>
            <IconBtn
              @click="markAllAsRead"
              v-tooltip:bottom="'Mark all as read'"
            >
              <VIcon
                :icon="unReadNo > 0 ? 'bx-envelope' : 'bx-envelope-open'"
              />
            </IconBtn>
            <IconBtn @click="deleteAll" v-tooltip:bottom="'Delete all'">
              <VIcon icon="bx-trash" />
            </IconBtn>
          </template>
        </VCardItem>
        <VDivider />
        <PerfectScrollbar
          tag="div"
          :options="{ wheelPropagation: false, suppressScrollX: true }"
        >
          <VList class="notification-list rounded-0 px-0" lines="three">
            <TransitionGroup appear name="list" tag="div" class="tg-list">
              <VListItem
                v-for="notif in notifs"
                :key="notif.id"
                :active="notif.read_at == null"
                color="info"
                link
                @click-once="actionVisit(notif.id, notif.data.action)"
              >
                <template #prepend>
                  <VAvatar color="info" variant="tonal">
                    <VImg
                      v-if="notif.data.avatar.avatar"
                      :src="notif.data.avatar.avatar"
                    />
                    <span v-else class="text-h5">{{
                      notif.data.avatar.name_initial
                    }}</span>
                  </VAvatar>
                </template>
                <template #append>
                  <VMenu :close-on-content-click="false">
                    <template #activator="{ props }">
                      <VBtn
                        v-bind="props"
                        color="muted"
                        icon="bx-dots-vertical-rounded"
                        variant="text"
                      />
                    </template>

                    <VList>
                      <VListItem
                        :title="
                          notif.read_at === null
                            ? 'Mark as read'
                            : 'Mark as unread'
                        "
                        @click-once="toggleRead(notif.id)"
                      />
                      <VListItem
                        title="Delete"
                        @click-once="deleteNotif(notif.id)"
                      />
                    </VList>
                  </VMenu>
                </template>
                <template #title>
                  <p class="font-weight-medium text-md mb-1 text-wrap">
                    {{ notif.data.title }}
                  </p>
                </template>
                <template #subtitle>
                  <p class="text-caption text-medium-emphasis mb-2 text-wrap">
                    {{ notif.data.subtitle }}
                  </p>
                </template>
                <p class="text-caption mb-0">
                  {{ dayjs(notif.created_at).fromNow() }}
                </p>
              </VListItem>
              <VListItem v-if="notif.hasmore" key="1">
                <VEmptyState
                  v-intersect="{
                    handler: onVisible,
                    options: {
                      threshold: [1.0],
                    },
                  }"
                >
                  <template #title>
                    <v-progress-circular
                      class="me-2"
                      size="30"
                      color="primary"
                      indeterminate
                    >
                    </v-progress-circular>
                    Loading...
                  </template>
                </VEmptyState>
              </VListItem>
            </TransitionGroup>
            <VEmptyState
              v-if="!notifs.length"
              icon="bx-bell-off"
              title="You're All Caught Up!"
              text="There are no new notifications at the moment. Check back later
                for updates."
            ></VEmptyState>
          </VList>
        </PerfectScrollbar>
        <VDivider />
        <Link href="/notifications" v-if="false">
          <VBtn block class="rounded-t-0"> View all Notifications </VBtn>
        </Link>
      </VCard>
    </VMenu>
  </IconBtn>
</template>

<style lang="scss">
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
