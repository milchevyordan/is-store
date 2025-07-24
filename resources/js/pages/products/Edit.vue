<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import ResetSaveButtons from '@/components/HTML/ResetSaveButtons.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import TextInput from '@/components/TextInput.vue';
import { DataTable, Multiselect } from '@/DataTable/types';
import { type BreadcrumbItem, Category, ChangeLog, Product, ProductForm } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import ChangeLogs from '@/components/HTML/ChangeLogs.vue';
import Creator from '@/components/Creator.vue';
import { onFileChange } from '@/utils';
import TextareaInput from '@/components/TextareaInput.vue';
import Select from '@/components/Select.vue';

const props = defineProps<{
    product: Product;
    changeLogs?: DataTable<ChangeLog>;
    categories: Multiselect<Category>;
}>();

const form = useForm<ProductForm>({
    _method: 'put',
    id: props.product.id,
    category_id: props.product.category_id,
    image: null!,
    title: props.product.title,
    description: props.product.description,
    price: props.product.price,
});

const save = async () => {
    return new Promise<void>((resolve, reject) => {
        form.post(route('admin.products.update', props.product.id as number), {
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
        title: 'Product',
        href: '',
    },
    {
        title: 'Edit',
        href: '',
    },
];
</script>

<template>
    <Head :title="'Product'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Product
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
                                    <InputLabel
                                        for="category_id"
                                        value="Category"
                                    />

                                    <Select
                                        id="category_id"
                                        v-model="form.category_id"
                                        :name="'category_id'"
                                        :options="categories"
                                        placeholder="Category"
                                        class="mt-1 block w-full mb-3.5"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.category_id"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="title"
                                        value="Title *"
                                    />

                                    <TextInput
                                        id="title"
                                        v-model="form.title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="title"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.title"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="description"
                                        value="Description"
                                    />

                                    <TextareaInput
                                        id="description"
                                        v-model="form.description"
                                        class="mt-1 block w-full"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.description"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="price"
                                        value="Price"
                                    />

                                    <TextInput
                                        id="price"
                                        v-model="form.price"
                                        type="number"
                                        step="0.01"
                                        class="mt-1 block w-full"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.price"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="image"
                                        :value="`Image: ${product.image?.split('/').pop()}`"
                                    />

                                    <input
                                        id="image"
                                        type="file"
                                        @change="
                                            (event) => onFileChange(event, form)
                                        "
                                        class="mt-1 block w-full"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.image"
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

                            <Creator
                                :creator-name="product.creator?.name"
                                :image="product.image"
                            />
                        </div>
                    </div>
                </div>

                <ChangeLogs
                    :change-logs-limited="product.change_logs_limited"
                    :change-logs="changeLogs"
                />
            </div>
        </div>
    </AppLayout>
</template>
