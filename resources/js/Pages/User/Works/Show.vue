<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/reactivity';
import { ref } from 'vue';
import { DatePicker } from 'v-calendar';
import { ImageOff } from 'mdue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import BadgeGroup from '@/Components/Badges/BadgeGroup.vue';
import Button from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modals/Modal.vue';
import Checkbox from '@/Components/Checkbox.vue';
import Label from '@/Components/Label.vue';

const props = defineProps({
    work: {
        type: Object,
        default: {
            name: null,
            slug: null,
            worker: {
                user: {
                    uuid: null,
                    name: null,
                },
            },
            specialties: [],
            unity: {
                name: null,
                type: null,
            },
            time: null,
            price: null,
        }
    },
});

const pageProps = computed(() => usePage().props.value);
const isContractor = computed(() => (pageProps.value.contractor !== null));
const isWorker = computed(() => (pageProps.value.worker !== null));
const isOwnedByAuthWorker = computed(() => (
    isWorker
    && (pageProps.value.user.uuid === props.work.worker.user.uuid)
));

const modalIsOpened = ref(false);

const contractWorkForm = useForm({
    work: props.work.uuid,
    needToSchedule: false,
    scheduled_to: null,
});

function openModal() {
    if (modalIsOpened.value) return;
    if (! contractWorkForm.needToSchedule) return;
    modalIsOpened.value = true;
}

function closeModal() {
    modalIsOpened.value = false;
    contractWorkForm.reset('scheduled_to');
}

function hireWork(scheduled = false) {
    if (! scheduled) {
        openModal();
        return;
    }

    contractWorkForm.post(route('user.contractor.hired-works.store'), {
        onFinish: function () {
            contractWorkForm.reset('scheduled_to');
        }
    });
}
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

                    <!-- Work Infos -->
                    <div class="mt-5 p-5 space-y-3 border rounded w-full overflow-x-auto">
                        <!-- Future image carousel -->
                        <div class="flex items-center justify-center w-full rounded h-40 md:h-60 lg:h-72 xl:h-80 bg-gray-400" title="No image">
                            <ImageOff class="text-lg"/>
                        </div>

                        <div>
                            <span class="font-bold text-sm">{{$t('words.worker')}}</span>
                            <div class="mt-1">
                                {{ work.worker.user.name }}
                            </div>
                        </div>

                        <div v-if="work.description">
                            <span class="font-bold text-sm">{{$t('words.description')}}</span>
                            <div class="mt-1 border rounded p-3">
                                <span>{{ work.description }}</span>
                            </div>
                        </div>

                        <div v-if="work.specialties.length">
                            <span class="font-bold text-sm">{{$t('words.workSpecialties')}}</span>
                            <div class="rounded border p-3 mt-1 h-32 max-w-lg overflow-y-auto">
                                <BadgeGroup :badges="work.specialties"/>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-3">
                            <div v-if="work.unity">
                                <div class="flex items-center" title="Work unity reference">
                                    <span class="font-bold text-sm">{{$t('words.unity')}}</span>
                                    <div>
                                        <em class="ml-1 text-xs">({{$t('words.reference')}})</em>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <span>{{ work.unity.type }} ({{ work.unity.name }})</span>
                                </div>
                            </div>

                            <div v-if="work.time">
                                <div class="flex items-center" title="Work time reference">
                                    <span class="font-bold text-sm">{{$t('words.time')}}</span>
                                    <div>
                                        <em class="ml-1 text-xs">({{$t('words.reference')}})</em>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <span>{{ work.time }}</span>
                                </div>
                            </div>

                            <div v-if="work.price">
                                <div class="flex items-center" title="Work price reference">
                                    <span class="font-bold text-sm">{{$t('words.price')}}</span>
                                    <div>
                                        <em class="ml-1 text-xs">({{$t('words.reference')}})</em>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <span>{{ `R$ ${work.price}`.replace('.', ',') }}</span>
                                </div>
                            </div>
                        </div>

                        <div v-if="isContractor && !isOwnedByAuthWorker">
                            <label for="NeedScheduling" class="flex w-fit mb-2">
                                <Checkbox id="NeedScheduling" class="mr-2" v-model:checked="contractWorkForm.needToSchedule" />
                                <Label for="Schedule" :optional="true">
                                    <span>{{$t('phrases.scheduleWork')}}</span>
                                </Label>
                            </label>

                            <InputError class="mb-1" v-for="(error, errorKey) in contractWorkForm.errors" :key="errorKey" :message="$t('messages.hiredWork.errorDate')"/>
                            <Button class="w-full md:py-4 lg:py-5 " :disabled="contractWorkForm.processing" @click.prevent="hireWork(! contractWorkForm.needToSchedule)" v-html="contractWorkForm.needToSchedule ? $t('words.schedule'): $t('words.hire')"></Button>
                        </div>
                    </div>
                </div>
            </div>

            <Modal :title="$t('words.scheduleWork')" :isOpened="modalIsOpened" :onClose="closeModal" v-if="isContractor && !isOwnedByAuthWorker">
                <div class="flex flex-col">
                    <DatePicker class="mx-auto mb-2" mode="dateTime" v-model="contractWorkForm.scheduled_to" :minute-increment="10" :min-date="new Date()" />
                    <InputError class="mb-1" v-for="(error, errorKey) in contractWorkForm.errors" :key="errorKey" :message="$t('messages.hiredWork.errorDate')"/>
                    <Button class="w-full md:py-4 lg:py-5 mt-2" :disabled="contractWorkForm.processing" @click.prevent="hireWork((contractWorkForm.scheduled_to !== null))">{{$t('words.hire')}}</Button>
                </div>
            </Modal>
        </template>
    </AuthLayout>
</template>
