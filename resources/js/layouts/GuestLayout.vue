<script setup lang="ts">
import Footer from '@/Components/Front/Footer.vue';
import MessageAlert from '@/Components/Front/MessageAlert.vue';
import Nav from '@/Components/Front/Nav.vue';

defineProps<{
    navTransparent?: boolean;
}>();
</script>

<template>
    <Nav :transparent="navTransparent" />

    <MessageAlert />

    <slot />

    <Footer />
</template>
