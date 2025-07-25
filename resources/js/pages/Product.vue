<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import { CartForm, Product } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    product: Product;
}>();

const form = useForm<CartForm>({
    product_id: props.product.id,
});

const addToCart = async () => {
    return new Promise<void>((resolve, reject) => {
        form.post(route('cart.add'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                resolve();
            },
            onError: () => {
                reject(new Error('Error, during update'));
            },
        });
    });
};
</script>

<template>
    <Head title="Product" />

    <GuestLayout>
        <div class="bg-white">
            <div class="pt-16 sm:pb-24">
                <div
                    class="mx-auto mt-8 max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8"
                >
                    <div
                        class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8"
                    >
                        <div class="lg:col-span-5 lg:col-start-8 space-y-4">
                            <div v-if="product.category_id" class="flex items-center justify-between border-b pb-2">
                                <span class="text-gray-600 text-sm font-medium uppercase tracking-wide">Category</span>
                                <span class="text-gray-900 text-sm font-semibold">{{ product.category.title }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b pb-2">
                                <span class="text-gray-600 text-sm font-medium uppercase tracking-wide">Title</span>
                                <span class="text-gray-900 text-sm font-semibold">{{ product.title }}</span>
                            </div>

                            <div class="flex items-center justify-between border-b pb-2">
                                <h1 class="text-lg font-semibold text-gray-900 truncate">
                                    Price
                                </h1>
                                <span class="text-lg font-bold text-cyan-600">
                                    {{ product.price }} lv.
                                </span>
                            </div>
                        </div>
                        <!-- Image gallery -->
                        <div
                            class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0"
                        >
                            <h2 class="sr-only">Images</h2>

                            <div
                                class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8"
                            >
                                <img
                                    :src="`/storage/${product.image}`"
                                    alt="alt"
                                    class="rounded-lg lg:col-span-2 lg:row-span-2"
                                />
                            </div>
                        </div>

                        <div class="mt-8 lg:col-span-5">
                            <button
                                class="mt-8 flex w-full items-center justify-center rounded-md border border-transparent bg-cyan-500 px-8 py-3 text-base font-medium text-white hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                @click="addToCart"
                            >
                                Add to cart
                            </button>

                            <!-- Product details -->
                            <div class="mt-10">
                                <h2 class="text-sm font-medium text-gray-900">
                                    Description
                                </h2>

                                <div
                                    class="prose prose-sm mt-4 text-gray-500"
                                    v-html="product.description"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
