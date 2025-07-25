<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const navBarOpen = ref(false);

defineProps<{
    transparent?: boolean;
}>();

const toggleNavbar = () => {
    navBarOpen.value = !navBarOpen.value;
};
</script>

<template>
    <nav
        class="navbar-expand-lg top-0 z-50 flex w-full flex-wrap items-center justify-between px-2 py-3"
        :class="{
            absolute: transparent,
            'fixed bg-white shadow': !transparent,
        }"
    >
        <div
            class="container mx-auto flex flex-wrap items-center justify-between px-4"
        >
            <div
                class="relative flex w-full justify-between lg:static lg:block lg:w-auto lg:justify-start"
            >
                <Link
                    class="mr-4 inline-block whitespace-nowrap py-2 font-bold uppercase leading-relaxed"
                    :href="route('home')"
                >
                    <span class="text-cyan-500">IS</span>
                </Link>
                <button
                    class="block cursor-pointer rounded border border-solid border-transparent bg-transparent px-3 py-1 text-xl leading-none outline-none focus:outline-none lg:hidden"
                    type="button"
                    @click="toggleNavbar"
                >
                    <i
                        class="fas fa-bars"
                        :class="{
                            'text-white': transparent,
                        }"
                    ></i>
                </button>
            </div>
            <div
                class="flex-grow items-center lg:flex"
                :class="{
                    'block rounded shadow-lg': navBarOpen,
                    hidden: !navBarOpen,
                    'bg-white lg:bg-opacity-0 lg:shadow-none': transparent,
                }"
                id="example-navbar-warning"
            >
                <ul class="mr-auto flex list-none flex-col lg:flex-row">
                    <li class="flex items-center">
                        <Link
                            class="text-blueGray-700 flex items-center px-3 text-xs font-bold uppercase"
                            :class="{
                                'lg:hover:text-blueGray-200 py-4 lg:py-2 lg:text-white':
                                    transparent,
                                'hover:text-blueGray-500 py-2': !transparent,
                            }"
                            :href="route('products')"
                        >
                            <i
                                class="text-blueGray-400 fa-solid fa-cube leading-lg mr-2 text-lg"
                                :class="{
                                    'lg:text-blueGray-200': transparent,
                                }"
                            />
                            All Products
                        </Link>
                    </li>
                </ul>
                <ul class="flex list-none flex-col lg:ml-auto lg:flex-row">
                    <nav class="flex items-center justify-end gap-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a]"
                        >
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035]"
                            >
                                Log in
                            </Link>
                            <Link
                                :href="route('register')"
                                class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a]"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                    <li class="flex items-center">
                        <Link
                            class="relative mb-3 ml-3 rounded bg-cyan-500 px-4 py-2 text-xs font-bold uppercase text-white shadow outline-none transition-all duration-150 ease-linear hover:shadow-lg focus:outline-none lg:mb-0 lg:mr-1"
                            :href="route('home')"
                        >
                            <i class="fa-solid fa-cart-shopping mr-1"></i>
                            Количка
                            <span
                                v-if="usePage().props.cartItemsCount > 0"
                                class="absolute -right-2 -top-2 rounded-full bg-red-500 px-2 text-xs font-bold text-white"
                            >
                                {{ usePage().props.cartItemsCount }}
                            </span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
