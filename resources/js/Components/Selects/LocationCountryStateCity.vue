<script setup>
import { onBeforeMount, ref } from 'vue';
import Label from '@/Components/Label.vue';
import axios from 'axios';

const props = defineProps({
    modelValue: Number, // City ID
    disabled: {
        type: Boolean,
        default: false
    },
    city: Object,
    defaultCountry: {
        type: Number,
        default: 1,
    },
});

const countries = ref([]);
const states = ref([]);
const cities = ref([]);

const selectedCountry = ref(props.city?.state?.country?.id ?? props.defaultCountry);
const selectedState = ref(props.city?.state?.id ?? null);

const emits = defineEmits(['update:modelValue']);

onBeforeMount(() => {
    updateCountries();
});

function clearCountries() {
    if (!countries.value.length) return;
    countries.value = [];
    clearStates();
}

function clearStates() {
    if (!states.value.length) return;
    selectedState.value = null;
    states.value = [];
    clearCities();
}

function clearCities() {
    if (!cities.value.length) return;
    cities.value = [];
}

function updateCountries() {
    clearCountries();
    axios.get('/api/countries')
        .then((response) => {
            countries.value = response.data.countries;

            updateStates();
        })
        .catch((err) => {
            clearCountries();
        });

    if (selectedState.value) {
        updateStates();
    }
}

function updateStates() {
    clearStates();
    axios.get(`/api/countries/${selectedCountry.value}/states`)
        .then((response) => {
            states.value = response.data.states;
        })
        .catch((err) => {
            clearStates();
        });

    if (selectedState.value) {
        updateCities();
    }
}

function updateCities() {
    clearCities();
    emits('update:modelValue', null);
    axios.get(`/api/states/${selectedState.value}/cities`)
        .then((response) => {
            cities.value = response.data.cities;
        })
        .catch((err) => {
            clearCities();
        });
}
</script>

<template>
    <div>
        <div class="grid gap-2">
            <div>
                <Label for="country" :value="$t('words.country')" :info="$t('words.country')" />
                <select class="w-full" id="country" :disabled="disabled" v-model="selectedCountry" @change="updateStates">
                    <option :value="null" disabled>{{ $t('words.state') }}</option>

                    <template v-if="countries.length">
                        <option v-for="country in countries" :key="`option-country-${country.id}`" :value="country.id">{{ country.name }}</option>
                    </template>
                </select>
            </div>
            <div>
                <Label for="state" :value="$t('words.state')" :info="$t('words.state')" />
                <select class="w-full" id="state" :disabled="(disabled || (!states.length))" v-model="selectedState" @change="updateCities">
                    <option :value="null" disabled>{{ $t('words.state') }}</option>

                    <template v-if="states.length">
                        <option v-for="state in states" :key="`option-city-${state.id}`" :value="state.id">{{ `${state.name} - ${state.uf}` }}</option>
                    </template>
                </select>
            </div>
            <div>
                <Label for="city" :value="$t('words.city')" :info="$t('words.city')" />
                <select class="w-full" id="city" :disabled="(disabled || (!cities.length))" @change="$emit('update:modelValue', Number($event.target.value))" :value="(modelValue ?? city.id)">
                    <option :value="null" disabled>{{ $t('words.city') }}</option>

                    <template v-if="cities.length">
                        <option v-for="city in cities" :key="`option-city-${city.id}`" :value="city.id">{{ city.name }}</option>
                    </template>
                </select>
            </div>
        </div>

    </div>
</template>
