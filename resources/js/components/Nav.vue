<script setup>
  import { RouterLink } from 'vue-router';

</script>

<template>
  <nav class="max-w-screen-xl mx-auto mb-10">
    <ul class="flex gap-x-10">

      <li><RouterLink to='/' class="text-slate-400" active-class="text-slate-700">Wishlists</RouterLink></li>
      <li><RouterLink to='/login' class="text-slate-400" active-class="text-slate-700">Login</RouterLink></li>
    </ul>
  </nav>
</template>