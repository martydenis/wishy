<script setup>
  import { ref, computed } from 'vue'
  import { useStore } from 'vuex'
  import { RouterLink } from 'vue-router'
  import Modal from '../components/Modal.vue'
  import Dropdown from './Dropdown.vue'
  import DropdownItem from './DropdownItem.vue'
  import Button from './Button.vue'

  const store = useStore()
  const emit = defineEmits(['wishlistDeleted'])
  const props = defineProps(['id', 'name', 'user', 'createdAt', 'description', 'wishesTotalCount', 'wishesCheckedCount', 'privacy', 'allowEditing']);
  const isDeleteWishlistModalShown = ref(false)
  const disabled = ref(false)
  const progressWidth = computed(() => (props.wishesCheckedCount * 100 / props.wishesTotalCount) + '%')
  const isAboveTablet = window.innerWidth > 768

  const toggleDeleteWishlistModal = () => {
    isDeleteWishlistModalShown.value = !isDeleteWishlistModalShown.value
  }

  const deleteWishlist = (input) => {
    if (props.allowEditing == false) {
      return;
    }

    if (input == 0) {
      return toggleDeleteWishlistModal();
    }

    disabled.value = true;

    window.axios.delete('/api/wishlists/' + props.id)
      .then(result => {
        if (result.data == 0) {
          return;
        }

        emit('wishlistDeleted', props.id)
        store.commit('removeWishlist', props.id)
      }).catch(result => {
        disabled.value = false;
      });
  }
</script>

<template>
  <li :id="'wishlist_' + id" :class="'wishlist group relative mb-4 px-4 py-3 md:px-6 md:py-5 ring-1 ring-slate-100/20 bg-slate-800 hover:bg-[#313c4e] rounded-[0.5em] overflow-hidden ease-out duration-300 cursor-pointer flex gap-4 items-center justify-between' + (disabled ? ' disabled' : '')">
    <RouterLink :to="{name: 'Wishlist', params: {id: id}}" class="absolute w-full h-full top-0 left-0"></RouterLink>
    <div>
      <p class="text-slate-200"><strong>{{ name }}</strong></p>
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
      <Button @click.stop="toggleDeleteWishlistModal" icon="delete" color="rose" size="lg"></Button>
    </div>
    <Dropdown v-if="allowEditing && !isAboveTablet">
      <DropdownItem :route="{name: 'ManageWishlist', params: {id: id}}" icon="edit" text="Edit"></DropdownItem>
      <DropdownItem @click.stop="toggleDeleteWishlistModal" icon="delete" text="Delete"></DropdownItem>
    </Dropdown>

    <Modal :visible="isDeleteWishlistModalShown" @user-input="deleteWishlist">
      <template #header>Are you sure you want to delete this wishlist&nbsp;?</template>
      <template #default><p>All its wishes will be lost</p></template>
      <template #yes-button>Yes, delete it</template>
    </Modal>

    <span class="progress-bar absolute left-0 bottom-0 h-[3px] bg-sky-500 " :style="{'width': progressWidth}"></span>
  </li>
</template>

<style lang="scss">
  @tailwind components;
  @layer components {
    .wishlist {
      &.disabled {
        @apply bg-slate-200 border-slate-300 pointer-events-none;
      }
    }
  }
</style>