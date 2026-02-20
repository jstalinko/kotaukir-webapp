<script setup>
import { computed } from 'vue';
import Footer from './Footer.vue';

const props = defineProps({
    user: Object,
    site: Object,
});

</script>

<template>
    <div
        class="min-h-screen bg-white font-sans text-zinc-900 selection:bg-orange-500 selection:text-white flex flex-col">

        <!-- Corporate Header (Minimalist, no navigation links) -->
        <header class="bg-white border-b border-zinc-200 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-4 flex justify-between items-center">

                <!-- Logo & Brand -->
                <div class="flex items-center gap-3 md:gap-4">
                    <div v-if="!site?.site_logo"
                        class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-orange-500 to-amber-500 rounded-lg text-white flex items-center justify-center font-bold text-xl md:text-2xl shadow-inner">
                        {{ (site?.site_name || user?.name || '?').charAt(0).toUpperCase() }}
                    </div>
                    <img v-else :src="site.site_logo" class="h-10 md:h-12 w-auto object-contain" />
                    <div class="flex flex-col">
                        <span
                            class="text-xl md:text-2xl font-extrabold tracking-tight text-zinc-900 uppercase leading-none">{{
                                site?.site_name || user?.name }}</span>
                        <span
                            class="text-[9px] md:text-[10px] font-bold text-orange-600 uppercase tracking-widest mt-1">{{
                                site?.site_slogan || 'Professional Woodworking' }}</span>
                    </div>
                </div>

                <!-- Contact CTA (Hidden on very small screens) -->
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">Get in Touch</span>
                    <a v-if="user?.phone" :href="`tel:${user.phone}`"
                        class="text-sm md:text-base font-bold text-zinc-900 hover:text-orange-600 transition-colors bg-orange-50 px-3 py-1 rounded-full border border-orange-200">
                        {{ user.phone }}
                    </a>
                    <a v-else href="tel:+6281234567890"
                        class="text-sm md:text-base font-bold text-zinc-900 hover:text-orange-600 transition-colors bg-orange-50 px-3 py-1 rounded-full border border-orange-200">
                        +62 812 3456 7890
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow w-full relative">
            <slot />
        </main>

        <Footer />
    </div>
</template>

<style>
/* Smooth scrolling and basic resets */
html {
    scroll-behavior: smooth;
}
</style>
