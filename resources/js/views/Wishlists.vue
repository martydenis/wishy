<script setup>
  import { inject } from 'vue';
  import Wishlist from '../components/Wishlist.vue';

  const wishlists = inject('wishlists');

  console.log(wishlists.value);
</script>

<template>
  <div class="max-w-screen-xl mx-auto">
    <h1 class="text-6xl font-bold mb-4 text-slate-800">Wishlists</h1>

    <div class="relative mb-8">
      <svg class="text-slate-300 absolute left-3 top-0 h-full"><use href="#search"></use></svg>
      <input type="search" name="wishlist-filter" id="wishlist-filter" placeholder="Search for a wishlist" class="px-3 py-2 pl-12 rounded-md border-solid border">
    </div>

    <ul v-if="wishlists.length" class="flex flex-col gap-3">
      <Wishlist
        v-for="wishlist in wishlists"
        :key="wishlist.id"
        :name="wishlist.name"
        :owner="wishlist.owner_id" />
    </ul>
  </div>
</template>