<script setup>
import Layout from './Layout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Search, X, ArrowRight, Filter } from 'lucide-vue-next';
import { getDomainUrl } from '../../../../lib/domain';

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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10 lg:py-16">

            <div class="mb-10 lg:mb-16 border-b border-zinc-200 pb-8 lg:pb-12 text-center md:text-left">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-orange-100/80 text-orange-700 text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4 border border-orange-200">
                    Complete Inventory
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-zinc-900 tracking-tight leading-none">
                    Product Catalog
                </h1>
            </div>

            <!-- Filters -->
            <div
                class="flex flex-col lg:flex-row gap-4 mb-10 mt-6 items-center justify-between p-4 bg-zinc-50 border border-zinc-200 rounded-2xl">
                <div class="relative w-full lg:max-w-md">
                    <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" />
                    <input v-model="searchQuery" type="text" placeholder="Search catalog..."
                        class="w-full pl-11 pr-4 py-3 bg-white border border-zinc-200 rounded-xl focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all font-bold text-sm text-zinc-900 placeholder:text-zinc-400" />
                </div>

                <div class="flex items-center gap-2 overflow-x-auto w-full lg:w-auto pb-2 lg:pb-0 scrollbar-hide py-1">
                    <div class="hidden lg:flex items-center justify-center shrink-0 w-8">
                        <Filter class="w-4 h-4 text-zinc-400" />
                    </div>
                    <button @click="selectedCategory = null"
                        :class="selectedCategory === null ? 'bg-zinc-900 text-white border-zinc-900 shadow-sm' : 'bg-white text-zinc-500 border-zinc-200 hover:border-orange-300 hover:text-orange-600'"
                        class="px-4 py-2 border rounded-full text-xs font-bold whitespace-nowrap transition-colors flex-shrink-0">
                        All Items
                    </button>
                    <button v-for="cat in categories" :key="cat.id" @click="selectedCategory = cat.id"
                        :class="selectedCategory === cat.id ? 'bg-zinc-900 text-white border-zinc-900 shadow-sm' : 'bg-white text-zinc-500 border-zinc-200 hover:border-orange-300 hover:text-orange-600'"
                        class="px-4 py-2 border rounded-full text-xs font-bold whitespace-nowrap transition-colors flex-shrink-0">
                        {{ cat.name }}
                    </button>
                    <button v-if="searchQuery || selectedCategory" @click="clearFilters"
                        class="flex items-center gap-1.5 px-4 py-2 bg-orange-50 text-orange-600 border border-orange-200 rounded-full hover:bg-orange-600 hover:text-white transition-colors text-xs font-bold whitespace-nowrap flex-shrink-0">
                        <X class="w-3.5 h-3.5" /> Clear
                    </button>
                </div>
            </div>

            <!-- Results Data -->
            <div class="flex items-center justify-between mb-8 text-xs font-bold text-zinc-400 bg-white">
                <p>
                    Showing <span class="text-zinc-900">{{ filteredProducts.length }}</span> Results
                </p>
            </div>

            <!-- Grid -->
            <div v-if="filteredProducts.length > 0"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                <Link v-for="product in filteredProducts" :key="product.id"
                    :href="getDomainUrl(user.name, `/product/${product.slug}`)"
                    class="group block bg-white border border-zinc-200 hover:border-orange-300 hover:shadow-xl hover:shadow-orange-900/5 transition-all rounded-2xl p-4">

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
                            {{ product.description ||
                                'Professional grade product designed for modern homes and offices.' }}
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

            <div v-else
                class="py-24 md:py-32 text-center border-2 border-zinc-200 border-dashed rounded-3xl bg-zinc-50 flex flex-col items-center">
                <h3 class="text-2xl font-extrabold text-zinc-400 tracking-tight mb-3">No Inventory Matches</h3>
                <p class="text-sm font-medium text-zinc-500 max-w-sm mb-6">
                    Adjust your search filters or clear selection to view all products.
                </p>
                <button @click="clearFilters"
                    class="px-6 py-3 bg-white border border-zinc-200 text-zinc-600 hover:text-orange-600 hover:border-orange-300 font-bold text-sm rounded-xl transition-colors shadow-sm">
                    Reset Catalog
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
