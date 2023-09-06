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
  <li :id="'wishlist_' + id" :class="'wishlist group relative mb-4 px-4 py-3 md:px-6 md:py-5 ring-1 ring-slate-100/20 bg-slate-800 hover:bg-[#313c4e] rounded-[0.5em] overflow-hidden ease-out duration-300 cursor-pointer flex gap-4 items-center justify-between' + (disabled ? ' disabled' : '')">
    <RouterLink :to="{name: 'Wishlist', params: {id: id}}" class="absolute w-full h-full top-0 left-0"></RouterLink>
    <div>
      <p class="text-slate-200 text-lg"><strong>{{ name }}</strong></p>
      <p v-if="user" class="text-sky-500 text-sm">{{ user }}</p>

      <p class="flex flex-wrap gap-x-3 sm:gap-x-6 text-slate-400 text-xs sm:text-sm mt-2">
        <span v-if="wishesTotalCount > 0">{{ wishesCheckedCount }} / {{ wishesTotalCount }} {{ wishesTotalCount > 1 ? 'wishes' : 'wish' }}</span>
        <span v-else>No wishes</span>

        <span v-if="createdAt" class="flex gap-1.5 items-center"><svg class="text-[0.75em]"><use href="#clock" /></svg>{{ createdAt }}</span>

        <span v-if="!user">
          <span v-if="privacy == 0" class="flex gap-1.5 items-center text-sky-500"><svg class="text-[0.75em]"><use href="#lock" /></svg> Private</span>
          <span v-else-if="privacy == 1" class="flex gap-1.5 items-center"><svg class="text-[0.75em]"><use href="#link" /></svg> Shared with friends</span>
          <span v-else class="flex gap-1.5 items-center"><svg class="text-[0.75em]"><use href="#users" /></svg> All friends</span>
        </span>
      </p>
    </div>

    <div v-if="allowEditing && isAboveTablet" class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2 relative z-10">
      <Button :route="{name: 'ManageWishlist', params: {id: id}}" icon="edit" size="lg"></Button>
      <Button @click.stop="$emit('deleteWishlist', id)" icon="delete" color="rose" size="lg"></Button>
    </div>
    <Dropdown v-if="allowEditing && !isAboveTablet">
      <DropdownItem :route="{name: 'ManageWishlist', params: {id: id}}" icon="edit" text="Edit"></DropdownItem>
      <DropdownItem @click="$emit('deleteWishlist', id)" icon="delete" text="Delete"></DropdownItem>
    </Dropdown>

    <span class="progress-bar absolute left-0 bottom-0 h-[3px] bg-sky-500 " :style="{'width': progressWidth}"></span>
  </li>
</template>