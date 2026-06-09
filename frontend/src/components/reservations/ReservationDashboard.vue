<script setup>

defineProps({
  totalReservations: Number,
  pendingReservations: Number,
  confirmedReservations: Number,
  cancelledReservations: Number,
  activeReservations: Number,
})
</script>

<template>
  <el-row :gutter="20" style="margin-bottom: 30px">
    <el-col :span="4">
      <el-card shadow="hover">
        <div style="text-align:center">
          <p>Total</p>
          <h1>{{ totalReservations }}</h1>
        </div>
      </el-card>
    </el-col>

    <el-col :span="4">
      <el-card shadow="hover">
        <div style="text-align:center">
          <p>Pendientes</p>
          <h1 style="color:#E6A23C">{{ pendingReservations }}</h1>
        </div>
      </el-card>
    </el-col>

    <el-col :span="4">
      <el-card shadow="hover">
        <div style="text-align:center">
          <p>Confirmadas</p>
          <h1 style="color:#67C23A">{{ confirmedReservations }}</h1>
        </div>
      </el-card>
    </el-col>

    <el-col :span="4">
      <el-card shadow="hover">
        <div style="text-align:center">
          <p>Canceladas</p>
          <h1 style="color:#F56C6C">{{ cancelledReservations }}</h1>
        </div>
      </el-card>
    </el-col>

    <el-col :span="4">
      <el-card shadow="hover">
        <div style="text-align:center">
          <p>Activas</p>
          <h1 style="color:#409EFF">{{ activeReservations }}</h1>
        </div>
      </el-card>
    </el-col>
  </el-row>
</template>