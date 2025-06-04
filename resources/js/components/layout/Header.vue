<template>
    <header class="container">
        <div class="flex flex-row py-2 sm:pb-2  justify-between **:hover:stroke-primary flex-wrap ">
            <div class="sm:order-1">
                <h2 class="text-2xl font-bold! text-primary">MajaStore</h2>
            </div>


            <div class="flex flex-row gap-8 sm:order-3">
                <button @click="toggleSearch">
                    <MagnifyingGlassIcon class="size-6 stroke-gray-800" />
                </button>
                <button>
                    <ShoppingCartIcon class="size-6 stroke-gray-800" />
                </button>
                <button @click="toggleMenu" class="sm:hidden">
                    <Bars3Icon class="size-6 stroke-gray-800" v-show="!isMenuOpen" />
                    <XMarkIcon class="size-6 stroke-gray-800" v-show="isMenuOpen" />
                </button>

                <button class="hidden sm:block">
                    <UserIcon class="size-6"></UserIcon>
                </button>
            </div>

            <label for="search"
                class=" search flex rounded-lg gap-2 p-2 my-2 border sm:order-4 grow border-primary-light/40 hidden w-full">
                <MagnifyingGlassIcon class="size-6 stroke-primary-light/40" />
                <input type="text" id="search" placeholder="Buscar" class="outline-hidden text-lg">
            </label>
            <div
                class="menu border-t-1  border-primary-light/40  hidden flex grow flex-col sm:order-2 sm:flex sm:items-center sm:justify-center sm:flex-row   gap-6 py-4 mt-2 *:hover:text-primary sm:border-0 sm:py-0 sm:m-0 sm:gap-2">
                <a v-for="option in options" :href='option.dir' class="">{{ option.categories }}</a>
                <a href="auth/login" class="gap-2 object-cover flex items-center w-24 sm:hidden">
                    <UserIcon class="size-4"></UserIcon> Usuario
                </a>
            </div>
        </div>
    </header>
</template>

<script setup>

import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline'
import { ShoppingCartIcon } from '@heroicons/vue/24/outline'
import { Bars3Icon } from '@heroicons/vue/24/outline'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { UserIcon } from '@heroicons/vue/24/outline'
import { ref } from "vue"

const isMenuOpen = ref(false)
const isSearchOpen = ref(false)
const options = [
    { dir: "/categorias/sala/", categories: "Sala" },
    { dir: "/categorias/Cuarto/", categories: "Cuarto" },
    { dir: "/categorias/Comedor/", categories: "Comedor" },
    { dir: "/categorias/Oficina/", categories: "Oficina" },
    { dir: "/categorias/Almacenamiento/", categories: "Almacenamiento" },
]
const toggleMenu = () => { document.querySelector(".menu").classList.toggle("hidden") }
const toggleSearch = () => { document.querySelector(".search").classList.toggle("hidden") }
</script>
