<script setup>
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
  {
    id: 5,
    avatar: 'http://[::1]:5173/resources/images/avatars/avatar-12.png',
    avatarName: 'CJ',
    title: 'Congratulation David! 🎉',
    subtitle: 'Won the monthly best seller badge',
    time: 'Today',
    isSeen: true,
  },
  {
    id: 6,
    avatar: 'http://[::1]:5173/resources/images/avatars/avatar-12.png',
    avatarName: 'CJ',
    title: 'Congratulation David! 🎉',
    subtitle: 'Won the monthly best seller badge',
    time: 'Today',
    isSeen: false,
  },
  {
    id: 7,
    avatar: 'http://[::1]:5173/resources/images/avatars/avatar-12.png',
    avatarName: 'CJ',
    title: 'Congratulation David! 🎉',
    subtitle: 'Won the monthly best seller badge',
    time: 'Today',
    isSeen: true,
  },
]);

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
