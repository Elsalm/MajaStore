<template>
    <a-list class="demo-loadmore-list" :loading="initLoading" item-layout="vertical" :data-source="data">
        <template #renderItem="{ item: order }">
            <a-list-item :key="order.order_id">
                <a-skeleton :loading="!!order.loading" active>
                    <a-list-item-meta>
                        <template #title>
                            <strong>Pedido #{{ order.order_id }}</strong> — {{ order.order_amount }}€
                        </template>
                        <template #description>
                            <ul>
                                <li v-for="prod in order.products" :key="prod.order_product_id">
                                    {{ prod.product_name }} ×{{ prod.quantity }} @ {{ prod.price }}€ = {{
                                    lineTotal(prod) }}€
                                </li>
                            </ul>
                        </template>
                    </a-list-item-meta>
                </a-skeleton>
            </a-list-item>
        </template>
    </a-list>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

const props = defineProps<{
    data: Array<any>
}>();

const initLoading = false;

function lineTotal(prod: any) {
    return (prod.quantity * parseFloat(prod.price)).toFixed(2);
}
</script>

<style scoped>
.demo-loadmore-list {
    min-height: 350px;
}
</style>
