<template>
    <div class="border-b border-gray-200 py-4">
        <button class="w-full flex items-center justify-between text-left font-medium" @click="isOpen = !isOpen">
            {{ props.name }}
            <ChevronDownIcon :class="['transform transition-transform', { 'rotate-180': isOpen }]" size="18" />
        </button>
        <div v-if="isOpen" class="mt-2 space-y-1">
            <label v-for="option in props.model" :key="option.id" class="flex items-center cursor-pointer">
                <input type="checkbox"
                    class="form-checkbox h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary"
                    :value="option.id" v-model="selected" />
                <span class="ml-2 text-sm text-gray-700">{{ option.name }}</span>
            </label>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { ChevronDownIcon } from 'lucide-vue-next'

const props = defineProps({
    model: Array,
    name: String,
})


const isOpen = ref(true)

const emit = defineEmits(['update:modelValue']);
const selected = ref([]);

watch(selected, (val) => {
    emit('update:modelValue', val);
});

function toggleOption(id) {
    const isSelected = props.selectedOptions.includes(id)
    const updated = isSelected
        ? props.selectedOptions.filter(item => item !== id)
        : [...props.selectedOptions, id]
    emit('change', updated)
}
</script>
