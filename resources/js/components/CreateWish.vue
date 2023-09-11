<script setup>
  import { ref, inject, onMounted, onUnmounted, watch } from 'vue'
  import Modal from "../components/Modal.vue";

  const $eventBus = inject('$eventBus')
  const wish = ref({})
  const isVisible = ref(false)
  const isEditing = ref(false)
  const errors = ref({})
  let position = null

  // wish.value = {...wish.value, ...data};
  // isEditing.value = Object.keys(wish.value).length > 0

  const emitAddWish = (input) => {
    if (input == 0) {
      return $eventBus.emit('hideWishCreationModal')
    }

    if (!('name' in wish.value) || wish.value.name.trim() == '') {
      errors.value.name = []
      return errors.value.name.push('You must enter at least a name')
    }

    $eventBus.emit('addWish', {
      wish: wish.value,
      position: position
    });
  }

  const hideModal = () => {
    wish.value = {}
    errors.value = {}
    isEditing.value = false
    isVisible.value = false
  }

  const showModal = (data) => {
    if (data) {
      wish.value = {...wish.value, ...data.wish}
      position = data.position
    } else {
      position = null
    }

    isEditing.value = Object.keys(wish.value).length > 0
    isVisible.value = true;
  }

  const displayErrors = (axiosError) => {
    errors.value = axiosError.response.data.errors
  }

  onMounted(() => {
    $eventBus.on('errorInWishCreationModal', displayErrors)
    $eventBus.on('hideWishCreationModal', hideModal)
    $eventBus.on('showWishCreationModal', showModal)
  });

  onUnmounted(() => {
    $eventBus.off('errorInWishCreationModal', displayErrors)
    $eventBus.off('hideWishCreationModal', hideModal)
    $eventBus.off('showWishCreationModal', showModal)
  });

  const vFocus = {
    mounted: (el) => el.focus()
  }
</script>

<template>
  <Modal :visible="isVisible" @user-input="emitAddWish">
    <template #header>{{ isEditing ? 'Change your wish' : 'Make a wish' }}</template>
    <template #default>
      <form @submit.prevent="emitAddWish(1)">
        <label
          for="name"
          class="mt-5 block"
          :class="{'text-rose-500': 'name' in errors}">Name</label>
        <input id="name" name="name" v-focus v-model="wish.name" :class="{'error': 'name' in errors}" autocomplete="off" />
        <span v-if="errors.name" class="text-rose-500 text-sm">{{ errors.name[0] }}</span>

        <label
          for="url"
          class="mt-5 block"
          :class="{'text-rose-500': 'url' in errors}">URL</label>
        <input id="url" name="url" v-model="wish.url" :class="{'error': 'url' in errors}" autocomplete="off" />
        <span v-if="errors.url" class="text-rose-500 text-sm">{{ errors.url[0] }}</span>

        <label
          for="description"
          class="mt-5 block"
          :class="{'text-rose-500': 'description' in errors}">Description (optional)</label>
        <textarea id="description" name="description" v-model="wish.description" :class="{'error': 'description' in errors}" autocomplete="off" ></textarea>
        <span v-if="errors.description" class="text-rose-500 text-sm">{{ errors.description[0] }}</span>

        <button type="submit" class="hidden">submit</button>
      </form>
    </template>
    <template #no-button>Cancel</template>
    <template #yes-button>{{ isEditing ? 'Change your wish' : 'Make a wish' }}</template>
  </Modal>
</template>