<script setup>
import { ref } from 'vue'

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
})
const quantity = ref(1)
const colors = ref(1)

function incrementQuantity() {
    quantity.value++
}
function decrementQuantity() {
    if (quantity.value > 1) quantity.value--
}
const setItemCart = () => {
    axios.post("/cart", { id: props.product.id, quantity: quantity.value, price: props.product.price });
    window.dispatchEvent(new CustomEvent('cartUpdated'));
}
</script>

<template>
    <div class="bg-white">
        <div class="container py-8">
            <nav class="text-sm mb-8 text-gray-500">
                Home / Furniture / Sofas / <span class="font-medium text-gray-900">{{ product.name }}</span>
            </nav>

            <div class="flex flex-col gap-8 md:flex-row md:aling-center md:justify-center ">
                <div class="border-md shadow-lg md:w-120 border-box ">
                    <div v-for="(img, i) in product.images" :key="i" class="flex aling-center justify-center p-4">
                        <img :src="img" :alt="product.name" class="w-3/4 object-cover rounded" />
                    </div>
                </div>

                <div class=" col-start-9 col-span-4">
                    <h1 class="text-3xl font-semibold text-gray-900 mb-2">{{ product.name }}</h1>

                    <div class="mb-6 text-2xl font-bold text-primary">${{ parseFloat(product.price).toFixed(2) }}</div>

                    <div v-if="product.material" class="mb-4">
                        <h3 class="font-semibold mb-1">Material:</h3>
                        <ul>
                            <li v-for="material in product.material">{{ material }}</li>
                        </ul>
                    </div>

                    <div v-if="product.categories.length" class="mb-4">
                        <h3 class="font-semibold mb-1">Categorías:</h3>
                        <ul class="flex space-x-2">
                            <li v-for="cat in product.categories" :key="cat" class="bg-gray-200 px-2 rounded">{{ cat }}
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-semibold mb-1">Descripción:</h3>
                        <p class="text-gray-600 mb-6 md:w-90 lg:120">{{ product.description }}</p>
                    </div>

                    <div class="flex items-center gap-4 mb-6 ">
                        <button class="btn btn-primary" @click="decrementQuantity">-</button>
                        <span>{{ quantity }}</span>
                        <button class="btn btn-primary" @click="incrementQuantity">+</button>
                    </div>

                    <button class="btn btn-primary" @click="setItemCart">Agregar al carrito</button>
                </div>
            </div>
        </div>
    </div>
</template>
