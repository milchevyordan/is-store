<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Product } from '@/types';

defineProps<{
    offerings: Product[];
}>();
</script>

<template>
    <Head title="Is" />

    <GuestLayout>
        <section class="header relative flex max-h-[860px] items-center pt-16">
            <div class="container mx-auto flex flex-wrap items-center">
                <!-- Text Content -->
                <div class="w-full px-4 md:w-8/12 lg:w-6/12">
                    <div class="my-20 pt-16 sm:pt-0 md:pt-32">
                        <h2
                            class="text-blueGray-600 text-center text-3xl font-semibold md:text-left md:text-4xl"
                        >
                            The technology you can rely on!
                        </h2>
                        <p
                            class="text-blueGray-500 mt-4 text-center text-base leading-relaxed md:text-left md:text-lg"
                        >
                            Power. Innovation
                        </p>
                        <div
                            class="mt-8 flex flex-col justify-center md:flex-row md:justify-start"
                        >
                            <Link
                                :href="route('home')"
                                class="get-started mb-3 rounded bg-cyan-500 px-6 py-4 text-center font-bold uppercase text-white shadow outline-none transition-all duration-150 ease-linear hover:shadow-lg focus:outline-none active:bg-emerald-600 md:mb-0 md:mr-3"
                            >
                                Check the products
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="w-full md:w-4/12 lg:w-6/12 xl:w-6/12">
                    <img
                        class="b-auto mx-auto h-auto max-w-full object-contain md:absolute md:right-0 md:top-0 md:mt-20 md:w-5/12"
                        src="/images/cover-image.webp"
                        alt="iPhone"
                    />
                </div>
            </div>
        </section>

        <section class="bg-blueGray-100 relative mt-48 pb-40 md:mt-40">
            <div
                class="absolute bottom-auto left-0 right-0 top-0 -mt-20 h-20 w-full"
                style="transform: translateZ(0)"
            >
                <svg
                    class="absolute bottom-0 overflow-hidden"
                    xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none"
                    version="1.1"
                    viewBox="0 0 2560 100"
                    x="0"
                    y="0"
                >
                    <polygon
                        class="text-blueGray-100 fill-current"
                        points="2560 0 2560 100 0 100"
                    ></polygon>
                </svg>
            </div>

            <div class="mt-24 flex flex-wrap justify-center text-center">
                <div class="w-full px-12 md:w-6/12 md:px-4">
                    <h2 class="text-4xl font-semibold">
                        Our offerings
                    </h2>
                </div>
            </div>
        </section>

        <section class="z-1 bg-blueGray-600 relative block">
            <div class="container mx-auto">
                <div class="flex flex-wrap justify-center">
                    <div class="lg:w-12/12 -mt-24 w-full px-4">
                        <div class="flex flex-wrap">
                            <div
                                v-for="product in offerings"
                                :key="product.id"
                                class="w-full px-4 lg:w-4/12"
                            >
                                <h5
                                    class="pb-4 text-center text-xl font-semibold"
                                >
                                    {{ product.title }}
                                </h5>
                                <Link :href="route('product', product.slug)">
                                    <div
                                        class="relative mb-6 flex w-full min-w-0 flex-col break-words rounded-lg bg-white shadow-lg transition-all duration-150 ease-linear hover:-mt-4"
                                    >
                                        <img
                                            alt="..."
                                            class="h-auto max-w-full rounded-lg border-none align-middle"
                                            :src="`/storage/${product.image}`"
                                        />
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
