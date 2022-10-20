<script setup>
import { computed } from '@vue/reactivity';
import { Inertia } from '@inertiajs/inertia';
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { AccountCircle, MenuDown } from 'mdue';
import Header from './Header.vue';
import Dropdown from '../../Components/Dropdown.vue';
import DropdownLink from '../../Components/DropdownLink.vue';
import MenuHeaderX from '../Menus/MenuHeaderX.vue';
import ItemX from '../Menus/Items/ItemX.vue';

const pageProps = usePage().props.value;
const currentRoute = computed(() => route().current());

const isWorker = (pageProps.worker !== null);
const isContractor = (pageProps.contractor !== null);
const canSee = {
    worker: isWorker,
    contractor: isContractor,
};

const routes = {
    // Main
    dashboard: 'dashboard',

    // Worker
    worker: {
        myWorks: 'user.worker.my-works.show',
    },

    // Contractor
    contractor: {
        hiredWorks: {
            list: 'user.contractor.hired-works.list',
        },
    },

    // Works
    works: {
        list: 'works.list'
    },
};

const isRoute = computed(() => ({
    // Main
    dashboard: (currentRoute.value === routes.dashboard),

    // Worker
    worker: {
        myWorks: (currentRoute.value === routes.worker.myWorks),
    },

    // Contractor
    contractor: {
        hiredWorks: {
            list: (currentRoute.value === routes.contractor.hiredWorks.list),
        },
    },

    // Works
    works: {
        list: (currentRoute.value === routes.works.list),
    },
}));

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <Header>
        <template #links>
            <MenuHeaderX class="h-full">
                <ItemX class="h-full hover:bg-white" :class="{ 'bg-white': isRoute.dashboard }">
                    <template v-if="! isRoute.dashboard">
                        <Link :href="route(routes.dashboard)" class="flex h-full px-3 items-center">Dashboard</Link>
                    </template>
                    <template v-else>
                        <span class="flex h-full px-3 items-center">Dashboard</span>
                    </template>
                </ItemX>
                <ItemX class="h-full hover:bg-white border-l" :class="{ 'bg-white': isRoute.works.list }">
                    <template v-if="! isRoute.works.list">
                        <Link :href="route(routes.works.list)" class="flex h-full px-3 items-center">Works</Link>
                    </template>
                    <template v-else>
                        <span class="flex h-full px-3 items-center">Works</span>
                    </template>
                </ItemX>
                <ItemX class="h-full hover:bg-white border-l" :class="{ 'bg-white': isRoute.worker.myWorks }" v-if="canSee.worker">
                    <template v-if="! isRoute.worker.myWorks">
                        <Link :href="route(routes.worker.myWorks)" class="flex h-full px-3 items-center">My Works</Link>
                    </template>
                    <template v-else>
                        <span class="flex h-full px-3 items-center">My Works</span>
                    </template>
                </ItemX>
                <ItemX class="h-full hover:bg-white border-l" :class="{ 'bg-white': isRoute.contractor.hiredWorks.list }" v-if="canSee.contractor">
                    <template v-if="! isRoute.contractor.hiredWorks.list">
                        <Link :href="route(routes.contractor.hiredWorks.list)" class="flex h-full px-3 items-center">Hired Works</Link>
                    </template>
                    <template v-else>
                        <span class="flex h-full px-3 items-center">Hired Works</span>
                    </template>
                </ItemX>
            </MenuHeaderX>
        </template>

        <template #profile>
            <div class="space-x-1">
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                        </button>

                        <span v-else class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                <AccountCircle class="text-3xl mr-2"/>
                                {{ $page.props.user.name }}
                                <MenuDown class="ml-2 -mr-0.5 h-4 w-4"/>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            Manage Account
                        </div>

                        <DropdownLink :href="route('profile.show')">
                            Profile
                        </DropdownLink>

                        <div class="border-t border-gray-100" />

                        <!-- Authentication -->
                        <form @submit.prevent="logout">
                            <DropdownLink as="button">
                                Log Out
                            </DropdownLink>
                        </form>
                    </template>
                </Dropdown>
            </div>
        </template>
    </Header>
</template>
