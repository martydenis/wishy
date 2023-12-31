<script setup>
  import { ref, reactive, inject, onMounted, onUnmounted } from 'vue'
  import { useRouter } from 'vue-router';
  import { useStore } from 'vuex';
  import { arrayOfObjectsToMap } from '../tools.js'
  import Wish from '../components/Wish.vue'
  import CreateWish from '../components/CreateWish.vue'
  import Modal from '../components/Modal.vue'
  import Button from '../components/Button.vue';

  const $eventBus = inject('$eventBus');
  const router = useRouter()
  const store = useStore()
  const props = defineProps(['id'])
  const isEditing = !!props.id;
  const errors = ref({})
  const friendsSharedWith = ref(new Map());
  const fields = ref({
    privacy: 0,
    wishes: [],
    friends_shared_with: []
  });
  const isFormDisabled = ref(true)
  const isWishlistSharingModalOpen = ref(false)

  const fillFormIn = () => {
    if (!isEditing) {
      return isFormDisabled.value = false
    }

    window.axios.get('/api/wishlists/' + props.id)
      .then(response => {
        fields.value = response.data
        friendsSharedWith.value = arrayOfObjectsToMap(response.data.friends_shared_with)
      })
      .catch(result => {
        if (typeof result.response != 'undefined') {
          return errors.value = result.response.data.errors
        }
      })
      .finally(() => {
        isFormDisabled.value = false
      })
  }

  fillFormIn()

  const submit = () => {
    if (isFormDisabled.value == true) {
      return
    }

    const apiUrl = isEditing ? '/api/wishlists/' + props.id + '/edit' : '/api/wishlists/create';
    isFormDisabled.value = true;

    window.axios.post(apiUrl, fields.value)
      .then(response => {
        router.push({name: "Wishlist", params: {id: response.data.id} })
      })
      .catch(result => {
        if (typeof result.response == 'undefined') {
          return;
        }

        const requestErrors = result.response.data.errors;

        if (requestErrors && requestErrors.wishes) {
          for (const wishId in requestErrors.wishes) {
            const error = requestErrors.wishes[wishId]

            fields.value.wishes[wishId].errors = error
          }
        }

        return errors.value = requestErrors
      })
      .finally(() => {
        isFormDisabled.value = false;
      })
  }

  const deleteWish = (index) => {
    fields.value.wishes.splice(index, 1);
  }

  const addWish = (params) => {
    const wishToAdd = params.wish

    if (params.position !== null) {
      const position = parseInt(params.position)
      const wish = fields.value.wishes[position];
      fields.value.wishes[position] = { ...wish, ...wishToAdd };
    } else {
      wishToAdd.key = Math.round(Math.random() * 1000000);
      fields.value.wishes.push(wishToAdd);
    }

    $eventBus.emit('hideWishCreationModal')
  }

  const checkWish = (position) => {
    const wish = fields.value.wishes[position];
    wish.checked = !wish.checked
    wish.isDisabled = true
    setTimeout(() => {
      wish.isDisabled = false
    }, 200)
  }

  const toggleFriendSharing = (id) => {
    if (friendsSharedWith.value.has(id)) {
      friendsSharedWith.value.delete(id);
    } else {
      friendsSharedWith.value.set(id, store.getters.friends.accepted.get(id))
    }
  }

  const toggleWishlistSharingModal = (input) => {
    isWishlistSharingModalOpen.value = !isWishlistSharingModalOpen.value

    if (typeof input == 'null') {
      return
    }

    if (input) {
      fields.value.friends_shared_with = Array.from(friendsSharedWith.value.values())
    } else {
      friendsSharedWith.value = arrayOfObjectsToMap(fields.value.friends_shared_with)
    }
  }

  onMounted(() => {
    $eventBus.on('addWish', addWish)
  });

  onUnmounted(() => {
    $eventBus.off('addWish', addWish)
  });
</script>

<template>
  <div class="max-md:mb-20">
    <h1 class="mb-8 md:mb-12 max-sm:text-3xl">{{ id ? 'Manage your wishlist' : 'Create a new wishlist'}}</h1>

    <form @submit.prevent="submit">
      <div class="flex flex-col md:flex-row-reverse gap-8 xl:gap-14">
        <div class="grow">
          <h2 class="text-xl md:text-2xl font-bold flex gap-y-2 gap-x-8 flex-wrap items-center text-slate-200">
            What are you wishing for ?

            <Button @click.prevent="$eventBus.emit('showWishCreationModal')" icon="add" :text="!store.getters.isMobile ? 'Make a wish' : ''" color="sky" class="ml-auto"></Button>
          </h2>

          <transition-group appear name="list" tag="ol" class="transition-list mt-4" v-if="fields.wishes.length">
            <Wish
              v-for="(wish, index) in fields.wishes"
              :key="wish.id || wish.key"
              :position="index"
              :id="wish.id || wish.key"
              :name="wish.name"
              :errors="wish.errors"
              :checked="wish.checked"
              :description="wish.description"
              :url="wish.url"
              :disabled="wish.isDisabled"
              :allow-checking="true"
              :allow-deleting="true"
              @check-wish="checkWish"
              @delete-wish="deleteWish" />
          </transition-group>

          <p v-else class="mt-4">This wishlist is empty at this moment.<br>Click on the button up here to make a wish.</p>
        </div>

        <div class="rounded-2xl p-6 lg:p-10 bg-slate-900 md:w-80 xl:w-96 shrink-0 xl:self-start">
          <h2 class="text-xl md:text-2xl font-bold mb-4 text-slate-200">What's your list about&nbsp;?</h2>
          <label for="name" class="mt-6" :class="{'text-rose-600': 'name' in errors}">Name</label>
          <input type="text" id="name"
            v-model="fields.name"
            :class="{'error': 'name' in errors}">
          <span v-if="errors.name" class="text-rose-600 text-sm">{{ errors.name[0] }}</span>

          <label for="description" class="mt-6">Description (optional)</label>
          <textarea id="description"
            v-model="fields.description" >
          </textarea>

          <p class="flex justify-between mt-6">
            <label for="privacy">Privacy</label>
            <p v-if="fields.privacy == 1" class="text-sm text-sky-500 underline hover:no-underline cursor-pointer" @click="toggleWishlistSharingModal(null)">
              <span v-if="!fields.friends_shared_with.length">Share with friends</span>
              <span v-else>Shared with {{ fields.friends_shared_with.length }} {{ fields.friends_shared_with.length == 1 ? 'friend': 'friends' }}</span>
            </p>
          </p>
          <select name="privacy" id="privacy" v-model="fields.privacy" class="px-3 py-1 h-12 mb-1.5 rounded-md border block w-full duration-300">
            <option value="0">Private</option>
            <option value="1">Pick friends</option>
            <option value="2">All friends</option>
          </select>

          <p v-if="fields.privacy == 0" class="text-sm leading-snug text-slate-400">This list is for you and you only</p>
          <p v-else-if="fields.privacy == 1" class="text-sm leading-snug text-slate-400">You can select the friends that will be allowed to see this list and check its wishes</p>
          <p v-else class="text-sm leading-snug text-slate-400">All your friends can see this list and check its wishes</p>

          <Teleport to="body" :disabled="!store.getters.isMobile">
            <Button type="submit" @click.prevent="submit" color="sky"
              class="mt-4"
              icon="save"
              :text="store.getters.isMobile ? '' : (id ? 'Save' : 'Create')"
              :size="store.getters.isMobile ? 'floating' : 'lg'"
              :block="!store.getters.isMobile"></Button>
          </Teleport>
        </div>
      </div>
    </form>

    <CreateWish />

    <Modal :visible="isWishlistSharingModalOpen" @user-input="toggleWishlistSharingModal">
      <template #header>Share this wishlist with your friends</template>

      <ul v-if="store.getters.friends.accepted && store.getters.friends.accepted.size" class="mt-2">
        <li
          v-for="[id, friend] in store.getters.friends.accepted"
          :key="id"
          @click="toggleFriendSharing(id)"
          class="flex gap-4 items-center group text-md px-3 py-2 rounded-lg hover:bg-slate-800 duration-300 cursor-pointer"
          :class="{
            'hover:text-slate-200': !friendsSharedWith.has(id),
            'text-sky-500': friendsSharedWith.has(id)
          }">
          <i
            :toto="id"
            class="text-sm h-9 w-9 rounded-full flex justify-center items-center self-start shrink-0 duration-300"
            :class="{
              'bg-sky-600 text-slate-200': friendsSharedWith.has(id),
              'bg-slate-800 text-slate-300': !friendsSharedWith.has(id)
            }" >
            <transition name="switch" mode="out-in">
              <svg v-if="friendsSharedWith.has(id)"><use href="#check" /></svg>
              <svg v-else><use href="#user" /></svg>
            </transition>
          </i>
          <span class="flex-grow text-lg overflow-hidden w-full leading-tight font-bold">{{ friend.name }}</span>
        </li>
      </ul>
      <p v-else>Invite some friends on Wishy first, you will then be able to share this list with them</p>

      <template #yes-button>Ok</template>
    </Modal>
  </div>
</template>