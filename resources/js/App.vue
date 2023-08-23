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
  <div id="content" class="max-w-screen-xl mx-auto w-full p-5 pt-8 sm:p-10 sm:pt-16">
    <RouterView v-slot="{ Component }">
      <transition name="viewFade" mode="out-in">
        <component :is="Component"></component>
      </transition>
    </RouterView>
  </div>
</template>