<script setup>
import AuthLayout from '../../../../Layouts/AuthLayout.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import SectionBorder from '../../../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Components/SectionBorder.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import TwoFactorAuthenticationForm from './Partials/TwoFactorAuthenticationForm.vue';
import LogoutOtherBrowserSessionsForm from './Partials/LogoutOtherBrowserSessionsForm.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import SidebarMenu from '../Partials/SidebarMenu.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});


</script>

<template>
    <AuthLayout title="Profile">

        <template #main>
            <div class="flex">
                <!-- Sidebard Menu -->
                <SidebarMenu class="flex flex-col h-fit w-64 md:w-96"/>

                <!-- Page Content -->
                <div class="flex flex-col w-full ml-5">
                    <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                        <UpdateProfileInformationForm :user="$page.props.user" />

                        <SectionBorder />
                    </div>

                    <div v-if="$page.props.jetstream.canUpdatePassword">
                        <UpdatePasswordForm class="mt-10 sm:mt-0" />

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
        </template>
    </AuthLayout>
</template>
