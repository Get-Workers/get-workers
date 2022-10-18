<script setup>
import { Close } from 'mdue';
import Badge from './Badge.vue';

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

function remove(index) {
    let removedBadge = props.badges[index];
    emit('remove', { badgeId: removedBadge.id });
}
</script>

<template>
    <div class="flex flex-wrap" v-if="badges.length">
        <Badge
            v-for="(badge, index) in badges"
            :removable="removable"
            :name="badge.name"
            @remove="remove(index)"
        >{{ badge.name }}</Badge>
    </div>
</template>
