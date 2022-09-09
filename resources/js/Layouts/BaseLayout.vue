<script setup>
import { Head } from '@inertiajs/inertia-vue3';

defineProps({
    title: String,
});
</script>

<template>
    <div class="min-h-screen">
        <Head :title="title" />

        <!-- Header -->
        <slot name="header" />

        <!-- Main -->
        <slot name="main" />

        <!-- Footer -->
        <slot name="footer" />
    </div>

</template>
