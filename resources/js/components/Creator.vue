<script setup lang="ts">
import InputLabel from '@/components/InputLabel.vue';
import TextInput from '@/components/TextInput.vue';

defineProps<{
    creatorName?: string;
    image?: string;
}>();
</script>

<template>
    <div class="mt-6 space-y-6">
        <div v-if="creatorName">
            <InputLabel value="Creator" />

            <TextInput id="name" :model-value="creatorName" type="text" disabled class="mt-1 block w-full" />
        </div>
        <div v-if="image" class="mx-auto mt-16 w-full">
            <div class="relative w-full">
                <img :src="`/storage/${image}`" alt="Current Image" />
                <div class="absolute inset-0 rounded-2xl ring-1 ring-gray-900/10 ring-inset" />
            </div>
        </div>
    </div>
</template>
