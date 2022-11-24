<script setup>
import { ref, onBeforeMount, onUpdated } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Loading, Phone } from 'mdue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import Button from '@/Components/Button.vue';
import CopyField from '@/Components/CopyField.vue';
import InputError from '@/Components/InputError.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';

const props = defineProps({hiredWork: Object});

const hiredWork = ref({});

onBeforeMount(() => {
    setHiredWork();
});

onUpdated(() => {
    setHiredWork();
})

function setHiredWork() {
    let tempHiredWork = {...props.hiredWork};
    if (tempHiredWork.initiated_at) {
        tempHiredWork.initiated_at = new Date(tempHiredWork.initiated_at * 1000);
    }
    if (tempHiredWork.done_at) {
        tempHiredWork.done_at = new Date(tempHiredWork.done_at * 1000);
    }
    hiredWork.value = tempHiredWork;
}

const hiredWorkForm = useForm({ hiredWork: props.hiredWork.uuid });

function submitDelete() {
    hiredWorkForm.delete(route('user.profile.worker.hired-works.destroy'), {
        onBefore: function() {
            hiredWorkForm.clearErrors();
        },
    })
}

function submitInitiate() {
    hiredWorkForm.post(route('user.profile.worker.hired-works.initiate'), {
        onBefore: function() {
            hiredWorkForm.clearErrors();
        },
    })
}

function submitDone() {
    hiredWorkForm.post(route('user.profile.worker.hired-works.done'), {
        onBefore: function() {
            hiredWorkForm.clearErrors();
        },
    })
}
</script>

<template>
    <AuthLayout :title="$t('words.hiredWorks')">
        <template #main>
            <div class="flex">
                <!-- Sidebard Menu -->
                <SidebarMenu class="sm:w-5/12 md:w-2/6 lg:w-3/12 w-full sm:m-0 mx-auto"/>

                <!-- Page Content -->
                <div class="sm:w-7/12 md:w-4/6 lg:w-9/12 w-full px-5 sm:mt-0 mt-2">
                    <div class="flex items-center">
                        <div class="font-bold text-lg" :title="hiredWork.work.name">{{ hiredWork.work.name }}</div>
                        <div>
                            <em class="ml-1 font-medium text-sm text-gray-500" :title="hiredWork.work.slug">({{ hiredWork.work.slug }})</em>
                        </div>
                    </div>

                    <!-- Work Infos -->
                    <div class="mt-5 p-5 space-y-3 border rounded w-full overflow-x-auto">
                        <div class="flex sm:flex-row flex-col">
                            <div class="w-full sm:mr-5">
                                <div class="flex flex-col lg:flex-row space-y-2 lg:space-y-0 lg:space-x-3 mt-1">
                                    <div>
                                        <span class="font-bold text-sm">{{ $t('words.contractor') }}</span>
                                        <div class="mt-1">
                                            <span>{{ hiredWork.contractor.user.name }}</span>
                                        </div>
                                    </div>

                                    <template v-if="hiredWork.contractor.user.phone_number">
                                        <div class="mt-5">
                                            <span class="font-bold text-sm">{{$t('words.phoneNumber')}}</span>
                                            <div class="mt-1">
                                                <div class="mt-1">
                                                    <div class="flex items-center">
                                                        <Phone class="text-sm" />
                                                        <CopyField class="ml-2" width="width: 130px;" :modelValue="hiredWork.contractor.user.phone_number" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="mt-5" v-if="hiredWork.work.description">
                                    <span class="font-bold text-sm">{{ $t('words.description') }}</span>
                                    <div class="mt-1 border rounded p-3">
                                        <span>{{ hiredWork.work.description }}</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mt-5" v-if="(hiredWork.work.unity) || (hiredWork.work.time) || (hiredWork.work.price)">
                                    <div v-if="hiredWork.work.unity">
                                        <div class="flex items-center" :title="$t('words.unity')">
                                            <span class="font-bold text-sm">{{ $t('words.unity') }}</span>
                                            <div>
                                                <em class="ml-1 text-xs">({{ $t('words.reference') }})</em>
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            <span>{{ hiredWork.work.unity.type }} ({{ hiredWork.work.unity.name }})</span>
                                        </div>
                                    </div>

                                    <div v-if="hiredWork.work.time">
                                        <div class="flex items-center" :title="$t('words.estimatedTime')">
                                            <span class="font-bold text-sm">{{ $t('words.estimatedTime') }}</span>
                                            <div>
                                                <em class="ml-1 text-xs">({{ $t('words.reference') }})</em>
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            <span>{{ hiredWork.work.time }}</span>
                                        </div>
                                    </div>

                                    <div v-if="hiredWork.work.price">
                                        <div class="flex items-center" :title="$t('words.price')">
                                            <span class="font-bold text-sm">{{ $t('words.price') }}</span>
                                            <div>
                                                <em class="ml-1 text-xs">({{ $t('words.reference') }})</em>
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            <span>{{ `R$ ${hiredWork.work.price}`.replace('.', ',') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:w-64 w-full rounded border p-2 bg-blue-300 sm:mt-0 mt-2 h-fit text-sm">
                                <span class="font-bold text-base">{{ $t('words.status') }}</span>
                                <div class="mt-1">
                                    <template v-if="hiredWork.initiated_at">
                                        <div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold">{{ $t('phrases.initiatedAt') }}</span>

                                                <div class="flex items-center">
                                                    <span class="text-sm">{{ hiredWork.initiated_at.toLocaleDateString() }}</span>
                                                    <em class="text-xs ml-2">({{ hiredWork.initiated_at.toLocaleTimeString() }})</em>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <template v-if="hiredWork.done_at">
                                                    <div class="flex flex-col">
                                                        <span class="font-semibold">{{ $t('phrases.doneAt') }}</span>

                                                        <div class="flex items-center">
                                                            <span class="text-sm">{{ hiredWork.done_at.toLocaleDateString() }}</span>
                                                            <em class="text-xs ml-2">({{ hiredWork.done_at.toLocaleTimeString() }})</em>
                                                        </div>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="flex items-center">
                                                        <Loading class="animate-spin"/>
                                                        <span class="ml-2">{{ $t('phrases.progress') }}</span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div>
                                            <span>{{$t('phrases.notInitiated')}}</span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex mt-2" v-if="hiredWorkForm.hasErrors">
                        <InputError :message="hiredWorkForm.errors.hiredWork" />
                    </div>

                    <div class="mt-2 space-y-2" v-if="! hiredWork.done_at">
                        <Button class="w-full py-5" :title="$t('words.initiate')" @click="submitInitiate" :disabled="hiredWorkForm.processing" v-if="! hiredWork.initiated_at">{{ $t('words.initiate') }}</Button>
                        <Button class="w-full py-5" :title="$t('words.done')" @click="submitDone" :disabled="hiredWorkForm.processing" v-if="hiredWork.initiated_at && ! hiredWork.done_at">{{ $t('words.done') }}</Button>
                    </div>

                    <div class="flex mt-2" v-if="! hiredWork.initiated_at">
                        <Button class="w-full py-5" :title="$t('words.cancel')" @click="submitDelete" :disabled="hiredWorkForm.processing">{{ $t('words.cancel') }}</Button>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
