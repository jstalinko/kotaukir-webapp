<script setup>
import { Link } from '@inertiajs/vue3';
import { ShoppingBag, Search, Menu, X } from 'lucide-vue-next';
import { ref } from 'vue';
import { getDomainUrl } from '../../../../lib/domain';

const props = defineProps({
    user: Object,
    site: Object,
});

const isMobileMenuOpen = ref(false);
</script>

<template>
    <nav class="sticky top-0 z-50 bg-[#FDFCFB]/80 backdrop-blur-md border-b border-brown-100/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div v-if="!site?.site_logo"
                        class="w-10 h-10 bg-[#451A03] rounded-lg flex items-center justify-center text-white font-serif text-xl font-bold">
                        {{ (site?.site_name || user.name).charAt(0).toUpperCase() }}
                    </div>
                    <img v-else :src="site.site_logo" class="h-10 w-auto object-contain" />

                    <div class="flex flex-col">
                        <span class="text-xl font-bold font-serif tracking-tight text-[#451A03]">{{ site?.site_name ||
                            user.name }}</span>
                        <span class="text-[10px] uppercase tracking-[0.2em] text-orange-600 font-bold -mt-1">{{
                            site?.site_slogan || 'Furniture Gallery' }}</span>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <template v-if="site?.menus && site.menus.length > 0">
                        <Link v-for="item in site.menus" :key="item.id" :href="item.url"
                            class="text-sm font-medium text-[#451A03]/70 hover:text-orange-600 transition-colors">
                            {{ item.label }}
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="getDomainUrl(user.name, '/')"
                            class="text-sm font-medium text-[#451A03]/70 hover:text-orange-600 transition-colors">Home
                        </Link>
                        <Link :href="getDomainUrl(user.name, '/products')"
                            class="text-sm font-medium text-[#451A03]/70 hover:text-orange-600 transition-colors">
                            Koleksi
                        </Link>
                    </template>
                </div>

                <!-- Icons -->
                <div class="hidden md:flex items-center space-x-5">
                    <button class="p-2 text-[#451A03]/70 hover:text-orange-600 transition-all hover:scale-110">
                        <Search class="w-5 h-5" />
                    </button>
                    <button class="relative p-2 text-[#451A03]/70 hover:text-orange-600 transition-all hover:scale-110">
                        <ShoppingBag class="w-5 h-5" />
                        <span
                            class="absolute top-1 right-1 w-2 h-2 bg-orange-600 rounded-full border-2 border-[#FDFCFB]"></span>
                    </button>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="p-2 rounded-md text-[#451A03]">
                        <Menu v-if="!isMobileMenuOpen" class="w-6 h-6" />
                        <X v-else class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div v-show="isMobileMenuOpen"
            class="md:hidden bg-[#FDFCFB] border-t border-brown-100/10 shadow-xl overflow-hidden animate-in slide-in-from-top-4 duration-300">
            <div class="px-4 pt-4 pb-6 space-y-2">
                <template v-if="site?.menus && site.menus.length > 0">
                    <Link v-for="item in site.menus" :key="item.id" :href="item.url"
                        class="block px-4 py-3 text-base font-medium text-[#451A03] rounded-xl hover:bg-orange-50">
                        {{ item.label }}
                    </Link>
                </template>
                <template v-else>
                    <Link :href="getDomainUrl(user.name, '/')"
                        class="block px-4 py-3 text-base font-medium text-[#451A03] rounded-xl hover:bg-orange-50">Home
                    </Link>
                    <Link :href="getDomainUrl(user.name, '/products')"
                        class="block px-4 py-3 text-base font-medium text-[#451A03] rounded-xl hover:bg-orange-50">
                        Koleksi
                    </Link>
                </template>
            </div>
        </div>
    </nav>
</template>