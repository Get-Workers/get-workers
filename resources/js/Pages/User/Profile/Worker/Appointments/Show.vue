<script setup>
import { ref, onMounted } from 'vue';
import { Calendar } from 'v-calendar';
import AuthLayout from '../../../../../Layouts/AuthLayout.vue';
import SidebarMenu from '../../Partials/SidebarMenu.vue';

const props = defineProps({ hiredWorks: Array });

const attributes = ref([]);

const masks = { weekdays: 'WWW' };

onMounted(() => {
    props.hiredWorks.forEach((hiredWork) => {
        let registeredWorks = attributes.value.map((hiredWork) => hiredWork.key);
        if (registeredWorks.includes(hiredWork.work.uuid)) return;

        let dates = props.hiredWorks
                .filter((hiredWorkFilter) => (hiredWork.work.uuid === hiredWorkFilter.work.uuid))
                .map((hiredWork) => hiredWork.scheduled_to);

        attributes.value.push({
            key: hiredWork.work.uuid,
            color: 'blue',
            popover: true,
            customData: { title: hiredWork.work.name, class: 'bg-blue-200 border-blue-200 font-bold' },
            dates: [...new Set(dates)],
        });
    });
});
</script>

<template>
    <AuthLayout title="Appointments">
        <template #main>
            <div class="flex">
                <!-- Sidebard Menu -->
                <SidebarMenu class="flex flex-col min-h-fit w-64 md:w-96"/>

                <!-- Page Content -->
                <div class="flex flex-col ml-5 w-full px-5">
                    <div class="font-bold text-lg">Appointments</div>

                    <div class="flex w-full mt-5 overflow-x-auto">
                        <div class="min-w-lg">
                            <Calendar
                                class="custom-calendar w-full"
                                :masks="masks"
                                :attributes="attributes"
                                disable-page-swipe
                                is-expanded
                            >
                            <template #day-popover="{day, dayTitle, attributes}">
                                <div>
                                    <div class="text-xs text-gray-300 font-semibold text-center">
                                        {{ dayTitle }}
                                    </div>
                                </div>
                            </template>
                                <template v-slot:day-content="{ day, attributes }">
                                    <div class="flex flex-col p-1 overflow-hidden border w-full h-24">
                                        <span class="day-label text-sm text-gray-900 font-semibold">{{ day.day }}</span>

                                        <div class="flex justify-center overflow-y-auto h-12 w-full" >
                                            <p v-for="attr in attributes"
                                                :key="attr.key"
                                                class="text-xs leading-tight rounded-sm p-1 mt-0 mb-1 break-words w-32"
                                                :class="attr.customData.class"
                                            >
                                            {{ attr.customData.title }}
                                            </p>
                                        </div>
                                    </div>
                                </template>
                            </Calendar>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
