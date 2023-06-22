<script setup>
    import { RouterView } from "vue-router";
    import { ref, provide } from "vue";
    import Icons from "./components/Icons.vue";
    import Nav from "./components/Nav.vue";

    const wishlists = ref([]);

    provide('wishlists', wishlists);

    window.axios.get('/api/wishlists').then(results => {
        wishlists.value = results.data;
    });
</script>

<template>
    <Icons></Icons>
    <Nav></Nav>
    <RouterView></RouterView>
</template>

<style lang="scss">

</style>