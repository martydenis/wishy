import { createRouter, createWebHistory } from 'vue-router'
import Wishlists from './views/Wishlists.vue'
import Login from './views/Login.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Wishlists
  },
  {
    path: '/login/',
    name: 'login',
    component: Login
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router