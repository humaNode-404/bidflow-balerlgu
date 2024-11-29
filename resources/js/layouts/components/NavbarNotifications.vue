<script setup>
const notifications = ref([
  {
    id: 1,
    img: 'avatar-4',
    title: 'Congratulation Flora! 🎉',
    subtitle: 'Won the monthly best seller badge',
    time: 'Today',
    isSeen: true,
  },
])

const removeNotification = notificationId => {
  notifications.value.forEach((item, index) => {
    if (notificationId === item.id)
      notifications.value.splice(index, 1)
  })
}

const markRead = notificationId => {
  notifications.value.forEach(item => {
    notificationId.forEach(id => {
      if (id === item.id)
        item.isSeen = true
    })
  })
}

const markUnRead = notificationId => {
  notifications.value.forEach(item => {
    notificationId.forEach(id => {
      if (id === item.id)
        item.isSeen = false
    })
  })
}

const handleNotificationClick = notification => {
  if (!notification.isSeen)
    markRead([notification.id])
}
</script>

<template>
  <VBadge
    dot
    location="top right"
    offset-x="9"
    offset-y="9"
    color="error"
  > 
    <Notifications 
      :notifications="notifications"
      @remove="removeNotification"
      @read="markRead"
      @unread="markUnRead"
      @click:notification="handleNotificationClick"
    />
  </VBadge>
</template>
