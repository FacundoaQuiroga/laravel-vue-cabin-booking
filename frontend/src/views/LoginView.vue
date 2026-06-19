<script setup>
import axios from 'axios'
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import { ElMessage } from 'element-plus'
import api from '@/api/axios'


const router = useRouter()

const form = reactive({
  email: '',
  password: '',
})

const onSubmit = async () => {
  try {
    axios.defaults.withCredentials = true
    axios.defaults.withXSRFToken = true

    await axios.get('http://localhost:8080/sanctum/csrf-cookie')

    await axios.post('http://localhost:8080/login', form, {
      headers: {
        Accept: 'application/json',
      },
    })

    ElMessage.success('Login successful')
    router.push('/admin/reservations')
  } catch (error) {
    ElMessage.error(error.response?.data?.message || 'Login failed')
  }
}
</script>

<template>
  <div class="login-page">
    <el-card class="login-card" shadow="always">
      <template #header>
        <strong>Admin Login</strong>
      </template>

      <el-form :model="form" label-position="top">
        <el-form-item label="Email">
          <el-input v-model="form.email" type="email" />
        </el-form-item>

        <el-form-item label="Password">
          <el-input v-model="form.password" type="password" show-password />
        </el-form-item>

        <el-button type="primary" style="width: 100%" @click="onSubmit">
          Login
        </el-button>
      </el-form>
    </el-card>
  </div>
</template>

<style scoped>
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f7f8fa;
  padding: 24px;
}

.login-card {
  width: 100%;
  max-width: 420px;
}
</style>