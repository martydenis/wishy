<script setup>
  import { ref, computed } from 'vue'
  import { useStore } from 'vuex'
  import Modal from "../components/Modal.vue";
  import Friend from "../components/Friend.vue";
  import Button from "../components/Button.vue";

  const store = useStore()
  const friendRequest = ref({})
  const isFriendInviteModalOpen = ref(false)
  const friendKeyToDelete = ref(null)
  const friends = computed(() => store.getters.friends)

  window.axios.get('/api/friends')
    .then(response => {
      if (response.data) {
        store.commit('updateFriends', response.data)
      }
    })
    .catch(error => {
      console.log(error)

      if (typeof error.response != 'undefined' && error.response.status == 401) {
        store.dispatch('logout')
      }
    });

  const modalUserInput = (input) => {
    if (input == 0) {
      delete friendRequest.value.success
      friendRequest.value.message = ''
      friendRequest.value.inputValue = ''

      return isFriendInviteModalOpen.value = false
    }

    submitFriendRequest()
  }

  const submitFriendRequest = () => {
    window.axios.post('/api/friend-request', {email: friendRequest.value.inputValue})
      .then(response => {
        friendRequest.value.inputValue = ''
        friendRequest.value.success = true
        friendRequest.value.message = response.data.message

        setTimeout(() => {
          delete friendRequest.value.success
          friendRequest.value.message = ''
        }, 4000)
      })
      .catch(error => {
        if (typeof error.response == 'undefined' || error.response.status == 500) {
          return;
        }

        friendRequest.value.success = false
        friendRequest.value.message = error.response.data.message
      })
  }

  const toggleDeleteFriendModal = (key) => {
    friendKeyToDelete.value = key
  }

  const deleteFriend = (input) => {
    if (input == 0) {
      return friendKeyToDelete.value = null
    }

    const friend = friends.value.accepted.get(friendKeyToDelete.value);
    const friendshipId = friend?.friendship_id;

    if (!!friend == false || !!friendshipId == false) {
      return;
    }

    window.axios.delete('/api/friends/' + friendshipId)
      .then(response => {
        friends.value.accepted.delete(friendKeyToDelete.value)
        store.commit('updateFriends', friends.value)
        friendKeyToDelete.value = null;
      })
  }

  const acceptFriendRequest = (friendKey) => {
    const friend = friends.value.pending.get(friendKey);
    const friendshipId = friend?.friendship_id;

    if (!!friend == false) {
      return;
    }

    window.axios.post(`/api/friend-request/${friendshipId}/accept`)
      .then(response => {
        friends.value.pending.delete(friendKey)
        friends.value.accepted.set(friendKey, friend)
      })
  }

  const rejectFriendRequest = (friendKey) => {
    const friend = friends.value.pending[friendKey];
    const friendshipId = friend?.friendship_id;

    if (!!friend == false) {
      return;
    }

    window.axios.post(`/api/friend-request/${friendshipId}/reject`)
      .then(response => {
        console.log(response);
        friends.value.pending.delete(friendKey)
        // friends.value.accepted = friends.value.accepted.filter(friend => friend.id != friend_id)
      })
  }
</script>

<template>
  <div class="max-w-lg mx-auto">
    <h1>Your friends</h1>

    <div v-if="friends.pending && friends.pending.size" class="mt-4 border-b border-slate-800 pb-4">
      <p class="font-semibold text-slate-400 text-sm">These people have invited you to be their friend</p>
      <ul class="mt-3">
        <Friend
          v-for="[id, friend] in friends.pending"
          :key="id"
          :id="id"
          :name="friend.name"
          :pending="true"
          @accept="acceptFriendRequest"
          @reject="rejectFriendRequest"
        />
      </ul>
    </div>

    <div class="mt-4 flex items-center">
      <p v-if="friends.accepted && friends.accepted.size" class="text-slate-200">{{ friends.accepted.size }} {{ friends.accepted.size > 1 ? 'friends' : 'friend'}}</p>

      <Button @click.prevent="isFriendInviteModalOpen = !isFriendInviteModalOpen" icon="add" text="Find friends" class="ml-auto"></Button>
    </div>

    <transition name="switch" mode="out-in"  class="mt-4">
      <ul v-if="friends.accepted && friends.accepted.size">
        <transition-group
          appear
          name="list"
          tag="ul"
          class="transition-list">
          <Friend
            v-for="[id, friend] in friends.accepted"
            :key="id"
            :id="id"
            :name="friend.name"
            :pending="false"
            @delete="toggleDeleteFriendModal"
          />
        </transition-group>
      </ul>
      <p v-else class="text-slate-400">Start by adding some friends to see their wishlists and check their wishes.</p>
    </transition>

    <Modal :visible="friendKeyToDelete != null" @user-input="deleteFriend">
      <template #header>Are you sure you want to remove this friend ?</template>
      <p>This action is irreversible.</p>
      <template #yes-button>Yes, remove this friend</template>
    </Modal>

    <Modal :visible="isFriendInviteModalOpen" @user-input="modalUserInput" :button-disabled="!friendRequest.inputValue">
      <template #header>Invite a friend</template>

      <form @submit.prevent="submitFriendRequest" method="post" class="mt-4">
        <label for="friend-request" class="block mb-1">Write down your friend's email address</label>
        <input type="text" id="friend-request"
          v-model="friendRequest.inputValue"
          :class="{'error': 'success' in friendRequest && !friendRequest.success, 'success': friendRequest.success}">
        <p v-if="friendRequest.message" class="text-sm mt-2" :class="{'text-rose-400' : !friendRequest.success, 'text-lime-400' : friendRequest.success}">{{ friendRequest.message }}</p>
      </form>

      <template #yes-button><svg><use href="#send"/></svg>Send invitation</template>
    </Modal>
  </div>
</template>