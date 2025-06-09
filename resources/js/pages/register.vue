<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
            <div>
                <h2 class="mt-6 text-center text-3xl font-bold text-gray-900">
                    Registrarse
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Ya tienes una cuenta?
                    <a href="/login" class="font-medium text-primary hover:text-primary-light">
                        Iniciar sesión
                    </a>
                </p>
            </div>
            <form class="mt-8 space-y-6" @submit.prevent="handleSubmit">
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nombre Completo
                        </label>
                        <input id="name" name="name" type="text" autocomplete="name" required v-model="formData.name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            v-model="formData.email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Contraseña
                        </label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            v-model="formData.password"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Repetir Contraseña
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            autocomplete="new-password" required v-model="formData.password_confirmation"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" />
                    </div>
                </div>
                <button class="btn btn-primary w-full" type="submit">Crear Cuenta</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import axios from 'axios'
const formData = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const handleSubmit = () => {
    axios.post("/user", formData).then(response => console.log(response.data));
}

</script>
