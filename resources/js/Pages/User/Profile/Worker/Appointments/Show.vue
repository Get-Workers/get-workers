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
            <div class="flex flex-col sm:flex-row">
                <!-- Sidebard Menu -->
                <SidebarMenu class="sm:w-5/12 md:w-2/6 lg:w-3/12 w-full sm:m-0 mx-auto"/>

                <!-- Page Content -->
                <div class="sm:w-7/12 md:w-4/6 lg:w-9/12 w-full px-5 sm:mt-0 mt-2">
                    <div class="font-bold text-lg">Appointments</div>

                    <div class="flex 2xl:max-w-fit xl:max-w-4xl lg:max-w-screen-sm md:max-w-md sm:max-w-sm mt-5 overflow-x-auto">
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
