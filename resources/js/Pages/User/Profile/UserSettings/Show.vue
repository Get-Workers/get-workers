<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import TwoFactorAuthenticationForm from './Partials/TwoFactorAuthenticationForm.vue';
import LogoutOtherBrowserSessionsForm from './Partials/LogoutOtherBrowserSessionsForm.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import SidebarMenu from '../Partials/SidebarMenu.vue';
import UpdateCpfForm from './Partials/UpdateCpfForm.vue';
import UpdatePhoneNumberForm from './Partials/UpdatePhoneNumberForm.vue';
import LocaleChanger from '@/Components/Dictionaries/LocaleChanger.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AuthLayout :title="$t('words.profile')">

        <template #main>
            <div class="flex flex-col sm:flex-row">
                <!-- Sidebard Menu -->
                <SidebarMenu class="sm:w-5/12 md:w-2/6 lg:w-3/12 w-full sm:m-0 mx-auto"/>


                <!-- Page Content -->
                <div class="sm:w-7/12 md:w-4/6 lg:w-9/12 w-full px-5 sm:mt-0 mt-2">
                    <div class="font-bold text-lg">{{ $t('words.profile') }}</div>

                    <div class="mt-5 flex flex-col items-end">
                        <span>{{ $t('words.localeChanger') }}</span>
                        <LocaleChanger class="mt-2"/>
                    </div>

                    <div class="mt-5">
                        <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                            <UpdateProfileInformationForm :user="$page.props.user" />

                            <SectionBorder />
                        </div>

                        <div v-if="$page.props.jetstream.canUpdatePassword">
                            <UpdatePasswordForm class="mt-10 sm:mt-0" />

                            <SectionBorder />
                        </div>

                        <div>
                            <UpdateCpfForm :user="$page.props.user" />

                            <SectionBorder />
                        </div>

                        <div>
                            <UpdatePhoneNumberForm :user="$page.props.user" />

                            <SectionBorder />
                        </div>

                        <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                            <TwoFactorAuthenticationForm
                                :requires-confirmation="confirmsTwoFactorAuthentication"
                                class="mt-10 sm:mt-0"
                            />

                            <SectionBorder />
                        </div>

                        <LogoutOtherBrowserSessionsForm :sessions="sessions" class="mt-10 sm:mt-0" />

                        <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                            <SectionBorder />

                            <DeleteUserForm class="mt-10 sm:mt-0" />
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
