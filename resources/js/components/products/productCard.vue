<template>
    <div class="product-card group bg-white rounded-lg overflow-hidden border border-gray-100 ">
        <div class="relative">
            <a :href="`/product/${id}`" class="block overflow-hidden">
                <img :src="props.image" :alt="props.name"
                    class="w-full h-64 object-cover transform transition-transform duration-500 group-hover:scale-105" />
            </a>
        </div>
        <div class="p-4">
            <!-- Categories -->
            <div v-if="categories && categories.length > 0" class="flex flex-wrap gap-1 mb-2">
                <span v-for="category in categories.slice(0, 2)" :key="category"
                    class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                    {{ category }}
                </span>
                <span v-if="categories.length > 2" class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                    +{{ categories.length - 2 }}
                </span>
            </div>
            <a :href="`/products/${id}`">
                <h3 class="text-lg font-medium text-gray-800 hover:text-primary transition-colors mb-1">
                    {{ name }}
                </h3>
            </a>
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center">
                    <span class="text-lg font-semibold text-primary">
                        €{{ formatPrice(price) }}
                    </span>
                    <!--
                    <span v-if="originalPrice && originalPrice > price" class="text-sm text-gray-400 line-through ml-2">
                        €{{ formatPrice(originalPrice) }}
                    </span>
-->
                </div>
            </div>
        </div>
    </div>

</template>
<script setup>
const props = defineProps({
    id: {
        type: [String, Number],
        required: true
    },
    name: {
        type: String,
        required: true
    },
    price: {
        type: [String, Number],
        required: true
    },
    material: {
        type: String,
        default: null
    },
    image: {
        type: String,
        default: null
    },
    categories: {
        type: Array,
        default: () => []
    },
});

const formatPrice = (price) => {
    return Number(price).toFixed(2)
}
</script>
