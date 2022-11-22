<script setup>
import { ref, onBeforeMount, onUpdated } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Loading, Phone } from 'mdue';
import Button from '@/Components/Button.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import CopyField from '@/Components/CopyField.vue';
import ReviewCard from '@/Components/Reviews/ReviewCard.vue';
import CreateReviewForm from './Partials/CreateReviewForm.vue';

const props = defineProps({hiredWork: {type: Object}});

const hiredWork = ref({});

onBeforeMount(() => {
    setHiredWork();
});

onUpdated(() => {
    setHiredWork();
});

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

const deleteForm = useForm({
    hiredWork: props.hiredWork.uuid,
});

function submitDelete() {
    deleteForm.delete(route('user.contractor.hired-works.destroy'), {
        onBefore: function() {
            deleteForm.clearErrors();
        },
    })
}
</script>

<template>
    <AuthLayout :title="$t('words.works')">
        <template #main>
            <div class="flex">
                <!-- Page Content -->
                <div class="w-full px-5">
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
                                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 mt-1">
                                    <div>
                                        <span class="font-bold text-sm">{{ $t('words.worker') }}</span>
                                        <div class="mt-1">
                                            <span>{{ hiredWork.work.worker.user.name }}</span>
                                        </div>
                                    </div>

                                    <template v-if="hiredWork.work.worker.cnpj">
                                        <div>
                                            <span class="font-bold text-sm">{{ $t('words.cnpj') }}</span>
                                            <div class="mt-1">
                                                <span>{{ hiredWork.work.worker.cnpj }}</span>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <template v-if="hiredWork.work.worker.phone_numbers.length">
                                    <div class="mt-5">
                                        <span class="font-bold text-sm">{{ $t('words.phoneNumbers') }}</span>
                                        <div class="mt-1">
                                            <div class="mt-1" v-for="phoneNumber in hiredWork.work.worker.phone_numbers" :key="phoneNumber.id">
                                                <div class="flex items-center">
                                                    <Phone class="text-sm" />
                                                    <CopyField class="ml-2" width="width: 130px;" :modelValue="phoneNumber.number" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <div class="mt-5" v-if="hiredWork.work.description">
                                    <span class="font-bold text-sm">{{ $t('words.description') }}</span>
                                    <div class="mt-1 border rounded p-3 max-w-full">
                                        <span>{{ hiredWork.work.description }}</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-5" v-if="(hiredWork.work.unity) || (hiredWork.work.time) || (hiredWork.work.price)">
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
                                        <div class="flex items-center" title="Estimated time">
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
                                                <span class="font-semibold">{{ $t('phrases.initiated') }}</span>

                                                <div class="flex items-center">
                                                    <span class="text-sm">{{ hiredWork.initiated_at.toLocaleDateString() }}</span>
                                                    <em class="text-xs ml-2">({{ hiredWork.initiated_at.toLocaleTimeString() }})</em>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <template v-if="hiredWork.done_at">
                                                    <div class="flex flex-col">
                                                        <span class="font-semibold">{{ $t('phrases.done') }}</span>

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
                                            <span>{{ $t('phrases.notInitiated') }}</span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <template v-if="! hiredWork.initiated_at">
                        <div class="flex mt-2">
                            <Button class="w-full py-5" title="Cancel" @click="submitDelete" :disabled="deleteForm.processing">{{$t('words.cancel')}}</Button>
                        </div>
                    </template>

                    <template v-if="hiredWork.done_at">
                        <div class="mt-2 mx-auto w-full md:w-fit border rounded p-5">
                            <h2 class="font-semibold">{{ $t('words.review') }}</h2>

                            <div class="mt-2">
                                <template v-if="hiredWork.contractor_review">
                                    <ReviewCard :review="hiredWork.contractor_review" />
                                </template>
                                <template v-else>
                                    <CreateReviewForm :hiredWork="hiredWork" />
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
