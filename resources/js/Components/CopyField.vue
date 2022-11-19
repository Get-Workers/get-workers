<script setup>
import { computed } from '@vue/reactivity';
import { ContentCopy } from 'mdue';
import { ref } from 'vue';

defineProps({
    modelValue: String,
    disabled: {
        type: Boolean,
        default: false
    },
    width: {
        type: String,
        default: '',
    },
});

defineEmits(['update:modelValue']);

const isSecureContext = computed(() => window.isSecureContext);

const input = ref(null);

function copy() {
    let field = input.value;

    field.focus();
    field.select();

    if (! isSecureContext.value || (field.value.length === 0)) return;

    navigator.clipboard.writeText(String(field.value));
}
</script>

<template>
    <div class="flex items-center">
        <input
            ref="input"
            type="text"
            class="w-full h-full text-center text-sm px-2 py-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            :class="{ 'bg-gray-200': disabled }"
            :style="width"
            :disabled="disabled"
            :value="modelValue"
            readonly
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <ContentCopy class="text-lg ml-2 hover:cursor-pointer" @click="copy"/>
    </div>

</template>
