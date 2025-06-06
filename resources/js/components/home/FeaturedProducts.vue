<template>
    <div class="container bg-primary-lighter py-10 flex flex-col gap-4">
        <div class="flex flex-row items-center justify-between ">
            <h3 class="text-2xl font-bold! flex pr-4 ">Productos Destacados</h3>
            <a href="" class="text-lg! flex flex-row items-center text-primary">Ver Todo
                <ArrowIcon class="size-5" />
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-neutral-50 rounded-lg shadow-lg overflow-hidden flex flex-col gap-2 pb-2 "
                v-for="(model, index) in topProducts" :key="model.product.name + index">
                <img :src="model.media" :alt="model.product.description" class="size-80 object-cover">
                <div class="pl-4 pb-4 flex flex-col gap-2">
                    <a href="" class="text-sm text-gray-500/80">{{model.product.categories.map(category =>
                        category.name).join(",")}}</a>
                    <h4 class="text-lg! font-semibold!">{{ model.product.name }}</h4>
                    <div class="flex">
                        <!--
                        <StarSolidIcon class="fill-yellow-500 size-5" v-for="i in Math.ceil(product.rate)" :key="i">
                        </StarSolidIcon>
                        <p>({{ product.rate }})</p>
-->
                    </div>
                    <h4 class="text-base! font-semibold! text-primary">&euro;{{ model.product.price }}</h4>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import ArrowIcon from "@svg/arrow.vue"
import { StarIcon as StarSolidIcon } from "@heroicons/vue/24/solid"
import { StarIcon } from "@heroicons/vue/24/outline"
import { HeartIcon } from "@heroicons/vue/24/outline"
const topProducts = ref([]);
const getFeaturedProducts = async () => {
    const data = await axios.get("/featured/products").then(response => response.data)
    topProducts.value.push(...data);
}
onMounted(() => {
    getFeaturedProducts();
})
</script>
