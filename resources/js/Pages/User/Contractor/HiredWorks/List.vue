<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import ContractorHiredWorkCard from '@/Components/Cards/ContractorHiredWorkCard.vue';
import InputSuccess from '@/Components/InputSuccess.vue';

defineProps({
    hiredWorks: {
        type: Array,
        default: [],
    },
    deleteStatus: {
        type: Boolean,
        defaul: false,
    },
});
</script>

<template>
    <AuthLayout :title="$t('words.hiredWorks')">
        <template #main>
            <div class="flex">
                <!-- Page Content -->
                <div class="w-full px-5">
                    <div class="font-bold text-lg">{{ $t('words.hiredWorks') }}</div>

                    <InputSuccess class="mt-1" :success="deleteStatus" :message="$t('messages.hiredWork.delete.success')"/>

                    <!-- Hired Works List -->
                    <template v-if="hiredWorks.length">
                        <div class="mt-5 p-5 border rounded w-full space-y-5">
                            <template v-for="hiredWork in hiredWorks">
                                <ContractorHiredWorkCard class="hover:bg-gray-300 border rounded-md" :hiredWork="hiredWork" />
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
