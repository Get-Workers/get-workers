<script setup>
import { ref } from 'vue';
import { computed } from '@vue/reactivity';
import { usePage } from '@inertiajs/inertia-vue3';
import { ChevronRight, ChevronDown, SubdirectoryArrowRight } from 'mdue';
import Sidebar from '../../../../Components/Menus/Sidebar.vue';
import Link from '../../../../Components/Links/Link.vue';
import Item from '../../../../Components/Menus/Items/Item.vue';
import SubItem from '../../../../Components/Menus/Items/SubItem.vue';

const pageProps = computed(() => usePage().props.value);
const isWorker = computed(() => (pageProps.value.worker !== null));
const currentRoute = computed(() => route().current());

const routes = {
    // Worker
    worker: {
        myWorks: 'user.profile.worker.my-works.show',
        hiredWorks: {
            list: 'user.worker.hired-works.list',
        },
    },

    // Profile
    profile: {
        show: 'profile.show',
    },

    // User
    user: {
        profile: {
            worker: {
                specialties: {show: 'user.profile.worker.specialties.show'},
                certifications: {show: 'user.profile.worker.certifications.show'},
                myWorks: {show: 'user.profile.worker.my-works.show'},
                hiredWorks: {list: 'user.profile.worker.hired-works.list'},
                appointments: {show: 'user.profile.worker.appointments.show'},
            },
        },
    },
};

const isRoute = computed(() => ({
    // Worker
    worker: {
        myWorks: (currentRoute.value === routes.worker.myWorks),
        hiredWorks: {
            list: (currentRoute.value === routes.worker.hiredWorks),
        },
    },
    profile: {show: (currentRoute.value === routes.profile.show)},
    user: {
        profile: {
            worker: {
                specialties: {show: (currentRoute.value === routes.user.profile.worker.specialties.show)},
                certifications: {show: (currentRoute.value === routes.user.profile.worker.certifications.show)},
                myWorks: {show: (currentRoute.value === routes.user.profile.worker.myWorks.show)},
                hiredWorks: {list: (currentRoute.value === routes.user.profile.worker.hiredWorks.list)},
                appointments: {show: (currentRoute.value === routes.user.profile.worker.appointments.show)},
            },
        },
    },
}));

const isWorkerSettingsOpen = computed(() =>  (
    menu.value.workerSettings.open ||
    isRoute.value.user.profile.worker.specialties.show ||
    isRoute.value.user.profile.worker.certifications.show ||
    isRoute.value.user.profile.worker.appointments.show ||
    isRoute.value.user.profile.worker.myWorks.show ||
    isRoute.value.user.profile.worker.hiredWorks.list
));

const menu = ref({
    workerSettings: {
        open: false,
    }
});

function toggleMenuItem(menuItem) { menu.value[menuItem].open = !menu.value[menuItem].open; };
</script>

<template>
    <Sidebar class="space-y-1">

    <!-- User Settings -->
    <div>
        <Link v-if="!isRoute.profile.show" :href="route(routes.profile.show)">
            <Item class="font-semibold hover:bg-blue-200">User Settings</Item>
        </Link>
        <Item v-else class="bg-gray-300 text-gray-700 font-semibold" >User Settings</Item>
    </div>

    <!-- Worker Settings -->
    <div v-if="isWorker">
        <Item
            class="font-semibold"
            :class="{ 'hover:bg-blue-200': !isWorkerSettingsOpen, 'bg-gray-300 text-gray-700': isWorkerSettingsOpen }"
            @click="toggleMenuItem('workerSettings')"
        >
            {{ $t('words.worker') }}
            <template #icon>
                <div class="flex items-center font-black">
                    <ChevronDown v-if="isWorkerSettingsOpen" />
                    <ChevronRight v-else />
                </div>
            </template>
        </Item>

        <div class="space-y-1 mt-1" v-if="isWorkerSettingsOpen">
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

            <div>
                <Link :href="route(routes.user.profile.worker.specialties.show)" v-if="!isRoute.user.profile.worker.specialties.show">
                    <SubItem class="hover:bg-blue-200">
                            <div>{{ $t('words.specialties') }}</div>
                        <template #icon><SubdirectoryArrowRight /></template>
                    </SubItem>
                </Link>
                <SubItem class="bg-gray-300 text-gray-700" v-else>
                        <div>{{ $t('words.specialties') }}</div>
                    <template #icon>
                        <SubdirectoryArrowRight class="m-auto"/>
                    </template>
                </SubItem>
            </div>

            <div>
                <Link :href="route(routes.user.profile.worker.certifications.show)" v-if="!isRoute.user.profile.worker.certifications.show">
                    <SubItem class="hover:bg-blue-200">
                            <div>{{ $t('words.certifications') }}</div>
                        <template #icon><SubdirectoryArrowRight /></template>
                    </SubItem>
                </Link>
                <SubItem class="bg-gray-300 text-gray-700" v-else>
                        <div>{{ $t('words.certifications') }}</div>
                    <template #icon><SubdirectoryArrowRight /></template>
                </SubItem>
            </div>

            <div>
                <Link :href="route(routes.user.profile.worker.myWorks.show)" v-if="!isRoute.user.profile.worker.myWorks.show">
                    <SubItem class="hover:bg-blue-200">
                            <div>{{ $t('words.works') }}</div>
                        <template #icon><SubdirectoryArrowRight /></template>
                    </SubItem>
                </Link>
                <SubItem class="bg-gray-300 text-gray-700" v-else>
                        <div>{{ $t('words.works') }}</div>
                    <template #icon><SubdirectoryArrowRight /></template>
                </SubItem>
            </div>

            <div>
                <Link :href="route(routes.user.profile.worker.hiredWorks.list)" v-if="!isRoute.user.profile.worker.hiredWorks.list">
                    <SubItem class="hover:bg-blue-200">
                            <div>{{ $t('words.hiredWorks') }}</div>
                        <template #icon><SubdirectoryArrowRight /></template>
                    </SubItem>
                </Link>
                <SubItem class="bg-gray-300 text-gray-700" v-else>
                        <div>{{ $t('words.hiredWorks') }}</div>
                    <template #icon><SubdirectoryArrowRight /></template>
                </SubItem>
            </div>

            <div>
                <Link :href="route(routes.user.profile.worker.appointments.show)" v-if="!isRoute.user.profile.worker.appointments.show">
                    <SubItem class="hover:bg-blue-200">
                            <div>{{ $t('words.appointments') }}</div>
                        <template #icon><SubdirectoryArrowRight /></template>
                    </SubItem>
                </Link>
                <SubItem class="bg-gray-300 text-gray-700" v-else>
                        <div>{{ $t('words.appointments') }}</div>
                    <template #icon><SubdirectoryArrowRight /></template>
                </SubItem>
            </div>

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
        </div>
    </div>

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
</template>
