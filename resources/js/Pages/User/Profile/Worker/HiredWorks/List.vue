<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';
import WorkerHiredWorkCard from '@/Components/Cards/WorkerHiredWorkCard.vue';
import InputSuccess from '@/Components/InputSuccess.vue';

defineProps({
    hiredWorks: {
        type: Array,
        default: [],
    },
    deleteStatus: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <AuthLayout :title="$t('words.hiredWorks')">
        <template #main>
            <div class="flex flex-col sm:flex-row">
                <!-- Sidebard Menu -->
                <SidebarMenu class="sm:w-5/12 md:w-2/6 lg:w-3/12 w-full sm:m-0 mx-auto"/>

                <!-- Page Content -->
                <div class="sm:w-7/12 md:w-4/6 lg:w-9/12 w-full px-5 sm:mt-0 mt-2">
                    <div class="font-bold text-lg">{{ $t('words.hiredWorks') }}</div>

                    <InputSuccess class="mt-1" :success="deleteStatus" :message="$t('messages.hiredWork.delete.success')"/>

                    <!-- Hired Works List -->
                    <div class="mt-5 border rounded p-5">
                        <template v-if="hiredWorks.length">
                            <div class="mt-5 p-5 border rounded w-full space-y-5">
                                <template v-for="hiredWork in hiredWorks">
                                    <WorkerHiredWorkCard class="hover:bg-gray-300 border rounded-md" :hiredWork="hiredWork" />
                                </template>
                            </div>
                        </template>
                        <template v-else>
                            <div>
                                <span>{{ $t('words.noData') }}</span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
