import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import { useUsersStore } from '@/stores/users.js'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: {},
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
      meta: {},
    },
    {
      path: '/todoes',
      name: 'todoes',
      component: () => import('../views/Todoes.vue'),
      meta: {
        requiresAuth: true,
      }
    }
  ]
})

router.beforeResolve((to, from) => {
  let store = useUsersStore()
  console.log('user:', store.user.username)

  if(to.meta?.requiresAuth){
    if(store.user){
      //noop
      return true
    }else{
      store.next = to
      store.show_login = true
      return false
      //return '/login'
    }
  }
})

export default router
