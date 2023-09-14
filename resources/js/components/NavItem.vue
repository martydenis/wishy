<script setup>
  import { RouterLink } from 'vue-router'

  defineProps(['to', 'icon', 'text'])
</script>

<template>
  <li class="max-lg:flex-1 min-w-0">
    <RouterLink :to="to" class="max-lg:active:bg-slate-800 nav-link duration-300 block h-full items-center justify-center lg:justify-start text-center py-2 font-semibold text-xs text-slate-400lg:rounded-md" active-class="menu-active">
      <span class="nav-link-icon rounded-full w-10 h-10 lg:w-11 lg:h-11 max-lg:-mb-1 mx-auto flex justify-center items-center duration-300 max-lg:bg-transparent">
        <svg class="text-lg"><use :href="'#' + icon" /></svg>
      </span>
      {{ text }}
    </RouterLink>
  </li>
</template>