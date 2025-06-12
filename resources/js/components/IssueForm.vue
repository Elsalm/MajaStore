<template>
    <div class="container">
        <div>
            <h1 class="text-3xl">Reportar un problema</h1>
        </div>

        <div v-if="success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            Reporte enviado con éxito.
        </div>

        <form class="space-y-6" @submit.prevent="handleSubmit">
            <div class="space-y-4">
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripcion:</label>
                    <textarea name="description" v-model="form.description" id="message" rows="4"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none! focus:ring-primary focus:border-primary"></textarea>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipo:</label>
                    <select id="type" v-model="form.type"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none! focus:ring-primary focus:border-primary">
                        <option value="product">Product</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div v-if="form.type === 'product'">
                    <label for="product_id" class="block text-sm font-medium text-gray-700">ID Producto:</label>
                    <input type="text" id="product_id" v-model="form.product_id"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none! focus:ring-primary focus:border-primary" />
                </div>

                <div>
                    <button type="submit"
                        class="w-full py-2 px-4 bg-primary text-white! font-semibold rounded-md shadow-sm hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        Enviar
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios'

const success = ref(false)

const form = reactive({
    description: '',
    type: 'product',
    product_id: '',
})

const resetForm = () => {
    form.description = ''
    form.type = 'product'
    form.product_id = ''
}

const handleSubmit = () => {
    axios.post('/issues', form).then(() => {
        resetForm()
        success.value = true
        setTimeout(() => {
            success.value = false
        }, 15000)
    })
}
</script>
