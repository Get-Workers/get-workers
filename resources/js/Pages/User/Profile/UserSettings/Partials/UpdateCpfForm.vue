<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import FormSection from '@/Components/FormSection.vue';
import Label from '@/Components/Label.vue';
import InputSuccess from '@/Components/InputSuccess.vue';
import InputError from '@/Components/InputError.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';

const props = defineProps({
    user: Object,
})

const formCpf = useForm({
    cpf: props.user.cpf,
});

function sendCpfForm() {
    if (! formCpf.isDirty) return;

    formCpf.put(route('user.profile.cpf'), {
        preserveScroll: true,
        onBefore() {
            formCpf.clearErrors();
        },
    });
}
</script>

<template>
    <FormSection @submitted="sendCpfForm">
        <template #title>
            {{ $t('words.updateCpfForm') }}
        </template>

        <template #form>
            <div class="col-span-6">
                <Label for="cpf" :value="$t('words.cpf')" :required="true" :info="$t('words.cpf')" />
                <div class="flex mt-1 items-center">
                    <Input class="w-full" id="cpf" type="text" required placeholder="000.000.000-00"
                        maxlength="18" mask="###.###.###-##" v-model="formCpf.cpf" />
                </div>
                <InputError class="mt-1" :message="formCpf.errors.cpf"/>
                <InputSuccess class="mt-1" :success="formCpf.wasSuccessful" :message="$t('phrases.cpfUpdated')"/>
            </div>
        </template>

        <template #actions>
            <Button type="submit" class="ml-5 h-fit" :disabled="formCpf.processing">{{ $t('words.update') }}</Button>
        </template>
    </FormSection>
</template>
