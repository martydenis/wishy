<script setup>
  import { ref } from 'vue';
  import Wishlist from '../components/Wishlist.vue';

  const wishlists = ref([]);
  const deleteWishlist = async (id) => {
    document.getElementById('wishlist_' + id).classList.add("disabled");

    window.axios.post('/api/wishlists/delete', {
      id: id,
    }).then(result => {
      if (result.data == 0) {
        return;
      }

      wishlists.value = wishlists.value.filter(wishlist => wishlist.id != id);
    }).catch(result => {
      document.getElementById('wishlist_' + id).classList.remove("disabled");
    });
  }

  window.axios.post('/api/wishlists/get').then(result => {
    wishlists.value = result.data;
  });
</script>

<template>
  <div class="max-w-screen-xl mx-auto">
    <h1 class="text-6xl font-bold mb-4 text-slate-800">Wishlists</h1>

    <transition name="switch" mode="out-in">
      <div v-if="wishlists.length">
        <div class="relative mb-8">
          <svg class="text-slate-300 absolute left-3 top-0 h-full"><use href="#search"></use></svg>
          <input type="search" name="wishlist-filter" id="wishlist-filter" placeholder="Search for a wishlist" class="px-3 py-2 pl-12 rounded-md border-solid border">
        </div>

        <transition-group
          appear
          name="list"
          tag="ul"
          class="wishlist-list"
        >
          <Wishlist
            v-for="wishlist in wishlists"
            :key="wishlist.id"
            :id="wishlist.id"
            :name="wishlist.name"
            :user="wishlist.user.name"
            @delete-wishlist="deleteWishlist(wishlist.id)" />
        </transition-group>
      </div>
      <p v-else class="text-slate-400">No wishlist left to see</p>
    </transition>
  </div>
</template>

<style lang="scss">
  .wishlist-list {
    position: relative;

    li {
      width: 100%;
      transform-origin: center center;
    }
  }

  /**
  Switch transition */

  .list-enter-from,
  .list-leave-to {
    opacity: 0;
    transform: scale3d(0.9, 0.5, 1);
  }

  .list-enter-to,
  .list-leave-from {
    opacity: 1;
    transform: scale3d(1, 1, 1);
  }

  .list-enter-active {
    transition: all 0.4s ease-out;
  }

  .list-leave-active {
    transition: all 0.4s ease-in;
    position: absolute;
  }

  .list-move {
    transition: all 0.4s 0.2s ease-out;
  }

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
    transition: all 0.4s ease-out;
  }

  .switch-leave-active {
    transition: all 0.4s ease-in;
  }
</style>