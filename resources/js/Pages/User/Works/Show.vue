<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/reactivity';
import { ref } from 'vue';
import { ImageOff } from 'mdue';
import AuthLayout from '../../../Layouts/AuthLayout.vue';
import BadgeGroup from '../../../Components/Badges/BadgeGroup.vue';
import Button from '../../../Components/Button.vue';
import InputError from '../../../Components/InputError.vue';

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

let formError = ref(false);

const contractWorkForm = useForm({
    work: props.work.uuid
});

function contractWork() {
    contractWorkForm.post(route('user.contractor.hired-works.store'), {
        onBefore: function() {
            formError.value = false;
        },
        onError: function() {
            formError.value = true;
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
                            <span class="font-bold text-sm">Worker</span>
                            <div class="mt-1">
                                {{ work.worker.user.name }}
                            </div>
                        </div>

                        <div v-if="work.description">
                            <span class="font-bold text-sm">Description</span>
                            <div class="mt-1 border rounded p-3">
                                <span>{{ work.description }}</span>
                            </div>
                        </div>

                        <div v-if="work.specialties.length">
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

                        <div v-if="isContractor && !isOwnedByAuthWorker">
                            <InputError class="mb-1" :message="contractWorkForm.errors.work" v-if="formError"/>
                            <Button class="w-full md:py-4 lg:py-5" :disabled="contractWorkForm.processing" @click.prevent="contractWork">Hire</Button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
