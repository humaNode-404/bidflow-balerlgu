<script setup>
import CardBasic from '@/views/pages/cards/card-basic/CardBasic.vue';
import CardNavigation from '@/views/pages/cards/card-basic/CardNavigation.vue';
import CardSolid from '@/views/pages/cards/card-basic/CardSolid.vue';
</script>

<template>
  <div>
    <p class="mb-6 text-2xl">Basic Cards</p>

    <CardBasic />

    <p class="mb-6 mt-14 text-2xl">Navigation Cards</p>

    <CardNavigation />

    <p class="mb-6 mt-14 text-2xl">Solid Cards</p>

    <CardSolid />
  </div>
</template>
