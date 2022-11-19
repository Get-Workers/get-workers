<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import Button from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';
import InputSuccess from '@/Components/InputSuccess.vue';
import BadgeGroup from '@/Components/Badges/BadgeGroup.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';
import NewWorkForm from './Partials/NewWorkForm.vue';

const props = defineProps({
    works: {
        type: Array,
        required: true,
        default: []
    },
    unities: {
        type: Array,
        required: true,
        default: []
    },
    specialties: {
        type: Array,
        required: true,
        default: []
    },
});

const deleteForm = useForm({
    work: '',
});

function submitDelete(work) {
    deleteForm.work = work;
    deleteForm.delete(route('user.profile.worker.my-works.destroy'), {
        preserveScroll: true,
        onFinish: () => deleteForm.reset(),
    });
}

const newWorkFormShow = ref(false);
function toggleNewWorkForm(el, status = false) {
    workToUpdate.value = null;
    newWorkFormShow.value = status ? status : !newWorkFormShow.value;
}

const workToUpdate = ref(null);
function setWorkToUpdate(work) {
    if (work?.id === workToUpdate?.value) return;
    toggleNewWorkForm(null, true);
    workToUpdate.value = work;
}
</script>

<template>
    <AuthLayout :title="$t('words.myWorks')">
        <template #main>
            <div class="flex flex-col sm:flex-row">
                <!-- Sidebard Menu -->
                <SidebarMenu class="sm:w-5/12 md:w-2/6 lg:w-3/12 w-full sm:m-0 mx-auto"/>

                <!-- Page Content -->
                <div class="sm:w-7/12 md:w-4/6 lg:w-9/12 w-full px-5 sm:mt-0 mt-2">
                    <div class="font-bold text-lg">{{ $t('words.myWorks') }}</div>

                    <!-- Work Add Form -->
                    <div class="mt-5 border rounded px-5 py-3">
                        <div class="flex justify-between items-center">
                            <div>{{ $t('words.newWork') }}</div>

                            <Button type="button" @click="toggleNewWorkForm"
                                v-if="! newWorkFormShow">{{ $t('words.new') }}</Button>
                            <Button type="button" @click="toggleNewWorkForm" v-else>{{ $t('words.close') }}</Button>
                        </div>

                        <NewWorkForm class="mt-3 border-t pt-3"
                            :unities="unities"
                            :specialties="specialties"
                            :workToUpdate="workToUpdate"
                            :key="workToUpdate?.uuid"
                            @reset="setWorkToUpdate(null)"
                            v-if="newWorkFormShow"
                        />
                    </div>

                    <!-- Works Remove Form Messages -->
                    <InputError class="my-2" :message="deleteForm.errors.certification" />
                    <InputSuccess class="my-2" :success="deleteForm.wasSuccessful" :message="$t('messages.work.delete.success')" />

                    <!-- Works List && Remove Form -->
                    <div class="mt-5 border rounded w-full overflow-x-auto" v-if="works.length">
                        <div class="min-w-xl">
                            <div class="grid grid-flow-col grid-cols-12 gap-2 px-5 py-3 border-b">
                                <span class="col-span-2 font-bold" :title="$t('words.name')">{{ $t('words.name') }}</span>
                                <span class="col-span-2 font-bold" :title="$t('words.slug')">{{ $t('words.slug') }}</span>
                                <span class="col-span-2 font-bold" :title="$t('words.specialties')">{{ $t('words.specialties') }}</span>
                                <span class="col-span-1 font-bold" :title="$t('words.unity')">{{ $t('words.unity') }}</span>
                                <span class="col-span-1 font-bold" :title="$t('words.time')">{{ $t('words.time') }}</span>
                                <span class="col-span-2 font-bold" :title="$t('words.price')">{{ $t('words.price') }}</span>
                                <span class="col-span-2 font-bold" :title="$t('words.action')">{{ $t('words.action') }}</span>
                            </div>
                            <div class="grid grid-flow-col grid-cols-12 gap-2 px-5 py-3 h-20 hover:bg-gray-300 border-b last:border-none"
                                v-for="(work) in works" :key="`work-${work.uuid}`"
                            >
                                <div class="col-span-2 flex items-center overflow-y-auto">
                                    <span class="min-w-fit break-words text-ellipsis" :title="work.name">{{ work.name }}</span>
                                </div>
                                <div class="col-span-2 flex items-center overflow-y-auto">
                                    <span class="min-w-fit break-words text-ellipsis" :title="work.slug">{{ work.slug }}</span>
                                </div>
                                <div class="col-span-2 overflow-y-auto">
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
                                <div class="col-span-2 flex flex-col items-center overflow-y-auto">
                                    <Button :title="$t('words.delete')" @click="submitDelete(work.uuid)" :disabled="deleteForm.processing">
                                        {{ $t('words.delete') }}
                                    </Button>

                                    <Button class="mt-2" :title="$t('words.update')" @click="setWorkToUpdate(work)" :disabled="deleteForm.processing">
                                        {{ $t('words.update') }}
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
