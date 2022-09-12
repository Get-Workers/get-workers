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
            <!-- Register -->
            <AuthenticationCard class="mt-2">
                <div class="mb-4 text-sm text-gray-600">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </div>

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>


                <div class="mt-2">
                    <form @submit.prevent="submit">
                        <div>
                            <Label for="email" value="Email" />
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                placeholder="Email"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <Button class="mx-auto w-full text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Email Password Reset Link
                            </Button>
                        </div>
                    </form>
                </div>
            </AuthenticationCard>
        </template>
    </GuestLayout>
</template>
