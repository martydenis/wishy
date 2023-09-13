<script setup>
  import { ref } from 'vue'
  import { useStore } from 'vuex'
  import Wishlist from '../components/Wishlist.vue'

  const store = useStore()
  const userId = store.getters.user.id
  const wishlists = ref([]);

  window.axios.get('/api/wishlists')
    .then(result => {
      wishlists.value = result.data
    })
    .catch(error => {
      console.log(error);
    });

  const deleteWishlist = (id) => {
    document.getElementById('wishlist_' + id).classList.add("disabled");

    window.axios.delete('/api/wishlists/' + id).then(result => {
      if (result.data == 0) {
        return;
      }

      store.commit('removeWishlist', id)
    }).catch(result => {
      document.getElementById('wishlist_' + id).classList.remove("disabled")
    });
  }
</script>

<template>
  <div class="">
    <h1>Shared with you</h1>
    <p class="text-slate-200">You will find here the wishlists that your friends have shared with you.</p>

    <transition name="switch" mode="out-in" class="mt-8">
      <div v-if="wishlists && wishlists.length">
        <transition-group
          appear
          name="list"
          tag="ul"
          class="transition-list"
        >
          <Wishlist
            v-for="(wishlist, id) in wishlists"
            :key="wishlist.id"
            :id="wishlist.id"
            :name="wishlist.name"
            :user="wishlist.user.name"
            :created-at="wishlist.created_at_formatted"
            :wishes-total-count="wishlist.wishes_total_count"
            :wishes-checked-count="wishlist.wishes_checked_count"
            :privacy="wishlist.privacy"
            :allow-editing="userId == wishlist.user.id"
            @delete-wishlist="deleteWishlist(id)" />
        </transition-group>
      </div>
      <p v-else class="text-slate-400">Start by adding some friends to see their wishlists and check their wishes.</p>
    </transition>
  </div>
</template>

<style lang="scss">
  /**
  Switch transition */

  .switch-enter-from,
  .switch-leave-to {
    opacity: 0;
    transform: translateY(20px);
  }

  .switch-enter-to,
  .switch-leave-from {
    opacity: 1;
    transform: translateY(0);
  }

  .switch-enter-active {
    transition: all 0.2s ease-out;
  }

  .switch-leave-active {
    transition: all 0.2s ease-in;
  }
</style>