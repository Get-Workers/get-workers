<script setup>
import AuthLayout from '../../../../../Layouts/AuthLayout.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';
import Button from '../../../../../Components/Button.vue';
import InputError from '../../../../../Components/InputError.vue';
import Label from '../../../../../Components/Label.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/reactivity';

defineProps({
    specialties: {
        type: Array,
        required: true,
        default: []
    },
    userSpecialties: {
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
})

const addForm = useForm({
    specialty: {
        type: String,
        default: null,
    },
});

const deleteForm = useForm({
    specialty: {
        type: String,
        default: null,
    },
});

function submitAdd() {
    addForm.post(route('user.profile.worker.specialties.store'), {
        preserveScroll: true,
        onFinish: () => clearForms(),
    });
}

function submitDelete(specialty) {
    deleteForm.specialty = specialty;
    deleteForm.delete(route('user.profile.worker.specialties.destroy'), {
        preserveScroll: true,
        onFinish: () => clearForms(),
    });
}

function clearForms() {
    clearErrors();
    addForm.reset();
    deleteForm.reset();
}

function clearErrors() {
    addForm.clearErrors();
    deleteForm.clearErrors();
}

const isProcessingForms = computed(() => (deleteForm.processing || addForm.processing));
</script>

<template>
    <AuthLayout title="Specialties">
        <template #main>
            <div class="flex flex-col sm:flex-row">
                <!-- Sidebard Menu -->
                <SidebarMenu class="sm:w-5/12 md:w-2/6 lg:w-3/12 w-full sm:m-0 mx-auto"/>

                <!-- Page Content -->
                <div class="sm:w-7/12 md:w-4/6 lg:w-9/12 w-full px-5 sm:mt-0 mt-2">
                    <div class="font-bold text-lg">{{ $t('words.mySpecialties') }}</div>

                    <!-- Specialties Add Form -->
                    <div class="mt-5 border rounded px-5 py-3">
                        <form @submit.prevent="submitAdd">
                            <Label value="Specialties" for="specialtiesSelect" />
                            <div class="flex mt-2">
                                <select id="specialtiesSelect" class="w-full h-10 rounded" v-model="addForm.specialty">
                                    <option value="" class="text-gray-400" selected disabled default>Select...</option>
                                    <option v-for="specialty in specialties" :value="specialty.id" >{{ specialty.name }}</option>
                                </select>

                                <Button class="ml-5" :disabled="isProcessingForms">Add</Button>
                            </div>

                            <!-- Specialties Add Form Messages -->
                            <InputError :message="addForm.errors.specialty" class="mt-2" />
                            <div v-if="storeStatus" class="mt-2 font-medium text-sm text-green-600">
                                Specialty added successfully
                            </div>

                            <!-- Specialties Remove Form Messages -->
                            <InputError :message="deleteForm.errors.specialty" class="mt-2" />
                            <div v-if="deleteStatus" class="mt-2 font-medium text-sm text-green-600">
                                Specialty removed successfully
                            </div>
                        </form>
                    </div>

                    <!-- Specialties List && Remove Form -->
                    <div class="mt-5 border rounded" v-if="userSpecialties.length">
                        <div v-for="(specialty, index) in userSpecialties" class="px-5 py-3 hover:bg-gray-300 border-b last:border-none">
                            <div class="flex justify-between items-center">
                                <span>{{ specialty.name }}</span>
                                <Button @click="submitDelete(specialty.id)" :disabled="isProcessingForms">Remove</Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
