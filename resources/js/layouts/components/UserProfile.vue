<!-- eslint-disable prettier/prettier -->
<script setup>
import Avatar from '@/components/Avatar.vue';
import { router, usePage } from '@inertiajs/vue3';

const user =  computed(() => {
  return usePage().props.auth.user;
});

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
  <VBadge
    dot
    location="bottom right"
    offset-x="3"
    offset-y="3"
    color="success"
    bordered
    class="me-2"
  >
    <VAvatar class="cursor-pointer" color="primary" variant="tonal">
      <VTooltip location="bottom" activator="parent" open-delay="500">
        <span class="text-capitalize">Profile</span>
      </VTooltip>
      <VImg v-if="user.avatar" :src="user.avatar" />
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
                <VBadge
                  dot
                  location="bottom right"
                  offset-x="3"
                  offset-y="3"
                  color="success"
                >
                  <Avatar
                    :item="{
                      name: user.name,
                      role: user.role,
                      avatar: user.avatar,
                    }"
                  >
                  </Avatar>
                </VBadge>
              </VListItemAction>
            </template>

            <VListItemTitle
              class="font-weight-semibold text-capitalize text-wrap"
              width="146"
            >
              {{ user.name }}
            </VListItemTitle>
            <VListItemSubtitle class="text-capitalize">
              {{ user.role }}
            </VListItemSubtitle>
          </VListItem>
          <VDivider class="my-2" />

          <VListItem
            color="primary"
            :active="$page.url.startsWith('/profile')"
            @click="link('/profile')"
          >
            <template #prepend>
              <VIcon class="me-2" icon="bx-user" size="22" />
            </template>
            <VListItemTitle>Profile</VListItemTitle>
          </VListItem>

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
  </VBadge>
</template>

<style lang="scss" scoped>
.v-list {
  max-inline-size: 16rem;
}
</style>
