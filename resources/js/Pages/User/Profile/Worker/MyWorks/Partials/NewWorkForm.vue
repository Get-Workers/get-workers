<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/reactivity';
import Button from '@/Components/Button.vue';
import ButtonCancel from '@/Components/ButtonCancel.vue';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputCurrency from '@/Components/InputCurrency.vue';
import InputError from '@/Components/InputError.vue';
import InputSuccess from '@/Components/InputSuccess.vue';
import BadgeGroup from '@/Components/Badges/BadgeGroup.vue';

const props = defineProps({
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
    workToUpdate: Object,
});

const emits = defineEmits(['reset']);

const newWorkForm = useForm({
    id: props.workToUpdate?.id ?? null,
    name:  props.workToUpdate?.name ?? '',
    description: props.workToUpdate?.description ?? '',
    time: props.workToUpdate?.time ?? null,
    price: props.workToUpdate?.price ?? 0,
    unity_id: props.workToUpdate?.unity_id ?? null,
    has_unity: props.workToUpdate?.unity_id ? true : false,
    specialties: props.workToUpdate?.specialties.map((specialty) => specialty.id) ?? [],
    specialtiesList: props.workToUpdate?.specialties ?? [],
});

function submitAdd() {
    let options = {
        preserveScroll: true,
        onSuccess: () => newWorkForm.reset() && emits('reset'),
        onBefore: () => newWorkForm.clearErrors(),
    };

    if (props.workToUpdate) {
        newWorkForm.put(route('user.profile.worker.my-works.update'), options);
        return;
    }

    newWorkForm.post(route('user.profile.worker.my-works.store'), options);
}

const nonSelectedSpecialties = computed(() => (props.specialties.filter((specialty) => !newWorkForm.specialties.includes(specialty.id))));

const specialtiesSelect = ref(null);
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
</script>

<template>
    <div>
        <form @submit.prevent="submitAdd" @reset.prevent="emits('reset')">
            <div class="space-y-5">
                <div>
                    <Label :value="$t('words.name')" for="workName" :required="true" />
                    <Input id="workName" type="text" class="mt-1 block w-full" required autofocus
                        :placeholder="$t('words.name')" max-length="255" v-model="newWorkForm.name"/>
                    <InputError class="mt-1" :message="newWorkForm.errors.name" />
                </div>
                <div>
                    <Label :value="$t('words.description')" for="workDescription" :optional="true" />
                    <textarea id="workDescription" class="w-full max-h-60"
                        :placeholder="`${$t('words.maxChars')}: 512`" max-length="512"
                        v-model="newWorkForm.description"
                    ></textarea>
                    <em class="text-sm text-gray-500">{{ $t('words.maxChars') }}: 512</em>
                    <InputError class="mt-1" :message="newWorkForm.errors.description" />
                </div>
                <div>
                    <label for="hasUnity" class="flex w-fit">
                        <Checkbox id="hasUnity" class="mr-2" v-model:checked="newWorkForm.has_unity" />
                        <Label for="hasUnity" value="" :optional="true">
                            <span>{{ $t('questions.work.hasUnity') }}</span>
                            <em class="ml-1 text-gray-500">({{ $t('messages.priceMeasurement') }})</em>
                        </Label>
                    </label>
                </div>
                <div v-if="newWorkForm.has_unity">
                    <Label :value="$t('words.unity')" for="Unity" :required="true" />
                    <select id="Unity" class="w-full mt-1 h-10 rounded"
                        v-model="newWorkForm.unity_id">
                        <option class="text-gray-400" :value="null" selected default>{{$t('words.select')}}
                        </option>
                        <option v-for="unity in unities" :value="unity.id">{{ unity.name }}</option>
                    </select>
                    <InputError class="mt-1" :message="newWorkForm.errors.unity_id" />
                </div>
                <div>
                    <Label :value="$t('words.specialties')" for="SpecialtySelect" :optional="true" />
                    <select id="SpecialtySelect" class="w-full mt-1 h-10 rounded"
                        v-model="specialtiesSelect" @change="selectSpecialty">
                        <option class="text-gray-400" :value="null" selected default>
                            {{$t('words.select')}}
                        </option>
                        <option v-for="specialty in nonSelectedSpecialties" :value="specialty">
                            {{ specialty.name }}
                        </option>
                    </select>
                    <InputError class="mt-1" :message="newWorkForm.errors.specialties" />
                    <BadgeGroup class="mt-2 max-h-32 overflow-y-auto" :removable="true" :badges="newWorkForm.specialtiesList" @remove="removeSelectedSpecialty($event.badgeId)"/>
                </div>
                <div>
                    <Label :value="$t('words.time')" for="workTime" :optional="true" />
                    <Input id="workTime" type="time" class="mt-1 block w-full" v-model="newWorkForm.time" />
                    <InputError class="mt-1" :message="newWorkForm.errors.time" />
                </div>
                <div>
                    <Label :value="$t('words.price')" for="workPrice" :optional="true" />
                    <InputCurrency id="workPrice" class="mt-1 block w-full" v-model="newWorkForm.price" />
                    <InputError class="mt-1" :message="newWorkForm.errors.price" />
                </div>
                <div class="flex align-items-end">
                    <div class="ml-auto">
                        <ButtonCancel type="reset" :disabled="newWorkForm.processing" v-if="workToUpdate">{{ $t('words.cancel') }}</ButtonCancel>
                        <Button class="ml-2" :disabled="newWorkForm.processing">{{ workToUpdate ? $t('words.update') : $t('words.register') }}</Button>
                    </div>
                </div>
            </div>

            <div>
                <InputSuccess class="my-2" :success="newWorkForm.wasSuccessful" :message="$t('messages.work.store.success')" />
            </div>
        </form>
    </div>
</template>
