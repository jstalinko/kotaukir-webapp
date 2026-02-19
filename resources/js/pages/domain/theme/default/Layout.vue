<script setup>
import Navbar from './Navbar.vue';
import Footer from './Footer.vue';

defineProps({
    user: Object,
    site: Object,
});
</script>

<template>
    <div class="min-h-screen bg-[#FDFCFB] text-[#2D241E] font-sans selection:bg-orange-100">
        <!-- Background decorative elements -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden opacity-40">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-orange-100/50 rounded-full blur-3xl"></div>
            <div class="absolute top-[20%] -right-[5%] w-[30%] h-[30%] bg-brown-100/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative flex flex-col min-h-screen">
            <Navbar :user="user" :site="site" />

            <main class="flex-1">
                <slot />
            </main>

            <Footer :user="user" :site="site" />
        </div>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');

:root {
    --theme-primary: #D97706;
    /* Warm Orange */
    --theme-secondary: #451A03;
    /* Deep Brown */
    --theme-bg: #FDFCFB;
}

body {
    font-family: 'Outfit', sans-serif;
}

h1,
h2,
h3,
h4,
.font-serif {
    font-family: 'Playfair Display', serif;
}
</style>
