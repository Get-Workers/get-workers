<script setup>
import { nextTick, ref } from 'vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import Button from '@/Components/Button.vue';
import Input from '@/Components/Input.vue';
import InputError from '@/Components/InputError.vue';
import Label from '@/Components/Label.vue';
import Logo from '@/Components/Logos/Logo.vue';

const recovery = ref(false);

const form = useForm({
    code: '',
    recovery_code: '',
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);

const toggleRecovery = async () => {
    recovery.value ^= true;

    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = '';
    } else {
        codeInput.value.focus();
        form.recovery_code = '';
    }
};

const submit = () => {
    form.post(route('two-factor.login'));
};
</script>

<template>
    <Head :title="$t('words.twoFactorConfirmation')" />

    <AuthenticationCard>
        <template #logo>
            <Logo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            <template v-if="! recovery">
                {{ $t('phrases.pleaseConfirmAccessByAuthCodeOnAuthenticator') }}
            </template>

            <template v-else>
                {{ $t('phrases.pleaseConfirmAccessByOneOfEmergencyCodes') }}
            </template>
        </div>

        <form @submit.prevent="submit">
            <div v-if="! recovery">
                <Label for="code" :value="$t('words.code')" />
                <Input
                    id="code"
                    ref="codeInput"
                    v-model="form.code"
                    type="text"
                    inputmode="numeric"
                    class="mt-1 block w-full"
                    autofocus
                    autocomplete="one-time-code"
                    :placeholder="$t('words.code')"
                />
                <InputError class="mt-2" :message="form.errors.code" />
            </div>

            <div v-else>
                <Label for="recovery_code" :value="$t('words.recoveryCode')" />
                <Input
                    id="recovery_code"
                    ref="recoveryCodeInput"
                    v-model="form.recovery_code"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="one-time-code"
                    :placeholder="$t('words.recoveryCode')"
                />
                <InputError class="mt-2" :message="form.errors.recovery_code" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer" @click.prevent="toggleRecovery">
                    <template v-if="! recovery">
                        {{ $t('phrases.useRecoveryCode') }}
                    </template>

                    <template v-else>
                        {{ $t('phrases.useAuthenticationCode') }}
                    </template>
                </button>

                <Button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ $t('words.login') }}
                </Button>
            </div>
        </form>
    </AuthenticationCard>
</template>
