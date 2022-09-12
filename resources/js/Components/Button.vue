<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-white hover:text-blue-500 hover:border-blue-500 active:bg-blue-800 focus:outline-none focus:bg-blue-800 focus:text-white focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
        <slot />
    </button>
</template>
