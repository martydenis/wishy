<script setup>
  import { ref, reactive } from 'vue'

  const isDropdownOpen = ref(false)
  const dropdownPosition = reactive({})
  const triggerer = ref(null)

  const openDropdown = () => {
    const button = triggerer.value;
    const rect = button.getBoundingClientRect();

    dropdownPosition.x = window.innerWidth - rect.left - button.offsetWidth
    dropdownPosition.y = rect.top  + window.scrollY

    isDropdownOpen.value = true
  }

  const closeDropdown = () => {
    isDropdownOpen.value = false
  }
</script>

<template>
  <slot name="triggerer">
    <button type="button" ref="triggerer" @click.stop="openDropdown" class="text-lg rounded-full text-slate-300 hover:text-slate-200 hover:bg-slate-700 ease-out duration-300 w-10 h-10 flex justify-center items-center relative z-10">
      <svg class="pointer-events-none"><use href="#more-vertical"/></svg>
    </button>
  </slot>

  <Teleport to="body">
    <div v-if="isDropdownOpen" @click="closeDropdown" class="fixed top-0 bottom-0 left-0 w-full z-20"></div>
    <Transition name="switch">
      <ul v-if="isDropdownOpen" 
        @click="closeDropdown"
        class="flex flex-col absolute z-30 rounded-lg bg-slate-800 border border-slate-700 py-3 w-36 shadow-md"
        :style="{ top: dropdownPosition.y + 'px', right: dropdownPosition.x + 'px' }">
        <slot></slot>
      </ul>
    </Transition>
  </Teleport>
</template>