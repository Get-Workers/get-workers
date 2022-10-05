<script setup>
import { Close } from 'mdue';

const props = defineProps({
    removable: {
        type: Boolean,
        default: false
    },
    badges: {
        type: Array,
        default: []
    }
});

const emit = defineEmits(['remove']);
const colors = [
    'red',
    'blue',
    'green',
    'yellow',
    'orange',
    'purple',
    'lime',
    'teal',
    'cyan'
];

function getRandomColor() {
    let max = props.badges.length;
    return Math.floor(Math.random() * max);
}

function setBadgeColor(badgeIndex) {
    let randomColorIndex = getRandomColor();
    props.badges[badgeIndex].color = colors[randomColorIndex];
}

function getColor(badgeIndex) {
    if (!props.badges[badgeIndex].color) {
        setBadgeColor(badgeIndex);
    }
    return props.badges[badgeIndex].color;
}

function isColor(index, colorName) {
    let badgeColor = getColor(index);
    return (badgeColor === colorName);
}

function remove(index) {
    let removedBadge = props.badges[index];
    emit('remove', { badgeId: removedBadge.id });
}
</script>

<template>
    <div class="flex flex-wrap" v-if="badges.length">
        <div class="flex py-1 px-3 mr-2 mb-2 font-semibold rounded-full border"
            :class="{
                'text-red-800 bg-red-200 border-red-200': isColor(index, 'red'),
                'text-blue-800 bg-blue-200 border-blue-200': isColor(index, 'blue'),
                'text-green-800 bg-green-200 border-green-200': isColor(index, 'green'),
                'text-yellow-800 bg-yellow-200 border-yellow-200': isColor(index, 'yellow'),
                'text-orange-800 bg-orange-200 border-orange-200': isColor(index, 'orange'),
                'text-purple-800 bg-purple-200 border-purple-200': isColor(index, 'purple'),
                'text-lime-800 bg-lime-200 border-lime-200': isColor(index, 'lime'),
                'text-teal-800 bg-teal-200 border-teal-200': isColor(index, 'teal'),
                'text-cyan-800 bg-cyan-200 border-cyan-200': isColor(index, 'cyan'),
            }"
            v-for="(badge, index) in badges">
            <div class="flex justify-center items-center mr-1 hover:cursor-pointer" v-if="removable" @click="remove(index)">
                <Close />
            </div>
            <div>
                {{ badge.name }}
            </div>
        </div>
    </div>
</template>
