<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '../../Components/AuthenticationCard.vue';
import Button from '../../Components/Button.vue';
import Input from '../../Components/Input.vue';
import InputError from '../../Components/InputError.vue';
import Checkbox from '../../Components/Checkbox.vue';
import Label from '../../Components/Label.vue';
import Link from '../../Components/Links/Link.vue';
import GuestLayout from '../../Layouts/GuestLayout.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout title="Login">
        <template #main>
            <!-- Register -->
            <AuthenticationCard class="mt-2">
                <div>
                    <span class="text-2xl font-semibold">Login</span>
                    <div>
                        <span class="inline-block">Already have an account?</span>
                        <Link class="inline-block ml-2" :href="route('register')">Register</Link>
                    </div>
                </div>

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <div class="mt-2">
                    <form @submit.prevent="submit">
                        <div class="space-y-3">
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
                                    autocomplete="current-password"
                                    placeholder="Password"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>


                        </div>

                        <div class="flex justify-between mt-5">
                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.remember" name="remember" />
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>

                            <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                                Forgot your password?
                            </Link>
                        </div>



                        <div class="flex items-center justify-end mt-8">
                            <Button class="mx-auto w-full text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Login
                            </Button>
                        </div>
                    </form>
                </div>
            </AuthenticationCard>
        </template>
    </GuestLayout>
</template>
