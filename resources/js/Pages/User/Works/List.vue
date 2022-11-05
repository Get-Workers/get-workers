<script setup>
import AuthLayout from '../../../Layouts/AuthLayout.vue';
import BadgeGroup from '../../../Components/Badges/BadgeGroup.vue';
import Link from '../../../Components/Links/Link.vue';
import Pagination from '../../../Components/Pagination.vue';

defineProps({ works: Object });
</script>

<template>
    <AuthLayout title="Works">
        <template #main>
            <div class="flex">
                <!-- Page Content -->
                <div class="w-full px-5">
                    <div class="font-bold text-lg">{{ $t('words.works') }}</div>

                    <!-- Works List -->
                    <div class="mt-5 border rounded w-full overflow-x-auto" v-if="works.data.length">
                        <div class="min-w-xl">
                            <div class="grid grid-flow-col grid-cols-12 gap-2 px-5 py-3 border-b">
                                <span class="col-span-3 font-bold" :title="$t('words.name')">{{ $t('words.name') }}</span>
                                <span class="col-span-2 font-bold" :title="$t('words.slug')">{{ $t('words.slug') }}</span>
                                <span class="col-span-3 font-bold" :title="$t('words.specialties')">{{ $t('words.specialties') }}</span>
                                <span class="col-span-1 font-bold" :title="$t('words.unity')">{{ $t('words.unity') }}</span>
                                <span class="col-span-1 font-bold" :title="$t('words.time')">{{ $t('words.time') }}</span>
                                <span class="col-span-2 font-bold" :title="$t('words.price')">{{ $t('words.price') }}</span>
                            </div>
                            <div class="grid grid-flow-col grid-cols-12 gap-2 px-5 py-3 h-20 hover:bg-gray-300 border-b last:border-none"
                                v-for="work in works.data" :key="work.uuid"
                            >
                                <div class="col-span-3 flex items-center overflow-y-auto">
                                    <Link class="min-w-fit break-words text-ellipsis"
                                        :href="route('works.show', { workUuid: work.uuid })"
                                        :title="work.name"
                                    >{{ work.name }}</Link>
                                </div>
                                <div class="col-span-2 flex items-center overflow-y-auto">
                                    <span class="min-w-fit break-words text-ellipsis" :title="work.slug">{{ work.slug }}</span>
                                </div>
                                <div class="col-span-3 overflow-y-auto">
                                    <BadgeGroup :badges="work.specialties" />
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <span :title="work.unity ? work.unity.name : ''">{{ work.unity ? work.unity.type : '' }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <span :title="work.time">{{ work.time }}</span>
                                </div>
                                <div class="col-span-2 flex items-center">
                                    <span class="px-3 py-1 border border-blue-200 rounded-full bg-blue-200" :title="`R$ ${work.price}`.replace('.', ',')">{{ `R$ ${work.price}`.replace('.', ',') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <Pagination class="mt-2" :links="works.links" />
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
