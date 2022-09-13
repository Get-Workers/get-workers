<script setup>
import { computed } from '@vue/reactivity';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import SectionBorder from '../../Components/SectionBorder.vue';
import LogoutOtherBrowserSessionsForm from './Partials/LogoutOtherBrowserSessionsForm.vue';
import TwoFactorAuthenticationForm from './Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import AuthLayout from '../../Layouts/AuthLayout.vue';
import Sidebar from '../../Components/Menus/Sidebar.vue';
import Item from '../../Components/Menus/Items/Item.vue';
import Link from '../../Components/Links/Link.vue';
// import SubItem from '../../Components/Menus/Items/SubItem.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});

const isUserSettingsRoute = computed(() => (route().current() === 'profile.show'));
</script>

<template>
    <AuthLayout title="Profile">

        <template #main>
            <div class="flex">
                <div class="w-20 md:w-80 lg:w-96">
                    <Sidebar class="space-y-1">
                        <div>
                            <Link v-if="!isUserSettingsRoute" :href="route('profile.show')">
                                <Item class="font-semibold hover:bg-blue-200">User Settings</Item>
                            </Link>
                            <Item v-else class="bg-gray-300 text-gray-700 font-semibold" >User Settings</Item>
                        </div>

                        <!-- Worker Settings -->
                        <!-- <div class="space-y-1"> -->
                            <!-- <div> -->
                                <!-- <Link v-if="true"> -->
                                    <!-- <Item class="font-semibold hover:bg-blue-200"> -->
                                        <!-- Worker Settings -->
                                        <!-- <template #icon>></template> -->
                                    <!-- </Item> -->
                                <!-- </Link> -->
                                <!-- <Item v-else class="bg-gray-300 text-gray-700 font-semibold" > -->
                                    <!-- Worker Settings -->
                                    <!-- <template #icon>></template> -->
                                <!-- </Item> -->
                            <!-- </div> -->
                            <!-- <div> -->
                                <!-- <SubItem v-if="true"> -->
                                    <!-- <Link><div>Profile</div></Link> -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                                <!-- <SubItem v-else> -->
                                    <!-- Profile -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                            <!-- </div> -->
                            <!-- <div> -->
                                <!-- <SubItem v-if="true"> -->
                                    <!-- <Link><div>Specialties</div></Link> -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                                <!-- <SubItem v-else> -->
                                    <!-- Specialties -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                            <!-- </div> -->
                            <!-- <div> -->
                                <!-- <SubItem v-if="true"> -->
                                    <!-- <Link><div>Certifications</div></Link> -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                                <!-- <SubItem v-else> -->
                                    <!-- Certifications -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                            <!-- </div> -->
                            <!-- <div> -->
                                <!-- <SubItem v-if="true"> -->
                                    <!-- <Link><div>Calendar</div></Link> -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                                <!-- <SubItem v-else> -->
                                    <!-- Calendar -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                            <!-- </div> -->
                        <!-- </div> -->

                        <!-- Contractor Settings -->
                        <!-- <div class="space-y-1"> -->
                            <!-- <div> -->
                                <!-- <Link v-if="true"> -->
                                    <!-- <Item class="font-semibold hover:bg-blue-200"> -->
                                        <!-- Contractor Settings -->
                                        <!-- <template #icon>></template> -->
                                    <!-- </Item> -->
                                <!-- </Link> -->
                                <!-- <Item v-else class="bg-gray-300 text-gray-700 font-semibold" > -->
                                    <!-- Contractor Settings -->
                                    <!-- <template #icon>></template> -->
                                <!-- </Item> -->
                            <!-- </div> -->
                            <!-- <div> -->
                                <!-- <SubItem v-if="true"> -->
                                    <!-- <Link><div>Profile</div></Link> -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                                <!-- <SubItem v-else> -->
                                    <!-- Profile -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                            <!-- </div> -->
                            <!-- <div> -->
                                <!-- <SubItem v-if="true"> -->
                                    <!-- <Link><div>Calendar</div></Link> -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                                <!-- <SubItem v-else> -->
                                    <!-- Calendar -->
                                    <!-- <template #icon>-</template> -->
                                <!-- </SubItem> -->
                            <!-- </div> -->
                        <!-- </div> -->
                    </Sidebar>
                </div>

                <div>
                    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
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
            </div>
        </template>
    </AuthLayout>
</template>
