<script setup>
defineProps({
  form: Object,
  errors: Object,
  editingId: [Number, null],
  cabins: Array,

})

defineEmits(['submit', 'reset'])
</script>

<template>
  <el-card shadow="always" style="margin-bottom:30px">
    <template #header>
      <strong>
        {{ editingId ? 'Editar Reserva' : 'Nueva Reserva' }}
      </strong>
    </template>

    <el-form @submit.prevent="$emit('submit')" label-position="top">
      <el-form-item label="Nombre del huésped" :error="errors.guest_name?.[0]">
        <el-input v-model="form.guest_name" />
      </el-form-item>

      <el-form-item label="Email" :error="errors.guest_email?.[0]">
        <el-input v-model="form.guest_email" />
      </el-form-item>

      <el-form-item label="Teléfono" :error="errors.guest_phone?.[0]">
        <el-input v-model="form.guest_phone" />
      </el-form-item>

      <el-form-item label="Cabaña" :error="errors.cabin_id?.[0]">
        <el-select
          v-model="form.cabin_id"
          placeholder="Seleccionar cabaña"
          style="width: 100%"
        >
          <el-option
            v-for="cabin in cabins"
            :key="cabin.id"
            :label="`${cabin.name} (${cabin.capacity} personas)`"
            :value="cabin.id"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="Fecha de ingreso" :error="errors.check_in?.[0]">
        <el-date-picker
          v-model="form.check_in"
          type="date"
          value-format="YYYY-MM-DD"
          placeholder="Seleccionar fecha de ingreso"
          style="width: 100%"
        />
      </el-form-item>

      <el-form-item label="Fecha de salida" :error="errors.check_out?.[0]">
        <el-date-picker
          v-model="form.check_out"
          type="date"
          value-format="YYYY-MM-DD"
          placeholder="Seleccionar fecha de salida"
          style="width: 100%"
        />
      </el-form-item>

      <el-form-item label="Cantidad de huéspedes" :error="errors.guests?.[0]">
        <el-input-number v-model="form.guests" :min="1" />
      </el-form-item>

      <el-form-item label="Notas">
        <el-input v-model="form.notes" type="textarea" />
      </el-form-item>

      <el-button type="primary" @click="$emit('submit')">
        {{ editingId ? 'Actualizar Reserva' : 'Crear Reserva' }}
      </el-button>

      <el-button v-if="editingId" @click="$emit('reset')">
        Cancelar edición
      </el-button>
    </el-form>
  </el-card>
</template>