<script setup>
import { ref, reactive, onMounted } from 'vue'
import api from '@/api/axios'
import { ElMessage, ElMessageBox } from 'element-plus'


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
        
        <el-card shadow="always">
            <template #header>
                <strong>Nueva Cabaña</strong>
            </template>
            <el-form :model="form" label-width="180px" style="width: 100%" >

                <el-form-item label="Nombre de Cabaña" :error="errors.name?.[0]">
                    <el-input v-model="form.name" style="width: 500px"/>
                </el-form-item>
                
                <el-form-item label="Capacidad de Huespedes">
                    <el-input-number v-model="form.capacity" :min="1" :error="errors.capacity?.[0]" style="width: 180px" />
                </el-form-item>  
                
                <el-form-item label="Descripción">
                <el-input v-model="form.description" type="textarea" :error="errors.description?.[0]" style="width: 420px" />
                </el-form-item>

                <el-form-item label="Status">
                    <el-radio-group v-model="form.status" :error="errors.status?.[0]">
                        <el-radio value="available">Disponible</el-radio>
                        <el-radio value="unavailable">No Disponible</el-radio>
                    </el-radio-group>
                    </el-form-item>
                

                <el-form-item>
                    <el-button type="primary" @click="onSubmit">{{ editingId ? 'Actualizar' : 'Crear' }}</el-button>
                    <el-button v-if="editingId" @click="resetForm()" >
                        Cancelar
                    </el-button>
                </el-form-item>
            </el-form>
        </el-card>

        <hr style="margin: 40px 0" />

        <el-card shadow="always">
            <template #header>
                <strong>Cabañas Registradas</strong>
            </template>
            <el-table :data="cabins" style="width: 100%">
                <el-table-column prop="name" label="Nombre" width="100" />
                <el-table-column prop="capacity" label="Capacidad" width="100" />
                <el-table-column prop="description" label="Descripcion" width="300" />
                <el-table-column label="Acciones" width="180">
                    <template #default="scope">
                        <el-button type="warning" size="small" @click="editCabin(scope.row)">
                            Editar
                        </el-button>
                        <el-button type="danger" size="small" @click="deleteCabin(scope.row.id)">
                            Eliminar
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-card>
    </div>
   
</template>