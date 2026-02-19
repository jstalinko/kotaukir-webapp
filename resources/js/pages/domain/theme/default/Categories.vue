<script setup>
import Layout from './Layout.vue';
import ProductCard from './components/ProductCard.vue';
import { Link } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';

const props = defineProps({
    user: Object,
    site: Object,
    products: Array,
    categories: Array,
    category: Object,
});
</script>

<template>
    <Layout :user="user" :site="site">
        <!-- Category Header -->
        <div class="bg-gradient-to-b from-orange-50/60 to-transparent py-20">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em] mb-4 block">Kategori</span>
                <h1 class="text-5xl md:text-6xl font-serif font-bold text-[#451A03] mb-4">{{ category?.name }}</h1>
                <p class="text-gray-500 max-w-xl mx-auto text-sm">
                    {{ category?.description ||
                        'Jelajahi berbagai pilihan koleksi furniture terbaik kami untuk kategori ini.' }}
                </p>
                <nav class="flex justify-center gap-2 mt-8 text-xs font-bold uppercase tracking-widest text-gray-400">
                    <Link :href="`/domain/${user?.name}`" class="hover:text-[#451A03] transition-colors">Beranda</Link>
                    <ChevronRight class="w-3 h-3 mt-0.5" />
                    <Link :href="`/domain/${user?.name}/products`" class="hover:text-[#451A03] transition-colors">Produk
                    </Link>
                    <ChevronRight class="w-3 h-3 mt-0.5" />
                    <span class="text-[#451A03]">{{ category?.name }}</span>
                </nav>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
            <!-- Other Categories -->
            <div class="flex items-center gap-4 overflow-x-auto pb-4 scrollbar-hide mb-10">
                <Link v-for="cat in categories" :key="cat.id" :href="`/domain/${user?.name}/category/${cat.slug}`"
                    :class="cat.id === category?.id ? 'bg-[#451A03] text-white' : 'bg-white text-[#451A03] border border-gray-200 hover:border-[#451A03]/30'"
                    class="px-6 py-2.5 rounded-full text-xs font-bold whitespace-nowrap transition-all shadow-sm">
                    {{ cat.name }}
                </Link>
            </div>

            <div v-if="products?.length > 0"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <ProductCard v-for="product in products" :key="product.id" :product="product" :user="user" />
            </div>
            <div v-else class="text-center py-40 bg-white rounded-[40px] border border-brown-100/5 shadow-inner">
                <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                </div>
                <h3 class="text-2xl font-serif font-bold text-[#451A03]">Produk Belum Tersedia</h3>
                <p class="text-gray-400 mt-2">Maaf, saat ini koleksi di kategori ini masih dalam persiapan.</p>
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
