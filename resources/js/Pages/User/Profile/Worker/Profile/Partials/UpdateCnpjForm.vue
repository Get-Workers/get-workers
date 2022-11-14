<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import FormSection from '@/Components/FormSection.vue';
import Label from '@/Components/Label.vue';
import InputSuccess from '@/Components/InputSuccess.vue';
import InputError from '@/Components/InputError.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';

const pageProps = usePage().props;
const worker = pageProps.value.worker;

const formCnpj = useForm({
    cnpj: worker.cnpj,
});

function sendCnpjForm() {
    formCnpj.put(route('user.profile.worker.profile.cnpj'), {
        onBefore() {
            formCnpj.clearErrors();
        }
    });
}
</script>

<template>
    <FormSection @submitted="sendCnpjForm">
        <template #title>
            {{ $t('words.updateCnpjForm') }}
        </template>

        <template #form>
            <div class="col-span-6">
                <Label for="cnpj" :value="$t('words.cnpj')" :optional="true" info="teste" />
                <div class="flex mt-1 items-center">
                    <Input class="w-full" id="cnpj" type="text" required placeholder="00.000.000/0000-00"
                        maxlength="18" mask="##.###.###/####-##" v-model="formCnpj.cnpj" />
                </div>
                <InputError class="mt-1" :message="formCnpj.errors.cnpj"/>
                <InputSuccess class="mt-1" :success="formCnpj.wasSuccessful" :message="$t('phrases.cnpjUpdated')"/>
            </div>
        </template>

        <template #actions>
            <Button type="submit" class="ml-5 h-fit" :disabled="formCnpj.processing">{{ $t('words.update') }}</Button>
        </template>
    </FormSection>
</template>
