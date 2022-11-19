<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import FormSection from '@/Components/FormSection.vue';
import Label from '@/Components/Label.vue';
import InputSuccess from '@/Components/InputSuccess.vue';
import InputError from '@/Components/InputError.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';

const props = defineProps({
    user: Object,
})

const formPhoneNumber = useForm({
    phoneNumber: props.user.phone_number,
});

function sendCpfForm() {
    if (! formPhoneNumber.isDirty) return;

    formPhoneNumber.put(route('user.profile.phone-number'), {
        preserveScroll: true,
        onBefore() {
            formPhoneNumber.clearErrors();
        },
    });
}
</script>

<template>
    <FormSection @submitted="sendCpfForm">
        <template #title>
            {{ $t('words.updatePhoneNumberForm') }}
        </template>

        <template #form>
            <div class="col-span-6">
                <Label for="phoneNumber" :value="$t('words.phoneNumber')" :required="true" :info="$t('words.phoneNumber')" />
                <div class="flex mt-1 items-center">
                    <Input class="w-full" id="phoneNumber" type="text" required placeholder="(99) 99999-9999"
                        maxlength="15" mask="(##) #####-####" v-model="formPhoneNumber.phoneNumber" />

                        <!-- <div class="mt-1" v-if="formPhones.phoneNumbers[index].created_at && formPhones.phoneNumbers[index].validated"> -->
                            <!-- <Input class="w-20 text-sm" type="tel" placeholder="X-X-X-X" maxlength="7" required -->
                                <!-- mask="#-#-#-#" /> -->
                        <!-- </div> -->
                </div>
                <InputError class="mt-1" :message="formPhoneNumber.errors.phoneNumber"/>
                <InputSuccess class="mt-1" :success="formPhoneNumber.wasSuccessful" :message="$t('phrases.phoneNumberUpdated')"/>
            </div>
        </template>

        <template #actions>
            <Button type="submit" class="ml-5 h-fit" :disabled="formPhoneNumber.processing">{{ $t('words.update') }}</Button>
        </template>
    </FormSection>
</template>
