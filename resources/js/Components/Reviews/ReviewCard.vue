<script setup>
import StarRating from '@/Components/Ratings/StarRating.vue';

defineProps({ review: Object });
</script>

<template>
    <div class="bg-white rounded-lg border w-72 xl:w-80 h-60">
        <div class="flex flex-col h-full px-4 py-2">
            <div>
                <h3 class="font-bold text-lg truncate" :title="review.title">{{ review.title }}</h3>
            </div>

            <div class="mt-2 h-full pt-1 border-t">
                <p class="line-clamp-5" :title="review.description" v-if="review.description">{{ review.description }}</p>
                <p v-else>{{ $t('phrases.noDescription') }}</p>
            </div>

            <div class="mt-2 pt-1 border-t">
                <StarRating v-model="review.rating" :disabled="true" />
            </div>
        </div>
    </div>
</template>
