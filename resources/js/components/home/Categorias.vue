<template>
    <div class="container my-8 flex flex-col items-center gap-6 ">
        <h3 class="text-2xl font-bold! text-center">Busca por Categorias</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 w-full">
            <div class="relative">
                <img src="@img/Sala.jpg" alt="" class="h-60 w-full object-cover rounded-lg shadow-md">
                <a href="" class="text-lg! font-semibold absolute left-2 bottom-10 text-white drop-shadow">
                    Sala
                </a>
                <a href="/product" class="text-sm! text-gray-100 flex items-center absolute left-2 bottom-4">
                    Comprar Ahora
                    <ArrowIcon class="size-4 ml-1" />
                </a>
            </div>

            <div class="relative">
                <img src="@img/Dormitorio.jpg" alt="" class="h-60 w-full object-cover rounded-lg shadow-md">
                <a href="" class="text-lg! font-semibold absolute left-2 bottom-10 text-white drop-shadow">
                    Dormitorio
                </a>
                <a href="/product" class="text-sm! text-gray-100 flex items-center absolute left-2 bottom-4">
                    Comprar Ahora
                    <ArrowIcon class="size-4 ml-1" />
                </a>
            </div>

            <div class="relative">
                <img src="@img/Comedor.jpg" alt="" class="h-60 w-full object-cover rounded-lg shadow-md">
                <a href="" class="text-lg! font-semibold absolute left-2 bottom-10 text-white drop-shadow">
                    Comedor
                </a>
                <a href="/product" class="text-sm! text-gray-100 flex items-center absolute left-2 bottom-4">
                    Comprar Ahora
                    <ArrowIcon class="size-4 ml-1" />
                </a>
            </div>

            <div class="relative">
                <img src="@img/Oficina.jpg" alt="" class="h-60 w-full object-cover rounded-lg shadow-md">
                <a href="" class="text-lg! font-semibold absolute left-2 bottom-10 text-white drop-shadow">
                    Oficina
                </a>
                <a href="/product" class="text-sm! text-gray-100 flex items-center absolute left-2 bottom-4">
                    Comprar Ahora
                    <ArrowIcon class="size-4 ml-1" />
                </a>
            </div>

        </div>
    </div>
</template>
<script setup>
import ArrowIcon from "@svg/arrow.vue"
</script>
