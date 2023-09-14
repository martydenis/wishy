<script setup>
  import NavItem from './NavItem.vue'
</script>

<template>
  <nav class="bg-slate-900 lg:py-6 fixed z-50 w-full bottom-0 left-0 h-20 lg:h-full lg:w-24">
    <ul class="px-2 max-w-sm mx-auto flex lg:gap-3 lg:flex-col h-full justify-center">
      <NavItem :to="{name: 'Home'}" icon="wishy" text="Home"></NavItem>
      <NavItem :to="{name: 'Discover'}" icon="compass" text="Discover"></NavItem>
      <NavItem :to="{name: 'Friends'}" icon="users" text="Friends"></NavItem>
      <NavItem :to="{name: 'Account'}" icon="setting" text="Account" class="lg:mt-auto"></NavItem>
    </ul>
  </nav>
</template>

<style lang="scss">
  .menu-active {
    @apply text-slate-200;

    @media (min-width: 1024px) {
      .nav-link-icon {
        @apply bg-sky-900;
      }
    }
  }

  @media (hover: hover) {
    .nav-logo {
      @apply hover:opacity-75;
    }

    .nav-link {
      @apply hover:text-slate-300;
    }

    .nav-link:hover .nav-link-icon {
      @apply bg-sky-900;
    }
  }
</style>