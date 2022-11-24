<script setup>
import { computed } from '@vue/reactivity';
import Link from '@/Components/Links/Link.vue';
import { Loading } from 'mdue';

const props = defineProps({ hiredWork: Object });

const scheduledTo = computed(() => props.hiredWork.scheduled_to ? new Date(props.hiredWork.scheduled_to * 1000) : null);

const initiatedAt = computed(() => props.hiredWork.initiated_at ? new Date(props.hiredWork.initiated_at * 1000) : null);
const isInitiated = computed(() => initiatedAt.value !== null);

const doneAt = computed(() => props.hiredWork.done_at ? new Date(props.hiredWork.done_at * 1000) : null);
const isDone = computed(() => doneAt.value !== null);
</script>

<template>
    <div :key="`hired-work-card-${hiredWork.uuid}`">
        <Link
            class="text-black"
            :href="route('user.contractor.hired-works.show', { hiredWorkUuid: hiredWork.uuid })"
        >
            <div class="px-5 py-3">
                <div class="flex">
                    <template v-if="!isInitiated">
                        <div class="flex items-center text-blue-500" :title="$t('phrases.notInitiated')">
                            <span class="font-semibold">{{ $t('phrases.notInitiated') }}</span>
                        </div>
                    </template>
                    <template v-else-if="!isDone">
                        <div class="flex items-center text-yellow-500" :title="$t('phrases.progress')">
                            <Loading class="animate-spin"/>
                            <span class="ml-2 font-semibold">{{ $t('phrases.progress') }}</span>
                        </div>
                    </template>
                    <template v-else>
                        <div class="flex items-center text-green-500" :title="$t('words.done')">
                            <span class="font-semibold">{{ $t('words.done') }}</span>
                        </div>
                    </template>

                    <div class="ml-auto w-5 h-5 rounded-full"
                        :class="{
                            'bg-blue-500': !isInitiated,
                            'bg-yellow-500': (isInitiated && !isDone),
                            'bg-green-500': isDone
                        }"
                    ></div>
                </div>

                <div class="mt-1 flex flex-col h-full">
                    <div class="flex md:w-2/3 mr-6">
                        <span class="font-bold text-xl truncate" :title="hiredWork.work.name">{{ hiredWork.work.name }}</span>
                    </div>

                    <div class="mt-1 grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                        <template v-if="scheduledTo">
                            <div>
                                <span class="font-semibold">{{ $t('words.scheduled') }}</span>

                                <div class="flex items-center">
                                    <span class="text-sm">{{ scheduledTo.toLocaleDateString() }}</span>
                                    <em class="text-xs ml-2">({{ scheduledTo.toLocaleTimeString() }})</em>
                                </div>
                            </div>
                        </template>

                        <template v-if="initiatedAt">
                            <div>
                                <span class="font-semibold" :title="$t('words.initiate')">{{ $t('words.initiated') }}</span>

                                <div class="flex items-center">
                                    <span class="text-sm">{{ initiatedAt.toLocaleDateString() }}</span>
                                    <em class="text-xs ml-2">({{ initiatedAt.toLocaleTimeString() }})</em>
                                </div>
                            </div>
                        </template>

                        <template v-if="doneAt">
                            <div>
                                <span class="font-semibold">{{ $t('words.done') }}</span>

                                <div class="flex items-center">
                                    <span class="text-sm">{{ doneAt.toLocaleDateString() }}</span>
                                    <em class="text-xs ml-2">({{ doneAt.toLocaleTimeString() }})</em>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </Link>
    </div>
</template>
