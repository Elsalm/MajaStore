<template>
    <div class="bg-gray-50 min-h-screen">
        <div class="container py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-semibold mb-2">Todos Nuestros Muebles</h1>
                <p class="text-gray-600">
                    Busca en nuestra coleccion de muebles de alta calidad para tu casa
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <div class="hidden lg:block w-64 flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                        <FilterCategory :model="categoriesOptions" name="Categorias"
                            v-model="optionsSelected.categories" />
                        <FilterCategory :model="colorsOptions" name="Colors" v-model="optionsSelected.colors" />
                        <FilterCategory :model="materialsOptions" name="Materials"
                            v-model="optionsSelected.materials" />
                    </div>
                </div>
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    <ProductCard v-for="product in productsData" :key="product.id" v-if="productsData.length > 0"
                        :name="product.name" :id="product.id" :price="product.price" :image="product.image_url"
                        :categories="product.categories" />
                    <p v-else class="text-gray-600 text-lg">
                        Productos no encontrados
                    </p>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue'
import FilterCategory from './FilterCategory.vue';
import ProductCard from './productCard.vue'
import axios from 'axios'

const isFilterOpen = ref(false)
const productsData = ref([]);

const categoriesOptions = ref([]);
const colorsOptions = ref([]);
const materialsOptions = ref([]);

const optionsSelected = reactive({
    materials: [],
    colors: [],
    categories: []
})

const toggleFilterSidebar = () => {
    isFilterOpen.value = !isFilterOpen.value
}

const getModel = async (url, data = null) => {
    let response;
    if (!data) {
        response = await axios.get(`/${url}`);
    } else {
        response = await axios.post(`/${url}`, data);
    }
    return response.data;
}

watch(optionsSelected, async (newVal) => {
    productsData.value = [];
    await getModel(`products/all?page=1`, newVal).then(data => { productsData.value.push(...data.products.data) }).catch((error) => { console.log(error.response.products) });
}, { deep: true });

onMounted(() => {
    getModel(`products/all?page=${1}`).then(data => { productsData.value.push(...data.products.data); }).catch((error) => { console.log(error.response.products) });
    getModel(`categories`).then(data => categoriesOptions.value.push(...data.category));
    getModel(`colors`).then(data => colorsOptions.value.push(...data.colors));
    getModel(`materials`).then(data => materialsOptions.value.push(...data.materials));
})
</script>
