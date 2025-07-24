<script setup lang="ts">
import { computed, onMounted, onUnmounted, watch } from "vue";

import IconXmark from "@/icons/X-mark.vue";

const props = withDefaults(
    defineProps<{
        show?: boolean;
        maxWidth?:
            | "sm"
            | "md"
            | "lg"
            | "xl"
            | "2xl"
            | "3xl"
            | "4xl"
            | "5xl"
            | "6xl"
            | "7xl";
        closeable?: boolean;
    }>(),
    {
        show: false,
        maxWidth: "2xl",
        closeable: true,
    }
);

const emit = defineEmits(["close"]);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = "hidden";
        } else {
            document.body.style.overflow = "visible";
        }
    }
);

const close = () => {
    if (props.closeable) {
        emit("close");
    }
};

const closeOnEscape = (e: KeyboardEvent) => {
    if (e.key === "Escape" && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => {
    document.removeEventListener("keydown", closeOnEscape);
    document.body.style.overflow = "visible";
});

const maxWidthClass = computed(() => {
    return {
        sm: "sm:max-w-sm",
        md: "sm:max-w-md",
        lg: "sm:max-w-lg",
        xl: "sm:max-w-xl",
        "2xl": "sm:max-w-2xl",
        "3xl": "sm:max-w-3xl",
        "4xl": "sm:max-w-4xl",
        "5xl": "sm:max-w-5xl",
        "6xl": "sm:max-w-6xl",
        "7xl": "sm:max-w-7xl",
    }[props.maxWidth];
});
</script>

<template>
    <teleport to="body">
        <transition name="modal-fade" appear>
            <div
                v-show="show"
                class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-0"
                scroll-region
            >
                <!-- Backdrop -->
                <transition name="fade" appear>
                    <div
                        v-show="show"
                        class="fixed inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"
                        @click="close"
                    />
                </transition>

                <!-- Modal Container -->
                <transition name="modal-slide" appear>
                    <div
                        v-show="show"
                        class="relative mb-6 w-full rounded-lg bg-white shadow-xl dark:bg-gray-800"
                        :class="maxWidthClass"
                    >
                        <!-- Close Button -->
                        <IconXmark
                            class="absolute w-6 h-6 cursor-pointer right-3 top-3 hover:opacity-70 transition-all active:scale-90"
                            @click="close"
                        />
                        <slot v-if="show" />
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>
