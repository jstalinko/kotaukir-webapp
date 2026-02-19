<script setup>
import Layout from './Layout.vue';
import ProductCard from './components/ProductCard.vue';
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Search, SlidersHorizontal, X, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
    user: Object,
    site: Object,
    products: Array,
    categories: Array,
    category: Object,
});

const searchQuery = ref('');
const selectedCategory = ref(props.category?.id || null);

const filteredProducts = computed(() => {
    let list = props.products || [];

    if (selectedCategory.value) {
        list = list.filter(p => p.category_id === selectedCategory.value);
    }

    if (searchQuery.value.trim()) {
        const q = searchQuery.value.toLowerCase();
        list = list.filter(p => p.title?.toLowerCase().includes(q) || p.content?.toLowerCase().includes(q));
    }

    return list;
});

const clearFilters = () => {
    searchQuery.value = '';
    selectedCategory.value = null;
};
</script>

<template>
    <Layout :user="user" :site="site">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Header -->
            <div class="mb-12 text-center">
                <span class="text-orange-600 text-xs font-bold uppercase tracking-[0.3em] mb-4 block">Koleksi
                    Kami</span>
                <h1 class="text-5xl md:text-6xl font-serif font-bold text-[#451A03] leading-tight">
                    Semua <span class="italic text-orange-600">Produk</span>
                </h1>
                <p class="text-gray-500 max-w-xl mx-auto mt-4 text-sm">
                    Jelajahi seluruh koleksi furniture pilihan kami.
                </p>
            </div>

            <!-- Filters Row -->
            <div class="flex flex-col md:flex-row gap-4 mb-10 items-center">
                <!-- Search -->
                <div class="relative flex-1 max-w-md">
                    <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                    <input v-model="searchQuery" type="text" placeholder="Cari produk..."
                        class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-600/20 focus:border-orange-600 transition-all" />
                </div>

                <!-- Category Pills -->
                <div class="flex items-center gap-3 overflow-x-auto pb-1 scrollbar-hide flex-1 justify-end">
                    <button @click="selectedCategory = null"
                        :class="selectedCategory === null ? 'bg-[#451A03] text-white' : 'bg-white text-[#451A03] border border-gray-200 hover:border-[#451A03]/30'"
                        class="px-5 py-2.5 rounded-full text-xs font-bold whitespace-nowrap transition-all">
                        Semua
                    </button>
                    <button v-for="cat in categories" :key="cat.id" @click="selectedCategory = cat.id"
                        :class="selectedCategory === cat.id ? 'bg-[#451A03] text-white' : 'bg-white text-[#451A03] border border-gray-200 hover:border-[#451A03]/30'"
                        class="px-5 py-2.5 rounded-full text-xs font-bold whitespace-nowrap transition-all">
                        {{ cat.name }}
                    </button>
                </div>

                <!-- Clear -->
                <button v-if="searchQuery || selectedCategory" @click="clearFilters"
                    class="flex items-center gap-1 text-xs font-bold text-gray-400 hover:text-[#451A03] transition-colors">
                    <X class="w-3 h-3" /> Reset
                </button>
            </div>

            <!-- Results count -->
            <div class="flex items-center justify-between mb-8">
                <p class="text-sm text-gray-500 font-medium">
                    Menampilkan <span class="text-[#451A03] font-bold">{{ filteredProducts.length }}</span> produk
                    <span v-if="selectedCategory"> di kategori ini</span>
                    <span v-if="searchQuery"> untuk "{{ searchQuery }}"</span>
                </p>
            </div>

            <!-- Products Grid -->
            <div v-if="filteredProducts.length > 0"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <ProductCard v-for="product in filteredProducts" :key="product.id" :product="product" :user="user" />
            </div>

            <!-- Empty State -->
            <div v-else class="py-32 text-center">
                <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <Search class="w-8 h-8 text-orange-200" />
                </div>
                <h3 class="text-2xl font-serif font-bold text-[#451A03]">Produk tidak ditemukan</h3>
                <p class="text-gray-400 mt-2 max-w-sm mx-auto text-sm">
                    Coba ubah kata kunci pencarian atau pilih kategori yang berbeda.
                </p>
                <button @click="clearFilters"
                    class="mt-8 px-8 py-3 bg-[#451A03] text-white rounded-2xl text-sm font-bold hover:bg-[#2D241E] transition-all">
                    Tampilkan Semua Produk
                </button>
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
