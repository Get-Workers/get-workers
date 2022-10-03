<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/reactivity';
import AuthLayout from '../../../../Layouts/AuthLayout.vue';
import Button from '../../../../Components/Button.vue';
import InputError from '../../../../Components/InputError.vue';
import Input from '../../../../Components/Input.vue';
import Label from '../../../../Components/Label.vue';
import Checkbox from '../../../../Components/Checkbox.vue';
import BadgeGroup from '../../../../Components/Badges/BadgeGroup.vue';
import InputCurrency from '../../../../Components/InputCurrency.vue';

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
    storeStatus: {
        type: Boolean,
        default: false
    },
    deleteStatus: {
        type: Boolean,
        default: false
    }
});

const nonSelectedSpecialties = computed(() => (props.specialties.filter((specialty) => !newWorkForm.specialties.includes(specialty.id))));

const newWorkForm = useForm({
    name: '',
    slug: '',
    time: null,
    price: null,
    unity_id: null,
    has_unity: false,
    specialties: [],
    specialtiesList: []
});

const deleteForm = useForm({
    work: '',
});

function submitAdd() {
    console.log('TODO');
    // newWorkForm.post(route('user.profile.worker.works.store'), {
    //     preserveScroll: true,
    //     onSuccess: () => resetCertificationForm()
    // });
}

// function submitDelete(work) {
//     deleteForm.work = work;
//     deleteForm.delete(route('user.profile.worker.works.destroy'), {
//         preserveScroll: true,
//         onFinish: () => resetCertificationDeleteForm()
//     });
// }

// function resetCertificationDeleteForm() {
//     deleteForm.reset();
//     newWorkForm.clearErrors();
// }

// function resetCertificationForm() {
//     newWorkForm.reset();
//     deleteForm.clearErrors()
//     newWorkFormShow.value = false;
// }

let newWorkFormShow = ref(false);
function toggleNewCertificateForm() {
    newWorkFormShow.value = !newWorkFormShow.value;
}

function generateWorkSlug() {
    let name = newWorkForm.name;
    name = name && name.match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g);
    name = name && name.map(s => s.toLowerCase());
    name = name && name.join('-');
    newWorkForm.slug = name;
}

let specialtiesSelect = ref(null);
function selectSpecialty() {
    let item = specialtiesSelect.value;
    specialtiesSelect.value = null;
    if ((item === null) || (newWorkForm.specialties.includes(item.id))) {
        return;
    }
    newWorkForm.specialties.push(item.id);
    newWorkForm.specialtiesList.push(item);
}

function removeSelectedSpecialty(specialtyId) {
    newWorkForm.specialties = newWorkForm.specialties.filter((specialty) => (specialty !== specialtyId));
    newWorkForm.specialtiesList = newWorkForm.specialtiesList.filter((specialty) => (specialty.id !== specialtyId));
}

const isProcessingForms = computed(() => (deleteForm.processing || newWorkForm.processing));
</script>

<template>
    <AuthLayout title="My Works">
        <template #main>
            <div class="flex">
                <!-- Page Content -->
                <div class="w-full px-5">
                    <div class="font-bold text-lg">My works</div>

                    <!-- Certifications Add Form -->
                    <div class="mt-5 border rounded px-5 py-3">
                        <div class="flex justify-between items-center">
                            <div>New work</div>
                            <Button type="button" @click="toggleNewCertificateForm"
                                v-if="! newWorkFormShow">New</Button>
                            <Button type="button" @click="toggleNewCertificateForm" v-else>Close</Button>
                        </div>
                        <div class="mt-2 border rounded p-5" v-if="newWorkFormShow">
                            <form @submit.prevent="submitAdd">
                                <div class="space-y-5">
                                    <div>
                                        <Label value="Name" for="workName" :required="true" />
                                        <Input id="workName" type="text" class="mt-1 block w-full" required autofocus
                                            placeholder="Name" max-length="255" v-model="newWorkForm.name" @update:model-value="generateWorkSlug" />
                                        <InputError class="mt-1" :message="newWorkForm.errors.name" />
                                    </div>
                                    <div>
                                        <Label value="Slug" for="workSlug" :required="true" />
                                        <Input id="workSlug" type="text" class="mt-1 block w-full" required autofocus
                                            placeholder="Slug" max-length="255" v-model="newWorkForm.slug" :disabled="true" />
                                    </div>
                                    <div>
                                        <label for="hasUnity" class="flex w-fit">
                                            <Checkbox id="hasUnity" class="mr-2" v-model:checked="newWorkForm.has_unity" />
                                            <Label for="hasUnity" value="" :optional="true">
                                                <span>Work has unity type</span>
                                                <em class="ml-1 text-gray-500">(for price measurement)</em>
                                            </Label>
                                        </label>
                                    </div>
                                    <div v-if="newWorkForm.has_unity">
                                        <Label value="Unity" for="Unity" :required="true" />
                                        <select id="Unity" class="w-full mt-1 h-10 rounded"
                                            v-model="newWorkForm.unity_id">
                                            <option class="text-gray-400" :value="null" selected default>Select...
                                            </option>
                                            <option v-for="unity in unities" :value="unity.id">{{ unity.name }}</option>
                                        </select>
                                        <InputError class="mt-1" :message="newWorkForm.errors.unity_id" />
                                    </div>
                                    <div>
                                        <Label value="Specialties" for="SpecialtySelect" :optional="true" />
                                        <select id="SpecialtySelect" class="w-full mt-1 h-10 rounded"
                                            v-model="specialtiesSelect" @change="selectSpecialty">
                                            <option class="text-gray-400" :value="null" selected default>
                                                Select...
                                            </option>
                                            <option v-for="specialty in nonSelectedSpecialties" :value="specialty">
                                                {{ specialty.name }}
                                            </option>
                                        </select>
                                        <InputError class="mt-1" :message="newWorkForm.errors.specialties" />
                                        <BadgeGroup class="mt-2" :removable="true" :badges="newWorkForm.specialtiesList" @remove="removeSelectedSpecialty($event.badgeId)"/>
                                    </div>
                                    <div>
                                        <Label value="Time" for="workTime" :optional="true" />
                                        <Input id="workTime" type="time" class="mt-1 block w-full" v-model="newWorkForm.time" />
                                        <InputError class="mt-1" :message="newWorkForm.errors.time" />
                                    </div>
                                    <div>
                                        <Label value="Price" for="workPrice" :optional="true" />
                                        <InputCurrency id="workPrice" class="mt-1 block w-full" v-model="newWorkForm.price" :options="{ currency: 'BRL' }" />
                                        <InputError class="mt-1" :message="newWorkForm.errors.price" />
                                    </div>
                                    <div class="flex align-items-end">
                                        <Button class="ml-auto" :disabled="isProcessingForms">Register</Button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Works Remove Form Messages -->
                    <InputError :message="deleteForm.errors.certification" class="my-2" />
                    <div v-if="deleteStatus" class="my-2 font-medium text-sm text-green-600">
                        Work removed successfully
                    </div>

                    <!-- Works List && Remove Form -->
                    <div class="mt-5 border rounded" v-if="works.length">
                        <div class="px-5 py-3 border-b">
                            <div class="flex justify-between items-center">
                                <div class="flex">
                                    <span class="w-40" title="Certification name">Work name</span>
                                    <span class="ml-5" title="Certification identificator/URL"></span>
                                </div>
                                <span class="w-24">Action</span>
                            </div>
                        </div>
                        <div v-for="(work, index) in works" class="px-5 py-3 hover:bg-gray-300"
                            :class="{ 'border-b': ((index + 1) !== works.length)}">
                            <div class="flex justify-between items-center">
                                <div class="flex">
                                    <span class="w-40 truncate" :title="work.name">{{ work.name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
