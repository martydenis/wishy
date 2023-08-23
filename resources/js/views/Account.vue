<script setup>
  import { ref } from 'vue'
  import { useStore } from 'vuex'
  import { useRouter } from 'vue-router'
  import Modal from '../components/Modal.vue'

  const store = useStore()
  const router = useRouter()
  const isDeleteUserModalShown = ref(false)

  const toggleDeleteUserModal = () => {
    isDeleteUserModalShown.value = !isDeleteUserModalShown.value
  }

  const logout = () => {
    window.axios.post('/api/logout')
      .then(response => {
        store.commit('logout')
        router.push({name: "Login"})
      })
  }

  const deleteUser = (input) => {
    if (input == 0) {
      return isDeleteUserModalShown.value = !isDeleteUserModalShown.value
    }

    window.axios.delete('/api/delete-account')
      .then(response => {
        store.commit('logout')
        router.push({name: "Home"})
      })
  }
</script>

<template>
  <div class="max-w-sm mx-auto">
    <h1 class="text-center">{{ store.getters.user.name }}</h1>
    <p class="text-sky-500 text-center mt-2">{{ store.getters.user.email }}</p>
    <p class="text-slate-200 text-center mt-4">Manage your account here</p>

    <ul class="mt-12">
      <li>
        <button class="w-full flex gap-4 items-center px-4 py-3 font-semibold bg-slate-900 text-slate-500 cursor-not-allowed rounded-md text-left leading-tight">
          <svg><use href="#logout"/></svg>
          <span>Change password <small class="text-sm inline-block">(soon available)</small></span>
        </button>
      </li>
      <li class="mt-2">
        <button @click="logout" class="w-full flex gap-4 items-center px-4 py-3 font-semibold bg-slate-800 text-slate-300 hover:text-slate-200 hover:bg-slate-700 rounded-md">
          <svg><use href="#logout"/></svg>
          Logout
        </button>
      </li>
      <li class="mt-12"><hr class="border-slate-800"></li>
      <li class="mt-4">
        <button @click="toggleDeleteUserModal" class="w-full flex gap-4 items-center px-4 py-2 font-semibold text-slate-300 bg-slate-900 border border-slate-800 hover:text-slate-200 hover:bg-slate-700 rounded-md">
          <svg class="text-rose-500"><use href="#close"/></svg>
          Delete my account
        </button>
      </li>
    </ul>

    <Modal :visible="isDeleteUserModalShown" @user-input="deleteUser">
      <template #header>Are you sure you want to delete your account ?</template>
      <p>This action is irreversible.</p>
      <template #yes-button>Yes, delete my account</template>
    </Modal>
  </div>
</template>