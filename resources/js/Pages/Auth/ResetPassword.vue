<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import Button from '@/Components/Button.vue';
import Input from '@/Components/Input.vue';
import InputError from '@/Components/InputError.vue';
import Label from '@/Components/Label.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

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
                                autocomplete="new-password"
                                :placeholder="$t('words.password')"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div>
                            <Label for="password_confirmation" :value="$t('words.confirmPassword')" />
                            <Input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                                :placeholder="$t('words.confirmPassword')"
                            />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <Button class="mx-auto w-full text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            {{ $t('words.resetPassword') }}
                        </Button>
                    </div>
                </form>
            </AuthenticationCard>
        </template>
    </GuestLayout>
</template>
