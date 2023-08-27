import { createStore } from 'vuex'
import {arrayOfObjectsToMap} from './tools.js'

const store = createStore({
  state () {
    return {
      user: window.user || {},
      isMobile: window.innerWidth < 640,
      authenticated: window.authenticated,
      wishlists: [],
      friends: {
        accepted: window.initialData.friends ? arrayOfObjectsToMap(window.initialData.friends.accepted) : new Map(),
        pending: window.initialData.friends ? arrayOfObjectsToMap(window.initialData.friends.pending) : new Map()
      },
      isWishCreationModalOpen: false
    }
  },
  getters: {
    user (state) {
      return state.user
    },
    authenticated (state) {
      return state.authenticated
    },
    friends (state) {
      return state.friends
    },
    wishlists (state) {
      return state.wishlists
    },
    isWishCreationModalOpen(state) {
      return state.isCreateWishModalOpen
    },
    isMobile (state) {
      return state.isMobile
    }
  },
  mutations: {
    login (state, user) {
      state.user = user
      state.authenticated = true
      state.isWishCreationModalOpen = false
    },
    logout (state) {
      state.user = {}
      state.authenticated = false
      state.wishlists = []
      state.friends = {}
      state.isWishCreationModalOpen = false
    },
    deleteWishlist (state, id) {
      state.wishlists = state.wishlists.filter(wishlist => wishlist.id != id)
    },
    updateWishlists (state, wishlists) {
      state.wishlists = wishlists
    },
    updateFriends (state, friends) {
      state.friends = {
        accepted: arrayOfObjectsToMap(friends.accepted),
        pending: arrayOfObjectsToMap(friends.pending)
      }
    }
  },
})

export default store;