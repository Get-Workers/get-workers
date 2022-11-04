<script setup>
import Header from './Header.vue';
import Link from '../Links/Link.vue';
</script>

<template>
    <Header>
        <template #profile>
            <div class="space-x-1">
                <Link :href="route('login')" class="inline-block">{{ $t('words.login') }}</Link>
                <span>{{ $t('words.lowerCaseOr') }}</span>
                <Link :href="route('register')" class="inline-block">{{ $t('words.register') }}</Link>
            </div>
        </template>
    </Header>
</template>
