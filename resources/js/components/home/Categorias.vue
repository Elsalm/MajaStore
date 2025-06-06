<template>
    <div class="container my-8 flex flex-col items-center gap-6 ">
        <h3 class="text-2xl font-bold! text-center">Busca por Categorias</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div v-for="category in categories" class="relative" :key="category.name">
                <img :src="category.url" alt="" class="h-60 w-full object-cover rounded-lg shadow-md">
                <a href="" class="text-lg! font-semibold absolute left-2 bottom-10 text-white drop-shadow">
                    {{ category.name }}
                </a>
                <a href="" class="text-sm! text-gray-100 flex items-center absolute left-2 bottom-4">
                    Comprar Ahora
                    <ArrowIcon class="size-4 ml-1" />
                </a>
            </div>
        </div>
    </div>
</template>
<script setup>
import ArrowIcon from "@svg/arrow.vue"
const categories = [{ name: "Sala", url: "https://placehold.co/600x400" }, { name: "Cuarto", url: "https://placehold.co/600x400" },
{ name: "Comedor", url: "https://placehold.co/600x400" }, { name: "Oficina", url: "https://placehold.co/600x400" }]
</script>
