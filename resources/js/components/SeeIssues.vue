<template>
    <div class="mt-4">
        <div v-if="issues.length > 0" v-for="issue in issues" :key="issue.id"
            class="mb-2 border shadow-md border-primary rounded p-2">
            <div class="cursor-pointer flex justify-between items-center" @click="toggle(issue.id)">
                <div>
                    <strong class="text-primary">Issue #{{ issue.id }}</strong> —
                    {{ issue.type }} — {{ issue.user.email }}
                    <span :class="[
                        'ml-2 px-2 py-0.5 rounded text-xs font-semibold',
                        issue.status === 0 ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800'
                    ]">
                        {{ issue.status === 0 ? 'Pendiente' : 'Resuelto' }}
                    </span>
                </div>

                <span class="text-primary">{{ expanded[issue.id] ? '▲' : '▼' }}</span>
            </div>

            <div v-if="expanded[issue.id]" class="mt-2 ml-4">
                <div><strong>Descripción:</strong> {{ issue.description }}</div>
                <div><strong>ID Producto:</strong> {{ issue.product_id || 'N/A' }}</div>
                <div><strong>Creado:</strong> {{ issue.created_at }}</div>
            </div>

            <div class="mt-2 flex gap-2">
                <button @click.stop="handleDelete(issue.id)" class="btn  bg-red-600 hover:bg-red-600/70 ">
                    eliminar
                </button>
                <button @click.stop="handleResolve(issue.id)" class="btn btn-primary">
                    solucionado
                </button>
            </div>
        </div>

        <div v-else class="text-gray-600 mt-4">No todavia no hay problemas.</div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const issues = ref([]);
const expanded = ref({});

function toggle(id) {
    expanded.value[id] = !expanded.value[id];
}

async function handleDelete(id) {
    await axios.delete(`/issues/${id}`);
    issues.value = issues.value.filter(issue => issue.id !== id);
}

async function handleResolve(id) {
    await axios.put(`/issues/${id}/resolve`);
    issues.value = issues.value.filter(issue => issue.id !== id);
}

onMounted(() => {
    axios.get('/issues').then(res => {
        issues.value = res.data.data;
    });
});
</script>
