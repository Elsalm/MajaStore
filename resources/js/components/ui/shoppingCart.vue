<template>

</template>
<script setup>
import { ref } from "vue";
const cartOpen = ref(false);
cartIsOpen(){
    cartOpen = !cartOpen;
}
</script>
