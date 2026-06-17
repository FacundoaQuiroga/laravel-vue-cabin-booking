import { createRouter, createWebHistory } from 'vue-router'
import ReservationsView from '@/views/ReservationsView.vue'
import CabinsView from '@/views/CabinsView.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'reservations',
      component: ReservationsView,
    },
    {
      path: '/cabins',
      name: 'cabins',
      component: CabinsView,
    }
  ],
})

export default router