<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/reactivity';
import AuthLayout from '../../../../../Layouts/AuthLayout.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';
import Button from '../../../../../Components/Button.vue';
import InputError from '../../../../../Components/InputError.vue';
import Input from '../../../../../Components/Input.vue';
import Label from '../../../../../Components/Label.vue';
import ExternalLink from '../../../../../Components/Links/ExternalLink.vue';

defineProps({
    certifications: {
        type: Array,
        required: true,
        default: []
    },
    storeStatus: {
        type: Boolean,
        default: false
    },
    deleteStatus: {
        type: Boolean,
        default: false
    }
});

const newCertificationForm = useForm({
    name: '',
    description: '',
    certified_uuid: '',
    certified_link: '',
});

const deleteForm = useForm({
    certification: '',
});

function submitAdd() {
    newCertificationForm.post(route('user.profile.worker.certifications.store'), {
        preserveScroll: true,
        onSuccess: () => resetCertificationForm()
    });
}

function submitDelete(certification) {
    deleteForm.certification = certification;
    deleteForm.delete(route('user.profile.worker.certifications.destroy'), {
        preserveScroll: true,
        onFinish: () => resetCertificationDeleteForm()
    });
}

function resetCertificationDeleteForm() {
    deleteForm.reset();
    newCertificationForm.clearErrors();
}

function resetCertificationForm() {
    newCertificationForm.reset();
    deleteForm.clearErrors()
    newCertificateFormShow.value = false;
}

let newCertificateFormShow = ref(false);
function toggleNewCertificateForm() {
    newCertificateFormShow.value = !newCertificateFormShow.value;
}

const isProcessingForms = computed(() => (deleteForm.processing || newCertificationForm.processing));
</script>

<template>
    <AuthLayout title="Specialties">
        <template #main>
            <div class="flex">
                <!-- Sidebard Menu -->
                <SidebarMenu class="flex flex-col min-h-fit w-64 md:w-96"/>

                <!-- Page Content -->
                <div class="ml-5 w-full px-5">
                    <div class="font-bold text-lg">My certifications</div>

                    <!-- Certifications Add Form -->
                    <div class="mt-5 border rounded px-5 py-3">
                        <div class="flex justify-between items-center">
                            <div>New certificate</div>
                            <Button type="button" @click="toggleNewCertificateForm" v-if="!newCertificateFormShow">New</Button>
                            <Button type="button" @click="toggleNewCertificateForm" v-else>Close</Button>
                        </div>
                        <div class="mt-2 border rounded p-5" v-if="newCertificateFormShow">
                            <form @submit.prevent="submitAdd">
                                <div class="space-y-5">
                                    <div>
                                        <Label value="Name" for="certified_name"/>
                                        <Input id="certified_name" type="text" class="mt-1 block w-full" required autofocus placeholder="Name" max-length="255" v-model="newCertificationForm.name"/>
                                        <InputError class="mt-2" :message="newCertificationForm.errors.name" />
                                    </div>
                                    <div>
                                        <Label value="Description" for="certified_description"/>
                                        <Input id="certified_description" type="text" class="mt-1 block w-full" placeholder="Description" max-length="1024" v-model="newCertificationForm.description"/>
                                        <InputError class="mt-2" :message="newCertificationForm.errors.description" />
                                    </div>
                                    <div>
                                        <Label value="Certified credential" for="certified_credential"/>
                                        <Input id="certified_credential" type="text" class="mt-1 block w-full" placeholder="Certified credential" max-length="100" v-model="newCertificationForm.certified_uuid"/>
                                        <InputError class="mt-2" :message="newCertificationForm.errors.certified_uuid" />
                                    </div>
                                    <div>
                                        <Label value="Certified link" for="certified_link"/>
                                        <Input id="certified_link" type="text" class="mt-1 block w-full" placeholder="Certified link" max-length="255" v-model="newCertificationForm.certified_link"/>
                                        <InputError class="mt-2" :message="newCertificationForm.errors.certified_link" />
                                    </div>

                                    <div class="flex align-items-end">
                                        <Button class="ml-auto" :disabled="isProcessingForms">Register</Button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <!-- Specialties Remove Form Messages -->
                    <InputError :message="deleteForm.errors.certification" class="my-2" />
                    <div v-if="deleteStatus" class="my-2 font-medium text-sm text-green-600">
                        Certification removed successfully
                    </div>

                    <!-- Specialties List && Remove Form -->
                    <div class="mt-5 border rounded" v-if="certifications.length">
                        <div class="px-5 py-3 border-b">
                            <div class="flex justify-between items-center">
                                <div class="flex">
                                    <span class="w-40" title="Certification name">Certification name</span>
                                    <span class="ml-5" title="Certification identificator/URL">Certification identificator/URL</span>
                                </div>
                                <span class="w-24">Action</span>
                            </div>
                        </div>
                        <div v-for="certification in certifications" class="px-5 py-3 hover:bg-gray-300 border-b last:border-none">
                            <div class="flex justify-between items-center">
                                <div class="flex">
                                    <span class="w-40 truncate" :title="certification.name">{{ certification.name }}</span>
                                    <ExternalLink :href="certification.certified_link" :title="certification.certified_uuid" class="ml-5 max-w-40" target="_blank" v-if="certification.certified_link">
                                        {{ certification.certified_uuid ? certification.certified_uuid : certification.certified_link }}
                                    </ExternalLink>
                                    <span class="ml-5 max-w-40" v-else>{{ certification.certified_uuid }}</span>
                                </div>
                                <Button class="w-24" @click="submitDelete(certification.uuid)" :disabled="isProcessingForms">Remove</Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
