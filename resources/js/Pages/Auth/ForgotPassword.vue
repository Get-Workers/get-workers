<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '../../Components/AuthenticationCard.vue';
import Button from '../../Components/Button.vue';
import Input from '../../Components/Input.vue';
import InputError from '../../Components/InputError.vue';
import Label from '../../Components/Label.vue';
import GuestLayout from '../../Layouts/GuestLayout.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout title="Forgot Password">
        <template #main>
            <!-- Forgot Password -->
            <AuthenticationCard class="mt-2">
                <div class="mb-4 text-sm text-gray-600">
                    {{ $t('messages.forgotPassword') }}
                </div>

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <div class="mt-2">
                    <form @submit.prevent="submit">
                        <div>
                            <Label for="email" :value="$t('words.email')" />
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                :placeholder="$t('words.email')"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <Button class="mx-auto w-full text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{ $t('questions.password.reset') }}
                            </Button>
                        </div>
                    </form>
                </div>
            </AuthenticationCard>
        </template>
    </GuestLayout>
</template>
