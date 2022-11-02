<script setup>
import { Close } from 'mdue';

defineProps({
    removable: Boolean,
});
defineEmits(['remove']);
</script>

<template>
    <div class="flex py-1 px-3 mr-2 mb-2 font-semibold rounded-full border bg-blue-200 border-blue-200">
        <div class="flex justify-center items-center mr-1 hover:cursor-pointer" v-if="removable" @click.prevent="$emit('remove')">
            <Close />
        </div>
        <div>
            <span><slot /></span>
        </div>
    </div>
</template>
