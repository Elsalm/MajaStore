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
                v-for="(product, index) in topProducts" :key="product + index">
                <img src="https://placehold.co/600x400" alt="">
                <div class="pl-4 pb-4 flex flex-col gap-2">
                    <a href="" class="text-sm text-gray-500/80">{{ product.category }}</a>
                    <h4 class="text-lg! font-semibold!">{{ product.name }}</h4>
                    <div class="flex">
                        <StarSolidIcon class="fill-yellow-500 size-5" v-for="i in Math.ceil(product.rate)" :key="i">
                        </StarSolidIcon>
                        <p>({{ product.rate }})</p>
                    </div>
                    <h4 class="text-base! font-semibold! text-primary">&euro;{{ product.price }}</h4>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import ArrowIcon from "@svg/arrow.vue"
import { StarIcon as StarSolidIcon } from "@heroicons/vue/24/solid"
import { StarIcon } from "@heroicons/vue/24/outline"
import { HeartIcon } from "@heroicons/vue/24/outline"
const topProducts = [{ category: "sofas", name: "titulo1", rate: 4.8, price: 123456 }, { category: "sofas", name: "titulo1", rate: 4.8, price: 123456 }, { category: "sofas", name: "titulo1", rate: 4.8, price: 123456 }, { category: "sofas", name: "titulo1", rate: 4.8, price: 123456 }]
</script>
