<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center justify-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase disabled:opacity-25 transition"
        :class="{ 'hover:bg-white hover:text-red-500 hover:border-red-500 active:bg-red-800 focus:outline-none focus:bg-red-800 focus:text-white focus:ring focus:ring-gray-300': ! disabled }"
        :disabled="disabled"
    >
        <slot />
    </button>
</template>
