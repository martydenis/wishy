<script setup>
  import { ref } from 'vue'
  import { useStore } from 'vuex'
  import { useRouter } from 'vue-router'
  import Button from '../components/Button.vue'

  const store = useStore()
  const fields = ref({})
  const errors = ref({})

  const submit = () => {
    window.axios.post('/api/register', fields.value)
      .then(() => {
        store.dispatch('login')
      })
      .catch(result => {
        if (typeof result.response != 'undefined') {
          return errors.value = result.response.data.errors
        }

        errors.value = result.response.data.errors
      });
  }
</script>

<template>
  <div class="h-full flex flex-col justify-center items-center w-full max-w-md mx-auto">
    <img src="../../img/wishr.svg" alt="Wishr" width="72">
    <h1 class="text-center text-xl mt-4">Wishr</h1>
    <form @submit.prevent="submit" class="mt-8 w-full rounded-2xl p-5 sm:p-8 bg-slate-900 ring-1 ring-inset ring-white/10">
      <h2 class="text-3xl font-semibold mb-4 text-slate-200">Register</h2>

      <label for="name"
        :class="'block' + ('name' in errors ? ' text-rose-600' : '')">Name</label>
      <input type="text" id="name"
        v-model="fields.name"
        :class="{'error': 'name' in errors}">
      <span v-if="errors.name" class="text-rose-600 text-sm">{{ errors.name[0] }}</span>

      <label for="email"
        :class="'mt-5 block' + ('email' in errors ? ' text-rose-600' : '')">Email</label>
      <input type="email" id="email"
        v-model="fields.email"
        :class="{'error': 'email' in errors}">
      <span v-if="errors.email" class="text-rose-600 text-sm">{{ errors.email[0] }}</span>

      <label for="password"
        :class="'mt-5 block' + ('password' in errors ? ' text-rose-600' : '')">Password</label>
      <input type="password" id="password"
        v-model="fields.password"
        :class="{'error': 'password' in errors}">
      <span v-if="errors.password" class="text-rose-600 text-sm">{{ errors.password[0] }}</span>

      <label for="password_confirmation" class="mt-5 block">Confirm password</label>
      <input type="password" id="password_confirmation"
        v-model="fields.password_confirmation">

      <button type="submit" class="mt-8 block text-white bg-sky-500 w-full rounded-full h-[2.75em]">Sign up</button>
    </form>
    <p class="text-center mt-4 mb-2 text-slate-400">Already have an account ?</p>
    <Button :route="{name: 'Login'}" text="Login"></Button>
  </div>
</template>