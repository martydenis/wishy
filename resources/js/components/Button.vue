<script setup>
  import { RouterLink } from 'vue-router'
  const props = defineProps(['route', 'icon', 'text', 'color', 'size', 'type', 'block', 'disabled'])

  let btnColor = '';
  switch (props.color) {
    case 'sky':
      btnColor = 'bg-sky-500 text-slate-200 hover:bg-sky-600'
      break;
    case 'rose':
      btnColor = 'bg-slate-800 text-slate-200 hover:bg-rose-600 hover:text-rose-200'
      break;
    default:
      btnColor = 'bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-slate-200'
      break;
  }

  let btnSize = '';
  switch (props.size) {
    case 'sm':
      btnSize = 'min-w-[2rem] h-9 text-sm'
      break;
    case 'lg':
      btnSize = 'min-w-[2.75rem] h-11 text-[1.0625rem]'
      break;
    case 'floating':
      btnSize = 'fixed z-30 bottom-24 right-5 h-16 w-16 text-xl'
      break;
    default:
      btnSize = 'min-w-[2.5rem] h-10 text-md'
      break;
  }

  const btnPaddingX = props.text ? 'btn-has-text' : '';
  const btnFullWidth = typeof props.block != 'undefined' && (props.block === '' || props.block) ? 'w-full' : '';
</script>

<template>
  <button v-if="!route"
    :type="type"
    class="btn rounded-full flex gap-2 items-center justify-center ease-out duration-300"
    :class="[disabled ? 'pointer-events-none bg-slate-800 text-slate-500' : btnColor, btnSize, btnPaddingX, btnFullWidth]">
    <svg v-if="icon" class="shrink-0" :class="{'text-[0.925em]': text, 'text-[1em]': !text}"><use :href="'#' + icon"/></svg>
    <span v-if="text" class="leading-tight whitespace-nowrap">{{ text }}</span>
  </button>
  <RouterLink v-else
    :to="route"
    class="btn rounded-full flex gap-2 items-center justify-center ease-out duration-300"
    :class="[disabled ? 'pointer-events-none bg-slate-800 text-slate-500' : btnColor, btnSize, btnPaddingX, btnFullWidth]">
    <svg v-if="icon" class="shrink-0" :class="{'text-[0.925em]': text, 'text-[1em]': !text}"><use :href="'#' + icon"/></svg>
    <span v-if="text" class="leading-tight whitespace-nowrap">{{ text }}</span>
  </RouterLink>
</template>

<style lang="scss">
  .btn-has-text {
    padding-left: 1.2em;
    padding-right: 1.2em;
  }

  // .btn-disabled {
  //   @apply pointer-events-none bg-slate-800 text-slate-500;
  // }
</style>