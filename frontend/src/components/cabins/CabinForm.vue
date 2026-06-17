<script setup>
defineProps({
    form: Object,
    errors: Object,
    editingId: [Number, null],
})

defineEmits(['submit', 'reset'])

</script>

<template>

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

                <el-form-item label="Estado">
                    <el-radio-group v-model="form.status" :error="errors.status?.[0]">
                        <el-radio value="available">Disponible</el-radio>
                        <el-radio value="unavailable">No Disponible</el-radio>
                    </el-radio-group>
                    </el-form-item>
                

                <el-form-item>
                    <el-button type="primary" @click="$emit('submit')">{{ editingId ? 'Actualizar' : 'Crear' }}</el-button>
                    <el-button v-if="editingId" @click="$emit('reset')" >
                        Cancelar
                    </el-button>
                </el-form-item>
            </el-form>
        </el-card>


</template>