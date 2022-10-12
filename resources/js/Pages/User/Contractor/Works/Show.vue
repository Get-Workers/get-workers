<script setup>
import { ImageOff } from 'mdue';
import AuthLayout from '../../../../Layouts/AuthLayout.vue';
import BadgeGroup from '../../../../Components/Badges/BadgeGroup.vue';

defineProps({
    work: Object,
});
</script>

<template>
    <AuthLayout title="Works">
        <template #main>
            <div class="flex">
                <!-- Page Content -->
                <div class="w-full px-5">
                    <div class="flex items-center">
                        <div class="font-bold text-lg" :title="work.name">{{ work.name }}</div>
                        <div>
                            <em class="ml-1 font-medium text-sm text-gray-500" :title="work.slug">({{ work.slug }})</em>
                        </div>
                    </div>

                    <!-- Works List -->
                    <div class="mt-5 p-5 border rounded w-full overflow-x-auto">
                        <!-- Future image carousel -->
                        <div class="flex items-center justify-center w-full rounded h-40 md:h-60 lg:h-72 xl:h-80 bg-gray-400" title="No image">
                            <ImageOff class="text-lg"/>
                        </div>

                        <div class="mt-3">
                            <span class="font-bold text-sm">Worker</span>
                            <div class="mt-1">
                                {{ work.worker.user.name }}
                            </div>
                        </div>

                        <div class="mt-3" v-if="work.specialties.length">
                            <span class="font-bold text-sm">Work specialties</span>
                            <div class="rounded border p-3 mt-1 h-32 max-w-lg overflow-y-auto">
                                <BadgeGroup :badges="work.specialties"/>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-3">
                            <div v-if="work.unity">
                                <div class="flex items-center" title="Work unity reference">
                                    <span class="font-bold text-sm">Unity</span>
                                    <div>
                                        <em class="ml-1 text-xs">(reference)</em>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <span>{{ work.unity.type }} ({{ work.unity.name }})</span>
                                </div>
                            </div>

                            <div v-if="work.time">
                                <div class="flex items-center" title="Work time reference">
                                    <span class="font-bold text-sm">Time</span>
                                    <div>
                                        <em class="ml-1 text-xs">(reference)</em>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <span>{{ work.time }}</span>
                                </div>
                            </div>

                            <div v-if="work.price">
                                <div class="flex items-center" title="Work price reference">
                                    <span class="font-bold text-sm">Price</span>
                                    <div>
                                        <em class="ml-1 text-xs">(reference)</em>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <span>{{ `R$ ${work.price}`.replace('.', ',') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
