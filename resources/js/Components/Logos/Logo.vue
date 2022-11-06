<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="w-fit">
        <Link :href="route('landingpage')">
            <div class="flex items-center">
                <object data="/logo.svg" class="w-14 h-14" ></object>
                <h1 class="font-bold text-3xl sm:block hidden">
                    GetWorkers
                </h1>
            </div>
        </Link>
    </div>
</template>
