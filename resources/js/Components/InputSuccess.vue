<script setup>
defineProps({
    success: Boolean,
    message: String,
});
</script>

<template>
    <div v-if="success && message">
        <p class="text-sm text-green-600">
            {{ message }}
        </p>
    </div>
</template>
