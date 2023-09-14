<script setup>
  const emit = defineEmits(['reject', 'accept', 'delete'])
  const props = defineProps(['id', 'name', 'pending'])
</script>

<template>
    <li class="flex gap-4 items-center group px-2 py-2 rounded-xl hover:bg-slate-900 duration-300"
      :class="{ 'text-slate-300': !pending }">
      <i class="h-11 w-11 rounded-full flex justify-center items-center shrink-0"
        :class="{ 'bg-slate-700': !pending, 'border border-slate-700': pending }" >
        <svg><use href="#user" /></svg>
      </i>
      <span class="flex-grow overflow-hidden text-lg text-ellipsis whitespace-nowrap font-bold">{{ name }}</span>

      <span class="flex lg:opacity-0 lg:group-hover:opacity-100 duration-300">
        <i v-if="pending" @click="$emit('accept', id)" class="flex items-center justify-center rounded-full text-green-500 hover:text-green-400 h-11 w-11 shrink-0 cursor-pointer"><svg><use href="#check" /></svg></i>
        <i v-if="pending" @click="$emit('reject', id)" class="flex items-center justify-center rounded-full hover:text-rose-500 h-11 w-11 shrink-0 text-slate-400 cursor-pointer"><svg><use href="#close" /></svg></i>
        <i v-else @click="$emit('delete', id)" class="flex items-center justify-center rounded-full hover:text-rose-500 h-11 w-11 shrink-0 text-slate-400 cursor-pointer"><svg><use href="#close" /></svg></i>
      </span>
    </li>
</template>