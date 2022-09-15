<script setup>
import AuthLayout from '../../../../../Layouts/AuthLayout.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';
import Button from '../../../../../Components/Button.vue';
import InputError from '../../../../../Components/InputError.vue';
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
    specialty: '',
});

const deleteForm = useForm({
    specialty: '',
});

function submitAdd() {
    addForm.post(route('user.profile.worker.specialties.store'), {
        preserveScroll: true,
        onFinish: () => addForm.specialty = '',
    });
}

function submitDelete(specialty) {
    deleteForm.specialty = specialty;
    deleteForm.post(route('user.profile.worker.specialties.destroy'), {
        preserveScroll: true,
        onFinish: () => deleteForm.specialty = '',
    });
}

const isProcessingForms = computed(() => (deleteForm.processing || addForm.processing));
</script>

<template>
    <AuthLayout title="Specialties">
        <template #main>
            <div class="flex">
                <!-- Sidebard Menu -->
                <SidebarMenu class="flex flex-col min-h-fit w-64 md:w-96"/>

                <!-- Page Content -->
                <div class="ml-5 w-full px-5">
                    <div class="font-bold text-lg">My specialities</div>

                    <!-- Specialties Add Form -->
                    <div class="mt-5 border rounded px-5 py-3">
                        <form @submit.prevent="submitAdd">
                            <div class="flex">
                                <select name="" id="" class="w-full h-10 rounded" v-model="addForm.specialty">
                                    <option value="" selected>specialties</option>
                                    <option v-for="(specialty) in specialties" :value="specialty.id" >{{ specialty.name }}</option>
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
                        <div v-for="(specialty, index) in userSpecialties" class="px-5 py-3 hover:bg-gray-300" :class="{ 'border-b': ((index + 1) !== userSpecialties.length)}">
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
