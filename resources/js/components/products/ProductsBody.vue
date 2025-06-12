<template>
    <div class="bg-gray-50">
        <div class="container py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-semibold mb-2">Todos Nuestros Muebles</h1>
                <p class="text-gray-600">
                    Busca en nuestra coleccion de muebles de alta calidad para tu casa
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <aside class="lg:block w-full md:w-64 flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                        <FilterCategory :model="categoriesOptions" name="Categorias"
                            v-model="optionsSelected.categories" />
                        <FilterCategory :model="colorsOptions" name="Colors" v-model="optionsSelected.colors" />
                        <FilterCategory :model="materialsOptions" name="Materials"
                            v-model="optionsSelected.materials" />
                    </div>
                </aside>

                <section
                    class="grid gap-6 grid-cols-1 sm:grid-rows-2 sm:grid-cols-2 w-full lg:grid-cols-4 items-center">
                    <ProductCard v-for="product in productsData" :key="product.id" v-if="productsData.length > 0"
                        class="w-full" :name="product.name" :id="product.id" :price="product.price"
                        :image="product.image_url" :categories="product.categories" />
                    <p v-else class="text-gray-600 text-lg">Productos no encontrados</p>
                </section>
            </div>
        </div>

        <div class="w-full flex justify-center space-x-2 py-4">
            <button v-for="page in lastPage" :key="page" class="btn-secondary shadow-sm size-5"
                :class="{ 'bg-blue-500 text-white': currentPage === page }" @click="handlePaginate(page)"
                :disabled="currentPage === page">
                {{ page }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, watch, onMounted } from 'vue'
import axios from 'axios'
import FilterCategory from './FilterCategory.vue'
import ProductCard from './productCard.vue'

const props = defineProps({
    filtroId: {
        type: Number,
        default: null,
    },
})

const productsData = ref([])
const categoriesOptions = ref([])
const colorsOptions = ref([])
const materialsOptions = ref([])

const optionsSelected = reactive({
    categories: [],
    colors: [],
    materials: [],
})

const currentPage = ref(1)
const lastPage = ref(1)

if (props.filtroId) {
    optionsSelected.categories.push(props.filtroId)
}

const getModel = async (url, data = null) => {
    if (!data) {
        const res = await axios.get(`/${url}`)
        return res.data
    } else {
        const res = await axios.post(`/${url}`, data)
        return res.data
    }
}

const fetchProducts = async (page = 1) => {
    try {
        const queryParams = new URLSearchParams()
        queryParams.append('page', page)
        const data = await getModel(`products/all?page=${page}`, optionsSelected)

        productsData.value = data.products || []
        currentPage.value = data.pagination?.current_page || 1
        lastPage.value = data.pagination?.last_page || 1
    } catch (error) {
        console.error('Error al cargar productos:', error)
        productsData.value = []
    }
}

const handlePaginate = (page) => {
    if (page === currentPage.value) return
    fetchProducts(page)
    currentPage.value = page
}

watch(
    optionsSelected,
    () => {
        currentPage.value = 1
        fetchProducts(1)
    },
    { deep: true }
)

onMounted(async () => {
    await Promise.all([
        fetchProducts(1),
        getModel('categories').then((data) => categoriesOptions.value.push(...data.category || [])),
        getModel('colors').then((data) => colorsOptions.value.push(...data.colors || [])),
        getModel('materials').then((data) => materialsOptions.value.push(...data.materials || [])),
    ])
})
</script>
