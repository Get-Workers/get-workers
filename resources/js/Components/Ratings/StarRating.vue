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
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div class="flex w-fit space-x-2 p-2 border rounded text-xl">
        <div class="relative w-5 h-5 hover:cursor-pointer" v-for="number in quantity" :key="`rating-start-${number}`" @click="$emit('update:modelValue', number)">
            <Star :class="{ 'hidden hover:block': (modelValue < number) }" />
            <StarEmpty class="absolute inset-0" />
        </div>
    </div>
</template>
