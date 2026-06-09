import { defineStore } from 'pinia'
import api from '@/api/axios'

export const useReservationStore = defineStore('reservation', {
  state: () => ({
    reservations: [],
    loading: false,
  }),

  actions: {
    async fetchReservations() {
      this.loading = true
      const response = await api.get('/reservations')
      this.reservations = response.data
      this.loading = false
    },

    async createReservation(form) {
      await api.post('/reservations', form)
      await this.fetchReservations()
    },
    
    async updateReservation(id, form) {
      await api.put(`/reservations/${id}`, form)
      await this.fetchReservations()
    },

    async deleteReservation(id) {
      await api.delete(`/reservations/${id}`)
      await this.fetchReservations()
    },
  },
})