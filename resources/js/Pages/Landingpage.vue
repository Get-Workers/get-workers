<script setup>
import { Information } from 'mdue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Link from '@/Components/Links/Link.vue';
import WorkCard from '../Components/Cards/WorkCard.vue';

defineProps({ works: Object });
</script>

<template>
    <GuestLayout title="Welcome">
        <template #main>
            <div class="min-h-full">
                <div class="mx-auto w-fit">
                    <h1 class="font-bold text-lg">{{ $t('words.works') }}</h1>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-5 lg:gap-7 w-fit mx-auto mt-5">
                    <template v-for="work in works.data" :key="`card-list-${work.uuid}`">
                        <WorkCard :work="work"/>
                    </template>
                </div>
            </div>
        </template>
    </GuestLayout>
</template>
