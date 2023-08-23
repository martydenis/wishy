<script setup>
  import { ref, computed, inject, onMounted, onUnmounted } from 'vue'
  import { useStore } from 'vuex'
  import { useRouter } from 'vue-router'
  import Wish from '../components/Wish.vue'
  import CreateWish from '../components/CreateWish.vue'
  import Button from '../components/Button.vue'

  const router = useRouter()
  const store = useStore()
  const props = defineProps(['id'])
  const $eventBus = inject('$eventBus')
  const wishlist = ref(store.getters.wishlists.find(list => list.id == props.id) || {
    wishes_checked_count: 0,
    wishes: []
  })
  const allowEditing = ref(false)
  const userId = store.getters.user.id
  const progressWidth = computed(() => {
    return (!wishlist.value.wishes || wishlist.value.wishes.length == 0)
      ? '0%'
      : (wishlist.value.wishes_checked_count * 100 / wishlist.value.wishes.length) + '%'
  })

  window.axios.get('/api/wishlists/' + props.id)
    .then(response => {
      allowEditing.value = userId == response.data.user_id
      wishlist.value = response.data
    })
    .catch(error => {
      console.log(error);

      if (typeof error.response == 'undefined') {
        return;
      }

      // Unauthorized, needs to login
      if (error.response.status == 401) {
        store.commit('logout')
        router.push({name: "Login"});
      }

      // Wishlist doesn't exist or user is not authorized to display a private wishlist
      if (error.response.status == 404 || error.response.status == 403) {
        router.push({name: "Home"});
      }
    });

  const deleteWish = (key) => {
    const wish = wishlist.value.wishes[key]
    const wishId = wish.id

    if (typeof wishId == 'undefined') {
      return wishlist.value.wishes.splice(key, 1)
    }

    wish.isDisabled = true

    window.axios.delete('/api/wishes/' + wishId)
      .then(result => {
        wishlist.value.wishes.splice(key, 1);

        if (wish.checked) {
          wishlist.value.wishes_checked_count --
        }
      })
      .catch(error => {
        console.log(error)
        wish.isDisabled = false
      });
  }

  const addWish = (params) => {
    const wishToAdd = params.wish
    wishToAdd.wishlist_id = wishlist.value.id

    window.axios.post('/api/wishes/store-or-update', wishToAdd)
      .then(result => {
        if (params.position) {
          const position = parseInt(params.position)
          wishlist.value.wishes[position] = { ...result.data };
        } else {
          wishlist.value.wishes.push(result.data);
        }

        $eventBus.emit('hideWishCreationModal')
      })
      .catch(error => {
        if (error.response.status != 422) {
          return console.log(error)
        }

        $eventBus.emit('errorInWishCreationModal', error)
      });
  }

  const checkWish = (position) => {
    const wish = wishlist.value.wishes[position];

    wish.isDisabled = true
    window.axios.post('/api/wishes/' + wish.id + '/toggle-check')
      .then(result => {
        wish.checked = !wish.checked
        wishlist.value.wishes_checked_count += wish.checked ? 1 : -1;
      })
      .finally(() => {
        wish.isDisabled = false
      });
  }

  onMounted(() => {
    $eventBus.on('addWish', addWish)
  });

  onUnmounted(() => {
    $eventBus.off('addWish', addWish)
  });
</script>

<template>
  <div v-if="wishlist" class="max-w-screen-md mx-auto max-md:mb-20">
    <h1>{{ wishlist.name ? wishlist.name : '...' }}</h1>

    <div class="mt-4">
      <p v-if="wishlist.user" class="text-xl font-bold text-slate-200 flex flex-wrap gap-y-2 gap-x-5">
        {{ wishlist.user.name }}
        <span class="text-slate-400 font-normal text-sm flex gap-1.5 items-center">
          <svg class="text-[0.75em]"><use href="#clock" /></svg>
          {{ wishlist.created_at_formatted }}
        </span>  
      </p>
      <p v-if="wishlist.description" class="mt-4">{{ wishlist.description }}</p>
    </div>

    <div class="flex flex-wrap items-center mt-4 gap-y-3 gap-x-4">
        <Button v-if="allowEditing" :route="{name: 'ManageWishlist', id: wishlist.id}" icon="edit" text="Manage"></Button>
        <Button v-if="allowEditing" @click.prevent="$eventBus.emit('showWishCreationModal')" icon="add" color="sky" text="Make a wish"></Button>
    </div>

    <p class="mt-6 tags flex justify-center items-center relative h-px bg-slate-700">
      <span v-if="wishlist.wishes && wishlist.wishes.length"
        class="mx-auto mb-1 bg-slate-950 text-sm relative z-10 px-1"
        :class="{
          'text-slate-400': (wishlist.wishes_checked_count < wishlist.wishes.length),
          'text-sky-500': (wishlist.wishes_checked_count == wishlist.wishes.length)
        }"
      >
        {{ wishlist.wishes_checked_count }} / {{ wishlist.wishes.length }} {{ wishlist.wishes.length > 1 ? 'wishes checked' : 'wish checked' }}
      </span>
      <span class="absolute left-0 bottom-0 h-[3px] bg-sky-500 duration-500" :style="{'width': progressWidth}"></span>
    </p>

    <transition name="switch" mode="out-in" class="mt-10">
      <div v-if="wishlist.wishes && wishlist.wishes.length">
        <transition-group appear name="list" tag="ul" class="transition-list">
          <Wish
            v-for="(wish, index) in wishlist.wishes"
            :key="wish.id"
            :id="wish.id"
            :position="index"
            :name="wish.name"
            :url="wish.url"
            :disabled="wish.isDisabled"
            :description="wish.description"
            :checked="wish.checked"
            :use-ajax="true"
            :allow-checking="true"
            :allow-deleting="allowEditing"
            @check-wish="checkWish"
            @delete-wish="deleteWish" />
        </transition-group>
      </div>
      <p v-else class="text-slate-200 font-semibold">There's still no wish at the moment</p>
    </transition>

    <CreateWish/>
  </div>
</template>