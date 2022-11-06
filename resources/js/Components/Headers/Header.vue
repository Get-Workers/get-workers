<script setup>
import Logo from '@/Components/Logos/Logo.vue';
</script>

<template>
    <header class="fixed inset-0 h-16 bg-gray-200 border-b border-solid border-gray-300">
        <div class="relative flex h-16 w-full">
            <!-- Logo -->
            <Logo class="items-center ml-6 my-auto"/>

            <!-- Links -->
            <div class="w-fit h-full my-auto sm:ml-20 md:mr-auto mx-auto">
                <slot name="links" />
            </div>

            <div class="mr-6 my-auto md:ml-auto">
                <slot name="profile" />
            </div>
        </div>
    </header>
</template>
