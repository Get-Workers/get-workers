<script setup>
import { useCurrencyInput } from 'vue-currency-input';

const props = defineProps({
    modelValue: Number,
    options: Object,
    disabled: {
        type: Boolean,
        default: false
    }
});

defineEmits(['update:modelValue']);

const { inputRef, numberValue } = useCurrencyInput(props.options, false);
</script>

<template>
    <input
        ref="inputRef"
        type="text"
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :class="{ 'bg-gray-200': disabled }"
        :disabled="disabled"
        :value="modelValue"
        @input="$emit('update:modelValue', numberValue)"
    >
</template>
