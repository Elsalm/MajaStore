<template>
    <a-config-provider :theme="{ token: { colorPrimary: '#2D5F5D' } }">
        <a-space direction="vertical" style="width: 100%" class="shadow-md focus:outline-none!">
            <a-select v-model:value="value" mode="multiple" style="width: 100%" :placeholder="placeholder"
                option-label-prop="children" size="large" class="focus:outline-none!">
                <a-select-option v-for="option in options" :key="option.id" :value="option.name" :label="option.id">
                    {{ option.name }}
                </a-select-option>
            </a-select>
        </a-space>
    </a-config-provider>
</template>

<script lang="ts" setup>
import { ref, watch } from 'vue';
const props = defineProps({
    options: Array,
    placeholder: String,
});



const value = defineModel("value");

</script>
