<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { getDomainUrl } from '../../../../lib/domain';

const page = usePage();
const domainData = computed(() => page.props.domain || {});
const user = computed(() => domainData.value.user || {});
const site = computed(() => domainData.value.site || {});
const bestProducts = computed(() => domainData.value.best_products || []);
const menus = computed(() => site.value.menus || []);
</script>

<template>
    <footer class="bg-white border-t border-black/5 py-24">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 border-b border-black/5 pb-20">

                <!-- 1. Brand & Description -->
                <div class="flex flex-col items-start">
                    <div class="flex items-center gap-3 mb-6">
                        <div v-if="!site?.site_logo"
                            class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white font-black text-sm">
                            {{ (site?.site_name || user.name || '?').charAt(0).toUpperCase() }}
                        </div>
                        <img v-else :src="site.site_logo" class="h-10 w-auto object-contain" />
                        <span class="text-xl font-black tracking-tighter text-black uppercase">{{ site?.site_name ||
                            user.name }}</span>
                    </div>
                    <p class="text-sm text-black/50 leading-relaxed font-medium max-w-[250px]">
                        {{ site?.site_description || 'Elevating everyday living with modern, minimalist essentials.' }}
                    </p>
                </div>

                <!-- 2. Menu Links -->
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-black/30 mb-8">Navigation</h4>
                    <div class="flex flex-col gap-4">
                        <template v-if="menus.length > 0">
                            <a v-for="(menu, idx) in menus" :key="idx" :href="menu.url"
                                class="text-sm font-bold tracking-tight text-black/70 hover:text-black transition-colors">
                                {{ menu.label }}
                            </a>
                        </template>
                        <template v-else>
                            <Link :href="getDomainUrl(user.name, '/')"
                                class="text-sm font-bold tracking-tight text-black/70 hover:text-black transition-colors">
                                Home</Link>
                            <Link :href="getDomainUrl(user.name, '/products')"
                                class="text-sm font-bold tracking-tight text-black/70 hover:text-black transition-colors">
                                Shop</Link>
                            <Link :href="getDomainUrl(user.name, '/post')"
                                class="text-sm font-bold tracking-tight text-black/70 hover:text-black transition-colors">
                                Journal</Link>
                        </template>
                    </div>
                </div>

                <!-- 3. Best Selling Products -->
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-black/30 mb-8">Best Sellers</h4>
                    <div class="flex flex-col gap-4">
                        <template v-if="bestProducts.length > 0">
                            <Link v-for="product in bestProducts.slice(0, 3)" :key="product.id"
                                :href="getDomainUrl(user.name, `/product/${product.slug}`)" class="group flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-black/5 overflow-hidden flex-shrink-0">
                                    <img v-if="product.images?.[0]"
                                        :src="typeof product.images === 'string' ? JSON.parse(product.images)[0] : product.images[0]"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-bold tracking-tight text-black/80 group-hover:text-black transition-colors line-clamp-1">
                                        {{ product.title }}</p>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-black/30 mt-1">{{
                                        product.category?.name }}</p>
                                </div>
                            </Link>
                        </template>
                        <p v-else class="text-sm text-black/40 italic">New arrivals coming soon.</p>
                    </div>
                </div>

                <!-- 4. Address & Contact -->
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-black/30 mb-8">Visit & Contact</h4>
                    <address class="not-italic flex flex-col gap-3 text-sm font-medium text-black/60">
                        <p v-if="user.address || user.city">{{ user.address }}, {{ user.city }}<br />{{ user.province }}
                            {{
                            user.postal_code }}</p>
                        <p v-else>Virtual Studio location.</p>

                        <div class="mt-4 flex flex-col gap-2">
                            <a v-if="user.email" :href="`mailto:${user.email}`"
                                class="hover:text-black transition-colors">{{ user.email
                                }}</a>
                            <a v-if="user.phone" :href="`tel:${user.phone}`"
                                class="hover:text-black transition-colors">{{ user.phone
                                }}</a>
                        </div>
                    </address>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-black/30">
                    &copy; {{ new Date().getFullYear() }} {{ site?.site_name || user.name }}. All rights reserved.
                </p>
                <div class="flex gap-6 uppercase tracking-[0.2em] text-[10px] font-bold text-black/30">
                    <a href="#" class="hover:text-black transition-colors">Privacy</a>
                    <a href="#" class="hover:text-black transition-colors">Terms</a>
                </div>
            </div>
        </div>
    </footer>
</template>
