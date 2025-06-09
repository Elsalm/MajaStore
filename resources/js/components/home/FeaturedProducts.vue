<template>
    <div class="container bg-primary-lighter py-10 flex flex-col gap-4">
        <div class="flex flex-row items-center justify-between ">
            <h3 class="text-2xl font-bold! flex pr-4 ">Productos Destacados</h3>
            <a href="" class="text-lg! flex flex-row items-center text-primary">Ver Todo
                <ArrowIcon class="size-5" />
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <ProductCard v-for="data in productsData" :key="data.id" v-if="productsData.length > 0" :name="data.name"
                :id="data.id" :price="data.price" :image="data.image_url" :categories="data.categories" />
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import ProductCard from "../products/productCard.vue"
import ArrowIcon from "@svg/arrow.vue"
import { StarIcon as StarSolidIcon } from "@heroicons/vue/24/solid"
import { StarIcon } from "@heroicons/vue/24/outline"
import { HeartIcon } from "@heroicons/vue/24/outline"
const productsData = ref([]);
const getFeaturedProducts = async () => {
    const data = await axios.get("/featured/products").then(response => response.data)
    productsData.value.push(...data.products);
    console.log(productsData.value);
}
onMounted(() => {
    getFeaturedProducts();
})
</script>
