<script setup>
import Layout from './Layout.vue';
import { getDomainUrl } from '../../../../lib/domain';
import { Link } from '@inertiajs/vue3';
import { defineAsyncComponent, computed } from 'vue';
import { ArrowRight, Sparkles } from 'lucide-vue-next';

const props = defineProps({
    user: Object,
    site: Object,
    products: Array,
    categories: Array,
    category: Object,
    latest_posts: Array,
});

const activeComponents = computed(() => {
    const comps = props.site?.components;
    if (!comps) return [];
    if (Array.isArray(comps)) return comps;
    return comps['pro'] || [];
});

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(price);
};
</script>

<template>
    <Layout :user="user" :site="site">

        <!-- Corporate Hero -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10 lg:py-20">
            <div
                class="bg-gradient-to-br from-white to-orange-50/30 border border-zinc-200/60 p-6 md:p-12 lg:p-16 relative overflow-hidden rounded-3xl shadow-xl shadow-orange-900/5">
                <!-- Background decoration -->
                <div
                    class="absolute -top-24 -right-24 w-64 h-64 bg-gradient-to-br from-orange-400 to-amber-600 rounded-full blur-3xl opacity-20 hidden md:block">
                </div>
                <div
                    class="absolute -bottom-24 -left-24 w-64 h-64 bg-gradient-to-tr from-amber-400 to-yellow-600 rounded-full blur-3xl opacity-20 hidden md:block">
                </div>

                <div class="relative z-10 max-w-3xl">
                    <span
                        class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-orange-100/80 text-orange-700 text-[10px] md:text-xs font-bold tracking-widest uppercase mb-6 md:mb-8 border border-orange-200">
                        <Sparkles class="w-3 h-3 md:w-4 md:h-4" /> Official Brand
                    </span>
                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-zinc-900 tracking-tight leading-[1.05] mb-6">
                        Professional <br class="hidden sm:block" />
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-amber-500">Woodworking</span>
                        <br class="hidden sm:block" />
                        & Design.
                    </h1>
                    <p
                        class="text-base md:text-lg lg:text-xl font-medium text-zinc-500 max-w-2xl mb-8 md:mb-12 leading-relaxed">
                        {{ site?.site_description ||
                            'We deliver high-quality, precision-crafted' +
                            'furniture for commercial and residential spaces.Built to last, designed to inspire.' }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <Link :href="getDomainUrl(user?.name, '/products')"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-600 to-orange-500 text-white rounded-xl font-bold text-sm tracking-wide shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:-translate-y-0.5 transition-all w-full sm:w-auto">
                            View Catalog
                            <ArrowRight class="ml-2 w-4 h-4" />
                        </Link>
                        <a :href="`tel:${user?.phone || ''}`"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-zinc-900 rounded-xl font-bold text-sm tracking-wide border border-zinc-200 shadow-sm hover:border-orange-200 hover:bg-orange-50 transition-all w-full sm:w-auto">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Line -->
        <section class="border-y border-zinc-100 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-6 overflow-hidden">
                <div class="flex items-center gap-6 md:gap-12 overflow-x-auto scrollbar-hide py-2">
                    <span
                        class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-zinc-400 shrink-0">Filter
                        By</span>
                    <Link v-for="cat in categories" :key="cat.id"
                        :href="getDomainUrl(user?.name, `/category/${cat.slug}`)"
                        class="text-xs md:text-sm font-bold text-zinc-700 hover:text-orange-600 uppercase tracking-wider whitespace-nowrap transition-colors bg-zinc-50 hover:bg-orange-50 px-4 py-2 rounded-lg border border-zinc-200 hover:border-orange-200">
                        {{ cat.name }}
                    </Link>
                </div>
            </div>
        </section>

        <!-- Products Grid -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-16 lg:py-24">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12 border-b border-zinc-200 pb-6">
                <div>
                    <span
                        class="inline-block py-1 px-3 rounded bg-orange-100 text-orange-700 text-[10px] font-bold uppercase tracking-widest mb-3">Inventory</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-zinc-900 tracking-tight">{{ category ?
                        category.name : 'All Products' }}</h2>
                </div>
                <Link v-if="!category" :href="getDomainUrl(user?.name, '/products')"
                    class="inline-flex items-center gap-2 text-sm font-bold text-orange-600 hover:text-orange-700 group">
                    See completely catalog
                    <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                </Link>
            </div>

            <div v-if="products?.length > 0"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                <Link v-for="product in products" :key="product.id"
                    :href="getDomainUrl(user?.name, `/product/${product.slug}`)"
                    class="group block bg-white border border-zinc-200 rounded-2xl p-4 hover:border-orange-300 hover:shadow-xl hover:shadow-orange-900/5 transition-all">

                    <div class="aspect-[4/3] bg-zinc-100 mb-5 overflow-hidden rounded-xl relative">
                        <img v-if="product.images?.[0]"
                            :src="Array.isArray(product.images) ? product.images[0] : JSON.parse(product.images)[0]"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <div v-else class="w-full h-full flex flex-col items-center justify-center text-zinc-300">
                            <span class="text-xs font-bold uppercase tracking-widest">No Image</span>
                        </div>
                    </div>

                    <div class="px-2 pb-2">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-orange-600 block mb-1.5">
                            {{ product.category?.name || 'Uncategorized' }}
                        </span>
                        <h3
                            class="text-lg font-bold text-zinc-900 tracking-tight mb-2 line-clamp-1 group-hover:text-orange-600 transition-colors">
                            {{ product.name || product.title }}
                        </h3>
                        <p class="text-xs text-zinc-500 line-clamp-2 mb-4 h-8 font-medium leading-relaxed">
                            {{ product.description || 'Professional grade product designed' +
                                'for modern homes and' +
                                'offices.' }}
                        </p>

                        <div class="flex justify-between items-center pt-4 border-t border-zinc-100">
                            <span class="font-bold text-zinc-900 text-lg">{{ formatPrice(product.price) }}</span>
                            <span
                                class="w-8 h-8 rounded-full bg-zinc-100 text-zinc-600 flex items-center justify-center group-hover:bg-gradient-to-r group-hover:from-orange-500 group-hover:to-amber-500 group-hover:text-white transition-all shadow-sm">
                                <ArrowRight class="w-3.5 h-3.5" />
                            </span>
                        </div>
                    </div>
                </Link>
            </div>

            <div v-else class="p-16 text-center border-2 border-zinc-200 border-dashed rounded-3xl bg-zinc-50">
                <p class="text-lg font-bold text-zinc-400 tracking-tight">No Products Found</p>
            </div>
        </section>

        <!-- Latest Posts -->
        <section v-if="latest_posts?.length > 0"
            class="bg-zinc-50 py-16 lg:py-24 border-t border-zinc-200 relative overflow-hidden">
            <!-- Deco -->
            <div
                class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-orange-50/50 to-transparent pointer-events-none">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 relative z-10">
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12 border-b border-zinc-200 pb-6">
                    <div>
                        <span
                            class="inline-block py-1 px-3 rounded bg-zinc-200/50 text-zinc-600 text-[10px] font-bold uppercase tracking-widest mb-3">Insights</span>
                        <h2 class="text-3xl md:text-4xl font-extrabold text-zinc-900 tracking-tight">Latest News</h2>
                    </div>
                    <Link :href="getDomainUrl(user?.name, '/post')"
                        class="inline-flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-orange-600 transition-colors group">
                        Browse our journal
                        <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                    </Link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    <Link v-for="post in latest_posts" :key="post.id"
                        :href="getDomainUrl(user?.name, `/post/${post.slug}`)"
                        class="bg-white border border-zinc-200 rounded-2xl overflow-hidden hover:shadow-xl hover:border-orange-300 hover:shadow-orange-900/5 group transition-all">

                        <div class="p-6 md:p-8">
                            <div
                                class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4 flex items-center gap-3">
                                <span>{{ new Date(post.created_at).toLocaleDateString() }}</span>
                                <span class="w-1 h-1 bg-zinc-300 rounded-full"></span>
                                <span>{{ post.views || 0 }} Views</span>
                            </div>
                            <h3
                                class="text-xl font-bold text-zinc-900 tracking-tight mb-3 group-hover:text-orange-600 transition-colors line-clamp-2 leading-snug">
                                {{ post.title }}
                            </h3>
                            <p class="text-sm text-zinc-500 line-clamp-3 leading-relaxed font-medium">
                                {{ post.content?.replace(/<[^>]*>?/gm, '') || 'Read full article...' }}
                            </p>
                        </div>
                        <div
                            class="px-6 md:px-8 py-4 bg-zinc-50/50 border-t border-zinc-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-zinc-900">Read Article</span>
                            <ArrowRight
                                class="w-4 h-4 text-orange-500 group-hover:translate-x-1 transition-transform" />
                        </div>
                    </Link>
                </div>
            </div>
        </section>

    </Layout>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
