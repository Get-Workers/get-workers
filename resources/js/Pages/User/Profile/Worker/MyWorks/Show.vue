<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import Button from '@/Components/Button.vue';
import ButtonCancel from '@/Components/ButtonCancel.vue';
import InputError from '@/Components/InputError.vue';
import InputSuccess from '@/Components/InputSuccess.vue';
import BadgeGroup from '@/Components/Badges/BadgeGroup.vue';
import MyWorkCardVue from '@/Components/Cards/MyWorkCard.vue';
import Modal from '@/Components/Modals/Modal.vue';
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

const modalIsOpened = ref(false);
const workToDelete = ref(null);
const deleteForm = useForm({
    work: '',
});

function submitDelete() {
    deleteForm.work = workToDelete.value.uuid;
    deleteForm.delete(route('user.profile.worker.my-works.destroy'), {
        preserveScroll: true,
        onFinish() {
            deleteForm.reset();
            closeModal();
        },
    });
}

function cancelDelete() {
    deleteForm.reset();
    closeModal();
}

function deleteWorkAction(work) {
    workToDelete.value = work;
    openModal();
}

function openModal() {
    if (modalIsOpened.value) return;
    modalIsOpened.value = true;
}

function closeModal() {
    modalIsOpened.value = false;
}

const newWorkFormShow = ref(false);
function toggleNewWorkForm(el, status = false) {
    workToUpdate.value = null;
    newWorkFormShow.value = status ? status : !newWorkFormShow.value;
}

const workToUpdate = ref(null);
function setWorkToUpdate(work) {
    deleteForm.clearErrors();
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
                    <InputSuccess class="my-2" :success="deleteForm.recentlySuccessful" :message="$t('messages.work.delete.success')" />

                    <!-- Works List && Remove Form -->
                    <div class="mt-5 border rounded p-5">
                        <template v-if="works.length">
                            <div class="space-y-5">
                                <template v-for="work in works">
                                    <MyWorkCardVue class="border rounded max-h-80 hover:bg-gray-300" :work="work">
                                        <template #action>
                                            <div class="col-span-2 flex justify-end items-center space-x-2 w-full">
                                                <Button type="button" :title="$t('words.update')"
                                                    @click="setWorkToUpdate(work)" :disabled="deleteForm.processing"
                                                >{{ $t('words.update') }}</Button>

                                                <ButtonCancel type="button" :title="$t('words.delete')"
                                                    @click="deleteWorkAction(work)" :disabled="deleteForm.processing"
                                                >{{ $t('words.delete') }}</ButtonCancel>
                                            </div>
                                        </template>
                                    </MyWorkCardVue>
                                </template>
                            </div>
                        </template>
                        <template v-else>
                            <div>
                                <span>{{ $t('words.noData') }}</span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <Modal :title="$t('phrases.deleteWork')" :isOpened="modalIsOpened" :onClose="closeModal" :key="`modal`">
                <div class="flex flex-col" v-if="workToDelete">
                    <div>
                        <span class="text-xl">{{ $t('questions.work.delete') }}</span>
                    </div>

                    <div class="mt-5">
                        <span class="font-semibold text-base">{{ $t('words.work') }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span>{{ workToDelete?.name }}</span>
                        <span>{{ workToDelete?.slug }}</span>
                    </div>

                    <div class="mt-5 pt-5 flex justify-end space-x-2 border-t">
                        <Button type="button" :title="$t('words.delete')"
                            @click="submitDelete" :disabled="deleteForm.processing"
                            key="delete-confirm"
                        >{{ $t('words.delete') }}</Button>

                        <ButtonCancel type="button" :title="$t('words.cancel')"
                            @click="cancelDelete" :disabled="deleteForm.processing"
                            key="delete-cancel"
                        >{{ $t('words.cancel') }}</ButtonCancel>
                    </div>
                </div>
            </Modal>
        </template>
    </AuthLayout>
</template>
