<script setup>
import Main from '../Components/Mains/Main.vue';
import BaseLayout from './BaseLayout.vue';
import HeaderGuest from '../Components/Headers/HeaderGuest.vue';

defineProps({
    title: String,
});
</script>

<template>
    <BaseLayout :title="title">
        <template #header>
            <HeaderGuest />
        </template>

        <template #main>
            <Main>
                <slot name="main" />
            </Main>
        </template>
    </BaseLayout>
</template>
