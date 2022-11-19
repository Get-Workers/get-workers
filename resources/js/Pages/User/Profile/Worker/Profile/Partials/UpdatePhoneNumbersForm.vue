<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import FormSection from '@/Components/FormSection.vue';
import Label from '@/Components/Label.vue';
import InputSuccess from '@/Components/InputSuccess.vue';
import InputError from '@/Components/InputError.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';

const props = defineProps({phoneNumbers: Array});

const formPhones = useForm({
    phoneNumbers: props.phoneNumbers ?? [],
});

function sendPhoneNumbersForm() {
    if (! formPhones.isDirty) return;

    formPhones.put(route('user.profile.worker.profile.phone-numbers'), {
        onBefore() {
            formPhones.clearErrors();
        }
    });
}

function addNumber() {
    if (formPhones.phoneNumbers.length >= 3) return;
    formPhones.clearErrors();

    return formPhones.phoneNumbers.push({
        validated: null,
        phone_number: {
            number: '',
            created_at: null
        }
    });
}

function removeNumber(index) {
    formPhones.clearErrors();
    return formPhones.phoneNumbers.splice(index, 1);
}
</script>

<template>
    <FormSection @submitted="sendPhoneNumbersForm">
        <template #title>
            {{ $t('words.updatePhonesForm') }}
        </template>

        <template #form>
            <div class="col-span-6">
                <Label for="phoneNumbers" :value="$t('words.phoneNumbers')" :required="true" :info="$t('words.phoneNumbers')" />

                <div class="mt-2 flex justify-end">
                    <Button type="button" @click="addNumber">{{ $t('words.addMore') }}</Button>
                </div>

                <div class="mt-2 space-y-4 max-h-80 overflow-y-auto p-2">
                    <template v-for="(number, index) in formPhones.phoneNumbers" :key="`phone-number-${index}`">
                        <div class="flex items-center">
                            <Input class="w-full" type="tel" placeholder="(48) 99999-9999" required maxlength="15"
                                mask="(##) #####-####" v-model="formPhones.phoneNumbers[index].phone_number.number" />
                            <Button class="ml-2 px-2 h-fit" type="button" @click="removeNumber(index)">{{ $t('words.remove') }}</Button>
                        </div>
                        <InputError class="mt-1" :message="formPhones.errors[`phoneNumbers.${index}.phone_number.number`]"/>

                        <!-- <div class="mt-1" v-if="formPhones.phoneNumbers[index].created_at && formPhones.phoneNumbers[index].validated"> -->
                            <!-- <Input class="w-20 text-sm" type="tel" placeholder="X-X-X-X" maxlength="7" required -->
                                <!-- mask="#-#-#-#" /> -->
                        <!-- </div> -->
                    </template>
                </div>

                <InputError class="mt-1" :message="formPhones.errors.phoneNumbers"/>
                <InputSuccess class="mt-1" :success="formPhones.wasSuccessful" :message="$t('phrases.phonesUpdated')"/>
            </div>
        </template>

        <template #actions>
            <Button type="submit" class="ml-5 h-fit" :disabled="formPhones.processing">{{ $t('words.update') }}</Button>
        </template>
    </FormSection>
</template>
