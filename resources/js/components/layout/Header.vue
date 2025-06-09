<template>
    <header class="bg-white shadow-sm container py-4">
        <div class="flex flex-wrap items-center justify-between">
            <!-- Logo -->
            <a href="/">
                <h2 class="text-2xl font-bold text-primary sm:order-1">MajaStore</h2>
            </a>

            <!-- Desktop nav -->
            <nav class="hidden sm:flex items-center gap-6 sm:order-2">
                <a v-for="option in options" :key="option.categories" :href="option.dir"
                    class="text-gray-600 hover:text-primary transition-colors">
                    {{ option.categories }}
                </a>
            </nav>

            <!-- Search bar -->
            <label v-show="isSearchOpen" for="search"
                class="flex rounded-lg gap-2 p-2 my-2 border border-primary-light/40 w-full! order-4 sm:w-auto">
                <Search class="size-5 text-primary-light/40" />
                <input type="text" id="search" placeholder="Buscar" class="outline-none text-lg w-full" />
            </label>

            <!-- Icons -->
            <div class="flex items-center gap-4 sm:order-3">
                <button @click="toggleSearch" class="p-2 text-gray-600 hover:text-primary transition-colors">
                    <Search class="size-5" />
                </button>
                <button class="p-2 text-gray-600 hover:text-primary relative" @click="redirectCart">
                    <ShoppingCart class="size-5" />
                    <span v-if="cartArticles.length > 0"
                        class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        {{ cartArticles.length }}
                    </span>
                </button>

                <!-- User Menu -->
                <div class="relative" ref="userMenuRef">
                    <button @click="toggleUserMenu" class="p-2 text-gray-600 hover:text-primary">
                        <User class="size-5" />
                    </button>
                    <div v-if="isUserMenuOpen"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="/login" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            @click="closeUserMenu">
                            <LogIn class="mr-2 size-4" />
                            Iniciar sesión
                        </a>
                        <a href="/register" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            @click="closeUserMenu">
                            <UserPlus class="mr-2 size-4" />
                            Crear Cuenta
                        </a>
                    </div>
                </div>

                <!-- Mobile menu toggle -->
                <button @click="toggleMenu" class="sm:hidden p-2 text-gray-600 hover:text-primary">
                    <Menu class="size-5" v-if="!isMenuOpen" />
                    <X class="size-5" v-else />
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <nav v-show="isMenuOpen"
            class="md:hidden mt-4 bg-white border-t border-primary-light/40 pt-4 flex flex-col gap-4">
            <a v-for="option in options" :key="option.categories" :href="option.dir"
                class="text-gray-600 hover:text-primary transition-colors py-2" @click="closeMenu">
                {{ option.categories }}
            </a>
            <a href="/account" class="text-gray-600 hover:text-primary transition-colors py-2 flex items-center"
                @click="closeMenu">
                <User class="mr-2 size-5" />
                Mi cuenta
            </a>
        </nav>
    </header>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import {
    Search,
    ShoppingCart,
    Menu,
    X,
    User,
    LogIn,
    UserPlus,
} from 'lucide-vue-next'

const isMenuOpen = ref(false)
const isCartOpen = ref(false)
const isSearchOpen = ref(false)
const isUserMenuOpen = ref(false)
const userMenuRef = ref(null)
const cartArticles = ref([])
const options = [
    { dir: '/categorias/sala/', categories: 'Sala' },
    { dir: '/categorias/cuarto/', categories: 'Cuarto' },
    { dir: '/categorias/comedor/', categories: 'Comedor' },
    { dir: '/categorias/oficina/', categories: 'Oficina' },
    { dir: '/categorias/almacenamiento/', categories: 'Almacenamiento' },
]

const toggleMenu = () => (isMenuOpen.value = !isMenuOpen.value)
const redirectCart = () => (location.href = "/cart");
const closeMenu = () => (isMenuOpen.value = false)
const toggleSearch = () => (isSearchOpen.value = !isSearchOpen.value)
const toggleUserMenu = () => (isUserMenuOpen.value = !isUserMenuOpen.value)
const closeUserMenu = () => (isUserMenuOpen.value = false)

const handleClickOutside = (e) => {
    if (userMenuRef.value && !userMenuRef.value.contains(e.target)) {
        isUserMenuOpen.value = false
    }
}
onMounted(() => document.addEventListener('mousedown', handleClickOutside))
onBeforeUnmount(() => document.removeEventListener('mousedown', handleClickOutside))
</script>
