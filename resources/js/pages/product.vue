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
</script>

<template>
    <div class="bg-white">
        <div class="container py-8">
            <!-- Breadcrumbs simplificados -->
            <nav class="text-sm mb-8 text-gray-500">
                Home / Furniture / Sofas / <span class="font-medium text-gray-900">{{ product.name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Imágenes -->
                <div>
                    <div v-for="(img, i) in product.images" :key="i" class="mb-4 ">
                        <img :src="img" :alt="product.name" class="w-full object-cover rounded" />
                    </div>
                </div>

                <!-- Detalles -->
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 mb-2">{{ product.name }}</h1>

                    <!-- Precio -->
                    <div class="mb-6 text-2xl font-bold text-primary">${{ parseFloat(product.price).toFixed(2) }}</div>

                    <!-- Colores -->
                    <div v-if="product.color.length" class="mb-4">
                        <h3 class="font-semibold mb-1">Colores disponibles:</h3>
                        <ul class="flex space-x-2">
                            <label v-for="c in product.color" :key="c.id" class="flex items-center space-x-2">
                                <input type="checkbox" class="peer hidden" v-model="colors">
                                <span class="peer-checked:border-2 w-6 h-6 rounded-full border"
                                    :style="{ backgroundColor: c.hexa }" :title="c.name"></span>
                                <span>{{ c.name }}</span>
                            </label>
                        </ul>
                    </div>

                    <!-- Material -->
                    <div v-if="product.material" class="mb-4">
                        <h3 class="font-semibold mb-1">Material:</h3>
                        <ul>
                            <li v-for="material in product.material">{{ material }}</li>
                        </ul>
                    </div>

                    <!-- Categorías -->
                    <div v-if="product.categories.length" class="mb-4">
                        <h3 class="font-semibold mb-1">Categorías:</h3>
                        <ul class="flex space-x-2">
                            <li v-for="cat in product.categories" :key="cat" class="bg-gray-200 px-2 rounded">{{ cat }}
                            </li>
                        </ul>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <h3 class="font-semibold mb-1">Descripción:</h3>
                        <p class="text-gray-600 mb-6 whitespace-pre-line">{{ product.description }}</p>
                    </div>

                    <!-- Cantidad -->
                    <div class="flex items-center mb-6 space-x-4">
                        <button class="btn btn-primary" @click="decrementQuantity">-</button>
                        <span>{{ quantity }}</span>
                        <button class="btn btn-primary" @click="incrementQuantity">+</button>
                    </div>

                    <!-- Botón compra -->
                    <button class="btn btn-primary">Agregar al carrito</button>
                </div>
            </div>
        </div>
    </div>
</template>
