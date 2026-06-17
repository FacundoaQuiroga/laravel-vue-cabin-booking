<script setup>
import { ref, reactive, onMounted } from 'vue'
import api from '@/api/axios'
import { ElMessage, ElMessageBox } from 'element-plus'
import CabinForm from '@/components/cabins/CabinForm.vue'
import CabinTable from '@/components/cabins/CabinTable.vue'



const errors =reactive({})

const cabins = ref([])

const editingId = ref(null)

const form = reactive({
  name: '',
  capacity: 1,
  description: '',
  status: 'unavailable',
})

const resetForm = () => {
    editingId.value = null
    form.name = ''
    form.capacity = 1
    form.description = ''
    form.status = 'unavailable'
}

const editCabin = (cabin) => {
    editingId.value = cabin.id
    form.name = cabin.name
    form.capacity = cabin.capacity
    form.description = cabin.description
    form.status = cabin.status
}

const fetchCabins = async () => {
    const response = await api.get('/cabins')
    cabins.value = response.data
}

onMounted(async () => {
    fetchCabins()

})



const onSubmit = async () => {
    const isEditing = editingId.value

    try {
        if (isEditing) {
            await api.put(`/cabins/${editingId.value}`, form)
        } else {
            await api.post('/cabins', form)
        }

        await fetchCabins()

        ElMessage.success(isEditing ? 'Cabaña actualizada' : 'Cabaña creada')

        resetForm()
        Object.keys(errors).forEach((key) => delete errors[key])

    } catch (error) {
        ElMessage.error('No se pudo guardar la cabaña')

        if (error.response?.status === 422) {
            Object.assign(errors, error.response.data.errors)
            ElMessage.error('Revisa los campos del formulario')
        } else {
            ElMessage.error('No se pudo guardar la cabaña')
        }
    }
    
    
}

const deleteCabin = async (id) => {

    try{
        await ElMessageBox.confirm('¿Seguro que deseas eliminar esta cabaña?', 'Confirmar eliminación',
            {
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            type: 'warning',
            }
        )
            
        await api.delete(`/cabins/${id}`)
        await fetchCabins()

        ElMessage.success('Cabaña eliminada')
    } catch(error){
        ElMessage.error('No se pudo eliminar la cabaña')
    }
    
}

</script>

<template>
       
    <div style="padding: 20px; box-sizing: border-box">
        <h1>Sistema de Administracion de Cabañas</h1>

        <CabinForm 
            :form="form"
            :errors="errors"
            :editing-id="editingId"
            @submit="onSubmit"
            @reset="resetForm"
        />
        <hr style="margin: 40px 0" />

        <CabinTable
            :cabins="cabins"
            @edit="editCabin"
            @delete="deleteCabin"
        />
        
    </div>
   
</template>