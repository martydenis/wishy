<script setup>
  import { RouterLink } from 'vue-router'
  import { useStore } from 'vuex'

  const store = useStore()
</script>

<template>
  <nav class="bg-slate-900 border-slate-800 max-lg:border-t lg:border-r lg:py-6 fixed z-50 w-full bottom-0 left-0 h-[4.5rem] lg:h-full lg:w-60">
    <ul class="px-2 md:px-4 max-w-sm mx-auto flex lg:gap-2 lg:flex-col max-lg:text-xs h-full justify-center">
      <li class="hidden lg:flex my-3">
        <RouterLink :to="{name: 'Home'}" class="nav-logo block active:opacity-75 duration-300 px-4 py-2">
          <img src="../../img/wishr.svg" alt="Wishr" width="40">
        </RouterLink>
      </li>
      <li class="max-lg:flex-1 min-w-0">
        <RouterLink :to="{name: 'Home'}" class="nav-link duration-300 flex flex-col gap-1 lg:flex-row lg:gap-4 h-full items-center justify-center lg:justify-start max-lg:text-center px-2 md:px-4 py-2 font-semibold text-slate-400 active:bg-slate-800 lg:rounded-md" active-class="menu-active">
          <svg class="max-lg:text-lg"><use href="#home"/></svg>
          Home
        </RouterLink>
      </li>
      <li class="max-lg:flex-1 min-w-0">
        <RouterLink :to="{name: 'Discover'}" class="nav-link duration-300 flex flex-col gap-1 lg:flex-row lg:gap-4 h-full items-center justify-center lg:justify-start max-lg:text-center px-2 md:px-4 py-2 font-semibold text-slate-400 active:bg-slate-800 lg:rounded-md" active-class="menu-active">
          <svg class="max-lg:text-lg"><use href="#compass"/></svg>
          Discover
        </RouterLink>
      </li>
      <li class="max-lg:flex-1 min-w-0">
        <RouterLink :to="{name: 'Friends'}" class="nav-link duration-300 flex flex-col gap-1 lg:flex-row lg:gap-4 h-full items-center justify-center lg:justify-start max-lg:text-center px-2 md:px-4 py-2 font-semibold text-slate-400 active:bg-slate-800 lg:rounded-md" active-class="menu-active">
          <svg class="max-lg:text-lg"><use href="#users"/></svg>
          Friends
        </RouterLink>
      </li>
      <li class="hidden mt-auto lg:block"><hr class="border-slate-800"></li>
      <li class="max-lg:flex-1 min-w-0 lg:mt-2">
        <RouterLink :to="{name: 'Account'}" class="nav-link duration-300 flex flex-col gap-1 lg:flex-row lg:gap-4 h-full items-center justify-center lg:justify-start max-lg:text-center px-2 md:px-4 py-2 font-semibold text-slate-400 active:bg-slate-800 lg:rounded-md" active-class="menu-active">
          <svg class="max-lg:text-lg shrink-0"><use href="#setting"/></svg>
          <span class="block w-full leading-tight text-ellipsis overflow-hidden whitespace-nowrap">{{ store.getters.user.name }}</span>
        </RouterLink>
      </li>
    </ul>
  </nav>
</template>

<style lang="scss">
  .menu-active {
    @apply text-slate-200;
  }

  @media (hover: hover) {
    .nav-logo {
      @apply hover:opacity-75;
    }

    .nav-link {
      @apply hover:text-slate-300 hover:bg-slate-800;
    }
  }
</style>