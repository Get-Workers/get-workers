<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '../../Components/AuthenticationCard.vue';
import Button from '../../Components/Button.vue';
import Input from '../../Components/Input.vue';
import InputError from '../../Components/InputError.vue';
import Checkbox from '../../Components/Checkbox.vue';
import Label from '../../Components/Label.vue';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import Link from '../../Components/Links/Link.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout title="Register">
        <template #main>
            <!-- Register -->
            <AuthenticationCard class="mt-2">
                <div>
                    <span class="text-2xl font-semibold">Register</span>
                    <div>
                        <span class="inline-block">Already have an account?</span>
                        <Link class="inline-block ml-2" :href="route('login')">Login</Link>
                    </div>
                </div>

                <div class="mt-5">
                    <form @submit.prevent="submit">
                        <div class="space-y-3">
                            <div>
                                <Label for="name" value="Name" />
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    placeholder="Full name"
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div>
                                <Label for="email" value="Email" />
                                <Input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="email"
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
                                    autofocus
                                    autocomplete="password"
                                    placeholder="Password"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div>
                                <Label for="password_confirmation" value="Confirm password" />
                                <Input
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="password"
                                    placeholder="Confirm password"
                                />
                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>
                        </div>

                        <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                            <Label for="terms">
                                <div class="flex items-center">
                                    <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />
                                    <div class="ml-2">
                                        I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                                    </div>
                                </div>
                                <InputError class="mt-2" :message="form.errors.terms" />
                            </Label>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <Button class="mx-auto w-full text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Register
                            </Button>
                        </div>
                    </form>
                </div>
            </AuthenticationCard>
        </template>
    </GuestLayout>
</template>
