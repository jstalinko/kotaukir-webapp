<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Facebook, Instagram, Twitter, MapPin, Phone, Mail } from 'lucide-vue-next';
import { getDomainUrl } from '../../../../lib/domain';

const page = usePage();
const domainData = computed(() => page.props.domain || {});
const user = computed(() => domainData.value.user || {});
const site = computed(() => domainData.value.site || {});
const bestProducts = computed(() => domainData.value.best_products || []);
const menus = computed(() => site.value.menus || []);
</script>

<template>
    <footer class="bg-[#2D241E] text-white pt-20 pb-10 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

                <!-- 1. Brand -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div v-if="!site?.site_logo"
                            class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center text-white font-serif text-xl font-bold">
                            {{ (site?.site_name || user.name || '?').charAt(0).toUpperCase() }}
                        </div>
                        <img v-else :src="site.site_logo" class="h-10 w-auto object-contain bg-white/10 rounded" />
                        <span class="text-2xl font-bold font-serif tracking-tight">{{ site?.site_name || user.name
                        }}</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                        {{ site?.site_description || 'Website furniture gratis di buat di kotaukir.id' }}
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="#"
                            class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-orange-600 hover:border-orange-600 transition-all text-gray-400 hover:text-white">
                            <Instagram class="w-4 h-4" />
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-orange-600 hover:border-orange-600 transition-all text-gray-400 hover:text-white">
                            <Facebook class="w-4 h-4" />
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-orange-600 hover:border-orange-600 transition-all text-gray-400 hover:text-white">
                            <Twitter class="w-4 h-4" />
                        </a>
                    </div>
                </div>

                <!-- 2. Navigasi / Menu Links -->
                <div>
                    <h4 class="text-lg font-bold font-serif mb-6">Navigasi</h4>
                    <ul class="space-y-4">
                        <template v-if="menus.length > 0">
                            <li v-for="(menu, idx) in menus" :key="idx">
                                <a :href="menu.url"
                                    class="text-gray-400 hover:text-orange-400 text-sm transition-colors">{{ menu.label
                                    }}</a>
                            </li>
                        </template>
                        <template v-else>
                            <li>
                                <Link :href="getDomainUrl(user.name, '/')"
                                    class="text-gray-400 hover:text-orange-400 text-sm transition-colors">Utama</Link>
                            </li>
                            <li>
                                <Link :href="getDomainUrl(user.name, '/products')"
                                    class="text-gray-400 hover:text-orange-400 text-sm transition-colors">Koleksi Produk
                                </Link>
                            </li>
                            <li>
                                <Link :href="getDomainUrl(user.name, '/post')"
                                    class="text-gray-400 hover:text-orange-400 text-sm transition-colors">Artikel &
                                    Jurnal</Link>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- 3. Produk Terlaris -->
                <div>
                    <h4 class="text-lg font-bold font-serif mb-6">Produk Populer</h4>
                    <div class="space-y-4">
                        <template v-if="bestProducts.length > 0">
                            <Link v-for="product in bestProducts.slice(0, 3)" :key="product.id"
                                :href="getDomainUrl(user.name, `/product/${product.slug}`)"
                                class="group flex items-center gap-4">
                                <div class="w-12 h-12 rounded bg-white/5 overflow-hidden flex-shrink-0">
                                    <img v-if="product.images?.[0]"
                                        :src="typeof product.images === 'string' ? JSON.parse(product.images)[0] : product.images[0]"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors line-clamp-1">
                                        {{ product.title }}</p>
                                    <p class="text-xs text-orange-400/80 mt-1">{{ product.category?.name }}</p>
                                </div>
                            </Link>
                        </template>
                        <p v-else class="text-sm text-gray-500 italic">Belum ada produk.</p>
                    </div>
                </div>

                <!-- 4. Kontak & Visit -->
                <div>
                    <h4 class="text-lg font-bold font-serif mb-6">Lokasi & Kontak</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <MapPin class="w-5 h-5 text-orange-600 shrink-0 mt-0.5" />
                            <span class="text-gray-400 text-sm leading-snug">
                                <template v-if="user.address || user.city">
                                    {{ user.address }}, {{ user.city }}<br />{{ user.province }} {{ user.postal_code }}
                                </template>
                                <template v-else>
                                    Jl. Raya Ukir Jepara No. 123, Central Java, Indonesia
                                </template>
                            </span>
                        </li>
                        <li class="flex items-center gap-3">
                            <Phone class="w-5 h-5 text-orange-600 shrink-0" />
                            <a v-if="user.phone" :href="`tel:${user.phone}`"
                                class="text-gray-400 hover:text-orange-400 text-sm transition-colors">{{ user.phone
                                }}</a>
                            <span v-else class="text-gray-400 text-sm">+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <Mail class="w-5 h-5 text-orange-600 shrink-0" />
                            <a v-if="user.email" :href="`mailto:${user.email}`"
                                class="text-gray-400 hover:text-orange-400 text-sm transition-colors">{{ user.email
                                }}</a>
                            <span v-else class="text-gray-400 text-sm">info@kotaukir.com</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div
                class="pt-8 border-t border-white/5 text-center px-4 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-gray-500 font-medium tracking-wider uppercase">
                    &copy; {{ new Date().getFullYear() }} {{ site?.site_name || user.name }}. Crafted with pride.
                </p>
                <div class="flex gap-4 text-xs text-gray-500 font-medium uppercase tracking-wider">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Term of Service</a>
                </div>
            </div>
        </div>
    </footer>
</template>