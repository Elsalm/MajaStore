<template>
    <div class="bg-white p-4">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <SlidersIcon class="mr-2 text-gray-500" />
                <span class="font-medium">Filters</span>
            </div>
            <button @click="clearFilters" class="text-sm text-primary hover:text-primary-light">
                Clear all
            </button>
        </div>

        <FilterCategory name="Category" :options="categories" :selected-options="categoryFilters"
            @change="val => $emit('update:categoryFilters', val)" />
        <FilterCategory name="Material" :options="materials" :selected-options="materialFilters"
            @change="val => $emit('update:materialFilters', val)" />
        <FilterCategory name="Color" :options="colors" :selected-options="colorFilters"
            @change="val => $emit('update:colorFilters', val)" />
        <PriceRange :min="minPrice" :max="maxPrice" :current-min="priceRange.min" :current-max="priceRange.max"
            @change="(min, max) => $emit('update:priceRange', { min, max })" />
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'
import { SlidersIcon } from 'lucide-vue-next'
import FilterCategory from './FilterCategory.vue'

defineProps({
    filters: Object,
    categories: Array,
    materials: Array,
    colors: Array,
    minPrice: Number,
    maxPrice: Number
})

const emit = defineEmits([
    'update:categoryFilters',
    'update:materialFilters',
    'update:colorFilters',
    'update:priceRange'
])

function clearFilters() {
    emit('update:categoryFilters', [])
    emit('update:materialFilters', [])
    emit('update:colorFilters', [])
    emit('update:priceRange', { min: props.minPrice, max: props.maxPrice })
}
</script>
