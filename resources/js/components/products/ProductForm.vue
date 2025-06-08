<script setup>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
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
    <form @submit.prevent="onSubmitProduct" autocomplete="on">
        <input type="text" name="name" v-model="form.name">
        <textarea name="description" id="description" v-model="form.description"></textarea>
        <select name="" id="" v-model="form.categories" multiple v-if="formData.categories">
            <option v-for="category in formData.categories" :value="category.id">{{ category.name }}</option>
        </select>
        <div v-if="formData.colors">
            <label v-for="colors in formData.colors" :for="colors.name">
                <input type="checkbox" :value="colors.id" :id="colors.name" v-model="form.colors" class="peer hidden">
                <div :class="[`size-6 rounded-xl border border-gray-400 peer-checked:border-black`]"
                    :style="{ backgroundColor: colors.hexa }">
                </div>
            </label>
        </div>
        <select name="" id="" v-model="form.materials" multiple v-if="formData.materials">
            <option v-for="materials in formData.materials" :value="materials.id">{{ materials.name }}</option>
        </select>

        <input type="number" v-model="form.quantity" min="1">
        <input type="number" v-model="form.quantity" step="0.01" min="1">
        <input type="file" multiple @change="onChangeFiles">

        <button class="btn-primary p-4 rounded-lg">añadir producto</button>
    </form>
</template>
