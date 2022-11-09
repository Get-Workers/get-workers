<script setup>
import Main from '@/Components/Mains/Main.vue';
import BaseLayout from './BaseLayout.vue';
import GuestHeader from '@/Components/Headers/GuestHeader.vue';

defineProps({
    title: String,
});
</script>

<template>
    <BaseLayout :title="title">
        <template #header>
            <GuestHeader />
        </template>

        <template #main>
            <Main>
                <slot name="main" />
            </Main>
        </template>
    </BaseLayout>
</template>
