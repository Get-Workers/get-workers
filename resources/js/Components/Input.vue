<script setup>
import { onMounted, ref } from 'vue';
import { maska as vMaska } from 'maska';

defineProps({
    modelValue: String,
    disabled: {
        type: Boolean,
        default: false
    },
    mask: [Object, Array, String],
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :class="{ 'bg-gray-200': disabled }"
        :disabled="disabled"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        v-maska="mask"
    >
</template>
