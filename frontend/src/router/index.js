import { createRouter, createWebHistory } from 'vue-router'
import ReservationsView from '@/views/ReservationsView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'reservations',
      component: ReservationsView,
    },
  ],
})

export default router