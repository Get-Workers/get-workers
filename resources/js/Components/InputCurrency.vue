<script setup>
import { onUpdated } from 'vue';
import { useCurrencyInput } from 'vue-currency-input';

const props = defineProps({
    modelValue: Number,
    options: {
        type: Object,
        default: {
            currency: 'BRL',
            valueRange: {
                min: 0,
                max: 10000000
            },
            autoDecimalDigits: true,
            precision: 2
        }
    },
    disabled: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:modelValue', 'change']);

const { inputRef, numberValue, setValue } = useCurrencyInput(props.options, false);

function updateModelValue() {
    emit('update:modelValue', numberValue);
}

onUpdated(() => {
    setValue(props.modelValue);
});
</script>

<template>
    <input
        ref="inputRef"
        type="text"
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :class="{ 'bg-gray-200': disabled }"
        :disabled="disabled"
        @input="updateModelValue"
    >
</template>
