<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import ResetSaveButtons from '@/components/HTML/ResetSaveButtons.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import TextInput from '@/components/TextInput.vue';
import { DataTable } from '@/DataTable/types';
import { type BreadcrumbItem, Category, CategoryForm, ChangeLog } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import ChangeLogs from '@/components/HTML/ChangeLogs.vue';
import Creator from '@/components/Creator.vue';

const props = defineProps<{
    category: Category;
    changeLogs?: DataTable<ChangeLog>;
}>();

const form = useForm<CategoryForm>({
    _method: 'put',
    id: props.category.id,
    title: props.category.title,
});

const save = async () => {
    return new Promise<void>((resolve, reject) => {
        form.post(route('admin.categories.update', props.category.id as number), {
            preserveScroll: true,
            preserveState: true,
            forceFormData: true,
            onSuccess: () => {
                resolve();
            },
            onError: () => {
                reject(new Error('Error, during update'));
            },
        });
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Category',
        href: '',
    },
    {
        title: 'Edit',
        href: '',
    },
];
</script>

<template>
    <Head :title="'Category'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Category
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="grid gap-4 lg:grid-cols-1 xl:grid-cols-2">
                            <form
                                class="mt-6 space-y-6"
                                @submit.prevent="save()"
                            >
                                <div>
                                    <InputLabel for="title" value="Title" />

                                    <TextInput
                                        id="title"
                                        v-model="form.title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                        autocomplete="title"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.title"
                                    />
                                </div>

                                <ResetSaveButtons
                                    :processing="form.processing"
                                    :recently-successful="
                                        form.recentlySuccessful
                                    "
                                    @reset="form.reset()"
                                />
                            </form>

                            <Creator :creator-name="category.creator?.name" />
                        </div>
                    </div>
                </div>

                <ChangeLogs
                    :change-logs-limited="category.change_logs_limited"
                    :change-logs="changeLogs"
                />
            </div>
        </div>
    </AppLayout>
</template>
