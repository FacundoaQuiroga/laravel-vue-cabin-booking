import { defineStore } from 'pinia'
import api from '@/api/axios'

export const useCabinStore = defineStore('cabin', {
  state: () => ({
    cabins: [],
    loading: false,
  }),

  actions: {
    async fetchCabins() {
      this.loading = true
      const response = await api.get('/cabins')
      this.cabins = response.data
      this.loading = false
    },

    async createCabin(form) {
      await api.post('/cabins', form)
      await this.fetchCabins()
    },
    
    async updateCabin(id, form) {
      await api.put(`/cabins/${id}`, form)
      await this.fetchCabins()
    },

    async deleteCabin(id) {
      await api.delete(`/cabins/${id}`)
      await this.fetchCabins()
    },
  },
})