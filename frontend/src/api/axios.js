import axios from 'axios'
import router from '@/router'

const api = axios.create({
  baseURL: 'http://localhost:8080/api',
  withCredentials: true,
  withXSRFToken: true,
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
})

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      router.push('/login')
    }

    return Promise.reject(error)
  }
)

export default api