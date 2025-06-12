<template>
    <main>
        <Introduction />
        <Categorias />
        <FeaturedProducts />
        <div class="container flex gap-6 flex-col md:flex-row py-10 ">
            <div class="w-full md:w-1/2 flex flex-col gap-4">
                <h2 class="text-2xl font-bold">Crea el Espacio de tus Sueños</h2>
                <p>
                    Nuestros muebles son diseñados teniendo en cuenta la belleza y funcionalidad de cada pieza. Cada uno
                    está construido con materiales de alta calidad para asegurar la longevidad y el confort.
                </p>
                <ul class="flex flex-col gap-4">
                    <li class="flex items-center gap-1">
                        <CheckIcon class="size-4 stroke-primary" />Materiales sostenibles
                    </li>
                    <li class="flex items-center gap-1">
                        <CheckIcon class="size-4 stroke-primary" />Maestros carpinteros con atención al detalle
                    </li>
                    <li class="flex items-center gap-1">
                        <CheckIcon class="size-4 stroke-primary" />5 años de garantía en todos nuestros productos
                    </li>
                    <li class="flex items-center gap-1">
                        <CheckIcon class="size-4 stroke-primary" />Consultas de diseño gratuitas
                    </li>
                </ul>

                <a href="/product" class="btn-primary btn text-center rounded-lg">Ver Nuestros productos</a>
            </div>
            <div class="w-full h-100 md:w-1/2 object-contain flex gap-4 justify-center group *:rounded-lg">
                <img src="@img/sala_moderna.png" alt=""
                    class="self-start w-1/2 sm:w-2/5 h-9/10 object-cover transition-all duration-300 ease-in-out rounded-lg group-hover:scale-90 hover:scale-110">
                <img src="@img/dormitorio_moderno.png" alt=""
                    class="self-end w-1/2 sm:w-2/5 h-9/10 object-cover transition-all duration-300 ease-in-out rounded-lg group-hover:scale-90 hover:scale-110">
            </div>
        </div>
    </main>
</template>
<script setup>
import Introduction from '@components/home/Introduction.vue'
import Categorias from '@components/home/Categorias.vue'
import FeaturedProducts from '@components/home/FeaturedProducts.vue'
import { CheckIcon } from "@heroicons/vue/24/solid"
</script>
