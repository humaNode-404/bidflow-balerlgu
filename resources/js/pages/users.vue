<script setup>
import { Inertia } from '@inertiajs/inertia'
import { ref, watch } from 'vue'

defineProps({
  users: Array,
})

let search = ref('')

const headers = [
  {
    title: 'ID',
    sortable: false,
    key: 'id',
  },
  {
    title: 'NAME',
    key: 'name',
  },
  {
    title: 'EMAIL',
    key: 'email',
  },
  {
    title: 'DATE',
    key: 'date',
  },
  {
    title: 'ROLE',
    key: 'role',
  },
]

watch(search, value => {
  Inertia.get('/users', { search: value }, { preserveState: true })
})
</script>

<template>
  <!-- 👉 Search -->
  <div
    class="d-flex align-center cursor-pointer mb-4"
    style="user-select: none;"
  >
    <VTextField
      v-model="search"
      prepend-inner-icon="bx-search"
      placeholder="Search..."
    />
  </div>
  <VDataTable
    :headers="headers"
    :items="users"
    :items-per-page="5"
  />
</template>
