<script setup>
  import { RouterView } from "vue-router"
  import Icons from "./components/Icons.vue"
  import Nav from "./components/Nav.vue"
  import { useStore } from 'vuex'

  const store = useStore()
</script>

<template>
  <Icons></Icons>

  <Nav v-if="store.getters.authenticated"></Nav>
  <div id="content"
    class="max-w-screen-xl mx-auto w-full p-5 pt-8 lg:p-10 lg:pt-16 overflow-hidden"
    :class="{'max-lg:pb-[5.25rem] lg:max-2xl:pl-[8.5rem]': store.getters.authenticated}">
    <RouterView v-slot="{ Component }">
      <transition name="viewFade" mode="out-in">
        <component :is="Component" ></component>
      </transition>
    </RouterView>
  </div>
</template>

