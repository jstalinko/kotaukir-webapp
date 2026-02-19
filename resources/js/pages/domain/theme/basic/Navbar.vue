<script setup>
import { Link } from '@inertiajs/vue3';
import { ShoppingBag, Search, Menu, X } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
    site: Object,
});

const isMobileMenuOpen = ref(false);
</script>

<template>
    <nav class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-5xl">
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/20 shadow-2xl rounded-[32px] px-6 py-4 transition-all duration-300">
            <div class="flex justify-between items-center h-12">
                <!-- Left Nav (Desktop) -->
                <div class="hidden md:flex items-center space-x-6 flex-1">
                    <template v-if="site?.menus && site.menus.length > 0">
                        <Link v-for="item in site.menus.slice(0, 2)" :key="item.id" :href="item.url"
                            class="text-xs font-bold uppercase tracking-widest text-black/50 hover:text-black transition-colors">
                            {{ item.label }}
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="`/domain/${user.name}`"
                            class="text-xs font-bold uppercase tracking-widest text-black/50 hover:text-black transition-colors">
                            Home
                        </Link>
                        <Link :href="`/domain/${user.name}/category/all`"
                            class="text-xs font-bold uppercase tracking-widest text-black/50 hover:text-black transition-colors">
                            Shop
                        </Link>
                    </template>
                </div>

                <!-- Logo (Center) -->
                <div class="flex-shrink-0 flex items-center justify-center flex-1">
                    <Link :href="`/domain/${user.name}`" class="flex items-center gap-3">
                        <div v-if="!site?.site_logo"
                            class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ (site?.site_name || user.name).charAt(0).toUpperCase() }}
                        </div>
                        <img v-else :src="site.site_logo" class="h-10 w-auto object-contain" />
                        <span class="text-xl font-black tracking-tighter text-black uppercase">{{ site?.site_name ||
                            user.name }}</span>
                    </Link>
                </div>

                <!-- Right Nav (Desktop) -->
                <div class="hidden md:flex items-center justify-end space-x-6 flex-1">
                    <template v-if="site?.menus && site.menus.length > 2">
                        <Link v-for="item in site.menus.slice(2, 4)" :key="item.id" :href="item.url"
                            class="text-xs font-bold uppercase tracking-widest text-black/50 hover:text-black transition-colors">
                            {{ item.label }}
                        </Link>
                    </template>
                    <div class="flex items-center space-x-2 pl-4 border-l border-black/5">
                        <button class="p-2 text-black/50 hover:text-black transition-colors">
                            <Search class="w-4 h-4" />
                        </button>
                        <button class="p-2 text-black/50 hover:text-black transition-colors relative">
                            <ShoppingBag class="w-4 h-4" />
                            <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-black rounded-full"></span>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="p-2 text-black">
                        <Menu v-if="!isMobileMenuOpen" class="w-6 h-6" />
                        <X v-else class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div v-show="isMobileMenuOpen"
            class="md:hidden mt-4 bg-white/90 backdrop-blur-2xl border border-white/20 shadow-2xl rounded-[32px] overflow-hidden animate-in slide-in-from-top-4 duration-300">
            <div class="px-6 py-8 space-y-4 text-center">
                <template v-if="site?.menus && site.menus.length > 0">
                    <Link v-for="item in site.menus" :key="item.id" :href="item.url"
                        class="block text-lg font-bold text-black border-b border-black/5 pb-4 last:border-0">
                        {{ item.label }}
                    </Link>
                </template>
                <div class="flex justify-center gap-6 pt-4">
                    <button class="p-3 bg-black text-white rounded-full">
                        <Search class="w-5 h-5" />
                    </button>
                    <button class="p-3 bg-black text-white rounded-full relative">
                        <ShoppingBag class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>
    </nav>
</template>
