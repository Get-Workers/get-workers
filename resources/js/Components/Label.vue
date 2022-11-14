<script setup>
import { Information } from 'mdue';

defineProps({
    value: String,
    required: {
        type: Boolean,
        default: false
    },
    optional: {
        type: Boolean,
        default: false
    },
    info: {
        type: String,
        required: false,
        default: '',
    },
});
</script>

<template>
    <label class="flex font-medium text-sm text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
        <span class="ml-1 text-indigo-500" v-if="info.length" :title="info"><Information /></span>
        <span class="ml-1 text-red-400" v-if="required && !optional">*</span>
        <em class="ml-1 text-gray-500" v-if="optional && !required">(optional)</em>
    </label>
</template>
