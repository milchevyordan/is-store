<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import {ref} from "vue";

import ResetSaveButtons from "@/components/HTML/ResetSaveButtons.vue";
import Modal from "@/components/Modal.vue";
import Table from "@/DataTable/Table.vue";
import { DataTable } from "@/DataTable/types";
import IconPencilSquare from "@/icons/PencilSquare.vue";
import IconTrash from "@/icons/Trash.vue";
import { type BreadcrumbItem, DeleteForm, Product } from '@/types';
import {dateTimeToLocaleString} from "@/utils";
import AppLayout from "@/layouts/AppLayout.vue";

defineProps<{
    dataTable: DataTable<Product>;
}>();


const showDeleteModal = ref<boolean>(false);

const deleteForm = useForm<DeleteForm>({
    id: null!,
    name: null!,
    created_at: null!,
});

const openDeleteModal = (item: Product) => {
    deleteForm.id = item.id;
    deleteForm.created_at = item.created_at as Date;

    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    deleteForm.reset();
};

const handleDelete = () => {
    deleteForm.delete(
        route('admin.products.destroy', deleteForm.id as number),
        {
            preserveScroll: true,
        },
    );
    closeDeleteModal();
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Product',
        href: 'admin.products',
    },
];
</script>

<template>
    <Head :title="'Product'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <Table
                            :data-table="dataTable"
                            :per-page-options="[5, 10, 15, 20, 50]"
                            :global-search="true"
                            :advanced-filters="false"
                        >
                            <template #additionalContent>
                                <div class="w-full flex gap-2">
                                    <Link
                                        class="w-full md:w-auto border border-gray-300 dark:border-gray-700 rounded-md px-5 py-1.5 active:scale-95 transition hover:bg-gray-50 dark:hover:bg-gray-800"
                                        :href="route('admin.products.create')"
                                    >
                                        Create Product
                                    </Link>
                                </div>
                            </template>

                            <template #cell(created_at)="{ value, item }">
                                {{ dateTimeToLocaleString(value) }}
                            </template>

                            <template #cell(action)="{ value, item }">
                                <div class="flex gap-1.5">
                                    <Link
                                        class="border border-gray-300 dark:border-gray-700 rounded-md p-1 active:scale-90 transition"
                                        :title="'Edit question'"
                                        :href="route('products.edit', item.id)"
                                    >
                                        <IconPencilSquare
                                            classes="w-4 h-4 "
                                        />
                                    </Link>

                                    <button
                                        :title="'Delete'"
                                        class="border border-gray-300 dark:border-gray-700 rounded-md p-1 active:scale-90 transition"
                                        @click="openDeleteModal(item.id)"
                                    >
                                        <IconTrash classes="w-4 h-4 " />
                                    </button>
                                </div>
                            </template>
                        </Table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

    <Modal
        :show="showDeleteModal"
        @close="closeDeleteModal"
    >
        <div
            class="border-b border-gray-100 dark:border-gray-700 px-3.5 p-3 text-xl font-medium"
        >
            Delete Question <span class="font-bold">#{{ deleteForm?.id }}</span> ?
        </div>

        <form
            class="col-span-2 flex justify-end gap-3 my-2 pt-1 px-4"
            @submit.prevent="handleDelete"
        >
            <ResetSaveButtons
                :processing="deleteForm.processing"
                :recently-successful="deleteForm.recentlySuccessful"
                :is-delete="true"
                @reset="closeDeleteModal"
            />
        </form>
    </Modal>
</template>
