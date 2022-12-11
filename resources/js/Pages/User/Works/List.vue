<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import WorkCard from '@/Components/Cards/WorkCard.vue';
import FormFilterWorks from '@/Components/Forms/FormFilterWorks.vue';

defineProps({
    works: Object,
    search: String,
    stars: Number,
    selectedSpecialties: {
        type: Array,
        default: []
    },
    specialties: {
        type: Array,
        required: true,
        default: []
    },
    city: Object,
    cityId: Number,
});
</script>

<template>
    <AuthLayout title="Works">
        <template #main>
            <div class="flex">
                <!-- Page Content -->
                <div class="w-full px-5">
                    <h1 class="font-bold text-lg">{{ $t('words.works') }}</h1>

                    <!-- Filters -->
                    <FormFilterWorks
                        class="mt-5"
                        :search="search"
                        :stars="stars"
                        :selectedSpecialties="selectedSpecialties"
                        :specialties="specialties"
                        :city="city"
                        :cityId="cityId"
                    />

                    <!-- Works List -->
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
