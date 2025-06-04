<script setup>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
const form = reactive({
    name: "",
    description: "",
    quantity: 0,
    images: [],
    categories: [],
})
const onChangeFiles = (event) => {
    const size = Array.from(event.target.files).reduce((c, i) => c + i.size, 0);
    if (size <= 157286400) {
        form.images.push(...event.target.files)
    } else {
        window.alert("se ha superado el limite");
    }
}
const categoryNames = [{ name: "Cuarto", id: 1 }, { name: "Comedor", id: 2 }];

const url = "/products";
const onSubmitProduct = () => {
    axios.post(url, form, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(response => response.data).catch(error => console.log(error,

        console.log(form.categories)
    ));
}
</script>
<template>
    <form @submit.prevent="onSubmitProduct" autocomplete="on">
        <input type="text" name="name" v-model="form.name">
        <textarea name="description" id="description" v-model="form.description"></textarea>
        <select name="" id="" v-model="form.categories" multiple>
            <option v-for="category in categoryNames" :value="category.id">{{ category.name }}</option>
        </select>
        <input type="number" v-model="form.quantity" min="1">
        <input type="file" multiple @change="onChangeFiles">

        <input type="submit" value="hoal">
    </form>
</template>
