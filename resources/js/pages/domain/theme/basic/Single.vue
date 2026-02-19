<script setup>
import Layout from './Layout.vue';
import { ShoppingBag, MessageCircle, ChevronLeft, ChevronRight, Share2, Star, ShieldCheck, Truck } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
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
        return images ? [images] : ['https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85?auto=format&fit=crop&q=80'];
    }
};

const images = parseImages(props.product.images);

const whatsappLink = computed(() => {
    const text = `Halo ${props.user.name}, saya tertarik dengan produk ${props.product.name} yang saya lihat di website.`;
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
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-10">
            <!-- Breadcrumbs -->
            <nav class="flex mb-12 text-[10px] font-black uppercase tracking-[0.3em]" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-3">
                    <li>
                        <Link :href="`/domain/${user.name}`" class="text-black/30 hover:text-black">Home</Link>
                    </li>
                    <li class="flex items-center space-x-3">
                        <span class="text-black/10">/</span>
                        <span class="text-black/30">Products</span>
                    </li>
                    <li v-if="product.category" class="flex items-center space-x-3">
                        <span class="text-black/10">/</span>
                        <Link :href="`/domain/${user.name}/category/${product.category.slug}`"
                            class="text-black/30 hover:text-black">{{ product.category.name }}</Link>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24">
                <!-- Left: Gallery -->
                <div class="lg:col-span-7 space-y-8">
                    <div
                        class="relative aspect-[4/5] rounded-[48px] overflow-hidden bg-white border border-black/5 group shadow-2xl shadow-black/5">
                        <img :src="images[activeImageIndex]" :alt="product.name"
                            class="w-full h-full object-cover transition-all duration-1000 grayscale group-hover:grayscale-0" />

                        <!-- Navigation Arrows -->
                        <div v-if="images.length > 1"
                            class="absolute inset-x-8 top-1/2 -translate-y-1/2 flex justify-between opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="activeImageIndex = (activeImageIndex - 1 + images.length) % images.length"
                                class="w-14 h-14 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-black shadow-2xl hover:bg-black hover:text-white transition-all scale-90 group-hover:scale-100">
                                <ChevronLeft class="w-6 h-6" />
                            </button>
                            <button @click="activeImageIndex = (activeImageIndex + 1) % images.length"
                                class="w-14 h-14 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-black shadow-2xl hover:bg-black hover:text-white transition-all scale-90 group-hover:scale-100">
                                <ChevronRight class="w-6 h-6" />
                            </button>
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div v-if="images.length > 1" class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
                        <button v-for="(img, index) in images" :key="index" @click="activeImageIndex = index"
                            class="w-24 aspect-square rounded-[24px] overflow-hidden border-2 transition-all shrink-0"
                            :class="activeImageIndex === index ? 'border-black' : 'border-black/5 opacity-50'">
                            <img :src="img" class="w-full h-full object-cover grayscale" />
                        </button>
                    </div>
                </div>

                <!-- Right: Content -->
                <div class="lg:col-span-5 space-y-12">
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <span v-if="product.category"
                                class="text-[10px] font-black uppercase tracking-[0.4em] text-black/40">
                                {{ product.category.name }}
                            </span>
                        </div>

                        <h1
                            class="text-5xl md:text-6xl font-black text-black tracking-tighter uppercase italic leading-[0.95]">
                            {{ product.name }}
                        </h1>

                        <div class="text-3xl font-black text-black tracking-tighter mt-4">
                            {{ formatPrice(product.price) }}
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-6">
                        <h3
                            class="text-xs font-black uppercase tracking-[0.3em] text-black border-b border-black/10 pb-4">
                            Product Details</h3>
                        <div class="prose prose-sm max-w-none text-black/50 font-medium leading-relaxed"
                            v-html="product.description || product.content"></div>
                    </div>

                    <!-- Feature Icons -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-6 bg-black/[0.02] rounded-[32px] flex flex-col gap-3 border border-black/5">
                            <ShieldCheck class="w-6 h-6 text-black" />
                            <span class="text-[10px] font-black uppercase tracking-widest text-black/60">Quality
                                Assurance</span>
                        </div>
                        <div class="p-6 bg-black/[0.02] rounded-[32px] flex flex-col gap-3 border border-black/5">
                            <Truck class="w-6 h-6 text-black" />
                            <span class="text-[10px] font-black uppercase tracking-widest text-black/60">Express
                                Delivery</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-4 pt-6">
                        <button
                            class="w-full h-20 bg-black text-white rounded-[24px] font-black text-xs uppercase tracking-[0.3em] flex items-center justify-center gap-4 shadow-2xl shadow-black/20 hover:scale-[1.02] active:scale-95 transition-all">
                            <ShoppingBag class="w-5 h-5" />
                            Add to Cart
                        </button>

                        <a :href="whatsappLink" target="_blank"
                            class="w-full h-20 bg-white border border-black text-black rounded-[24px] font-black text-xs uppercase tracking-[0.3em] flex items-center justify-center gap-4 hover:bg-black hover:text-white transition-all">
                            <MessageCircle class="w-5 h-5" />
                            Direct Inquiry
                        </a>
                    </div>

                    <div class="p-8 bg-black rounded-[40px] text-center">
                        <p class="text-[10px] text-white/40 font-black uppercase tracking-[0.2em]">
                            Sustainable design practice by <span class="text-white">{{ site?.site_name || user.name
                                }}</span>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.prose :deep(p) {
    margin-bottom: 1.5em;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
