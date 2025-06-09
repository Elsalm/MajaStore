<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
            <div>
                <h2 class="mt-6 text-center text-3xl font-bold text-gray-900">
                    Iniciar sesión
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Or
                    <a href="/register" class="font-medium text-primary hover:text-primary-light">
                        Crear una cuenta
                    </a>
                </p>
            </div>
            <form class="mt-8 space-y-6" @submit.prevent="handleSubmit">
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Direccion de email
                        </label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            v-model="formData.email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" />
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Contraseña
                        </label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            v-model="formData.password"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" />
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" v-model="formData.remember"
                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" />
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            Recordar
                        </label>
                    </div>
                    <!--
                    <div class="text-sm">
                        <a href="#" class="font-medium text-primary hover:text-primary-light">
                            has olvidado tu contra
                        </a>
                    </div>

-->
                </div>
                <button type="submit" class="btn btn-primary w-full">Iniciar sesión</button>
            </form>
        </div>
    </div>

    <button class="btn btn-primary w-full" @click="handleLogOut">finalizar sesión</button>
</template>

<script setup>
import { reactive } from 'vue'
import axiost from 'axios'
const formData = reactive({
    email: '',
    password: '',
    remember: false,
})

const handleLogOut = () => {
    axios.post("/logout").then(response => console.log(response.data));
}



const handleSubmit = () => {
    axios.post("/login", formData).then(response => console.log(response.data));
}
</script>
