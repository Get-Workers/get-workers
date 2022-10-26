<script setup>
import { onMounted, onUpdated, ref } from 'vue';
import { Close } from 'mdue';

const props = defineProps({
    title: String,
    isOpened: Boolean,
    onClose: Function
});

const modal = ref(null);

onMounted(() => openModal());
onUpdated(() => openModal());

function openModal() {
    if (!props.isOpened && !modal.value.open) return;

    modal.value.showModal();
}

function closeModal() {
    props.onClose();
    modal.value.close();
}

</script>

<template>
    <teleport to="body">
        <transition leave-active-class="duration-500">
            <dialog class="xl:w-2/5 lg:w-2/4 md:w-2/3 sm:w-full w-full self-center rounded break-words" ref="modal" @close.prevent="closeModal">
                <div class="relative" v-if="isOpened">
                    <span class="text-xl font-bold">{{ title }}</span>

                    <div class="absolute -right-4 -top-4 border rounded-full w-8 h-8 cursor-pointer flex items-center justify-center hover:bg-blue-500 hover:text-white">
                        <Close @click="closeModal"/>
                    </div>

                </div>
                <div class="mt-2"><slot /></div>
            </dialog>
        </transition>
    </teleport>
</template>
