<script setup>
import Layout from './Layout.vue';
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';
import { getDomainUrl } from '../../../../lib/domain';

const props = defineProps({
    user: Object,
    site: Object,
    products: Array,
    categories: Array,
    category: Object,
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

        <div class="bg-stone-900 text-white py-24 border-b-8 border-orange-500">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 text-center">
                <span class="text-orange-500 text-xs font-black uppercase tracking-[0.3em] mb-4 block">Filter
                    Category</span>
                <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter leading-none mb-6">
                    {{ category?.name }}
                </h1>
                <p class="text-stone-400 max-w-xl mx-auto text-sm font-medium mb-10 leading-relaxed">
                    {{ category?.description ||
                        'Browse professional-grade items classified under this specialized collection.' }}
                </p>

                <nav
                    class="flex justify-center items-center gap-4 text-[10px] font-black uppercase tracking-widest text-stone-500">
                    <Link :href="getDomainUrl(user.name, '/')" class="hover:text-white transition-colors">Home</Link>
                    <ArrowRight class="w-3 h-3" />
                    <Link :href="getDomainUrl(user.name, '/products')" class="hover:text-white transition-colors">
                        Catalog / All</Link>
                </nav>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 py-16">

            <div class="flex items-center gap-4 overflow-x-auto pb-4 scrollbar-hide mb-12 border-b-2 border-stone-200">
                <Link v-for="cat in categories" :key="cat.id" :href="getDomainUrl(user.name, `/category/${cat.slug}`)"
                    :class="cat.id === category?.id ? 'border-orange-500 text-orange-600 bg-orange-50' : 'border-transparent text-stone-500 hover:text-stone-900 hover:border-stone-900'"
                    class="px-6 py-4 border-b-4 text-[10px] font-black uppercase tracking-[0.2em] whitespace-nowrap transition-colors">
                    {{ cat.name }}
                </Link>
            </div>

            <div v-if="products?.length > 0"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <Link v-for="product in products" :key="product.id"
                    :href="getDomainUrl(user.name, `/product/${product.slug}`)"
                    class="group block bg-white border-2 border-stone-100 hover:border-orange-500 transition-colors p-4 relative">

                    <div class="aspect-square bg-stone-100 mb-6 overflow-hidden">
                        <img v-if="product.images?.[0]"
                            :src="Array.isArray(product.images) ? product.images[0] : JSON.parse(product.images)[0]"
                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500" />
                    </div>

                    <div>
                        <span
                            class="text-[10px] font-black uppercase tracking-widest text-orange-600 block mb-2 line-clamp-1">
                            {{ product.category?.name || 'Uncategorized' }}
                        </span>
                        <h3
                            class="text-lg font-black text-stone-900 uppercase tracking-tight mb-2 line-clamp-1 group-hover:text-orange-600 transition-colors">
                            {{ product.name || product.title }}
                        </h3>
                        <p class="text-xs font-medium text-stone-500 line-clamp-2 mb-4 h-8">
                            {{ product.description || 'Professional grade product description goes here.' }}
                        </p>
                        <div
                            class="flex justify-between items-center border-t-2 border-stone-100 pt-4 group-hover:border-orange-200 transition-colors">
                            <span class="font-black text-stone-900">{{ formatPrice(product.price) }}</span>
                            <span
                                class="w-8 h-8 bg-stone-900 text-white flex items-center justify-center font-black group-hover:bg-orange-600 transition-colors">
                                <ArrowRight class="w-4 h-4" />
                            </span>
                        </div>
                    </div>
                </Link>
            </div>

            <div v-else class="py-32 text-center border-4 border-stone-200 border-dashed">
                <h3 class="text-3xl font-black text-stone-900 uppercase tracking-tighter mb-4">No Inventory Available
                </h3>
                <p class="text-sm font-medium text-stone-500 max-w-sm mx-auto mb-8">
                    This specific classification is currently being restocked or prepared for launch.
                </p>
                <Link :href="getDomainUrl(user.name, '/products')"
                    class="inline-block px-8 py-4 bg-stone-900 text-white text-[10px] font-black uppercase tracking-[0.2em] hover:bg-orange-600 transition-colors">
                    Back to All Products
                </Link>
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
