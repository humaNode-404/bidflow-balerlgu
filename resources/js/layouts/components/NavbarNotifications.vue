<script setup>
import Notifications from '@/components/Notifications.vue';

const notifications = ref([
  {
    id: 1,
    avatar: 'http://[::1]:5173/resources/images/avatars/avatar-7.png',
    avatarName: 'CJ',
    title: 'Congratulation David! 🎉',
    subtitle: 'Won the monthly best seller badge',
    time: 'Today',
    isSeen: true,
  },
  {
    id: 2,
    avatar: '',
    avatarName: 'CJ',
    title: 'Congratulation David! 🎉',
    subtitle: 'Won the monthly best seller badge',
    time: 'Today',
    isSeen: false,
  },
  {
    id: 3,
    avatar: 'http://[::1]:5173/resources/images/avatars/avatar-9.png',
    avatarName: 'CJ',
    title: 'Congratulation David! 🎉',
    subtitle: 'Won the monthly best seller badge',
    time: 'Today',
    isSeen: false,
  },
  {
    id: 4,
    avatar: 'http://[::1]:5173/resources/images/avatars/avatar-12.png',
    avatarName: 'CJ',
    title: 'Congratulation David! 🎉',
    subtitle: 'Won the monthly best seller badge',
    time: 'Today',
    isSeen: false,
  },
]);

onMounted(() => {
  // window.Echo.channel('notifications') // Ensure the channel matches your backend setup
  //   .listen('.App\\Events\\NotificationSent', (data) => {
  //     alert('dsfsdf');
  //     // Add the new notification to the front of the list
  //     notifications.value.unshift(data); // This will push the new notification at the front
  //   });
});

onUnmounted(() => {
  //window.Echo.leave('notifications');
});

const removeNotification = (notificationId) => {
  notifications.value.forEach((item, index) => {
    if (notificationId === item.id) notifications.value.splice(index, 1);
  });
};

const toggleAllRead = (prevState) => {
  notifications.value.forEach((item) => {
    item.isSeen = prevState ? false : true;
  });
};

const toggleRead = (notificationId) => {
  notifications.value.forEach((item) => {
    notificationId.forEach((id) => {
      if (id === item.id) item.isSeen = !item.isSeen;
    });
  });
};

const handleNotificationClick = (notification) => {
  toggleRead([notification.id]);
};
</script>

<template>
  <Notifications
    :notifications="notifications"
    @remove="removeNotification"
    @read="toggleRead"
    @allread="toggleAllRead"
    @click:notification="handleNotificationClick"
  />
</template>
