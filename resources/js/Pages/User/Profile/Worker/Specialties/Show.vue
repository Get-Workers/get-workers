<script setup>
import AuthLayout from '../../../../../Layouts/AuthLayout.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';
import Button from '../../../../../Components/Button.vue';
import { useForm } from '@inertiajs/inertia-vue3';

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
    });
}

function submitDelete(specialty) {
    deleteForm.specialty = specialty;
    deleteForm.post(route('user.profile.worker.specialties.destroy'), {
        preserveScroll: true,
    });
}


</script>

<template>
    <AuthLayout title="Specialties">
        <template #main>
            <div class="flex">
                <!-- Sidebard Menu -->
                <SidebarMenu class="flex flex-col h-fit w-64 md:w-96"/>

                <!-- Page Content -->
                <div class="ml-5 w-full px-5">
                    <div class="font-bold text-lg">My specialities</div>
                    <div class="mt-5 border rounded px-5 py-3 space-y-2">
                        <form @submit.prevent="submitAdd">
                            <div class="flex">
                                <select name="" id="" class="w-full h-10 rounded" v-model="addForm.specialty">
                                    <option value="" selected>Select.</option>
                                    <option v-for="(specialty) in specialties" :value="specialty.id" >{{ specialty.name }}</option>
                                </select>

                                <Button class="ml-5">Add</Button>
                            </div>
                        </form>


                        <!-- List -->
                        <div class="mt-10">
                            <div v-for="(specialty, index) in userSpecialties" class="px-5 pb-2 mt-2 border-b">
                                <div class="flex justify-between items-center">
                                    <span>{{ specialty.name }}</span>
                                    <Button @click="submitDelete(specialty.id)">Delete</Button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
