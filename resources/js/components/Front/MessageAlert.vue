<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ref, watchEffect } from 'vue';

import { isNotEmpty } from '@/utils';

interface FlashMessages {
    errors?: any;
    error?: string;
    success?: string;
}

interface PageProps {
    flash?: FlashMessages;
}

const page = usePage() as { props: PageProps };
const showAlert = ref(false);

const clearFlashMessages = () => {
    usePage().props.flash = null!;
};

const closeAlert = () => {
    showAlert.value = false;
    clearFlashMessages();
};

watchEffect(() => {
    if (
        isNotEmpty(page.props.flash?.errors) ||
        page.props.flash?.error ||
        page.props.flash?.success
    ) {
        showAlert.value = true;

        setTimeout(() => {
            closeAlert();
        }, 3000);
    }
});
</script>

<template>
    <transition name="slide-fade">
        <div
            v-if="showAlert"
            class="fixed inset-0 z-50"
            role="alert"
            @click="closeAlert"
        >
            <div
                v-if="showAlert"
                class="relative mb-4 rounded border-0 bg-cyan-500 px-6 py-4 text-white"
                @click="closeAlert"
            >
                <span class="mr-5 inline-block align-middle text-xl">
                    <i class="fas fa-bell"></i>
                </span>
                <span
                    v-if="isNotEmpty(page.props.flash?.errors)"
                    class="mr-8 inline-block align-middle"
                >
                    <div
                        v-for="(error, index) in page.props.flash?.errors"
                        :key="index"
                    >
                        {{ error[0] ?? error }}
                    </div>
                </span>
                <span
                    v-else-if="page.props.flash?.error"
                    class="mr-8 inline-block align-middle"
                >
                    {{ page.props.flash?.error }}
                </span>
                <span
                    v-else-if="page.props.flash?.success"
                    class="mr-8 inline-block align-middle"
                >
                    {{ page.props.flash?.success }}
                </span>
                <button
                    class="absolute right-0 top-0 mr-6 mt-4 bg-transparent text-2xl font-semibold leading-none outline-none focus:outline-none"
                >
                    <span>×</span>
                </button>
            </div>
        </div>
    </transition>
</template>
