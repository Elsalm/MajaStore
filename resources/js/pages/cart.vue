<template>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-semibold mb-8">Tu carrito de compras</h1>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div v-if="cartItems.length > 0" class="bg-white rounded-lg shadow-sm">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-medium">
                                Productos ({{ cartItems.length }})
                            </h2>
                        </div>
                        <ul>
                            <li v-for="item in cartItems" :key="item.id"
                                class="p-6 border-b flex flex-col sm:flex-row items-start sm:items-center">
                                <div
                                    class="sm:w-24 sm:h-24 w-full h-40 mb-4 sm:mb-0 sm:mr-6 rounded-md overflow-hidden flex-shrink-0">
                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-cover" />
                                </div>
                                <div class="flex-grow">
                                    <h3 class="font-medium">{{ item.name }}</h3>
                                    <p class="text-primary font-semibold mt-1">${{ Number(item.price).toFixed(2) }}</p>
                                    <div class="flex flex-wrap items-center justify-between mt-4">
                                        <div class="flex items-center border rounded-md">
                                            <button class="px-3 py-1 text-gray-500 hover:text-gray-700"
                                                @click="decreaseQuantity(item.id)">
                                                <MinusIcon size="16" />
                                            </button>
                                            <span class="px-3 py-1 border-l border-r">{{ item.quantity }}</span>
                                            <button class="px-3 py-1 text-gray-500 hover:text-gray-700"
                                                @click="increaseQuantity(item.id)">
                                                <PlusIcon size="16" />
                                            </button>
                                        </div>
                                        <button
                                            class="btn flex items-center text-red-500 hover:text-red-700 mt-4 sm:mt-0"
                                            @click="removeItem(item.id)">
                                            <TrashIcon size="16" class="mr-1" />
                                            <span>Remove</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="p-6">
                            <button class="text-primary hover:underline flex items-center" @click="goToProducts">
                                <ArrowRightIcon size="16" class="mr-2 transform rotate-180" />
                                Seguir Comprando
                            </button>
                        </div>
                    </div>

                    <div v-else class="bg-white rounded-lg shadow-sm p-8 text-center">
                        <h2 class="text-2xl font-medium mb-4">Tu carrito esta vacio</h2>
                        <p class="text-gray-600 mb-6">
                            Parace que no has añadido nada a tu carrito todavia
                        </p>
                        <button @click="goToProducts" class="btn btn-primary">
                            Empieza a comprar
                        </button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                        <h2 class="text-lg font-medium mb-6">Resumen Anterior</h2>
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span>${{ subtotal.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span>{{ shipping === 0 ? 'Free' : '$' + shipping.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax (8%)</span>
                                <span>${{ tax.toFixed(2) }}</span>
                            </div>
                            <div class="border-t pt-4 mt-4">
                                <div class="flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span>${{ total.toFixed(2) }}</span>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary w-full mb-4" @click="storeOrder">Comprar</button>
                        <!--
                        <div class="text-sm text-gray-500 text-center">
                            <p>We accept:</p>
                            <div class="flex justify-center space-x-2 mt-2">
                                <div class="w-10 h-6 bg-gray-200 rounded"></div>
                                <div class="w-10 h-6 bg-gray-200 rounded"></div>
                                <div class="w-10 h-6 bg-gray-200 rounded"></div>
                                <div class="w-10 h-6 bg-gray-200 rounded"></div>
                            </div>
                        </div>
-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from "axios"
import {
    TrashIcon,
    MinusIcon,
    PlusIcon,
    ArrowRightIcon,
} from 'lucide-vue-next'

const cartItems = ref([]) // tú controlas esta data externamente

const subtotal = computed(() =>
    cartItems.value.reduce((sum, item) => sum + item.price * item.quantity, 0),
)
const shipping = 10
const tax = computed(() => subtotal.value * 0.08)
const total = computed(() => subtotal.value + shipping + tax.value)
const updateItem = (id, item) => {
    axios.put(`/cart/${id}`, item)
}
function increaseQuantity(id) {
    const item = cartItems.value.find((i) => i.id === id)
    if (item) {
        item.quantity++
        updateItem(id, item);
    }
}
function decreaseQuantity(id) {
    const item = cartItems.value.find((i) => i.id === id)
    if (item && item.quantity > 1) {
        item.quantity--
        updateItem(id, item);
    }

}
function removeItem(id) {
    axios.delete(`/cart/${id}`).then(response => cartItems.value = response.data.cart);
    window.dispatchEvent(new CustomEvent('cartUpdated'));
}
function goToProducts() {
    location.href = "/product"
}
const getCartItems = () => {
    axios.get("/cart/get").then(response => { cartItems.value = response.data.cart });
}

onMounted(() => {
    getCartItems();
});
const storeOrder = () => {
    axios.post("/order").then(res => { location.href = res.data.url });
}
</script>

<style></style>
