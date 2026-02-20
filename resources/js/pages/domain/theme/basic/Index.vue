<script setup>
import Layout from './Layout.vue';
import ProductCard from './components/ProductCard.vue';
import { ChevronRight, ArrowRight, Star, Quote } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { getDomainUrl } from '../../../../lib/domain';

const props = defineProps({
    user: Object,
    site: Object,
    products: Array,
    categories: Array,
    category: Object,
    latest_posts: Array,
});

const stripHtml = (html) => {
    if (!html) return '';
    return html.replace(/<[^>]*>?/gm, '');
};
</script>

<template>
    <Layout :user="user" :site="site">
        <!-- Dashboard Builder Components -->
        <div v-if="!category">
            <template v-for="comp in site?.components?.['basic'] || []" :key="comp.id">
                <!-- Hero Component -->
                <section v-if="comp.type === 'Hero'" class="max-w-7xl mx-auto px-6 lg:px-10 py-20">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                        <div class="lg:col-span-12 text-center space-y-8 max-w-4xl mx-auto">
                            <div class="animate-in fade-in slide-in-from-bottom-4 duration-1000">
                                <span
                                    class="text-[10px] font-black uppercase tracking-[0.4em] text-black/40 block mb-6">
                                    Established {{ new Date().getFullYear() - 5 }}
                                </span>
                                <h1 v-html="comp.settings?.title || 'Modern & <span class=\'italic font-light\'>Minimalist</span> Essentials.'"
                                    class="text-6xl md:text-8xl font-black text-black leading-[0.95] tracking-tighter uppercase mb-8">
                                </h1>
                                <p v-html="comp.settings?.subtitle || 'Curated collection for the contemporary lifestyle.'"
                                    class="text-lg md:text-xl text-black/50 font-medium max-w-2xl mx-auto leading-relaxed">
                                </p>
                            </div>

                            <div
                                class="flex flex-wrap justify-center gap-6 pt-10 animate-in fade-in slide-in-from-bottom-8 duration-1000 delay-300">
                                <button
                                    class="px-12 py-5 bg-black text-white rounded-full font-black text-xs uppercase tracking-[0.2em] shadow-2xl hover:bg-black/80 transition-all hover:scale-105">
                                    Shop Collection
                                </button>
                                <button
                                    class="px-12 py-5 bg-white border border-black/10 text-black rounded-full font-black text-xs uppercase tracking-[0.2em] hover:bg-black hover:text-white transition-all hover:scale-105">
                                    Our Story
                                </button>
                            </div>
                        </div>

                        <!-- Full Width Image -->
                        <div class="lg:col-span-12 animate-in fade-in zoom-in duration-1000 delay-500">
                            <div class="relative aspect-[21/9] rounded-[48px] overflow-hidden bg-[#F0F0F0]">
                                <img src="https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85?auto=format&fit=crop&q=80"
                                    class="w-full h-full object-cover grayscale transition-transform duration-[3s] hover:scale-110" />
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Featured Section -->
                <section v-if="comp.type === 'Featured'" class="max-w-7xl mx-auto px-6 lg:px-10 py-24">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-12 mb-16 px-4">
                        <div class="max-w-2xl">
                            <span
                                class="text-[10px] font-black uppercase tracking-[0.4em] text-black/30 block mb-4">Selected
                                Items</span>
                            <h2 v-html="comp.settings?.title || 'Seasonal <span class=\'italic font-light\'>Selects</span>'"
                                class="text-5xl font-black text-black tracking-tighter uppercase"></h2>
                        </div>
                        <Link :href="getDomainUrl(user.name, '/category/all')"
                            class="text-xs font-black uppercase tracking-[0.2em] text-black px-8 py-4 border border-black/10 rounded-full hover:bg-black hover:text-white transition-all">
                            Browse All
                        </Link>
                    </div>

                    <div v-if="products.length > 0"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        <ProductCard v-for="product in products.slice(0, 4)" :key="product.id" :product="product"
                            :user="user" />
                    </div>
                </section>
            </template>

            <!-- Mandatory Category List -->
            <section class="bg-black py-20 my-20">
                <div class="max-w-7xl mx-auto px-6 lg:px-10">
                    <div class="flex items-center gap-12 overflow-x-auto pb-4 scrollbar-hide">
                        <Link v-for="cat in categories" :key="cat.id"
                            :href="getDomainUrl(user.name, `/category/${cat.slug}`)"
                            class="text-4xl md:text-6xl font-black text-white/20 hover:text-white transition-all whitespace-nowrap uppercase tracking-tighter italic hover:scale-105 duration-500">
                            {{ cat.name }} /
                        </Link>
                    </div>
                </div>
            </section>

            <!-- Mandatory Product Grid -->
            <section class="max-w-7xl mx-auto px-6 lg:px-10 py-24">
                <div class="text-center mb-16">
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-black/30 block mb-4">Complete
                        Inventory</span>
                    <h2 class="text-5xl font-black text-black tracking-tighter uppercase">All Products</h2>
                </div>

                <div v-if="products.length > 0"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                    <ProductCard v-for="product in products" :key="product.id" :product="product" :user="user" />
                </div>
            </section>

            <!-- Latest Posts / Articles -->
            <section v-if="latest_posts && latest_posts.length > 0"
                class="max-w-7xl mx-auto px-6 lg:px-10 py-24 bg-[#FAFAFA] rounded-[48px] my-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-12 mb-16 px-4">
                    <div class="max-w-2xl">
                        <span
                            class="text-[10px] font-black uppercase tracking-[0.4em] text-black/30 block mb-4">Journal</span>
                        <h2 class="text-5xl font-black text-black tracking-tighter uppercase">Latest <span
                                class="italic font-light">Articles</span></h2>
                    </div>
                    <Link :href="getDomainUrl(user.name, '/post')"
                        class="text-xs font-black uppercase tracking-[0.2em] text-black px-8 py-4 border border-black/10 rounded-full hover:bg-black hover:text-white transition-all">
                        Read All
                    </Link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <Link v-for="post in latest_posts" :key="post.id" :href="getDomainUrl(user.name, `/post/${post.slug}`)"
                        class="group block">
                        <div class="aspect-[4/3] rounded-3xl overflow-hidden bg-black/5 mb-6">
                            <img v-if="post.image" :src="post.image"
                                class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105" />
                            <div v-else class="w-full h-full flex items-center justify-center text-black/20">No Image
                            </div>
                        </div>
                        <h3
                            class="text-xl font-bold uppercase tracking-tight mb-3 line-clamp-2 group-hover:text-black/60 transition-colors">
                            {{ post.title }}</h3>
                        <p class="text-sm text-black/50 line-clamp-3 leading-relaxed">{{ stripHtml(post.content) ||
                            'Read more...' }}
                        </p>
                    </Link>
                </div>
            </section>
        </div>

        <!-- Category View -->
        <div v-else class="max-w-7xl mx-auto px-6 lg:px-10 py-20">
            <div class="text-center mb-20 animate-in fade-in slide-in-from-top-8 duration-1000">
                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-black/30 block mb-4">Browsing
                    Category</span>
                <h1 class="text-6xl md:text-8xl font-black text-black tracking-tighter uppercase italic">{{
                    category.name }}
                </h1>
                <p class="text-black/40 mt-6 max-w-xl mx-auto font-medium">{{ category.description
                    || 'Explore our minimalist selection in this curated collection.' }}</p>
            </div>

            <div v-if="products.length > 0"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                <ProductCard v-for="product in products" :key="product.id" :product="product" :user="user" />
            </div>
            <div v-else class="py-40 text-center bg-white rounded-[48px] border border-black/5">
                <h3 class="text-2xl font-black uppercase tracking-tighter">No items found</h3>
                <Link :href="getDomainUrl(user.name, '/')"
                    class="mt-8 inline-block px-10 py-4 bg-black text-white rounded-full font-black text-xs uppercase tracking-widest">
                    Back to home</Link>
            </div>
        </div>
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