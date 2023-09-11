<script setup>
  import { ref } from 'vue'
  import { useStore } from 'vuex'
  import Button from '../components/Button.vue'

  const store = useStore()
  const fields = ref({})
  const errors = ref({})

  const submit = () => {
    window.axios.post('/api/login', fields.value)
      .then(() => {
        store.dispatch('login')
      })
      .catch(result => {
        if (typeof result.response != 'undefined') {
          return errors.value = result.response.data.errors
        }

        console.log(result);
      })
  }
</script>

<template>
  <div class="h-full flex flex-col justify-center items-center w-full max-w-sm mx-auto">
    <img src="../../img/wishr.svg" alt="Wishr" width="72">
    <h1 class="text-center text-xl mt-4">Wishr</h1>
    <form @submit.prevent="submit" class="mt-8 w-full rounded-2xl p-5 sm:p-8 bg-slate-900 ring-1 ring-inset ring-white/10">
      <h2 class="text-2xl text-center font-semibold mb-6 text-slate-200">Login</h2>

      <label for="email"
        :class="'mt-5' + ('email' in errors ? ' text-rose-600' : '')">Email</label>
      <input type="email" id="email"
        v-model="fields.email"
        :class="{'error': 'email' in errors}">
      <span v-if="errors.email" class="text-rose-600 text-sm">{{ errors.email[0] }}</span>

      <label for="password"
        :class="'mt-5' + ('password' in errors ? ' text-rose-600' : '')">Password</label>
      <input type="password" id="password"
        v-model="fields.password"
        :class="{'error': 'password' in errors}">
      <span v-if="errors.password" class="text-rose-600 text-sm">{{ errors.password[0] }}</span>

      <Button type="submit" class="mt-8" text="Login" block color="sky" size="lg"></Button>
    </form>
    <p class="text-center mt-4 mb-2 text-slate-400">Don't have an account ?</p>
    <RouterLink :to="{name: 'Register'}" class="inline-block p-1 ease-out duration-300 text-slate-200 underline underline-offset-4">Register</RouterLink>
  </div>
</template>