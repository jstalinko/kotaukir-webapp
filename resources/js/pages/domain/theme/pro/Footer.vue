<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Facebook, Instagram, Twitter, MapPin, Phone, Mail, ArrowRight } from 'lucide-vue-next';
import { getDomainUrl } from '../../../../lib/domain';

const page = usePage();
const domainData = computed(() => page.props.domain || {});
const user = computed(() => domainData.value.user || {});
const site = computed(() => domainData.value.site || {});
const bestProducts = computed(() => domainData.value.best_products || []);
const menus = computed(() => site.value.menus || []);
</script>

<template>
    <footer class="bg-zinc-50 border-t border-zinc-200 pt-16 pb-8 md:pt-24 md:pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-16">

                <!-- 1. Corporate Identity -->
                <div class="flex flex-col items-start border-l-2 border-orange-500 pl-4 md:pl-6 space-y-6">
                    <div class="flex items-center gap-3">
                        <div v-if="!site?.site_logo"
                            class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded flex items-center justify-center text-white font-bold text-xl">
                            {{ (site?.site_name || user.name || '?').charAt(0).toUpperCase() }}
                        </div>
                        <img v-else :src="site.site_logo" class="h-10 w-auto object-contain" />
                        <span class="text-xl font-extrabold tracking-tight text-zinc-900 uppercase">{{ site?.site_name
                            || user.name }}</span>
                    </div>
                    <p class="text-sm text-zinc-500 leading-relaxed font-medium">
                        {{ site?.site_description ||
                            'Professional furniture manufacturing and woodworking solutions with premium quality.' }}
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#"
                            class="w-10 h-10 rounded-full border border-zinc-200 bg-white flex items-center justify-center hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all text-zinc-400">
                            <Instagram class="w-4 h-4" />
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full border border-zinc-200 bg-white flex items-center justify-center hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all text-zinc-400">
                            <Facebook class="w-4 h-4" />
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full border border-zinc-200 bg-white flex items-center justify-center hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all text-zinc-400">
                            <Twitter class="w-4 h-4" />
                        </a>
                    </div>
                </div>

                <!-- 2. Navigation -->
                <div class="md:pl-6">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-zinc-400 mb-6">Navigation</h4>
                    <ul class="flex flex-col gap-3">
                        <template v-if="menus.length > 0">
                            <li v-for="(menu, idx) in menus" :key="idx">
                                <a :href="menu.url"
                                    class="group flex items-center gap-2 text-sm font-semibold text-zinc-700 hover:text-orange-600 transition-colors">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-orange-200 group-hover:bg-orange-500 transition-colors"></span>
                                    {{ menu.label }}
                                </a>
                            </li>
                        </template>
                        <template v-else>
                            <li>
                                <Link :href="getDomainUrl(user.name, '/')"
                                    class="group flex items-center gap-2 text-sm font-semibold text-zinc-700 hover:text-orange-600 transition-colors">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-orange-200 group-hover:bg-orange-500 transition-colors"></span>
                                    Utama
                                </Link>
                            </li>
                            <li>
                                <Link :href="getDomainUrl(user.name, '/products')"
                                    class="group flex items-center gap-2 text-sm font-semibold text-zinc-700 hover:text-orange-600 transition-colors">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-orange-200 group-hover:bg-orange-500 transition-colors"></span>
                                    Koleksi Produk
                                </Link>
                            </li>
                            <li>
                                <Link :href="getDomainUrl(user.name, '/post')"
                                    class="group flex items-center gap-2 text-sm font-semibold text-zinc-700 hover:text-orange-600 transition-colors">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-orange-200 group-hover:bg-orange-500 transition-colors"></span>
                                    Artikel & Jurnal
                                </Link>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- 3. Featured Products -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-zinc-400 mb-6">Top Collection</h4>
                    <div class="flex flex-col gap-4">
                        <template v-if="bestProducts.length > 0">
                            <Link v-for="product in bestProducts.slice(0, 3)" :key="product.id"
                                :href="getDomainUrl(user.name, `/product/${product.slug}`)"
                                class="group flex items-center gap-4 p-2 rounded-xl bg-white border border-zinc-100 hover:border-orange-300 hover:shadow-md transition-all">
                                <div class="w-12 h-12 rounded bg-zinc-100 overflow-hidden flex-shrink-0">
                                    <img v-if="product.images?.[0]"
                                        :src="typeof product.images === 'string' ? JSON.parse(product.images)[0] : product.images[0]"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                </div>
                                <div>
                                    <p
                                        class="text-xs font-bold text-zinc-900 group-hover:text-orange-600 transition-colors line-clamp-1">
                                        {{ product.title }}</p>
                                    <p class="text-[10px] font-medium text-zinc-500 mt-0.5">{{ product.category?.name }}
                                    </p>
                                </div>
                            </Link>
                        </template>
                        <p v-else class="text-sm font-medium text-zinc-500">No popular products yet.</p>
                    </div>
                </div>

                <!-- 4. Contact -->
                <div class="md:pl-6 lg:border-l border-zinc-200">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-zinc-400 mb-6">Headquarters</h4>
                    <ul class="flex flex-col gap-5">
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                                <MapPin class="w-4 h-4 text-orange-600" />
                            </div>
                            <span class="text-sm text-zinc-600 leading-relaxed font-medium">
                                <template v-if="user.address || user.city">
                                    <span class="font-bold text-zinc-900 block mb-0.5">Main Office</span>
                                    {{ user.address }}<br />{{ user.city }}, {{ user.province }} {{ user.postal_code }}
                                </template>
                                <template v-else>
                                    <span class="font-bold text-zinc-900 block mb-0.5">Head Office</span>
                                    Jl. Raya Utama No. 1, Industrial District
                                </template>
                            </span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                                <Phone class="w-4 h-4 text-orange-600" />
                            </div>
                            <a v-if="user.phone" :href="`tel:${user.phone}`"
                                class="text-sm font-semibold text-zinc-600 hover:text-orange-600 transition-colors">{{
                                    user.phone }}</a>
                            <span v-else class="text-sm font-semibold text-zinc-600">+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                                <Mail class="w-4 h-4 text-orange-600" />
                            </div>
                            <a v-if="user.email" :href="`mailto:${user.email}`"
                                class="text-sm font-semibold text-zinc-600 hover:text-orange-600 transition-colors">{{
                                    user.email }}</a>
                            <span v-else class="text-sm font-semibold text-zinc-600">contact@company.com</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 border-t border-zinc-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[11px] font-bold tracking-widest text-zinc-400 uppercase">
                    &copy; {{ new Date().getFullYear() }} {{ site?.site_name || user.name }}. All rights reserved.
                </p>
                <div class="flex gap-6 text-[11px] font-bold uppercase tracking-widest text-zinc-400">
                    <a href="#" class="hover:text-orange-600 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-orange-600 transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</template>
