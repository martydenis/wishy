<script setup>
  import { RouterLink } from 'vue-router'
  const props = defineProps(['route', 'icon', 'text'])
</script>

<template>
  <li>
    <button v-if="typeof route == 'undefined'" type="button" class="px-5 w-full bg-slate-800 text-slate-300 hover:text-slate-200 hover:bg-slate-700 ease-out duration-300 h-10 flex gap-3 items-center">
      <svg v-if="icon" class="text-xs"><use :href="'#' + icon"/></svg>
      <span v-if="text">{{ text }}</span>
    </button>
    <RouterLink v-else :to="route" class="py-1 px-5 w-full bg-slate-800 text-slate-300 hover:text-slate-200 hover:bg-slate-700 ease-out duration-300 h-10 flex gap-3 items-center">
      <svg v-if="icon" class="text-xs"><use :href="'#' + icon"/></svg>
      <span v-if="text">{{ text }}</span>
    </RouterLink>
  </li>
</template>