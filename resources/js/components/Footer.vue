<script setup>
import { Link } from '@inertiajs/vue3';

const year = new Date().getFullYear();
</script>

<template>
    <footer class="py-12 border-t border-white/5 bg-[#050505]">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex flex-col items-center space-y-6">
                <!-- Logo/Brand -->
                <Link href="/"
                    class="text-orange-500 text-2xl font-extrabold tracking-tighter hover:scale-105 transition-transform">
                    kotaukir<span class="text-white">.ID</span>
                </Link>

                <!-- Links -->
                <nav class="flex flex-wrap justify-center gap-x-8 gap-y-2">
                    <Link href="/privacy" class="text-sm text-gray-500 hover:text-orange-500 transition-colors">
                        Kebijakan Privasi
                    </Link>
                    <Link href="/terms" class="text-sm text-gray-500 hover:text-orange-500 transition-colors">
                        Syarat & Ketentuan
                    </Link>
                    <Link href="/contact" class="text-sm text-gray-500 hover:text-orange-500 transition-colors">
                        Kontak
                    </Link>
                </nav>

                <!-- Copyright -->
                <p class="text-sm text-zinc-500">
                    &copy; {{ year }} KotaUkir.ID - Crafted for the finest furniture makers. All
                    rights reserved.
                </p>
            </div>
        </div>
    </footer>
</template>
