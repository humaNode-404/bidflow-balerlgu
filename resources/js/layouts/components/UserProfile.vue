<!-- eslint-disable prettier/prettier -->
<script setup>
import Avatar from '@/components/Avatar.vue';
import { router, usePage } from '@inertiajs/vue3';

const resolveStatusVariant = (role) => {
  if (role === 'admin')
    return {
      color: 'primary',
      text: 'Admin',
    };
  else if (role === 'bac')
    return {
      color: 'info',
      text: 'Moderator',
    };
  else if (role === 'user')
    return {
      color: 'warning',
      text: 'User',
    };
  else
    return {
      color: 'warning',
      text: 'User',
    };
};

const user = ref(usePage().props.auth.user);

const link = (href, m = 'get') => {
  router.visit(href, {
    method: m,
  });
};

onMounted(() => {
  window.Echo.channel(`user.${user.value.id}`)
    .listen('.profile.updated', () => {
       router.reload( { 
        only: ['auth'],
       onSuccess: page => {
          user.value = page.props.auth?.user;
       },
        });
    });
});

onUnmounted(() => {
  window.Echo.leave(`user.${user.value.id}`);
});

</script>

<template>
  <VAvatar class="cursor-pointer" color="primary" variant="tonal">
    <VTooltip location="bottom" activator="parent" open-delay="500">
      <span class="text-capitalize">Profile</span>
    </VTooltip>
    <VImg v-if="user.avatar" :src="user.avatar" />
    <span v-else-if="user.name" class="text-body-2 initialism">{{
      user.name.split(' ').at(0)[0] + user.name.split(' ').at(-1)[0]
    }}</span>
    <VIcon v-else icon="bi-person"></VIcon>

    <!-- SECTION Menu -->
    <VMenu activator="parent" location="bottom end" offset="20px">
      <VList>
        <!-- 👉 User Avatar & Name -->
        <VListItem>
          <template #prepend>
            <VListItemAction>
              <Avatar
                :item="{
                  name: user.name,
                  role: user.role,
                  avatar: user.avatar,
                }"
              >
              </Avatar>
            </VListItemAction>
          </template>

          <VListItemTitle
            class="font-weight-semibold text-capitalize text-wrap"
            width="146"
          >
            {{ user.name }}
          </VListItemTitle>
          <VListItemSubtitle class="text-capitalize">
            <VIcon
              :icon="
                user.email_verified_at
                  ? 'bi-patch-check'
                  : 'bi-patch-exclamation'
              "
              :color="user.email_verified_at ? 'primary' : 'error'"
              size="small"
              class="me-1"
              v-tooltip:bottom="
                user.email_verified_at ? 'Verified User' : 'Not Verified User'
              "
            />
            {{ resolveStatusVariant(user.role).text }}
          </VListItemSubtitle>
        </VListItem>
        <VDivider class="my-2" />

        <VListItem
          color="primary"
          :active="$page.component.includes('acc')"
          @click="link(route('account'))"
        >
          <template #prepend>
            <VIcon class="me-2" icon="bx-user" size="22" />
          </template>
          <VListItemTitle>Profile</VListItemTitle>
        </VListItem>

        <VDivider class="my-2" />

        <VListItem
          color="error"
          class="text-button"
          @click="link(route('logout'), 'post')"
          :active="true"
        >
          <template #prepend>
            <VIcon class="me-2" icon="bx-log-out" size="22" />
          </template>

          <VListItemTitle>Logout</VListItemTitle>
        </VListItem>
      </VList>
    </VMenu>
  </VAvatar>
</template>

<style lang="scss" scoped>
.v-list {
  max-inline-size: 16rem;
}
</style>
