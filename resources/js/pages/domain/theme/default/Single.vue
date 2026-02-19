<script setup>
import Layout from './Layout.vue';
import { ShoppingCart, MessageCircle, ChevronLeft, ChevronRight, Share2, Star, ShieldCheck, Truck } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    user: Object,
    product: Object,
});

const activeImageIndex = ref(0);

const parseImages = (images) => {
    if (Array.isArray(images)) return images;
    try {
        const parsed = JSON.parse(images);
        return Array.isArray(parsed) ? parsed : [images];
    } catch {
        return images ? [images] : ['https://placehold.co/800x1000/brown/white?text=Furniture'];
    }
};

const images = parseImages(props.product.images);

const whatsappLink = computed(() => {
    const text = `Halo ${props.user.name}, saya tertarik dengan produk ${props.product.title} yang saya lihat di website.`;
    return `https://wa.me/6281234567890?text=${encodeURIComponent(text)}`;
});
</script>

<template>
    <Layout :user="user">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-xs font-bold uppercase tracking-widest" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <Link :href="`/domain/${user.name}`" class="text-gray-400 hover:text-[#451A03]">Beranda</Link>
                    </li>
                    <li class="flex items-center space-x-2">
                        <ChevronRight class="w-3 h-3 text-gray-300" />
                        <span class="text-gray-400">Produk</span>
                    </li>
                    <li v-if="product.category" class="flex items-center space-x-2">
                        <ChevronRight class="w-3 h-3 text-gray-300" />
                        <Link :href="`/domain/${user.name}/category/${product.category.slug}`"
                            class="text-gray-400 hover:text-[#451A03]">{{ product.category.name }}</Link>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
                <!-- Left: Gallery -->
                <div class="lg:col-span-7 space-y-6">
                    <div
                        class="relative aspect-[4/5] rounded-[40px] overflow-hidden bg-white border border-brown-100/10 shadow-lg group">
                        <img :src="images[activeImageIndex]" :alt="product.title"
                            class="w-full h-full object-cover transition-all duration-700" />

                        <!-- Navigation Arrows -->
                        <div v-if="images.length > 1"
                            class="absolute inset-x-4 top-1/2 -translate-y-1/2 flex justify-between opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="activeImageIndex = (activeImageIndex - 1 + images.length) % images.length"
                                class="w-12 h-12 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-[#451A03] shadow-xl hover:bg-orange-600 hover:text-white transition-all">
                                <ChevronLeft class="w-6 h-6" />
                            </button>
                            <button @click="activeImageIndex = (activeImageIndex + 1) % images.length"
                                class="w-12 h-12 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-[#451A03] shadow-xl hover:bg-orange-600 hover:text-white transition-all">
                                <ChevronRight class="w-6 h-6" />
                            </button>
                        </div>

                        <!-- Zoom Indicator -->
                        <div
                            class="absolute bottom-6 left-1/2 -translate-x-1/2 px-4 py-2 bg-black/20 backdrop-blur-md rounded-full text-white text-[10px] font-bold tracking-widest uppercase">
                            {{ activeImageIndex + 1 }} / {{ images.length }} Foto
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div v-if="images.length > 1" class="grid grid-cols-5 gap-4">
                        <button v-for="(img, index) in images" :key="index" @click="activeImageIndex = index"
                            class="aspect-square rounded-2xl overflow-hidden border-2 transition-all p-1"
                            :class="activeImageIndex === index ? 'border-orange-600 bg-orange-50' : 'border-transparent bg-white shadow-sm'">
                            <img :src="img" class="w-full h-full object-cover rounded-xl" />
                        </button>
                    </div>
                </div>

                <!-- Right: Content -->
                <div class="lg:col-span-5 space-y-10">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span v-if="product.category"
                                class="px-3 py-1 bg-orange-100 text-orange-700 text-[10px] font-bold uppercase tracking-widest rounded-full">
                                {{ product.category.name }}
                            </span>
                            <div class="flex items-center text-orange-400">
                                <Star v-for="i in 5" :key="i" class="w-3 h-3 fill-current" />
                            </div>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-serif font-bold text-[#451A03] leading-tight">
                            {{ product.title }}
                        </h1>

                        <div class="flex items-center gap-6 pt-2">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-widest">Kondisi</span>
                                <span class="text-[#451A03] font-bold">Baru & Ready</span>
                            </div>
                            <div class="w-[1px] h-8 bg-brown-100/20"></div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-widest">Minimal
                                    Order</span>
                                <span class="text-[#451A03] font-bold">1 Unit</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description with Tiptap styling -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-serif font-bold text-[#451A03] border-b border-brown-100/10 pb-2">
                            Deskripsi Produk</h3>
                        <div class="prose prose-stone prose-sm max-w-none text-brown-900/70 leading-relaxed"
                            v-html="product.content"></div>
                    </div>

                    <!-- Feature Icons -->
                    <div class="grid grid-cols-2 gap-4">
                        <div
                            class="p-4 bg-orange-50/50 rounded-2xl flex items-center gap-3 border border-orange-100/20">
                            <ShieldCheck class="w-6 h-6 text-orange-600" />
                            <span class="text-xs font-bold text-orange-800">Garansi Kayu 1 Thn</span>
                        </div>
                        <div
                            class="p-4 bg-emerald-50/50 rounded-2xl flex items-center gap-3 border border-emerald-100/20">
                            <Truck class="w-6 h-6 text-emerald-600" />
                            <span class="text-xs font-bold text-emerald-800">Kirim Seluruh Indo</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-4 pt-6">
                        <a :href="whatsappLink" target="_blank"
                            class="w-full h-16 bg-[#25D366] text-white rounded-2xl font-bold text-lg flex items-center justify-center gap-3 shadow-xl shadow-green-600/20 hover:scale-[1.02] active:scale-95 transition-all">
                            <MessageCircle class="w-6 h-6" />
                            Tanya Lewat WhatsApp
                        </a>

                        <div class="flex gap-3">
                            <button
                                class="flex-1 h-14 bg-[#451A03] text-white rounded-2xl font-bold flex items-center justify-center gap-2 hover:bg-[#2D241E] transition-all group">
                                <ShoppingCart class="w-5 h-5 group-hover:scale-110 transition-transform" />
                                Pesan Sekarang
                            </button>
                            <button
                                class="w-14 h-14 bg-white border border-brown-100/20 text-[#451A03] rounded-2xl flex items-center justify-center hover:bg-orange-50 transition-all">
                                <Share2 class="w-5 h-5" />
                            </button>
                        </div>
                    </div>

                    <div class="p-6 bg-[#451A03]/5 rounded-[32px] border border-[#451A03]/5">
                        <p class="text-[10px] text-[#451A03]/50 font-bold uppercase tracking-widest text-center">
                            Setiap pembelian produk kayu di {{ user.name }} berkontribusi pada program penanaman kembali
                            hutan jati.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Related Info -->
            <div class="mt-32 grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="space-y-4">
                    <h4 class="font-serif font-bold text-xl">Material Terbaik</h4>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Kami hanya menggunakan kayu jati grade A yang sudah melalui proses pengeringan (oven) sempurna
                        hingga kadar air mencapai 12%.
                    </p>
                </div>
                <div class="space-y-4">
                    <h4 class="font-serif font-bold text-xl">Finishing Berkualitas</h4>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Sentuhan akhir menggunakan bahan ramah lingkungan dengan teknik semprot yang merata, menonjolkan
                        keindahan serat kayu alami.
                    </p>
                </div>
                <div class="space-y-4">
                    <h4 class="font-serif font-bold text-xl">Packing Aman</h4>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Setiap produk dibungkus dengan foam sheet, single face paper, dan kardus tebal untuk menjamin
                        produk sampai tanpa cacat.
                    </p>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style>
/* Style for HTML content from RichEditor */
.prose h1,
.prose h2,
.prose h3 {
    margin-top: 1.5em;
    margin-bottom: 0.5em;
    color: #451A03;
    font-family: 'Playfair Display', serif;
}

.prose ul,
.prose ol {
    margin-bottom: 1em;
    padding-left: 1.5em;
}

.prose li {
    margin-bottom: 0.5em;
}
</style>
