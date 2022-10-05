<script setup>
defineProps({
    value: String,
    required: {
        type: Boolean,
        default: false
    },
    optional: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <label class="block font-medium text-sm text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
        <span class="ml-1 text-red-400" v-if="required && !optional">*</span>
        <em class="ml-1 text-gray-500" v-if="optional && !required">(optional)</em>
    </label>
</template>
