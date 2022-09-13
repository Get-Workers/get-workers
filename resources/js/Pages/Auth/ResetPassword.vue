<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '../../Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '../../Components/AuthenticationCardLogo.vue';
import Button from '../../Components/Button.vue';
import Input from '../../Components/Input.vue';
import InputError from '../../Components/InputError.vue';
import Label from '../../Components/Label.vue';
import GuestLayout from '../../Layouts/GuestLayout.vue';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout title="Reset Password">
        <template #main>
            <!-- Reset Password -->
            <AuthenticationCard>
                <form @submit.prevent="submit">
                    <div class="space-y-2">
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

                        <div>
                            <Label for="password" value="Password" />
                            <Input
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                                placeholder="Password"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div>
                            <Label for="password_confirmation" value="Confirm Password" />
                            <Input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                                placeholder="Confirm password"
                            />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <Button class="mx-auto w-full text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Reset Password
                        </Button>
                    </div>
                </form>
            </AuthenticationCard>
        </template>
    </GuestLayout>
</template>
