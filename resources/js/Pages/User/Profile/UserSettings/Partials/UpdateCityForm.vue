<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import FormSection from '@/Components/FormSection.vue';
import Label from '@/Components/Label.vue';
import InputSuccess from '@/Components/InputSuccess.vue';
import InputError from '@/Components/InputError.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';
import LocationCountryStateCity from '@/Components/Selects/LocationCountryStateCity.vue';

const props = defineProps({
    user: Object,
})

const formCity = useForm({
    city: props.user.city_id,
});

function sendCpfForm() {
    if (! formCity.isDirty) return;

    formCity.put(route('user.profile.city'), {
        preserveScroll: true,
        onBefore() {
            formCity.clearErrors();
        },
    });
}
</script>

<template>
    <FormSection @submitted="sendCpfForm">
        <template #title>
            {{ $t('words.updateCityForm') }}
        </template>

        <template #form>
            <div class="col-span-6">
                <div class="flex mt-1 items-center">
                    <LocationCountryStateCity v-model="formCity.city" :city="user.city" />
                </div>
                <InputError class="mt-1" :message="formCity.errors.city"/>
                <InputSuccess class="mt-1" :success="formCity.wasSuccessful" :message="$t('phrases.cityUpdated')"/>
            </div>
        </template>

        <template #actions>
            <Button type="submit" class="ml-5 h-fit" :disabled="formCity.processing">{{ $t('words.update') }}</Button>
        </template>
    </FormSection>
</template>
