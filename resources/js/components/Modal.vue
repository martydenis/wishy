<script setup>
  const emit = defineEmits(['userInput'])
  const props = defineProps(['visible', 'buttonDisabled'])

  const emitUserInput = (input) => {
    emit("userInput", input)
  }

  const data = 1
</script>

<template>
  <Teleport to="body">
    <Transition name="modal">
      <div @click.prevent="emitUserInput(0)" v-if="typeof visible == 'undefined' || visible" class="bg-slate-950/60 backdrop-blur-sm fixed z-50 top-0 left-0 w-full h-full p-5 sm:p-8 flex justify-center items-start overflow-y-scroll">
        <div @click.stop class="modal drop-shadow-2xl ring-1 ring-slate-800 bg-slate-900 rounded-3xl max-w-lg p-5 sm:p-8 grow my-auto">
          <h3 class="text-2xl font-bold mb-3 flex gap-3 justify-between items-center text-slate-200">
            <slot name="header">Are you sure&nbsp;?</slot>
            <button @click.prevent="emitUserInput(0)" class="rounded-full self-start text-slate-400 hover:bg-slate-800 hover:text-slate-600 transition-all text-xl h-10 w-10 flex justify-center items-center"><svg><use href="#close" /></svg></button>
          </h3>

          <slot></slot>

          <hr class="mt-4 mb-4 border-slate-700">

          <ul class="flex justify-between font-bold">
            <li><button @click.prevent="emitUserInput(0)" class="rounded-full flex gap-2 py-2 px-4 items-center ease-out duration-300 border border-slate-700 bg-slate-800 text-slate-200 hover:bg-slate-700 hover:text-white hover:border-transparent"><slot name="no-button">Cancel</slot></button></li>
            <li>
              <button @click.prevent="emitUserInput(data)"
                class="rounded-full flex gap-2 py-2 px-4 items-center ease-out duration-300"
                :class="{
                  'pointer-events-none bg-slate-800 text-slate-500': buttonDisabled,
                  'bg-sky-500 text-white hover:bg-sky-600': !buttonDisabled
                }">
                  <slot name="yes-button">Yes</slot>
              </button>
            </li>
          </ul>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>