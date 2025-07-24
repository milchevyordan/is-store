<script setup lang="ts">
import '../../css/tailwind.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import Footer from '@/components/Front/Footer.vue';
import MessageAlert from '@/components/Front/MessageAlert.vue';
import Nav from '@/components/Front/Nav.vue';

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
