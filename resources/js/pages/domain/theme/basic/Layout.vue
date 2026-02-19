<script setup>
import Navbar from './Navbar.vue';
import Footer from './Footer.vue';

defineProps({
    user: Object,
    site: Object,
});
</script>

<template>
    <div class="min-h-screen bg-[#F8F8F8] font-sans selection:bg-black selection:text-white">
        <!-- Site Navbar -->
        <Navbar :user="user" :site="site" />

        <!-- Main Content -->
        <main class="pt-32 pb-20">
            <slot />
        </main>

        <!-- Site Footer -->
        <Footer :user="user" :site="site" />
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

:root {
    --font-sans: 'Inter', sans-serif;
}

body {
    font-family: var(--font-sans);
}
</style>
