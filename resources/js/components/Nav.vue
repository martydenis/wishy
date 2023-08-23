<script setup>
  import { RouterLink } from 'vue-router'
  import { useStore } from 'vuex'

  const store = useStore()
</script>

<template>
  <nav class="bg-slate-900 border-slate-800 max-lg:border-t lg:border-r lg:py-6 fixed z-50 w-full bottom-0 left-0 h-20 lg:h-full lg:w-60">
    <ul class="px-4 flex lg:gap-2 lg:flex-col h-full justify-center">
      <li>
        <RouterLink :to="{name: 'Home'}" class="flex flex-col gap-2 lg:flex-row lg:gap-4 h-full items-center justify-center lg:justify-start px-4 py-2 font-semibold text-slate-400 hover:text-slate-300 hover:bg-slate-800 lg:rounded-md" active-class="menu-active">
          <svg class="max-lg:text-lg"><use href="#home"/></svg>
          Home
        </RouterLink>
      </li>
      <li>
        <RouterLink :to="{name: 'Discover'}" class="flex flex-col gap-2 lg:flex-row lg:gap-4 h-full items-center justify-center lg:justify-start px-4 py-2 font-semibold text-slate-400 hover:text-slate-300 hover:bg-slate-800 lg:rounded-md" active-class="menu-active">
          <svg class="max-lg:text-lg"><use href="#compass"/></svg>
          Discover
        </RouterLink>
      </li>
      <li>
        <RouterLink :to="{name: 'Friends'}" class="flex flex-col gap-2 lg:flex-row lg:gap-4 h-full items-center justify-center lg:justify-start px-4 py-2 font-semibold text-slate-400 hover:text-slate-300 hover:bg-slate-800 lg:rounded-md" active-class="menu-active">
          <svg class="max-lg:text-lg"><use href="#users"/></svg>
          Friends
        </RouterLink>
      </li>
      <!-- <li>
        <RouterLink :to="{name: 'Login'}" class="flex flex-col gap-2 lg:flex-row lg:gap-4 items-center justify-center lg:justify-start px-4 py-2 font-semibold text-slate-400 hover:text-slate-300 hover:bg-slate-800 lg:rounded-md" active-class="menu-active">
          <svg><use href="#user"/></svg>
          Login
        </RouterLink>
      </li> -->
      <li class="hidden mt-auto lg:block"><hr class="border-slate-800"></li>
      <li class="lg:mt-2">
        <RouterLink :to="{name: 'Account'}" class="flex flex-col gap-2 lg:flex-row lg:gap-4 h-full items-center justify-center lg:justify-start px-4 py-2 font-semibold text-slate-400 hover:text-slate-300 hover:bg-slate-800 lg:rounded-md" active-class="menu-active">
          <svg class="max-lg:text-lg"><use href="#setting"/></svg>
          {{ store.getters.user.name }}
        </RouterLink>
      </li>
    </ul>
  </nav>
</template>

<style>
  .menu-active {
    @apply text-slate-200 !important;
  }
</style>