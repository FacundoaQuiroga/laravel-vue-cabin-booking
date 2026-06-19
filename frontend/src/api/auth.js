import axios from 'axios'
import api from '@/api/axios'

export const getCsrfCookie = () => {
  return axios.get('http://localhost:8080/sanctum/csrf-cookie', {
    withCredentials: true,
    withXSRFToken: true,
  })
}

export const login = async (form) => {
  await getCsrfCookie()

  return axios.post('http://localhost:8080/login', form, {
    withCredentials: true,
    withXSRFToken: true,
    headers: {
      Accept: 'application/json',
    },
  })
}

export const logout = () => {
  return axios.post('http://localhost:8080/logout', {}, {
    withCredentials: true,
    withXSRFToken: true,
    headers: {
      Accept: 'application/json',
    },
  })
}

export const fetchUser = () => {
  return api.get('/user')
}