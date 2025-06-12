<template>
    <div>
        <div v-if="orders.order && orders.order.length > 0" v-for="order in orders.order" :key="order.order_id"
            class="mb-2 border shadow-md border-primary rounded p-2">

            <div class="cursor-pointer flex justify-between items-center" @click="toggle(order.order_id)">

                <div>
                    <strong class="text-primary">Pedido Cancelado #{{ order.order_id }}</strong> — {{ order.order_amount
                    }}€

                    <span :class="[
                        'ml-2 px-2 py-0.5 rounded text-xs font-semibold',
                        order.order_status < 0 ? 'bg-red-200 text-red-800' : order.order_status === 0 ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800'
                    ]">
                        {{ order.order_status < 0 ? 'cancelado' : order.order_status === 0 ? 'Pendiente' : 'Entregado'
                            }}</span>
                </div>
                <span class="text-primary">{{ expanded[order.order_id] ? '▲' : '▼' }}</span>

            </div>

            <div v-if="expanded[order.order_id]" class="mt-2">
                <div v-for="prod in order.products" :key="prod.order_product_id" class="ml-4">
                    {{ prod.product_name }} ×{{ prod.quantity }} @ {{ prod.price }}€ = {{ lineTotal(prod) }}€
                </div>
            </div>
        </div>

        <div v-else class="text-gray-600 mt-4">No hay órdenes canceladas.</div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

const orders = ref({});
const expanded = reactive({});

function toggle(orderId) {
    expanded[orderId] = !expanded[orderId];
}

function lineTotal(prod) {
    return (prod.quantity * parseFloat(prod.price)).toFixed(2);
}

onMounted(async () => {
    const response = await axios.get('/order/canceled');
    orders.value = response.data;
});
</script>
