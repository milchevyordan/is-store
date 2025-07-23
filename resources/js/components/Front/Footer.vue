<script setup lang="ts">

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="bg-blueGray-200 relative pb-6 pt-8">
        <div class="container mx-auto px-4">
            <div
                class="flex flex-wrap items-center justify-center md:justify-between"
            >
                <div class="mx-auto w-full px-4 text-center md:w-4/12">
                    <div class="text-blueGray-500 py-1  font-semibold">
                        Copyright © {{ currentYear }} IS
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
