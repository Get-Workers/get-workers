<script setup>
import { computed } from '@vue/reactivity';
import { Inertia } from '@inertiajs/inertia';
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { AccountCircle, MenuDown, Menu } from 'mdue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import Header from './Header.vue';
import MenuHeaderX from '../Menus/MenuHeaderX.vue';
import MenuHeaderY from '../Menus/MenuHeaderY.vue';
import ItemX from '../Menus/Items/ItemX.vue';
import ItemY from '../Menus/Items/ItemY.vue';

const pageProps = computed(() => usePage().props.value);
const currentRoute = computed(() => route().current());

const isWorker = computed(() => (pageProps.value.worker !== null));
const isContractor = computed(() => (pageProps.value.contractor !== null));
const canSee = computed(() => ({
    worker: isWorker,
    contractor: isContractor,
}));

const routes = computed(() => ({
    // Main
    dashboard: 'dashboard',

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
}));

const isRoute = computed(() => ({
    // Main
    dashboard: (currentRoute.value === routes.value.dashboard),

    // Contractor
    contractor: {
        hiredWorks: {
            list: (currentRoute.value === routes.value.contractor.hiredWorks.list),
        },
    },

    // Works
    works: {
        list: (currentRoute.value === routes.value.works.list),
    },
}));

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <Header class="">
        <template #links>
            <div class="flex items-center h-full md:hidden">
                <Dropdown position="static" align="left" dropdownPosition="static" width="screen">
                    <template #trigger>
                        <div class="mx-auto">
                            <Menu class="text-4xl" />
                        </div>
                    </template>

                    <template #content>
                        <!-- MenuHeaderY -->
                        <MenuHeaderY>
                            <!-- Item Y -->
                            <ItemY class="hover:bg-white h-14 items-center border-b" :class="{ 'bg-white': isRoute.dashboard }">
                                <template v-if="! isRoute.dashboard">
                                    <Link :href="route(routes.dashboard)" class="flex px-10 w-full h-full items-center">
                                            Dashboard
                                    </Link>
                                </template>
                                <template v-else>
                                    <span class="flex px-10 w-full h-full items-center">Dashboard</span>
                                </template>
                            </ItemY>
                            <ItemY class="hover:bg-white border-b h-14 items-center" :class="{ 'bg-white': isRoute.works.list }">
                                <template v-if="! isRoute.works.list">
                                    <Link :href="route(routes.works.list)" class="flex px-10 w-full h-full items-center">{{ $t('words.works') }}</Link>
                                </template>
                                <template v-else>
                                    <span class="flex px-10 w-full h-full items-center">{{ $t('words.works') }}</span>
                                </template>
                            </ItemY>
                            <ItemY class="hover:bg-white h-14 items-center" :class="{ 'bg-white': isRoute.contractor.hiredWorks.list }" v-if="canSee.contractor">
                                <template v-if="! isRoute.contractor.hiredWorks.list">
                                    <Link :href="route(routes.contractor.hiredWorks.list)" class="flex px-10 w-full h-full items-center">
                                        <div class="flex flex-col w-full h-full justify-center">
                                            <span>{{ $t('words.hiredWorks') }}</span>
                                            <em class="h-0 relative -top-2 text-xs text-gray-500">{{ $t('words.contractor') }}</em>
                                        </div>
                                    </Link>
                                </template>
                                <template v-else>
                                    <div class="flex px-10 w-full h-full items-center">
                                        <div class="flex flex-col w-full h-full justify-center">
                                            <span>{{ $t('words.hiredWorks') }}</span>
                                            <em class="h-0 relative -top-2 text-xs text-gray-500">{{ $t('words.contractor') }}</em>
                                        </div>
                                    </div>
                                </template>
                            </ItemY>
                        </MenuHeaderY>
                    </template>
                </Dropdown>
            </div>

            <MenuHeaderX class="hidden md:flex h-full">
                <ItemX class="hover:bg-white" :class="{ 'bg-white': isRoute.dashboard }">
                    <template v-if="! isRoute.dashboard">
                        <Link :href="route(routes.dashboard)" class="flex h-full px-3 items-center">Dashboard</Link>
                    </template>
                    <template v-else>
                        <span class="flex h-full px-3 items-center">Dashboard</span>
                    </template>
                </ItemX>
                <ItemX class="hover:bg-white border-l" :class="{ 'bg-white': isRoute.works.list }">
                    <template v-if="! isRoute.works.list">
                        <Link :href="route(routes.works.list)" class="flex h-full px-3 items-center">{{ $t('words.works') }}</Link>
                    </template>
                    <template v-else>
                        <span class="flex h-full px-3 items-center">{{ $t('words.works') }}</span>
                    </template>
                </ItemX>
                <ItemX class="hover:bg-white border-l" :class="{ 'bg-white': isRoute.contractor.hiredWorks.list }" v-if="canSee.contractor">
                    <template v-if="! isRoute.contractor.hiredWorks.list">
                        <Link :href="route(routes.contractor.hiredWorks.list)" class="flex h-full px-3">
                            <div class="flex flex-col justify-center items-center">
                                <span>{{ $t('words.hiredWorks') }}</span>
                                <em class="h-0 relative -top-2 text-xs text-gray-500" v-if="isContractor">{{ $t('words.contractor') }}</em>
                            </div>
                        </Link>
                    </template>
                    <template v-else>
                        <div class="flex flex-col h-full px-3 justify-center items-center">
                            <span>{{ $t('words.hiredWorks') }}</span>
                            <em class="h-0 relative -top-2 text-xs text-gray-500" v-if="isContractor">{{ $t('words.contractor') }}</em>
                        </div>
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
                                <span class="lg:block hidden mr-2">{{ $page.props.user.name }}</span>
                                <MenuDown class="-mr-0.5 h-4 w-4"/>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ $t('words.manageAccount') }}
                        </div>

                        <DropdownLink :href="route('profile.show')">
                            {{ $t('words.profile') }}
                        </DropdownLink>

                        <div class="border-t border-gray-100" />

                        <!-- Authentication -->
                        <form @submit.prevent="logout">
                            <DropdownLink as="button">
                                {{ $t('words.logout') }}
                            </DropdownLink>
                        </form>
                    </template>
                </Dropdown>
            </div>
        </template>
    </Header>
</template>
