<script setup>
import Layout from './Layout.vue';
import { getDomainUrl } from '../../../../lib/domain';
import { Link } from '@inertiajs/vue3';
import { ShieldCheck, Truck, Share2, ArrowLeft } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps({
    user: Object,
    product: Object,
    site: Object,
});

const activeImageIndex = ref(0);

const parseImages = (images) => {
    if (Array.isArray(images)) return images;
    try {
        const parsed = JSON.parse(images);
        return Array.isArray(parsed) ? parsed : [images];
    } catch {
        return images ? [images] : [];
    }
};

const images = parseImages(props.product.images);

const whatsappLink = computed(() => {
    const text = `Hello ${props.user.name}, I am interested in ordering the product: ${props.product.name || props.product.title}. Ref: ${window.location.href}`;
    return `https://wa.me/6281234567890?text=${encodeURIComponent(text)}`;
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
        <div class="bg-zinc-50 border-b border-zinc-200 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
                <!-- Breadcrumbs -->
                <nav class="flex flex-wrap items-center gap-2 text-[10px] md:text-sm font-bold text-zinc-500">
                    <Link :href="getDomainUrl(user.name, '/')"
                        class="hover:text-orange-600 transition-colors inline-flex items-center gap-1.5">
                        <ArrowLeft class="w-3 h-3 md:w-4 md:h-4" /> Home
                    </Link>
                    <span class="text-zinc-300">/</span>
                    <Link :href="getDomainUrl(user.name, '/products')" class="hover:text-orange-600 transition-colors">
                        Catalog</Link>
                    <span v-if="product.category" class="text-zinc-300">/</span>
                    <Link v-if="product.category" :href="getDomainUrl(user.name, `/category/${product.category.slug}`)"
                        class="hover:text-orange-600 transition-colors">{{ product.category.name }}</Link>
                </nav>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-12 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-20">
                <!-- Gallery -->
                <div class="lg:col-span-7">
                    <div class="bg-white border border-zinc-200 rounded-3xl p-2 md:p-3 relative mb-6 shadow-sm">
                        <div class="aspect-[4/3] bg-zinc-50 rounded-2xl overflow-hidden relative group">
                            <img v-if="images.length > 0" :src="images[activeImageIndex]"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                            <div v-else
                                class="w-full h-full flex flex-col gap-2 items-center justify-center font-bold text-zinc-400">
                                <span>No Image Available</span>
                            </div>
                        </div>

                        <div
                            class="absolute top-6 left-6 px-3 py-1.5 bg-gradient-to-r from-orange-600 to-amber-500 text-white text-[10px] md:text-xs font-bold uppercase tracking-widest shadow-md rounded-full">
                            Pro Series
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div v-if="images.length > 1" class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
                        <button v-for="(img, idx) in images" :key="idx" @click="activeImageIndex = idx"
                            class="w-20 md:w-24 aspect-square rounded-xl overflow-hidden border-2 shrink-0 transition-all hover:opacity-100"
                            :class="activeImageIndex === idx ? 'border-orange-500 shadow-md opacity-100' : 'border-zinc-200 opacity-60 hover:border-orange-300'">
                            <img :src="img" class="w-full h-full object-cover" />
                        </button>
                    </div>
                </div>

                <!-- Product Data -->
                <div class="lg:col-span-5 flex flex-col pt-2 lg:pt-8">
                    <div
                        class="inline-block px-3 py-1 bg-orange-100/80 text-orange-700 text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4 rounded-full border border-orange-200 self-start">
                        {{ product.category?.name || 'Collection' }}
                    </div>

                    <h1
                        class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-zinc-900 tracking-tight leading-tight mb-6">
                        {{ product.name || product.title }}
                    </h1>

                    <div
                        class="text-2xl lg:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-amber-600 mb-8 border-b border-zinc-200 pb-8">
                        {{ formatPrice(product.price) }}
                    </div>

                    <div class="prose prose-sm md:prose-base prose-zinc mb-10 text-zinc-600 leading-relaxed max-w-none"
                        v-html="product.description || product.content"></div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10 text-xs md:text-sm font-bold text-zinc-700">
                        <div class="flex items-center gap-3 border border-zinc-200 rounded-xl p-4 bg-zinc-50 shadow-sm">
                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                                <ShieldCheck class="w-4 h-4 text-orange-600" />
                            </div>
                            Premium Quality
                        </div>
                        <div class="flex items-center gap-3 border border-zinc-200 rounded-xl p-4 bg-zinc-50 shadow-sm">
                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                                <Truck class="w-4 h-4 text-orange-600" />
                            </div>
                            Safe Delivery
                        </div>
                    </div>

                    <!-- Direct Order Action -->
                    <div class="mt-auto flex flex-col sm:flex-row gap-4">
                        <a :href="whatsappLink" target="_blank"
                            class="flex-1 py-4 px-6 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white rounded-xl font-bold text-sm text-center shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:-translate-y-0.5 transition-all">
                            Order on WhatsApp
                        </a>
                        <button
                            class="py-4 px-6 bg-white border border-zinc-200 hover:border-zinc-300 text-zinc-700 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2 shadow-sm">
                            <Share2 class="w-4 h-4" /> Share
                        </button>
                    </div>
                </div>
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
