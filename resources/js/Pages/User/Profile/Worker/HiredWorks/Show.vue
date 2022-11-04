<script setup>
import { ref, onBeforeMount, onUpdated } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Loading } from 'mdue';
import AuthLayout from '../../../../Layouts/AuthLayout.vue';
import Button from '../../../../Components/Button.vue';
import InputError from '../../../../Components/InputError.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';

const props = defineProps({hiredWork: {type: Object}});

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
    <AuthLayout title="Works">
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
                            <div class="w-full">
                                <div>
                                    <span class="font-bold text-sm">Contractor</span>
                                    <div class="mt-1">
                                        <span>{{ hiredWork.contractor.user.name }}</span>
                                    </div>
                                </div>

                                <div v-if="hiredWork.work.description">
                                    <span class="font-bold text-sm">Description</span>
                                    <div class="mt-1 border rounded p-3">
                                        <span>{{ hiredWork.work.description }}</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-3" v-if="(hiredWork.work.unity) || (hiredWork.work.time) || (hiredWork.work.price)">
                                    <div v-if="hiredWork.work.unity">
                                        <div class="flex items-center" title="Work unity reference">
                                            <span class="font-bold text-sm">Unity</span>
                                            <div>
                                                <em class="ml-1 text-xs">(reference)</em>
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            <span>{{ hiredWork.work.unity.type }} ({{ hiredWork.work.unity.name }})</span>
                                        </div>
                                    </div>

                                    <div v-if="hiredWork.work.time">
                                        <div class="flex items-center" title="Estimated time">
                                            <span class="font-bold text-sm">Estimated time</span>
                                            <div>
                                                <em class="ml-1 text-xs">(reference)</em>
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            <span>{{ hiredWork.work.time }}</span>
                                        </div>
                                    </div>

                                    <div v-if="hiredWork.work.price">
                                        <div class="flex items-center" title="Work price reference">
                                            <span class="font-bold text-sm">Price</span>
                                            <div>
                                                <em class="ml-1 text-xs">(reference)</em>
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            <span>{{ `R$ ${hiredWork.work.price}`.replace('.', ',') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:w-64 w-full rounded border p-2 bg-blue-300 sm:mt-0 mt-2">
                                <span class="font-bold text-sm">Status</span>
                                <div class="mt-1">
                                    <div v-if="hiredWork.initiated_at">
                                        <div>
                                            <span>Initiated at: {{ `${hiredWork.initiated_at.toLocaleDateString()} ${hiredWork.initiated_at.toLocaleTimeString()}` }}</span>
                                        </div>
                                        <div class="mt-1">
                                            <span v-if="hiredWork.done_at">Done at: {{ `${hiredWork.done_at.toLocaleDateString()} ${hiredWork.done_at.toLocaleTimeString()}` }}</span>
                                            <div class="flex" v-else>
                                                <Loading class="animate-spin"/>
                                                <span class="ml-1">In progress</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <span>Not initiated</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex mt-2" v-if="hiredWorkForm.hasErrors">
                        <InputError :message="hiredWorkForm.errors.hiredWork" />
                    </div>

                    <div class="mt-2 space-y-2" v-if="! hiredWork.done_at">
                        <Button class="w-full py-5" title="Initiate" @click="submitInitiate" :disabled="hiredWorkForm.processing" v-if="! hiredWork.initiated_at">Initiate</Button>
                        <Button class="w-full py-5" title="Done" @click="submitDone" :disabled="hiredWorkForm.processing" v-if="hiredWork.initiated_at && ! hiredWork.done_at">Done</Button>
                    </div>

                    <div class="flex mt-2" v-if="! hiredWork.initiated_at">
                        <Button class="w-full py-5" title="Cancel" @click="submitDelete" :disabled="hiredWorkForm.processing">Cancel</Button>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
