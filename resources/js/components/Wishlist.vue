<script setup>
  const emit = defineEmits(["deleteWishlist"])
  const emitDeleteWishlist = () => {
    emit("deleteWishlist")
  }

  defineProps(['id', 'name', 'user', 'itemsCount']);
</script>

<template>
  <li :id="'wishlist_' + id" class="wishlist mb-3 px-6 py-4 drop-shadow-sm ring-1 ring-gray-900/5 bg-white rounded-lg hover:drop-shadow-xl ease-out duration-300 cursor-pointer flex gap-4 items-center justify-between">
    <div>
      <p class="text-slate-800"><strong>{{ name }}</strong></p>
      <p class="text-slate-400 text-sm">{{ user }}</p>
      <p class="text-slate-400 text-sm">{{ itemsCount }}</p>
    </div>
    <div>
      <button type="button" @click="emitDeleteWishlist()" class="rounded-full hover:bg-slate-100 ease-out duration-300 w-10 h-10 flex justify-center items-center">
        <svg><use href="#delete"/></svg>
      </button>
    </div>
  </li>
</template>

<style lang="scss">
  .wishlist {
    &.disabled {
      background-color: #f2f5f9;
    }
  }
</style>