<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Product } from '@/types';
import { Head, Link, WhenVisible } from '@inertiajs/vue3';
import LoadingAnimation from '@/components/LoadingAnimation.vue';

defineProps<{
    products: Product[];
    current: number;
    last: number;
}>();
</script>

<template>
    <Head title="Products" />

    <GuestLayout>
        <div class="bg-white ">
            <div
                class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8 mt-12"
            >
                <div
                    class="grid gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:grid-cols-3 lg:gap-x-8"
                >
                    <Link
                        v-for="product in products"
                        :key="product.id"
                        class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white hover:shadow-lg"
                        :href="route('product', product.slug)"
                    >
                        <div
                            class="aspect-h-4 aspect-w-3 bg-gray-200 sm:aspect-none group-hover:opacity-75 sm:h-96"
                        >
                            <img
                                :src="`/storage/${product.image}`"
                                alt="alt"
                                class="h-full w-full object-cover object-center sm:h-full sm:w-full"
                            />
                        </div>
                        <div class="flex flex-1 flex-col space-y-2 p-4">
                            <h3 class="text-sm font-medium text-gray-900">
                                <span
                                    aria-hidden="true"
                                    class="absolute inset-0"
                                />
                                {{ product.title }}
                            </h3>
                            <h3
                                v-if="product.category"
                                class="text-sm font-medium text-gray-900"
                            >
                                <span
                                    aria-hidden="true"
                                    class="absolute inset-0"
                                />
                                {{ product.category.title }}
                            </h3>
                            <div class="flex flex-1 flex-col justify-end">
                                <p
                                    v-if="product.price"
                                    class="text-base font-medium text-gray-900"
                                >
                                    {{ product.price }} lv.
                                </p>
                            </div>
                        </div>
                    </Link>

                    <WhenVisible
                        always
                        :params="{
                         data: {
                           page: current + 1,
                         },
                         only: ['products', 'current'],
                         preserveUrl: true,
                        }"
                    >
                        <div v-show="current < last">
                            <LoadingAnimation />
                        </div>
                        <template #fallback>
                            <LoadingAnimation />
                        </template>
                    </WhenVisible>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
