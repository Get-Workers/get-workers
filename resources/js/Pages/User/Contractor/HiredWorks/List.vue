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
                    <div class="mt-5 border rounded p-5">
                        <template v-if="hiredWorks.length">
                            <div class="space-y-5">
                                <template v-for="hiredWork in hiredWorks">
                                    <ContractorHiredWorkCard class="hover:bg-gray-300 border rounded-md" :hiredWork="hiredWork" />
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
