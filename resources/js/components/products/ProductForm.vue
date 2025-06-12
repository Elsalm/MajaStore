<script setup>
import { ref, reactive, onMounted, watch } from "vue";
import axios from "axios";
import UploadFile from "../ui/UploadFIle.vue"
import addLabel from "../ui/addLabel.vue"
const form = reactive({
    name: "",
    description: "",
    quantity: 1,
    price: 1.00,
    images: [],
    categories: [],
    materials: [],
    colors: [],
})

const formData = reactive({
    categories: [],
    materials: [],
    colors: [],
})
const resetForm = () => {
    form.name = ""
    form.description = ""
    form.quantity = 1
    form.price = 1.00
    form.images = []
    form.categories = []
    form.materials = []
    form.colors = []
}


const onChangeFiles = (event) => {
    const size = Array.from(event.target.files).reduce((c, i) => c + i.size, 0);
    if (size <= 157286400) {
        form.images.push(...event.target.files)
    } else {
        window.alert("se ha superado el limite");
    }
}


const onSubmitProduct = () => {
    axios.post("/product", form, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(() => { resetForm() })
}

const getModel = async (url) => {
    const data = await axios.get(`/${url}`).then(response => response.data);
    return data;
};

onMounted(async () => {
    formData.categories = await getModel("categories").then(data => data.category);
    formData.colors = await getModel("colors").then(data => data.colors);
    formData.materials = await getModel("materials").then(data => data.materials);
});
</script>
<template>

    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
            <div>
                <h2 class="mt-6 text-center text-3xl font-bold text-gray-900">
                    Crear Producto
                </h2>
            </div>
            <form class="mt-8 space-y-6" @submit.prevent="handleSubmit">

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nombre de el Producto:
                        </label>

                        <input type="text" name="name" v-model="form.name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none! focus:ring-primary focus:border-primary">

                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Descripcion:
                        </label>

                        <textarea name="description" v-model="form.description" id="message" rows="4"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none! focus:ring-primary focus:border-primary"></textarea>

                    </div>

                    <div class=" flex gap-2">
                        Colores disponibles:
                        <label v-for="colors in formData.colors" :for="colors.name" class="block">
                            <input type="checkbox" :value="colors.id" :id="colors.name" v-model="form.colors"
                                class="peer hidden">
                            <div :class="[`size-6 rounded-xl border border-gray-400 peer-checked:border-black`]"
                                :style="{ backgroundColor: colors.hexa }">
                            </div>
                        </label>
                    </div>
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">
                            Cantidad Disponible:
                        </label>

                        <input type="number" name="quantity" v-model="form.quantity" step="0.01" min="1"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="precio" class="block text-sm font-medium text-gray-700">
                            Precio:
                        </label>

                        <input type="number" name="precio" v-model="form.price" step="0.01" min="1"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <UploadFile v-model="form.images" />
                    </div>
                    <div v-if="formData.categories.length > 0">

                        <label for="categories" class="block text-sm font-medium text-gray-700">
                            Categorias:
                        </label>
                        <addLabel :options="formData.categories" v-model:value="form.categories" name="categories"
                            placeholder="Seleccionar categorias" />
                    </div>

                    <div v-if="formData.materials.length > 0">

                        <label for="materials" class="block text-sm font-medium text-gray-700">
                            Materiales:
                        </label>

                        <addLabel :options="formData.materials" v-model:value="form.materials" name="materials"
                            placeholder="Seleccionar Materiales" />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-full" @click="onSubmitProduct">Crear Producto</button>
            </form>
        </div>
    </div>
</template>
