<script setup>
import { ref } from 'vue';
import { computed } from '@vue/reactivity';
import Sidebar from '../../../../Components/Menus/Sidebar.vue';
import Link from '../../../../Components/Links/Link.vue';
import Item from '../../../../Components/Menus/Items/Item.vue';
import SubItem from '../../../../Components/Menus/Items/SubItem.vue';

const isUserSettingsRoute = computed(() => (route().current() === 'profile.show'));

const isWorkerSettingsOpen = computed(() =>  (
    menu.value.workerSettings.open ||
    (route().current() === 'user.profile.worker.specialties.show')
));
const isWorkerSettingsSpecialtiesRoute = computed(() => (route().current() === 'user.profile.worker.specialties.show'));


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
        <Link v-if="!isUserSettingsRoute" :href="route('profile.show')">
            <Item class="font-semibold hover:bg-blue-200">User Settings</Item>
        </Link>
        <Item v-else class="bg-gray-300 text-gray-700 font-semibold" >User Settings</Item>
    </div>

    <!-- Worker Settings -->
    <div v-if="showWorkerSettings">
        <Item
            class="font-semibold"
            :class="{ 'hover:bg-blue-200': !isWorkerSettingsOpen, 'bg-gray-300 text-gray-700': isWorkerSettingsOpen }"
            @click="toggleMenuItem('workerSettings')"
        >
            Worker Settings
            <template #icon>
                <template v-if="isWorkerSettingsOpen">\/</template>
                <template v-else>></template>
            </template>
        </Item>

        <div v-if="isWorkerSettingsOpen">
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
                <Link :href="route('user.profile.worker.specialties.show')">
                    <SubItem :class="{ 'hover:bg-blue-200': !isWorkerSettingsSpecialtiesRoute, 'bg-gray-300 text-gray-700': isWorkerSettingsSpecialtiesRoute }">
                            <div>Specialties</div>
                        <template #icon>-</template>
                    </SubItem>
                </Link>
            </div>

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
