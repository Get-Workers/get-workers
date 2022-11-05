<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AuthLayout from '../../../../Layouts/AuthLayout.vue';
import Link from '../../../../Components/Links/Link.vue';
import BadgeGroup from '../../../../Components/Badges/BadgeGroup.vue';
import Button from '../../../../Components/Button.vue';
import InputError from '../../../../Components/InputError.vue';

defineProps({
    hiredWorks: {
        type: Array,
        default: [],
    },
    deleteStatus: {
        type: Boolean,
        defaul: false,
    },
});

const deleteForm = useForm({
    hiredWork: null,
});

function submitDelete(uuid) {
    deleteForm.hiredWork = uuid;
    deleteForm.delete(route('user.contractor.hired-works.destroy'), {
        onBefore: function() {
            deleteForm.clearErrors();
        },
        onFinish: function() {
            deleteForm.hiredWork = null;
        }
    })
}
</script>

<template>
    <AuthLayout title="Works">
        <template #main>
            <div class="flex">
                <!-- Page Content -->
                <div class="w-full px-5">
                    <div class="font-bold text-lg">{{ $t('words.hiredWorks') }}</div>

                    <InputError :message="deleteForm.errors.hiredWork" class="my-2" />
                    <div v-if="deleteStatus" class="my-2 font-medium text-sm text-green-600">
                        {{ $t('messages.hiredWork.delete.success') }}
                    </div>

                    <!-- Hired Works List -->
                    <div class="mt-5 border rounded w-full overflow-x-auto" v-if="hiredWorks.length">
                        <div class="min-w-xl">
                            <div class="grid grid-flow-col grid-cols-12 gap-2 px-5 py-3 border-b">
                                <span class="col-span-2 font-bold" :title="$t('words.name')">{{ $t('words.name') }}</span>
                                <span class="col-span-2 font-bold" :title="$t('words.slug')">{{ $t('words.slug') }}</span>
                                <span class="col-span-3 font-bold" :title="$t('words.specialties')">{{ $t('words.specialties') }}</span>
                                <span class="col-span-1 font-bold" :title="$t('words.unity')">{{ $t('words.unity') }}</span>
                                <span class="col-span-1 font-bold" :title="$t('words.time')">{{ $t('words.time') }}</span>
                                <span class="col-span-2 font-bold" :title="$t('words.price')">{{ $t('words.price') }}</span>
                                <span class="col-span-1 font-bold" :title="$t('words.action')">{{ $t('words.action') }}</span>
                            </div>
                            <div class="grid grid-flow-col grid-cols-12 gap-2 px-5 py-3 h-20 hover:bg-gray-300 border-b last:border-none"
                                v-for="(hiredWork) in hiredWorks"
                            >
                                <div class="col-span-2 flex items-center overflow-y-auto">
                                    <Link class="min-w-fit break-words text-ellipsis"
                                        :href="route('user.contractor.hired-works.show', { hiredWorkUuid: hiredWork.uuid })"
                                        :title="hiredWork.work.name"
                                    >{{ hiredWork.work.name }}</Link>
                                </div>
                                <div class="col-span-2 flex items-center overflow-y-auto">
                                    <span class="min-w-fit break-words text-ellipsis" :title="hiredWork.work.slug">{{ hiredWork.work.slug }}</span>
                                </div>
                                <div class="col-span-3 overflow-y-auto">
                                    <BadgeGroup :badges="hiredWork.work.specialties" />
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <span :title="hiredWork.work.unity ? hiredWork.work.unity.name : ''">{{ hiredWork.work.unity ? hiredWork.work.unity.type : '' }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <span :title="hiredWork.work.time">{{ hiredWork.work.time }}</span>
                                </div>
                                <div class="col-span-2 flex items-center">
                                    <span class="px-3 py-1 border border-blue-200 rounded-full bg-blue-200" :title="`R$ ${hiredWork.price}`.replace('.', ',')">{{ `R$ ${hiredWork.price}`.replace('.', ',') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center overflow-y-auto">
                                    <Button :title="$t('words.cancel')" @click="submitDelete(hiredWork.uuid)" :disabled="hiredWork.initiated_at || deleteForm.processing">
                                        {{ $t('words.cancel') }}
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthLayout>
</template>
