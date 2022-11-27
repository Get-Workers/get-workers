<script setup>
import { onMounted, ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/reactivity';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import Button from '@/Components/Button.vue';
import ButtonCancel from '@/Components/ButtonCancel.vue';
import StarRating from '@/Components/Ratings/StarRating.vue';
import BadgeGroup from '@/Components/Badges/BadgeGroup.vue';

const props = defineProps({
    search: String,
    stars: Number,
    selectedSpecialties: {
        type: Array,
        default: []
    },
    specialties: {
        type: Array,
        default: []
    },
});

const nonSelectedSpecialties = computed(() => (props.specialties.filter((specialty) => !formFilter.specialties.includes(specialty.id))));

const specialtiesSelect = ref(null);
function selectSpecialty() {
    let item = specialtiesSelect.value;
    specialtiesSelect.value = null;
    if ((item === null) || (formFilter.specialties.includes(item.id))) {
        return;
    }
    formFilter.specialties.push(item.id);
    formFilter.specialtiesList.push(item);
}

function removeSelectedSpecialty(specialtyId) {
    formFilter.specialties = formFilter.specialties.filter((specialty) => (specialty !== specialtyId));
    formFilter.specialtiesList = formFilter.specialtiesList.filter((specialty) => (specialty.id !== specialtyId));
}

const formFilter = useForm({
    search: '',
    stars: 0,
    specialties: [],
    specialtiesList: [],
});

function prepareFilters() {
    formFilter.search = props.search;
    formFilter.stars = props.stars;
    formFilter.specialties = props.selectedSpecialties.map((specialty) => specialty.id);
    formFilter.specialtiesList = props.selectedSpecialties;
}

onMounted(() => {
    prepareFilters();
});
</script>

<template>
    <div>
        <form method="GET" @reset="formFilter.reset()">
            <div class="grid gap-2 grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
                <div>
                    <Label for="search" :value="$t('words.work')" />
                    <Input class="mt-1 w-full" type="text" id="search" name="search" v-model="formFilter.search" />
                </div>

                <div>
                    <Label for="stars" :value="$t('phrases.minRating')" />
                    <div class="mt-1 flex space-x-2">
                        <StarRating v-model="formFilter.stars" />
                        <Button type="button" @click="formFilter.reset('stars')">{{ $t('words.reset') }}</Button>
                        <input type="hidden" name="stars" v-model="formFilter.stars" />
                    </div>
                </div>

                <template v-if="specialties.length">
                    <div class="col-span-1 md:col-span-2 xl:col-span-3">
                        <Label :value="$t('words.specialties')" for="SpecialtySelect" />

                        <div class="mt-1">
                            <input type="hidden" name="specialties" v-model="formFilter.specialties" />
                            <select
                                id="SpecialtySelect"
                                class="w-full h-10 rounded"
                                v-model="specialtiesSelect" @change="selectSpecialty"
                            >
                                <option class="text-gray-400" :value="null" selected default>
                                    {{$t('words.select')}}
                                </option>
                                <option v-for="specialty in nonSelectedSpecialties" :value="specialty">
                                    {{ $t(`specialties.${specialty.name}`) }}
                                </option>
                            </select>
                            <BadgeGroup
                                class="mt-2 max-h-20 overflow-y-auto border rounded p-3"
                                :removable="true"
                                :badges="formFilter.specialtiesList.map((specialty) => {
                                    return {
                                        ...specialty,
                                        name: $t(`specialties.${specialty.name}`)
                                    };
                                })"
                                @remove="removeSelectedSpecialty($event.badgeId)"
                            />
                        </div>

                    </div>
                </template>
            </div>

            <div class="mt-2 flex justify-end space-x-2">
                <Button>{{ $tc('phrases.applyFilter', 2) }}</Button>
                <ButtonCancel type="reset">{{ $tc('words.reset') }}</ButtonCancel>
            </div>
        </form>
    </div>
</template>
