<script setup>
defineProps({
  reservations: Array,
})

defineEmits(['edit', 'delete', 'change-status'])
</script>

<template>
  <el-table :data="reservations" style="width: 100%">
    <el-table-column prop="guest_name" label="Huésped" width="180" />
    <el-table-column label="Cabaña" width="220">
      <template #default="scope">
        <div>
          <strong>{{ scope.row.cabin?.name || 'Sin cabaña' }}</strong>
          <br />
          <small v-if="scope.row.cabin">
            {{ scope.row.cabin.capacity }} personas
          </small>
        </div>
      </template>
    </el-table-column>
    <el-table-column prop="check_in" label="Ingreso" width="120" />
    <el-table-column prop="check_out" label="Salida" width="120" />
    <el-table-column prop="guests" label="Huéspedes" width="100" />

    <el-table-column label="Estado" width="120">
      <template #default="scope">
        <el-tag
          :type="
            scope.row.status === 'confirmed'
              ? 'success'
              : scope.row.status === 'cancelled'
                ? 'danger'
                : 'warning'
          "
        >
          {{
            scope.row.status === 'confirmed'
              ? 'Confirmada'
              : scope.row.status === 'cancelled'
                ? 'Cancelada'
                : 'Pendiente'
          }}
        </el-tag>
      </template>
    </el-table-column>

    <el-table-column label="Acciones" min-width="350">
      <template #default="scope">
        <el-space wrap>
          <el-button
            v-if="scope.row.status !== 'confirmed'"
            type="success"
            size="small"
            @click="$emit('change-status', scope.row, 'confirmed')"
          >
            Confirmar
          </el-button>

          <el-button
            v-if="scope.row.status !== 'cancelled'"
            type="info"
            size="small"
            @click="$emit('change-status', scope.row, 'cancelled')"
          >
            Cancelar
          </el-button>

          <el-button
            type="warning"
            size="small"
            @click="$emit('edit', scope.row)"
          >
            Editar
          </el-button>

          <el-button
            type="danger"
            size="small"
            @click="$emit('delete', scope.row.id)"
          >
            Eliminar
          </el-button>
        </el-space>
      </template>
    </el-table-column>
  </el-table>
</template>