<script setup>
    import { RouterView } from "vue-router";
    import { ref, provide } from "vue";
    import Icons from "./components/Icons.vue";
    import Nav from "./components/Nav.vue";
</script>

<template>
    <Icons></Icons>
    <Nav></Nav>
    <RouterView v-slot="{ Component }">
        <transition name="viewFade" mode="out-in">
            <component :is="Component"></component>
        </transition>
    </RouterView>
</template>

<style lang="scss">
    .viewFade-enter-from,
    .viewFade-leave-to {
        opacity: 0;
        transform: translateY(30px);
    }

    .viewFade-enter-active {
        transition: all 0.4s ease-out;
    }

    .viewFade-leave-active {
        transition: all 0.4s ease-in;
    }
</style>