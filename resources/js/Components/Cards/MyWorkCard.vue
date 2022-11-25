<script setup>
defineProps({ work: Object });
</script>

<template>
    <div style="min-height: 100px;" :key="`my-work-card-${work.uuid}`">
        <div class="px-5 py-3">
            <div class="flex flex-col h-full">
                <div class="md:w-2/3">
                    <div class="flex">
                        <span class="font-bold text-xl truncate" :title="work.name">{{ work.name }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold text-sm truncate" :title="work.slug">{{ work.slug }}</span>
                    </div>
                </div>

                <div class="mt-3">
                    <div>
                        <span class="font-semibold text-sm truncate" :title="$t('words.price')">{{ $t('words.price') }}</span>

                        <div class="mt-1 flex">
                            <span :title="`R$ ${work.price}`.replace('.', ',')">{{ `R$ ${work.price}`.replace('.', ',') }}</span>
                            <span class="ml-1" :title="work.unity?.name" v-if="work.unity">/{{ work.unity?.type }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <template v-if="$slots.action">
                <div class="mt-2">
                    <slot name="action" />
                </div>
            </template>
        </div>
    </div>
</template>
