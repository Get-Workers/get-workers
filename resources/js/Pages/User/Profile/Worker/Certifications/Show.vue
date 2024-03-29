<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/reactivity';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';
import Button from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import ExternalLink from '@/Components/Links/ExternalLink.vue';

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
    <AuthLayout :title="$t('words.myCertifications')">
        <template #main>
            <div class="flex flex-col sm:flex-row">
                <!-- Sidebard Menu -->
                <SidebarMenu class="sm:w-5/12 md:w-2/6 lg:w-3/12 w-full sm:m-0 mx-auto"/>

                <!-- Page Content -->
                <div class="sm:w-7/12 md:w-4/6 lg:w-9/12 w-full px-5 sm:mt-0 mt-2">
                    <div class="font-bold text-lg">{{ $t('words.myCertifications') }}</div>

                    <!-- Certifications Add Form -->
                    <div class="mt-5 border rounded px-5 py-3">
                        <div class="flex justify-between items-center">
                            <div>{{ $t('words.newCertificate') }}</div>
                            <Button type="button" @click="toggleNewCertificateForm" v-if="!newCertificateFormShow">{{ $t('words.new') }}</Button>
                            <Button type="button" @click="toggleNewCertificateForm" v-else>{{ $t('words.close') }}</Button>
                        </div>
                        <div class="mt-2 border rounded p-5" v-if="newCertificateFormShow">
                            <form @submit.prevent="submitAdd">
                                <div class="space-y-5">
                                    <div>
                                        <Label :value="$t('words.name')" for="certified_name" required />
                                        <Input id="certified_name" type="text" class="mt-1 block w-full" required autofocus :placeholder="$t('words.name')" max-length="255" v-model="newCertificationForm.name" />
                                        <InputError class="mt-2" :message="newCertificationForm.errors.name" />
                                    </div>
                                    <div>
                                        <Label :value="$t('words.description')" for="certified_description" />
                                        <Input id="certified_description" type="text" class="mt-1 block w-full" :placeholder="$t('words.description')" max-length="1024" v-model="newCertificationForm.description" />
                                        <InputError class="mt-2" :message="newCertificationForm.errors.description" />
                                    </div>
                                    <div>
                                        <Label :value="$t('words.certifiedCredential')" for="certified_credential" />
                                        <Input id="certified_credential" type="text" class="mt-1 block w-full" :placeholder="$t('words.certifiedCredential')" max-length="100" v-model="newCertificationForm.certified_uuid" />
                                        <InputError class="mt-2" :message="newCertificationForm.errors.certified_uuid" />
                                    </div>
                                    <div>
                                        <Label :value="$t('words.certifiedLink')" for="certified_link" />
                                        <Input id="certified_link" type="text" class="mt-1 block w-full" :placeholder="$t('words.certifiedLink')" max-length="255" v-model="newCertificationForm.certified_link" />
                                        <InputError class="mt-2" :message="newCertificationForm.errors.certified_link" />
                                    </div>

                                    <div class="flex align-items-end">
                                        <Button class="ml-auto" :disabled="isProcessingForms">{{ $t('words.register') }}</Button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <!-- Specialties Remove Form Messages -->
                    <InputError :message="deleteForm.errors.certification" class="my-2" />
                    <div v-if="deleteStatus" class="my-2 font-medium text-sm text-green-600">
                        {{ $t('messages.certification.delete.success') }}
                    </div>

                    <!-- Specialties List && Remove Form -->
                    <template v-if="certifications.length">
                        <div class="mt-5 border rounded">
                            <div class="px-5 py-3 border-b">
                                <div class="flex justify-between items-center">
                                    <div class="flex">
                                        <span class="w-40" :title="$t('words.certificationName')">{{ $t('words.certificationName') }}</span>
                                        <span class="ml-5" :title="`${$t('words.certificationIdentificator')}/URL`">{{ `${$t('words.certificationIdentificator')}/URL` }}</span>
                                    </div>
                                    <span class="w-24">{{ $t('words.action') }}</span>
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
                                    <Button class="w-24" @click="submitDelete(certification.uuid)" :disabled="isProcessingForms">{{ $t('words.delete') }}</Button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="mt-5 border rounded p-5">
                            <div>
                                <span>{{ $t('words.noData') }}</span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
