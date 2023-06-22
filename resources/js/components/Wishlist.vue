<script setup>
  defineProps(['name', 'owner']);
</script>

<template>
  <li class="px-6 py-4 drop-shadow-sm ring-1 ring-gray-900/5 bg-white rounded-lg hover:drop-shadow-xl ease-out duration-300 cursor-pointer flex gap-4 items-center justify-between">
    <div>
      <p class="text-slate-800"><strong>{{ name }}</strong></p>
      <p class="text-slate-400">{{ owner }}</p>
    </div>
    <div>
      <svg><use href="#delete"/></svg>
    </div>
  </li>
</template>

<style lang="scss">
  // .wishlist-actions {
    // svg {
    //   width: 30px;
    //   height: 30px;
    // }
  // }
</style>