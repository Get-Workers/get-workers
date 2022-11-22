<script setup>
import { StarOutline as StarEmpty, Star } from 'mdue';

defineProps({
    modelValue: {
        type: Number,
        default: 0,
    },
    quantity: {
        type: Number,
        default: 5,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div class="flex w-fit space-x-2 p-2 border rounded text-xl">
        <div class="relative w-5 h-5" :class="{ 'hover:cursor-pointer': (! disabled) }" v-for="number in quantity" :key="`rating-start-${number}`" @click="(! disabled) && $emit('update:modelValue', number)">
            <Star :class="{ 'hidden': (modelValue < number) }" />
            <StarEmpty class="absolute inset-0" />
        </div>
    </div>
</template>
