<!-- eslint-disable prettier/prettier -->
<script setup>
import { router, usePage } from '@inertiajs/vue3';

const page = usePage();
const user = ref(page.props.auth.user||null);

const link = (href) => {
  router.get(href,{},{
    preserveState: false,
    preserveScroll: false,
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
      <VTooltip location="bottom" activator="parent" open-delay="1000">
        <span class="text-capitalize">Profile</span>
      </VTooltip>
      <VImg v-if="user.avatar" :src="user.avatar" />
      <span v-else class="text-h5 initialism">{{
        `${user.first_name[0]}${user.last_name[0]} `
      }}</span>

      <!-- SECTION Menu -->
      <VMenu activator="parent" width="230" location="bottom end" offset="20px">
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
                  <VAvatar color="primary" variant="tonal">
                    <VImg v-if="user.avatar" :src="user.avatar" />
                    <span v-else class="text-h5">{{
                      `${user.first_name[0]}${user.last_name[0]} `
                    }}</span>
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template>

            <VListItemTitle class="font-weight-semibold text-capitalize">
              {{ user.name }}
            </VListItemTitle>
            <VListItemSubtitle>{{ user.role }}</VListItemSubtitle>
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
            @click="link(`route('logout')`)"
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
