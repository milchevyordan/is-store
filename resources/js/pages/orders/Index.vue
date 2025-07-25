<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

import ResetSaveButtons from '@/components/HTML/ResetSaveButtons.vue';
import Modal from '@/components/Modal.vue';
import Table from '@/DataTable/Table.vue';
import { DataTable } from '@/DataTable/types';
import { OrderStatus } from '@/enums/OrderStatus';
import DocumentText from '@/icons/DocumentText.vue';
import IconPencilSquare from '@/icons/PencilSquare.vue';
import IconTrash from '@/icons/Trash.vue';
import { type BreadcrumbItem, ChangeLog, DeleteForm, Order } from '@/types';
import {
    dateTimeToLocaleString,
    findEnumKeyByValue,
    replaceEnumUnderscores,
} from '@/utils';
import AppLayout from '@/layouts/AppLayout.vue';
import ChangeLogs from '@/components/HTML/ChangeLogs.vue';

const props = defineProps<{
    dataTable: DataTable<Order>;
    changeLogsLimited: ChangeLog[];
    changeLogs?: DataTable<ChangeLog>;
}>();

const showDeleteModal = ref<boolean>(false);

const deleteForm = useForm<DeleteForm>({
    id: null!,
    name: null!,
    created_at: null!,
});

const openDeleteModal = (item: Order) => {
    deleteForm.id = item.id;
    deleteForm.created_at = item.created_at as Date;

    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    deleteForm.reset();
};

const handleDelete = () => {
    deleteForm.delete(route('admin.orders.destroy', deleteForm.id as number), {
        preserveScroll: true,
    });
    closeDeleteModal();
};

const notDeliveredYet = computed(() =>
    props.dataTable.data
        .filter((item: Order) => item.status == OrderStatus.New)
        .map((item) => item.id),
);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Order',
        href: '',
    }
];
</script>

<template>
    <Head :title="'Order'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <Table
                            :data-table="dataTable"
                            :per-page-options="[5, 10, 15, 20, 50]"
                            :global-search="true"
                            :type-search="true"
                            :show-trashed="true"
                            :advanced-filters="false"
                            :selected-row-indexes="notDeliveredYet"
                            :selected-row-column="'id'"
                        >
                            <template #cell(created_at)="{ value, item }">
                                <div class="flex gap-1.5">
                                    {{ dateTimeToLocaleString(value) }}
                                </div>
                            </template>

                            <template #cell(status)="{ value, item }">
                                <div class="flex gap-1.5">
                                    {{
                                        replaceEnumUnderscores(
                                            findEnumKeyByValue(
                                                OrderStatus,
                                                value,
                                            ),
                                        )
                                    }}
                                </div>
                            </template>

                            <template #cell(action)="{ value, item }">
                                <div class="flex gap-1.5">
                                    <Link
                                        class="rounded-md border border-gray-300 p-1 transition active:scale-90 dark:border-gray-700"
                                        :title="'Edit order'"
                                        :href="
                                            route('admin.orders.edit', item.id)
                                        "
                                    >
                                        <IconPencilSquare
                                            classes="w-4 h-4 text-[#909090]"
                                        />
                                    </Link>

                                    <Link
                                        class="rounded-md border border-gray-300 p-1 transition active:scale-90 dark:border-gray-700"
                                        :title="'Show order'"
                                        :href="
                                            route('admin.orders.show', item.id)
                                        "
                                    >
                                        <DocumentText
                                            classes="w-4 h-4 text-[#909090]"
                                        />
                                    </Link>

                                    <button
                                        :title="'Delete'"
                                        class="rounded-md border border-gray-300 p-1 transition active:scale-90 dark:border-gray-700"
                                        @click="openDeleteModal(item)"
                                    >
                                        <IconTrash
                                            classes="w-4 h-4 text-[#909090]"
                                        />
                                    </button>
                                </div>
                            </template>
                        </Table>
                    </div>
                </div>

                <ChangeLogs
                    :change-logs-limited="changeLogsLimited"
                    :change-logs="changeLogs"
                />
            </div>
        </div>
    </AppLayout>

    <Modal :show="showDeleteModal" @close="closeDeleteModal">
        <div
            class="border-b border-gray-100 p-3 px-3.5 text-xl font-medium dark:border-gray-700"
        >
            Delete order {{ deleteForm?.id ?? '' }} added on
            {{ dateTimeToLocaleString(deleteForm?.created_at) }} ?
        </div>

        <form
            class="col-span-2 my-2 flex justify-end gap-3 px-4 pt-1"
            @submit.prevent="handleDelete"
        >
            <ResetSaveButtons
                :processing="deleteForm.processing"
                :recently-successful="deleteForm.recentlySuccessful"
                :is-delete="true"
                @reset="deleteForm.reset()"
            />
        </form>
    </Modal>
</template>
