<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

import Accordion from '@/components/HTML/Accordion.vue';
import Modal from '@/components/Modal.vue';
import Table from '@/DataTable/Table.vue';
import { DataTable } from '@/DataTable/types';
import { ChangeLog, ChangeLogsChange } from '@/types';
import { dateTimeToLocaleString } from '@/utils';

defineProps<{
    changeLogsLimited?: ChangeLog[];
    changeLogs?: DataTable<ChangeLog>;
}>();

const showChangeLogModal = ref<boolean>(false);

const openChangeLogModal = async () => {
    await new Promise((resolve, reject) => {
        router.reload({
            only: ['changeLogs'],
            onSuccess: resolve,
            onError: reject,
        });
    });

    showChangeLogModal.value = true;
};

const closeChangeLogModal = () => {
    showChangeLogModal.value = false;
};
</script>

<template>
    <div
        class="relative mt-4 rounded-lg bg-white px-4 py-4 shadow-sm sm:py-6 dark:bg-gray-800"
    >
        <Accordion>
            <template #head>
                <div
                    class="mb-4 flex justify-between text-gray-900 dark:text-gray-100"
                >
                    <div class="text-xl font-semibold sm:text-2xl">
                        Change Logs
                    </div>

                    <button
                        class="mr-10 rounded-md border border-gray-300 px-5 py-1.5 transition hover:bg-gray-50 active:scale-95 md:w-auto dark:border-gray-700 dark:hover:bg-gray-800"
                        @click="openChangeLogModal"
                    >
                        Show All
                    </button>
                </div>
            </template>

            <div v-if="changeLogsLimited" class="max-h-96 overflow-y-auto">
                <div
                    v-for="(changeLog, index) in changeLogsLimited"
                    :key="index"
                    :class="[
                        'mb-4 grid gap-4 pb-4 lg:grid-cols-2',
                        {
                            'border-b border-[#E9E7E7] dark:border-gray-700':
                                index !== changeLogsLimited.length - 1,
                        },
                    ]"
                >
                    <div
                        class="flex flex-col items-center border-[#E9E7E7] sm:gap-y-2 lg:border-r lg:pr-8 dark:border-gray-700"
                    >
                        <div
                            class="element-center"
                        >
                            <span class="mr-2 text-[#C7C7CC] dark:text-gray-500">
                                Id
                            </span>
                            <span class="text-[#6D6D73] dark:text-gray-200 bg-[#F2F2F7] dark:bg-gray-700 cursor-default rounded px-3 py-1 font-light m-1">
                                {{ changeLog.changeable_id }}
                            </span>
                        </div>
                        <div class="element-center">
                            <span
                                class="mr-2 text-[#C7C7CC] dark:text-gray-500"
                            >
                                Creator
                            </span>
                            <span
                                class="m-1 cursor-default rounded bg-[#F2F2F7] px-3 py-1 font-light text-[#6D6D73] dark:bg-gray-700 dark:text-gray-200"
                            >
                                {{ changeLog.creator.name }}
                            </span>
                        </div>
                        <div class="element-center">
                            <span
                                class="mr-2 text-[#C7C7CC] dark:text-gray-500"
                            >
                                Date
                            </span>
                            <span
                                class="m-1 cursor-default rounded bg-[#F2F2F7] px-3 py-1 font-light text-[#6D6D73] dark:bg-gray-700 dark:text-gray-200"
                            >
                                {{
                                    dateTimeToLocaleString(changeLog.created_at)
                                }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-row items-center lg:pl-4">
                        <ul class="flex flex-wrap">
                            <li
                                v-for="(changeItem, indexChange) in JSON.parse(
                                    changeLog.change,
                                )"
                                :key="indexChange"
                            >
                                <ul class="flex flex-wrap">
                                    <li
                                        v-for="(
                                            item, indexItem
                                        ) in changeItem as ChangeLogsChange[]"
                                        :key="indexItem"
                                        class="m-1 space-x-1 rounded-lg border border-gray-200 px-3 py-1 text-gray-900 dark:border-gray-600 dark:text-gray-200"
                                        :class="{
                                            'bg-red-100 dark:bg-red-800':
                                                item?.old && !item?.new,
                                        }"
                                    >
                                        <span
                                            v-if="String(indexChange) != 'main'"
                                            >{{ indexChange }} |</span
                                        >
                                        <span>{{ indexItem }} |</span>
                                        <span
                                            v-if="item?.old"
                                            class="text-gray-500 dark:text-gray-400"
                                        >
                                            {{ item?.old }}
                                        </span>
                                        <span v-if="item?.old && item?.new"
                                            >&rarr;</span
                                        >
                                        <span v-if="item?.new">
                                            {{ item?.new }}
                                        </span>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </Accordion>
    </div>

    <Modal
        :show="showChangeLogModal"
        @close="closeChangeLogModal"
    >
        <div class="p-3 px-3.5 text-xl font-medium">Change Logs</div>

        <div v-if="changeLogs" class="text-gray-900 dark:text-gray-100">
            <Table
                :data-table="changeLogs"
                :per-page-options="[5, 10, 15, 20, 50]"
                :global-search="true"
                prop-name="changeLogs"
            >
                <template #cell(change)="{ value, item }">
                    <div class="flex gap-1.5">
                        <ul class="flex flex-wrap">
                            <li
                                v-for="(changeItem, indexChange) in JSON.parse(
                                    value,
                                )"
                                :key="indexChange"
                            >
                                <ul class="flex flex-wrap">
                                    <li
                                        v-for="(
                                            change, indexItem
                                        ) in changeItem as ChangeLogsChange[]"
                                        :key="indexItem"
                                        class="m-1 space-x-1 rounded-lg border border-gray-200 px-3 py-1 text-gray-900 dark:border-gray-600 dark:text-gray-200"
                                        :class="{
                                            'bg-red-100 dark:bg-red-800':
                                                change?.old && !change?.new,
                                        }"
                                    >
                                        <span
                                            v-if="String(indexChange) != 'main'"
                                            >{{ indexChange }} |</span
                                        >
                                        <span>{{ indexItem }} |</span>
                                        <span
                                            v-if="change?.old"
                                            class="text-gray-500 dark:text-gray-400"
                                        >
                                            {{ change?.old }}
                                        </span>
                                        <span v-if="change?.old && change?.new"
                                            >&rarr;</span
                                        >
                                        <span v-if="change?.new">
                                            {{ change?.new }}
                                        </span>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </template>

                <template #cell(created_at)="{ value, item }">
                    <div class="flex gap-1.5">
                        {{ dateTimeToLocaleString(value) }}
                    </div>
                </template>
            </Table>
        </div>
    </Modal>
</template>
