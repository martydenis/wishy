<script setup>
  import { computed } from 'vue'
  import { RouterLink } from 'vue-router'
  import Dropdown from './Dropdown.vue'
  import DropdownItem from './DropdownItem.vue'
  import Button from './Button.vue'

  const emit = defineEmits(['deleteWishlist'])
  const props = defineProps(['id', 'name', 'user', 'createdAt', 'description', 'wishesTotalCount', 'wishesCheckedCount', 'privacy', 'allowEditing', 'disabled']);

  const progressWidth = computed(() => (props.wishesCheckedCount * 100 / props.wishesTotalCount) + '%')
  const isAboveTablet = window.innerWidth > 768
</script>

<template>
  <li :id="'wishlist_' + id" :class="'wishlist group relative mb-4 px-6 py-4 ring-1 ring-slate-800 bg-slate-900 active:bg-slate-800 rounded-[0.5em] overflow-hidden ease-out duration-300 cursor-pointer' + (disabled ? ' disabled' : '')">
    <RouterLink :to="{name: 'Wishlist', params: {id: id}}" class="absolute w-full h-full top-0 left-0"></RouterLink>
    <p v-if="user" class="text-sky-500 text-sm">{{ user }}</p>
    <div class="flex gap-2 justify-between items-start">
      <p class="text-slate-200 text-lg leading-tight self-center py-1"><strong>{{ name }}</strong></p>

      <div v-if="allowEditing" class="-mt-2 -mr-4">
        <div v-if="isAboveTablet" class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2 relative z-10 -my-1">
          <Button :route="{name: 'ManageWishlist', params: {id: id}}" icon="edit" size="lg"></Button>
          <Button @click.stop="$emit('deleteWishlist', id)" icon="delete" color="rose" size="lg"></Button>
        </div>
        <Dropdown v-else>
          <DropdownItem :route="{name: 'ManageWishlist', params: {id: id}}" icon="edit" text="Edit"></DropdownItem>
          <DropdownItem @click="$emit('deleteWishlist', id)" icon="delete" text="Delete"></DropdownItem>
        </Dropdown>
      </div>
    </div>

    <p class="flex flex-wrap gap-x-3 sm:gap-x-6 text-slate-400 text-xs sm:text-sm mt-1">
      <span class="flex gap-1.5 items-center">
        <svg class="text-[0.75em]"><use href="#check" /></svg>

        <span v-if="wishesTotalCount > 0">{{ wishesCheckedCount }} / {{ wishesTotalCount }}</span>
        <span v-else>0 wish</span>
      </span>

      <span v-if="createdAt" class="flex gap-1.5 items-center"><svg class="text-[0.75em]"><use href="#clock" /></svg>{{ createdAt }}</span>

      <span v-if="!user">
        <span v-if="privacy == 0" class="flex gap-1.5 items-center text-sky-500"><svg class="text-[0.75em]"><use href="#lock" /></svg> Private</span>
        <span v-else-if="privacy == 1" class="flex gap-1.5 items-center"><svg class="text-[0.75em]"><use href="#link" /></svg> Selected friends</span>
        <span v-else class="flex gap-1.5 items-center"><svg class="text-[0.75em]"><use href="#users" /></svg> All friends</span>
      </span>
    </p>

    <span class="progress-bar absolute left-0 bottom-0 h-[0.2rem] bg-sky-500" :style="{'width': progressWidth}"></span>
  </li>
</template>

<style lang="scss">
@media (hover: hover) {
  .wishlist:hover {
    @apply bg-slate-800
  }
}
</style>