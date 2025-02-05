<!-- eslint-disable prettier/prettier -->
<script setup>
import Avatar from '@/components/Avatar.vue';
import { router, usePage } from '@inertiajs/vue3';

let user =  usePage().props.auth.user;

const resolveStatusVariant = (role) => {
  if (role === 'admin')
    return {
      color: 'primary',
      text: 'Admin',
    };
  else if (role === 'mod')
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

watch(usePage,()=>{
  user = usePage().props.auth.user;
})

const link = (href,m ='get') => {
  router.visit(href,{
    method: m,
    preserveState: false,
    preserveScroll: false,
    // onFinish: () => {
    // },
  });
};

</script>

<template>
  <VAvatar class="cursor-pointer" color="primary" variant="tonal">
    <VTooltip location="bottom" activator="parent" open-delay="500">
      <span class="text-capitalize">Profile</span>
    </VTooltip>
    <VImg v-if="user.avatar" :src="`/storage/${user.avatar}`" />
    <span v-else class="text-body-2 initialism">{{
      user.name.split(' ').at(0)[0] + user.name.split(' ').at(-1)[0]
    }}</span>

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
                  avatar: `/storage/${user.avatar}`,
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
            <VChip :color="resolveStatusVariant(user.role).color" size="small">
              {{ resolveStatusVariant(user.role).text }}
            </VChip>
          </VListItemSubtitle>
        </VListItem>
        <VDivider class="my-2" />

        <VListItem
          color="primary"
          :active="$page.component.includes('acc')"
          @click="link(route('account.show'))"
        >
          <template #prepend>
            <VIcon class="me-2" icon="bx-user" size="22" />
          </template>
          <VListItemTitle>Profile</VListItemTitle>
        </VListItem>
        <!-- 
        <VListItem
          color="primary"
          :active="$page.url.startsWith('/settings')"
          @click="link('/settings')"
        >
          <template #prepend>
            <VIcon class="me-2" icon="bx-cog" size="22" />
          </template>
          <VListItemTitle>Settings</VListItemTitle>
        </VListItem>

        <VListItem
            color="primary"
            :active="$page.url.startsWith('/faq')"
            @click="link('/faq')"
          >
            <template #prepend>
              <VIcon class="me-2" icon="bx-help-circle" size="22" />
            </template>
            <VListItemTitle>FAQ</VListItemTitle>
          </VListItem> -->

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
