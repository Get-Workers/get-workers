<script setup>
import AuthLayout from '../../../../Layouts/AuthLayout.vue';
import SidebarMenu from '../Partials/SidebarMenu.vue';

defineProps({
    specialties: {
        type: Array,
        required: true,
        default: []
    }
})
</script>

<template>
    <AuthLayout title="Specialties">
        <template #main>
            <div class="flex">
                <!-- Sidebard Menu -->
                <SidebarMenu class="flex flex-col h-fit w-64 md:w-96"/>

                <!-- Page Content -->
                <div class="ml-5 w-full">
                    asd
                </div>
            </div>

        </template>
    </AuthLayout>
</template>
