<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="w-fit">
        <Link :href="route('landingpage')">
            <h1 class="font-bold text-3xl">
                GetWorkers
            </h1>
        </Link>
    </div>
</template>
