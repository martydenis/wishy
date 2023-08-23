<script setup>
  import { RouterLink } from 'vue-router'
  const props = defineProps(['route', 'icon', 'text', 'color', 'size', 'type', 'block'])

  let btnColor = '';
  switch (props.color) {
    case 'sky':
      btnColor = 'btn-sky'
      break;
    case 'rose':
      btnColor = 'btn-rose'
      break;
    default:
      btnColor = 'btn-default'
      break;
  }

  let btnSize = '';
  switch (props.size) {
    case 'sm':
      btnSize = 'btn-sm'
      break;
    case 'lg':
      btnSize = 'btn-lg'
      break;
    default:
      btnSize = 'btn-md'
      break;
  }

  const btnPaddingX = props.text ? 'btn-has-text' : '';
  const btnFullWidth = typeof props.block != 'undefined' ? 'w-full' : '';
</script>

<template>
  <button v-if="!route" :type="type" class="rounded-full flex gap-2 items-center justify-center ease-out duration-300" :class="[btnColor, btnSize, btnPaddingX, btnFullWidth]">
    <svg v-if="icon" :class="{'text-[0.925em]': text, 'text-[1em]': !text}"><use :href="'#' + icon"/></svg>
    <span v-if="text">{{ text }}</span>
  </button>
  <RouterLink v-else :to="route" class="rounded-full flex gap-2 items-center justify-center ease-out duration-300" :class="[btnColor, btnSize, btnPaddingX, btnFullWidth]">
    <svg v-if="icon" :class="{'text-[0.925em]': text, 'text-[1em]': !text}"><use :href="'#' + icon"/></svg>
    <span v-if="text">{{ text }}</span>
  </RouterLink>
</template>

<style lang="scss">
  .btn-sm {
    --btn-padding: 0.25em;
    padding: var(--btn-padding);
    @apply min-w-[2rem] h-8 text-sm;
  }

  .btn-md {
    --btn-padding: 0.375em;
    padding: var(--btn-padding);
    @apply min-w-[2.5rem] h-10 text-md;
  }

  .btn-lg {
    --btn-padding: 0.5em;
    padding: var(--btn-padding);
    @apply min-w-[2.75rem] h-11 text-lg;
  }

  .btn-has-text {
    padding-left: calc(var(--btn-padding) * 2);
    padding-right: calc(var(--btn-padding) * 2);
  }

  .btn-default {
    @apply bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-slate-200;
  }

  .btn-rose {
    @apply bg-slate-800 text-slate-200 hover:bg-rose-600 hover:text-rose-200;
  }

  .btn-sky {
    @apply bg-sky-500 text-slate-200 hover:bg-sky-600;
  }

  .btn-disabled {
    @apply pointer-events-none bg-slate-800 text-slate-500;
  }
</style>