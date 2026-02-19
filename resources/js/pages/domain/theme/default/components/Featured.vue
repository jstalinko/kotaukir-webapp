<script setup>
import ProductCard from './ProductCard.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    settings: Object,
    user: Object,
    site: Object,
    products: Array,
});
</script>

<template>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <h2 v-html="settings?.title || 'Koleksi <span class=\'italic text-orange-600\'>Terbaik</span> Kami'"
                    class="text-4xl font-serif font-bold text-[#451A03] mb-4"></h2>
                <p v-html="settings?.subtitle || 'Produk terpopuler yang menjadi pilihan utama pelanggan kami bulan ini.'"
                    class="text-gray-400 text-sm max-w-md"></p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-gray-400 mr-2 uppercase tracking-widest">Urutkan:</span>
                <button
                    class="px-4 py-2 bg-white border border-brown-100/10 rounded-xl text-xs font-bold text-[#451A03] shadow-sm">Terbaru</button>
            </div>
        </div>

        <div v-if="products && products.length > 0"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <ProductCard v-for="product in products.slice(0, 8)" :key="product.id" :product="product" :user="user" />
        </div>
        <div v-else class="text-center py-20 text-gray-400">
            <p class="text-sm">Belum ada produk yang dipublikasikan.</p>
        </div>
    </section>
</template>
