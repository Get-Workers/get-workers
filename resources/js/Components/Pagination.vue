<script setup>
import Link from './Links/Link.vue';

const props = defineProps({
    links: Array,
});

function getString(string) {
    string = string.split(' ');

    return string.find((el) => (
        (el == 'Previous') || (el == 'Next')
    )).toLowerCase();
}
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links">
                <div class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded" v-if="link.url === null" :key="key" v-html="isNaN(link.label) ? $t(`words.${getString(link.label)}`) : link.label"></div>
                <Link v-else :key="`link-${key}`"
                    class="mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-sm leading-4 hover:bg-white border focus:border-indigo-500 rounded"
                    :class="{ 'bg-white': link.active }"
                    :href="link.url"
                    v-html="isNaN(link.label) ? $t(`words.${getString(link.label)}`) : link.label"
                />
            </template>
        </div>
    </div>
</template>
