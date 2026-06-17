<script setup>
defineProps({
    cabins: Array,
    loading: Boolean,
})

defineEmits(['edit', 'delete'])

</script>

<template>

    <el-card shadow="always">
            <template #header>
                <strong>Cabañas Registradas</strong>
            </template>
            <el-table :data="cabins" v-loading="loading" style="width: 100%">
                <el-table-column prop="name" label="Nombre" width="100" />
                <el-table-column prop="capacity" label="Capacidad" width="100" />
                <el-table-column prop="description" label="Descripcion" width="300" />
                <el-table-column label="Estado" width="120">
                    <template #default="scope">
                        <el-tag
                        :type="
                            scope.row.status === 'available'
                            ? 'success'
                            : scope.row.status === 'unavailable'
                                ? 'danger'
                                : 'warning'
                        "
                        >
                        {{
                            scope.row.status === 'available'
                            ? 'Disponible'
                            : scope.row.status === 'unavailable'
                                ? 'No disponible'
                                : 'Disponible'
                        }}
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column label="Acciones" width="180">
                    <template #default="scope">
                        <el-button type="warning" size="small" @click="$emit('edit', scope.row)">
                            Editar
                        </el-button>
                        <el-button type="danger" size="small" @click="$emit('delete', scope.row.id)">
                            Eliminar
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-card>


</template>