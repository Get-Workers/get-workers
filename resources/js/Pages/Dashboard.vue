<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import WorkCard from '@/Components/Cards/WorkCard.vue';

defineProps({ works: Object });
</script>

<template>
    <AuthLayout :title="$t('phrases.mostHiredWorks')">
        <template #main>
            <div class="flex px-5">
                <div class="w-full min-h-full">
                    <h1 class="font-bold text-lg">{{ $t('phrases.mostHiredWorks') }}</h1>

                    <div class="mt-5 sm:border rounded md:p-5">
                        <template v-if="works.data.length">
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-5 lg:gap-7 w-fit mx-auto">
                                <template v-for="work in works.data" :key="`card-list-${work.uuid}`">
                                    <WorkCard :work="work"/>
                                </template>
                            </div>

                            <Pagination class="mt-5" :links="works.links" />
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
