<script setup>
import axios from 'axios'
import {ref,onMounted,reactive} from 'vue'
import api from '@/api/axios'
import { logout, fetchUser } from '@/api/auth'

import { useRouter } from 'vue-router'
import { ElMessage } from 'element-plus'

const router = useRouter()

const user = ref(null)

const handleLogout = async () => {
  await logout()

  ElMessage.success('Sesión cerrada')
  router.push('/login')
}

onMounted(async () => {
    const response = await fetchUser()
    user.value = response.data
})

</script>

<template>
  <div class="app-layout">
    <aside class="sidebar">
      <div class="brand">Cabin Admin</div>

      <router-link to="/admin/reservations" class="nav-link">Reservas</router-link>
      <router-link to="/admin/cabins" class="nav-link">Cabañas</router-link>
      
    <div class="admin-user">
      {{ user?.name }}
    </div>
    <button class="logout-button" @click="handleLogout">
      Cerrar sesión
    </button>

    </aside>

    <main class="content">
      <router-view />
    </main>
  </div>
</template>

<style scoped>
.app-layout {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 240px;
  background: #d95834;
  color: white;
  padding: 24px 0;
}

.brand {
  font-weight: 700;
  font-size: 20px;
  padding: 0 24px 24px;
}

.nav-link {
  display: block;
  padding: 14px 24px;
  color: white;
  text-decoration: none;
}

.nav-link.router-link-active {
  background: rgba(0, 0, 0, 0.18);
}

.content {
  flex: 1;
  padding: 24px;
  background: #f7f8fa;
}
.logout-button {
  width: 100%;
  padding: 14px 24px;
  border: 0;
  background: transparent;
  color: white;
  text-align: left;
  cursor: pointer;
  font: inherit;
}

.logout-button:hover {
  background: rgba(0, 0, 0, 0.18);
}
.admin-user {
  padding: 14px 24px;
  margin-top: 24px;
  font-size: 14px;
  opacity: 0.9;
}
</style>