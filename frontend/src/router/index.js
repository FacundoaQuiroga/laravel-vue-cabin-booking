import { createRouter, createWebHistory } from 'vue-router'
import PublicLayout from '@/layouts/PublicLayout.vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import HomeView from '@/views/HomeView.vue'
import ReservationsView from '@/views/ReservationsView.vue'
import CabinsView from '@/views/CabinsView.vue'

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

export default router