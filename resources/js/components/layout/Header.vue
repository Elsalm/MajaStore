<template>
    <header class="bg-white container py-4">
        <div class="flex flex-wrap items-center justify-between">
            <a href="/">
                <h2 class="text-2xl font-bold text-primary sm:order-1">MajaStore</h2>
            </a>

            <nav class="hidden sm:flex items-center gap-6 sm:order-2">
                <a v-for="option in options" :key="option.categories" :href="option.dir"
                    class="text-gray-600 hover:text-primary transition-colors">
                    {{ option.categories }}
                </a>
            </nav>

            <div class="w-full! order-4 relative" v-show="isSearchOpen">
                <label for="search"
                    class="flex rounded-lg gap-2 p-2 my-2 border border-primary-light/40 w-full!  sm:w-auto">
                    <Search class="size-5 text-primary-light/40" />
                    <input type="text" id="search" v-model="search" placeholder="Buscar"
                        class="outline-none text-lg w-full" />
                </label>
                <div v-if="results.length > 0"
                    class="absolute right-0 w-full bg-white rounded-sm border border-primary-light/40 shadow-md p-2 z-50">
                    <a v-for="result in results" :href="`/product/${result.id}`"
                        class="grid grid-cols-20 grid-rows-2 w-full hover:bg-neutral-800/10">
                        <img :src="result.img" :alt="result.name" class="size-20 col-span-2 row-span-3">
                        <span class="col-span-18 col-start-3">{{ result.name }}</span>
                        <span>{{ result.price }}</span>
                    </a>
                </div>
            </div>

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

                <div class="relative" ref="userMenuRef">
                    <button @click="toggleUserMenu" class="p-2 text-gray-600 hover:text-primary">
                        <User class="size-5" />
                    </button>
                    <div v-if="isUserMenuOpen"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <div v-if="!me">
                            <a href="/login" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                @click="closeUserMenu">
                                <LogIn class="mr-2 size-4" />
                                Iniciar sesión
                            </a>
                            <a href="/register"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                @click="closeUserMenu">
                                <UserPlus class="mr-2 size-4" />
                                Crear Cuenta
                            </a>

                        </div>
                        <div v-else>
                            <a href="/panel"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <MonitorCog class="mr-2 size-4" />
                                Panel
                            </a>
                            <a href="/product/create"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <MonitorCog class="mr-2 size-4" />
                                Crear producto
                            </a>
                            <button class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                @click="handleLogOut">
                                <UserMinus class="mr-2 size-4" />
                                Cerrar sesión
                            </button>
                        </div>
                    </div>
                </div>

                <button @click="toggleMenu" class="sm:hidden p-2 text-gray-600 hover:text-primary">
                    <Menu class="size-5" v-if="!isMenuOpen" />
                    <X class="size-5" v-else />
                </button>
            </div>
        </div>

        <nav v-show="isMenuOpen"
            class="md:hidden mt-4 bg-white border-t border-primary-light/40 pt-4 flex flex-col gap-4">
            <a v-for="option in options" :key="option.categories" :href="option.dir"
                class="text-gray-600 hover:text-primary transition-colors py-2" @click="closeMenu">
                {{ option.categories }}
            </a>
            <div>
                <template v-if="me">
                    <a href="/panel" class="text-gray-600 hover:text-primary transition-colors py-2 flex items-center"
                        @click="closeMenu">
                        <User class="mr-2 size-5" />
                        Mi cuenta
                    </a>
                    <button class="text-gray-600 hover:text-primary transition-colors py-2 flex items-center"
                        @click="handleLogOutM">
                        <UserMinus class="mr-2 size-5" />
                        Logout
                    </button>
                </template>
                <template v-else>
                    <a href="/login" class="text-gray-600 hover:text-primary transition-colors py-2 flex items-center"
                        @click="closeMenu">
                        <User class="mr-2 size-5" />
                        Login
                    </a>
                </template>
            </div>
        </nav>
    </header>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import axios from "axios"
import {
    Search,
    ShoppingCart,
    Menu,
    X,
    User,
    LogIn,
    UserPlus,
    UserMinus, MonitorCog
} from 'lucide-vue-next'

const isMenuOpen = ref(false)
const isCartOpen = ref(false)
const isSearchOpen = ref(false)
const isUserMenuOpen = ref(false)
const userMenuRef = ref(null)
const cartArticles = ref([])
const me = ref(false);
const search = ref("");
const results = ref([]);
const options = [
    { dir: '/categories/sofas/', categories: 'Sofas' },
    { dir: '/categories/sillas/', categories: 'Sillas' },
    { dir: '/categories/mesas/', categories: 'Mesas' },
    { dir: '/categories/camas/', categories: 'Camas' },
    { dir: '/categories/almacenamiento/', categories: 'Almacenamiento' },
]

const toggleMenu = () => (isMenuOpen.value = !isMenuOpen.value)
const redirectCart = () => (location.href = "/cart");
const closeMenu = () => (isMenuOpen.value = false)
const toggleSearch = () => (isSearchOpen.value = !isSearchOpen.value)
const toggleUserMenu = () => { isUserMenuOpen.value = !isUserMenuOpen.value; }
const closeUserMenu = () => (isUserMenuOpen.value = false)

const handleClickOutside = (e) => {
    if (userMenuRef.value && !userMenuRef.value.contains(e.target)) {
        isUserMenuOpen.value = false
    }
}
window.addEventListener('cartUpdated', () => {
    axios.get(`/cart/get`).then(response => { cartArticles.value = response.data.cart })
});
onMounted(() => {
    document.addEventListener('mousedown', handleClickOutside);
    axios.get(`/cart/get`).then(response => { cartArticles.value = response.data.cart })
    getMe().then(data => me.value = data);
})
const handleLogOutM = () => {
    axios.post("/logout").then(res => { me.value = false })
    isMenuOpen.value = false
}

const handleLogOut = () => {
    axios.post("/logout").then(res => { me.value = false })
    isUserMenuOpen.value = !isUserMenuOpen.value
}
const getMe = async () => {
    const data = await axios.get("/me").then(response => response.data);
    return data
}
const handleSearch = (data) => {
    return axios.post("/find/product", { "search": data }).then(response => response.data.results);
}
watch(search, (val) => {
    handleSearch(val).then(data => results.value = data);
});
onBeforeUnmount(() => document.removeEventListener('mousedown', handleClickOutside))
</script>
