<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import { home } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="dark min-h-screen bg-[#050505] flex flex-col">
        <Navbar />

        <!-- Main content area -->
        <div class="flex-1 flex items-center justify-center px-4 py-32 relative overflow-hidden">
            <!-- Background glow effects matching Hero -->
            <div class="absolute inset-0 z-0 pointer-events-none">
                <div
                    class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-orange-600/8 rounded-full blur-[120px]">
                </div>
                <div class="absolute bottom-1/4 right-1/4 w-[400px] h-[400px] bg-[#D2691E]/6 rounded-full blur-[100px]">
                </div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,transparent_0%,#050505_70%)]">
                </div>
            </div>

            <!-- Auth card -->
            <div class="w-full max-w-xl relative z-10">
                <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-2xl p-8 shadow-2xl">
                    <div class="flex flex-col gap-8">
                        <!-- Logo & Title -->
                        <div class="flex flex-col items-center gap-4">
                            <Link :href="home()"
                                class="text-orange-500 text-2xl font-extrabold tracking-tighter hover:scale-105 transition-transform">
                                kotaukir<span class="text-white">.ID</span>
                            </Link>
                            <div class="space-y-2 text-center">
                                <h1 class="text-xl font-semibold text-white">{{ title }}</h1>
                                <p class="text-sm text-gray-400">
                                    {{ description }}
                                </p>
                            </div>
                        </div>
                        <slot />
                    </div>
                </div>
            </div>
        </div>

        <Footer />
    </div>
</template>
