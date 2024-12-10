<script setup>
defineProps({
  item: {
    type: null,
  },
});
</script>

<template>
  <li class="nav-link" :class="{ disabled: item.disable }">
    <Link
      :href="item.href"
      :target="item.target"
      :class="{ 'router-link-active router-link-exact-active': item.active }"
    >
      <VIcon :icon="item.icon || 'bxs-circle'" class="nav-item-icon" />
      <span class="nav-item-title">
        {{ item.title }}
      </span>
      <span class="nav-item-badge" :class="item.badgeClass">
        {{ item.badgeContent }}
      </span>
    </Link>
  </li>
</template>

<style lang="scss">
.layout-vertical-nav {
  .nav-link a {
    display: flex;
    align-items: center;
    cursor: pointer;
  }
}
</style>
