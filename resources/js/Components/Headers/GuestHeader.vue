<script setup>
import Header from './Header.vue';
import Link from '../Links/Link.vue';
</script>

<template>
    <Header>
        <template #profile>
            <div class="space-x-1">
                <Link :href="route('login')" class="inline-block">Login</Link>
                <span>or</span>
                <Link :href="route('register')" class="inline-block">Register</Link>
            </div>
        </template>
    </Header>
</template>
