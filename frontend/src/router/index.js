import { createRouter, createWebHistory } from 'vue-router'
import PublicLayout from '@/layouts/PublicLayout.vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import HomeView from '@/views/HomeView.vue'
import ReservationsView from '@/views/ReservationsView.vue'
import CabinsView from '@/views/CabinsView.vue'
import LoginView from '@/views/LoginView.vue'
import api from '@/api/axios'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: PublicLayout,
      children: [
        {
          path: '',
          name: 'home',
          component: HomeView,
        },
        {
          path: 'login',
          name: 'login',
          component: LoginView,
        },
      ],
    },
    {
      path: '/admin',
      component: AdminLayout,
      children: [
        {
          path: 'reservations',
          name: 'admin.reservations',
          component: ReservationsView,
        },
        {
          path: 'cabins',
          name: 'admin.cabins',
          component: CabinsView,
        },
      ],
    },
  ],
})

router.beforeEach(async (to) => {
  if (!to.path.startsWith('/admin')) {
    return true
  }

  try {
    await api.get('/user')
    return true
  } catch (error) {
    return {
      name: 'login',
    }
  }
})

export default router