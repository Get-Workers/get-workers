<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import Button from '@/Components/Button.vue';
import Input from '@/Components/Input.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';
import Label from '@/Components/Label.vue';
import Link from '@/Components/Links/Link.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({ status: String });

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
            <!-- Login -->
            <AuthenticationCard class="mt-2">
                <div>
                    <span class="text-2xl font-semibold">{{ $t('words.login') }}</span>
                    <div>
                        <span class="inline-block">{{ $t('questions.account.doesntHave') }}</span>
                        <Link class="inline-block ml-2" :href="route('register')">{{ $t('words.register') }}</Link>
                    </div>
                </div>

                <div class="mt-5">
                    <div v-if="status" class="mt-5 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit">
                        <div class="space-y-3">
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

                            <div>
                                <Label for="password" :value="$t('words.password')" />
                                <Input
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    required
                                    autocomplete="current-password"
                                    :placeholder="$t('words.password')"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>


                        </div>

                        <div class="flex justify-between mt-5">
                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.remember" name="remember" />
                                <span class="ml-2 text-sm text-gray-600">{{ $t('messages.rememberMe') }}</span>
                            </label>

                            <Link :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                                {{ $t('questions.password.forgot') }}
                            </Link>
                        </div>



                        <div class="flex items-center justify-end mt-8">
                            <Button class="mx-auto w-full text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{ $t('words.login') }}
                            </Button>
                        </div>
                    </form>
                </div>
            </AuthenticationCard>
        </template>
    </GuestLayout>
</template>
