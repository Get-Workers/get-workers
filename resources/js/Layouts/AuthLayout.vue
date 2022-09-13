<script setup>
import Main from '../Components/Mains/Main.vue';
import BaseLayout from './BaseLayout.vue';
import AuthHeader from '../Components/Headers/AuthHeader.vue';

defineProps({
    title: String,
});
</script>

<template>
    <BaseLayout :title="title">
        <template #header>
            <AuthHeader />
        </template>

        <template #main>
            <Main>
                <slot name="main" />
            </Main>
        </template>
    </BaseLayout>
</template>
