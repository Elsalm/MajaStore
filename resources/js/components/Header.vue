<template>
    <header class="px-4 ">
        <div class="flex flex-row py-6 justify-between **:hover:stroke-primary">
            <div>
                <h2 class="text-2xl font-bold! text-primary">MajaStore</h2>
            </div>
            <div class="flex flex-row gap-8">
                <button @click="toggleSearch">
                    <MagnifyingGlassIcon class="size-6 stroke-gray-800" />
                </button>
                <button>
                    <ShoppingCartIcon class="size-6 stroke-gray-800" />
                </button>
                <button @click="toggleMenu">
                    <Bars3Icon class="size-6 stroke-gray-800" v-show="!isMenuOpen" />
                    <XMarkIcon class="size-6 stroke-gray-800" v-show="isMenuOpen" />
                </button>
            </div>
        </div>
        <label for="search" class="flex rounded-lg gap-2 p-2 border border-primary-light/40" v-show="isSearchOpen">
            <MagnifyingGlassIcon class="size-6 stroke-primary-light/40" />
            <input type="text" id="search" placeholder="Buscar" class="outline-hidden text-lg">
        </label>
        <div v-show="isMenuOpen"
            class="border-t-1 border-primary-light/40 flex flex-col gap-4 py-4 mt-4 *:hover:text-primary">
            <a v-for="option in options" :href='option.dir' class="">{{ option.categories }}</a>
            <a href="auth/login" class="flex gap-2">
                <UserIcon class="size-6"></UserIcon> Usuario
            </a>
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
const toggleMenu = () => { isMenuOpen.value = !isMenuOpen.value }
const toggleSearch = () => { isSearchOpen.value = !isSearchOpen.value }
</script>
