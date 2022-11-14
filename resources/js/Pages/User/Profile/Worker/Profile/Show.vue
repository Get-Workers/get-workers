<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';
import UpdateCnpjForm from './Partials/UpdateCnpjForm.vue';
</script>

<template>
    <AuthLayout :title="$t('words.workerProfile')">
        <template #main>
            <div class="flex flex-col sm:flex-row">
                <!-- Sidebard Menu -->
                <SidebarMenu class="sm:w-5/12 md:w-2/6 lg:w-3/12 w-full sm:m-0 mx-auto"/>

                <!-- Page Content -->
                <div class="sm:w-7/12 md:w-4/6 lg:w-9/12 w-full px-5 sm:mt-0 mt-2">
                    <div class="font-bold text-lg">{{ $t('words.workerProfile') }}</div>

                    <div class="mt-5">
                        <UpdateCnpjForm />
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
