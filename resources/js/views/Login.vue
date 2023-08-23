<script setup>
  import { ref } from 'vue'
  import { useStore } from 'vuex'
  import { useRouter, RouterLink } from 'vue-router'

  const store = useStore()
  const router = useRouter()
  const fields = ref({})
  const errors = ref({})

  const submit = () => {
    window.axios.post('/api/login', fields.value)
      .then((response) => {
        router.replace({name: "Home"})
        store.commit('login', response.data)
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
  <div class="h-full flex flex-col justify-center items-center">
    <h1 class="text-center">Wishr</h1>
    <form @submit.prevent="submit" class="w-full max-w-md rounded-2xl p-5 sm:p-8 bg-slate-900 ring-1 ring-inset ring-white/10">
      <h2 class="text-3xl font-semibold mb-4 text-slate-200">Login</h2>

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

      <button type="submit" class="mt-8 block text-white bg-sky-500 w-full rounded-full h-[2.75em]">Login</button>
    </form>
    <p class="text-center mt-4 text-slate-400">Don't have an account ? <RouterLink :to="{name : 'Register'}" class="underline">Sign up</RouterLink></p>
  </div>
</template>