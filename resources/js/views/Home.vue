<script setup>
  import { ref, computed } from 'vue'
  import { useRouter, RouterLink } from 'vue-router'
  import { useStore } from 'vuex'
  import Wishlist from '../components/Wishlist.vue'

  const store = useStore()
  const router = useRouter()
  const username = store.getters.user.name
  const wishlists = computed(() => store.getters.wishlists)

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
        store.commit('logout')
        router.push({name: "Login"});
      }
    });

  const handleDeletedWishlist = (id) => {
    wishlists.value = wishlists.value.filter(wishlist => wishlist.id != id)
  }
</script>

<template>
  <div class="max-w-screen-md mx-auto">
    <h1>My wishlists</h1>

    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
      <p class="grow text-slate-400" v-if="wishlists">Hi {{ username }}, you have {{ wishlists.length }} <span v-if="wishlists.length > 1">lists</span><span v-else>list</span></p>

      <RouterLink :to="{name: 'CreateWishlist'}" class="bg-slate-800 text-slate-300 border border-slate-700 rounded-full flex gap-2 py-1.5 px-4 items-center ease-out duration-300 hover:bg-slate-700 hover:text-slate-200">
        <svg><use href="#add"/></svg>
        Create a wishlist
      </RouterLink>
    </div>

    <transition-group
      appear
      name="list"
      tag="ul"
      class="transition-list"
    >
      <Wishlist
        v-for="wishlist in wishlists"
        :key="wishlist.id"
        :id="wishlist.id"
        :name="wishlist.name"
        :description="wishlist.description"
        :privacy="wishlist.privacy"
        :created-at="wishlist.created_at_formatted"
        :wishes-total-count="wishlist.wishes_total_count"
        :wishes-checked-count="wishlist.wishes_checked_count"
        :allow-editing="true"
        @wishlist-deleted="handleDeletedWishlist" />
    </transition-group>
  </div>
</template>