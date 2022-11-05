<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/reactivity';
import AuthLayout from '../../../../../Layouts/AuthLayout.vue';
import Button from '../../../../../Components/Button.vue';
import InputError from '../../../../../Components/InputError.vue';
import Input from '../../../../../Components/Input.vue';
import Label from '../../../../../Components/Label.vue';
import Checkbox from '../../../../../Components/Checkbox.vue';
import BadgeGroup from '../../../../../Components/Badges/BadgeGroup.vue';
import InputCurrency from '../../../../../Components/InputCurrency.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';

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
    description: '',
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
    newWorkForm.post(route('user.profile.worker.my-works.store'), {
        preserveScroll: true,
        onSuccess: () => resetCertificationForm()
    });
}

function submitDelete(work) {
    deleteForm.work = work;
    deleteForm.delete(route('user.profile.worker.my-works.destroy'), {
        preserveScroll: true,
        onFinish: () => resetCertificationDeleteForm()
    });
}

function resetCertificationDeleteForm() {
    deleteForm.reset();
    newWorkForm.clearErrors();
}

function resetCertificationForm() {
    newWorkForm.reset();
    deleteForm.clearErrors()
    newWorkFormShow.value = false;
}

let newWorkFormShow = ref(false);
function toggleNewCertificateForm() {
    newWorkFormShow.value = !newWorkFormShow.value;
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
            <div class="flex flex-col sm:flex-row">
                <!-- Sidebard Menu -->
                <SidebarMenu class="sm:w-5/12 md:w-2/6 lg:w-3/12 w-full sm:m-0 mx-auto"/>

                <!-- Page Content -->
                <div class="sm:w-7/12 md:w-4/6 lg:w-9/12 w-full px-5 sm:mt-0 mt-2">
                    <div class="font-bold text-lg">My works</div>

                    <!-- Work Add Form -->
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
                                            placeholder="Name" max-length="255" v-model="newWorkForm.name" />
                                        <InputError class="mt-1" :message="newWorkForm.errors.name" />
                                    </div>
                                    <div>
                                        <Label value="Description" for="workDescription" :optional="true" />
                                        <textarea id="workDescription" class="w-full max-h-60"
                                            placeholder="Max characters: 512" max-length="512"
                                            v-model="newWorkForm.description"
                                        ></textarea>
                                        <em class="text-sm text-gray-500">Max characters: 512</em>
                                        <InputError class="mt-1" :message="newWorkForm.errors.description" />
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
                                        <BadgeGroup class="mt-2 max-h-32 overflow-y-auto" :removable="true" :badges="newWorkForm.specialtiesList" @remove="removeSelectedSpecialty($event.badgeId)"/>
                                    </div>
                                    <div>
                                        <Label value="Time" for="workTime" :optional="true" />
                                        <Input id="workTime" type="time" class="mt-1 block w-full" v-model="newWorkForm.time" />
                                        <InputError class="mt-1" :message="newWorkForm.errors.time" />
                                    </div>
                                    <div>
                                        <Label value="Price" for="workPrice" :optional="true" />
                                        <InputCurrency id="workPrice" class="mt-1 block w-full" v-model="newWorkForm.price" />
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
                    <div class="mt-5 border rounded w-full overflow-x-auto" v-if="works.length">
                        <div class="min-w-xl">
                            <div class="grid grid-flow-col grid-cols-12 gap-2 px-5 py-3 border-b">
                                <span class="col-span-2 font-bold" title="{{ $t('words.name') }}">{{ $t('words.name') }}</span>
                                <span class="col-span-2 font-bold" title="{{ $t('words.slug') }}">{{ $t('words.slug') }}</span>
                                <span class="col-span-3 font-bold" title="{{ $t('words.specialties') }}">{{ $t('words.specialties') }}</span>
                                <span class="col-span-1 font-bold" title="{{ $t('words.unity') }}">{{ $t('words.unity') }}</span>
                                <span class="col-span-1 font-bold" title="{{ $t('words.time') }}">{{ $t('words.time') }}</span>
                                <span class="col-span-2 font-bold" title="{{ $t('words.price') }}">{{ $t('words.price') }}</span>
                                <span class="col-span-1 font-bold" title="{{ $t('words.action') }}">{{ $t('words.action') }}</span>
                            </div>
                            <div class="grid grid-flow-col grid-cols-12 gap-2 px-5 py-3 h-20 hover:bg-gray-300 border-b last:border-none"
                                v-for="(work) in works"
                            >
                                <div class="col-span-2 flex items-center overflow-y-auto">
                                    <span class="min-w-fit break-words text-ellipsis" :title="work.name">{{ work.name }}</span>
                                </div>
                                <div class="col-span-2 flex items-center overflow-y-auto">
                                    <span class="min-w-fit break-words text-ellipsis" :title="work.slug">{{ work.slug }}</span>
                                </div>
                                <div class="col-span-3 overflow-y-auto">
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
                                <div class="col-span-1 flex items-center overflow-y-auto">
                                    <Button :title="$t('words.delete')" @click="submitDelete(work.uuid)" :disabled="isProcessingForms">
                                        {{ $t('words.delete') }}
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
