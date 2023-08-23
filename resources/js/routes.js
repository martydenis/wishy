import { createRouter, createWebHistory } from 'vue-router'
import store from './stores.js'

import Home from './views/Home.vue'
import Wishlist from './views/Wishlist.vue'
import CreateWishlist from './views/CreateWishlist.vue'
import Login from './views/Login.vue'
import Register from './views/Register.vue'
import Account from './views/Account.vue'
import Friends from './views/Friends.vue'
import Discover from './views/Discover.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {requiresAuth: true}
  },
  {
    path: '/discover',
    name: 'Discover',
    component: Discover,
    meta: {requiresAuth: true}
  },
  {
    path: '/friends',
    name: 'Friends',
    component: Friends,
    meta: {requiresAuth: true}
  },
  {
    path: '/wishlists/create',
    name: 'CreateWishlist',
    component: CreateWishlist,
    meta: {requiresAuth: true}
  },
  {
    path: '/wishlists/:id/manage',
    name: 'ManageWishlist',
    component: CreateWishlist,
    props: true,
    meta: {requiresAuth: true}
  },
  {
    path: '/wishlists/:id',
    name: 'Wishlist',
    component: Wishlist,
    props: true,
    meta: {requiresAuth: true}
  },
  {
    path: '/account',
    name: 'Account',
    component: Account,
    meta: {requiresAuth: true}
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {requiresGuest: true}
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: {requiresGuest: true}
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

router.beforeEach((to, from) => {
  const authenticated = store.getters.authenticated;

  if (to.meta.requiresGuest && authenticated) {
    return {name: "Home"}
  } else if (to.meta.requiresAuth && !authenticated) {
    return {name: "Login"}
  }
})

export default router