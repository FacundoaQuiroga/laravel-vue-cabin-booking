<script setup>
import { reactive } from 'vue'

const form = reactive({
  email: '',
  password: '',
})

const onSubmit = () => {
  console.log('login', form)
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