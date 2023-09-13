<script setup>
  import { ref, computed } from 'vue'
  import { useStore } from 'vuex'
  import Wishlist from '../components/Wishlist.vue'
  import Modal from '../components/Modal.vue'
  import Button from '../components/Button.vue'

  const store = useStore()
  const username = store.getters.user.name
  const wishlists = computed(() => store.getters.wishlists)
  const wishlistIdToDelete = ref(null)

  window.axios.get('/api/home')
    .then(response => {
      if (response.data) {
        store.commit('updateWishlists', Object.values(response.data.user_wishlists))
        store.commit('updateFriends', response.data.friends)
      }
    })
    .catch(error => {
      console.log(error)

      if (typeof error.response != 'undefined' && error.response.status == 401) {
        store.dispatch('logout')
      }
    });

  const openDeleteWishlistModal = (key) => {
    wishlistIdToDelete.value = key
  }

  const closeDeleteWishlistModal = () => {
    wishlistIdToDelete.value = null
  }

  const deleteWishlist = (input) => {
    const wishlist = wishlists.value[wishlistIdToDelete.value]

    if (input == 0 || !wishlist.id) {
      return closeDeleteWishlistModal();
    }

    wishlist.disabled = true;

    window.axios.delete('/api/wishlists/' + wishlist.id)
      .then(result => {
        if (result.data == 0) {
          return;
        }

        store.commit('deleteWishlist', wishlistIdToDelete.value)
        closeDeleteWishlistModal()
      }).catch(result => {
        wishlist.disabled = false;
      });
  }
</script>

<template>
  <div class="max-md:mb-24">
    <h1>My wishlists</h1>

    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
      <p class="grow text-slate-400" v-if="wishlists">Hi {{ username }}, you have {{ wishlists.length }} <span v-if="wishlists.length > 1">lists</span><span v-else>list</span></p>

      <Button :to="{name: 'CreateWishlist'}" icon="add" text="New wishlist"></Button>
    </div>

    <transition-group
      appear
      name="list"
      tag="ul"
      class="transition-list"
    >
      <Wishlist
        v-for="(wishlist, index) in wishlists"
        :key="wishlist.id"
        :id="wishlist.id"
        :name="wishlist.name"
        :description="wishlist.description"
        :privacy="wishlist.privacy"
        :disabled="wishlist.disabled"
        :created-at="wishlist.created_at_formatted"
        :wishes-total-count="wishlist.wishes_total_count"
        :wishes-checked-count="wishlist.wishes_checked_count"
        :allow-editing="true"
        @delete-wishlist="openDeleteWishlistModal(index)" />
    </transition-group>

    <Modal :visible="wishlistIdToDelete != null" @user-input="deleteWishlist">
      <template #header>Are you sure you want to delete this wishlist&nbsp;?</template>
      <template #default><p>All its wishes will be lost</p></template>
      <template #yes-button>Yes, delete it</template>
    </Modal>
  </div>
</template>