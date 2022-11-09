<script setup>
import { Information } from 'mdue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Link from '@/Components/Links/Link.vue';

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
                    <template v-for="work in works.data">
                            <div class="flex flex-col bg-white rounded-lg border shadow-md hover:shadow-lg w-72 xl:w-80 h-60 transition ease-in-out delay-75 hover:scale-110 duration-150">
                                <div class="flex flex-col h-full px-4 py-2">
                                    <div class="h-min">
                                        <span class="font-bold text-lg truncate" :title="work.name">{{ work.name }}</span>
                                    </div>
                                    <div class="mt-2 h-full">
                                        <p class="line-clamp-5" :title="work.description" v-if="work.description">{{ work.description }}</p>
                                        <p v-else>{{ $t('phrases.noDescription') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <em class="pr-1 text-base max-w-fit truncate" style="max-width: 80%;" :title="`R$ ${work.price}`.replace('.', ',')">{{ `R$ ${work.price}`.replace('.', ',') }}</em>
                                        <em class="ml-2 pl-1 text-xs" v-if="work.unity">{{ `/ ${work.unity.type}` }}</em>
                                    </div>
                                </div>
                                <div class="flex h-10">
                                    <Link :href="route('works.show', {'workUuid': work.uuid})" class="w-full">
                                        <div class="flex px-4 py-2 border-t rounded-b justify-between items-center hover:bg-gray-300">
                                            <span>{{ $t('phrases.moreDetails') }}</span>
                                            <Information class="text-lg" />
                                        </div>
                                    </Link>
                                </div>
                            </div>
                    </template>
                </div>
            </div>
        </template>
    </GuestLayout>
</template>
