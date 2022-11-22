<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Label from '@/Components/Label.vue';
import Input from '@/Components/Input.vue';
import InputError from '@/Components/InputError.vue';
import Button from '@/Components/Button.vue';
import StarRating from '@/Components/Ratings/StarRating.vue';

const props = defineProps({
    hiredWork: Object,
})

const reviewForm = useForm({
    title: '',
    description: '',
    rating: 3,
});

function sendForm() {
    if (! reviewForm.isDirty) return;

    reviewForm.post(route('user.contractor.hired-works.review.store', { hiredWorkUuid: props.hiredWork.uuid }), {
        onBefore: () => reviewForm.clearErrors(),
    });
}
</script>

<template>
    <div>
        <form @submit.prevent="sendForm">
            <div class="w-full md:w-80">
                <Label for="title" :value="$t('words.title')" :required="true" />
                <Input id="title" type="text" class="mt-1 w-full" maxlength="150" v-model="reviewForm.title" />
                <InputError class="mt-1" :message="reviewForm.errors.title"/>
            </div>

            <div class="mt-2 w-full md:w-80">
                <Label for="description" :value="$t('words.description')" :required="true" />
                <textarea id="description" class="mt-1 w-full" maxlength="512" required v-model="reviewForm.description" />
                <InputError class="mt-1" :message="reviewForm.errors.description"/>
            </div>

            <div class="mt-2 w-full md:w-80">
                <Label for="rating" :value="$t('words.rating')" />

                <div class="mt-1">
                    <StarRating v-model="reviewForm.rating" />
                </div>
                <InputError class="mt-1" :message="reviewForm.errors.rating"/>
            </div>

            <InputError class="mt-1" :message="reviewForm.errors.hiredWork"/>
            <InputError class="mt-1" :message="reviewForm.errors.unexpected"/>

            <div class="mt-2 flex justify-end">
                <Button type="submit">{{ $t('words.save') }}</Button>
            </div>
        </form>
    </div>
</template>
