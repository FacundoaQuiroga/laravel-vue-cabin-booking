<script setup>
import { reactive, onMounted, ref, computed, watch } from 'vue'
import { useReservationStore } from '@/stores/reservationStore'
import { ElMessageBox, ElMessage, ElNotification } from 'element-plus'
import ReservationDashboard from '@/components/reservations/ReservationDashboard.vue'
import ReservationForm from '@/components/reservations/ReservationForm.vue'
import ReservationTable from '@/components/reservations/ReservationTable.vue'
import api from '@/api/axios'


const store = useReservationStore()

const search = ref('')
const statusFilter = ref('')
const cabins = ref([])


const filteredReservations = computed(() => {
  return store.reservations.filter((reservation) => {
    const term = search.value.toLowerCase()

    const guestName = reservation.guest_name?.toLowerCase() || ''
    const cabinName = reservation.cabin?.name?.toLowerCase() || ''

    const matchesSearch =
      guestName.includes(term) ||
      cabinName.includes(term)

    const matchesStatus = statusFilter.value
      ? reservation.status === statusFilter.value
      : true

    return matchesSearch && matchesStatus
  })
})


const editingId = ref(null)


const form = reactive({
  guest_name: '',
  guest_email: '',
  guest_phone: '',
  cabin_id: null,
  check_in: '',
  check_out: '',
  guests: 1,
  status: 'pending',
  notes: '',
})

const errors = reactive({})

onMounted(async () => {
  store.fetchReservations()

  const response = await api.get('/cabins')
  cabins.value = response.data
})

const resetForm = () => {
  form.guest_name = ''
  form.guest_email = ''
  form.guest_phone = ''
  form.cabin_id = null
  form.check_in = ''
  form.check_out = ''
  form.guests = 1
  form.status = 'pending'
  form.notes = ''
  editingId.value = null

  Object.keys(errors).forEach((key) => delete errors[key])
}

const submitForm = async () => {
  Object.keys(errors).forEach((key) => delete errors[key])

  try {
    if (editingId.value) {
      await store.updateReservation(editingId.value, form)
      ElMessage.success('Reserva actualizada correctamente')
    } else {
      await store.createReservation(form)
      ElMessage.success('Reserva creada correctamente')
    }

    resetForm()
  } catch (error) {
    if (error.response?.status === 422) {
      Object.assign(errors, error.response.data.errors)

      ElNotification.error({
        title: 'Datos incompletos',
        message: 'Revisá los campos del formulario.',
      })
    } else {
      ElNotification.error({
        title: 'Error',
        message: 'Ocurrió un error inesperado.',
      })
    }
  }
}

const editReservation = (reservation) => {
  editingId.value = reservation.id

  form.guest_name = reservation.guest_name
  form.guest_email = reservation.guest_email
  form.guest_phone = reservation.guest_phone
  form.cabin_id = reservation.cabin_id
  form.check_in = reservation.check_in
  form.check_out = reservation.check_out
  form.guests = reservation.guests
  form.status = reservation.status
  form.notes = reservation.notes
}

const confirmDelete = async (id) => {
  await ElMessageBox.confirm(
    '¿Seguro que deseas eliminar esta reserva?',
    'Confirmar eliminación',
    {
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
      type: 'warning',
    }
  )

  await store.deleteReservation(id)

  ElMessage.success('Reserva eliminada correctamente')
}

const changeStatus = async (reservation, status) => {
  await store.updateReservation(reservation.id, {
    ...reservation,
    status,
  })

  ElMessage.success('Estado actualizado correctamente')
}


const totalReservations = computed(() => store.reservations.length)

const pendingReservations = computed(() =>
  store.reservations.filter((reservation) => reservation.status === 'pending').length
)

const confirmedReservations = computed(() =>
  store.reservations.filter((reservation) => reservation.status === 'confirmed').length
)

const cancelledReservations = computed(() =>
  store.reservations.filter((reservation) => reservation.status === 'cancelled').length
)

const activeReservations = computed(() => {
  const today = new Date().toISOString().split('T')[0]

  return store.reservations.filter(
    reservation =>
      reservation.status === 'confirmed' &&
      reservation.check_in <= today &&
      reservation.check_out >= today
  ).length
})

const selectedCabin = computed(() => {
  return cabins.value.find((cabin) => cabin.id === form.cabin_id)
})

watch(selectedCabin, (cabin) => {
  if (cabin && form.gests > cabin.capacity) {
    form.guests = cabin.capacity
  }
})

</script>

<template>
  <div style="padding: 30px">
    <h1>Sistema de Reservas de Cabañas</h1>

    <ReservationDashboard
        :total-reservations="totalReservations"
        :pending-reservations="pendingReservations"
        :confirmed-reservations="confirmedReservations"
        :cancelled-reservations="cancelledReservations"
        :active-reservations="activeReservations"
    />

    <ReservationForm
      :form="form"
      :errors="errors"
      :editing-id="editingId"
      :cabins="cabins"
      :selected-cabin="selectedCabin"
      @submit="submitForm"
      @reset="resetForm"
    />

    <hr style="margin: 40px 0" />
    <el-card shadow="always">

        <template #header>
            <strong>Reservas Registradas</strong>
        </template>

        <el-row :gutter="20" style="margin-bottom: 20px">
            <el-col :span="12">
                <el-input
                v-model="search"
                placeholder="Buscar huésped..."
                clearable
                />
            </el-col>

            <el-col :span="6">
                <el-select
                v-model="statusFilter"
                placeholder="Filtrar por estado"
                clearable
                style="width: 100%"
                >
                <el-option label="Pendientes" value="pending" />
                <el-option label="Confirmadas" value="confirmed" />
                <el-option label="Canceladas" value="cancelled" />
                </el-select>
            </el-col>
        </el-row>
        
        <ReservationTable
            :reservations="filteredReservations"
            @edit="editReservation"
            @delete="confirmDelete"
            @change-status="changeStatus"
        />

    </el-card>
  </div>
</template>