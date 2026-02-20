<script setup>
import { Link } from '@inertiajs/vue3';
import { ShoppingBag, Eye } from 'lucide-vue-next';
import { getDomainUrl } from '../../../../../lib/domain';

defineProps({
    product: Object,
    user: Object,
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
    <div
        class="group relative bg-[#FDFDFD] rounded-[40px] overflow-hidden border border-black/5 hover:border-black/10 hover:shadow-2xl hover:shadow-black/5 transition-all duration-700">
        <!-- Image Wrapper -->
        <div class="aspect-[4/5] overflow-hidden bg-[#F0F0F0] relative">
            <template v-if="product.images && product.images.length > 0">
                <img :src="product.images[0]"
                    class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 grayscale group-hover:grayscale-0"
                    :alt="product.name" />
            </template>
            <div v-else class="w-full h-full flex items-center justify-center">
                <ShoppingBag class="w-12 h-12 text-black/10" />
            </div>

            <!-- Overlay Actions -->
            <div
                class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center gap-3">
                <Link :href="getDomainUrl(user.name, `/product/${product.slug}`)"
                    class="w-14 h-14 bg-white text-black rounded-full flex items-center justify-center shadow-xl hover:bg-black hover:text-white transition-all hover:scale-110">
                    <Eye class="w-6 h-6" />
                </Link>
                <button
                    class="w-14 h-14 bg-black text-white rounded-full flex items-center justify-center shadow-xl hover:bg-white hover:text-black transition-all hover:scale-110">
                    <ShoppingBag class="w-6 h-6" />
                </button>
            </div>

            <!-- Badge -->
            <div
                class="absolute top-6 left-6 px-4 py-1.5 bg-white/80 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-widest text-black">
                New Arrival
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <span class="text-[10px] font-bold text-black/30 uppercase tracking-[0.2em] block mb-1">
                        {{ product.category?.name || 'Essential' }}
                    </span>
                    <h3 class="text-xl font-bold text-black tracking-tight line-clamp-1 italic">
                        {{ product.name }}
                    </h3>
                </div>
                <div class="text-right">
                    <span class="text-lg font-black text-black tracking-tighter">
                        {{ formatPrice(product.price) }}
                    </span>
                </div>
            </div>

            <p class="text-xs text-black/40 font-medium line-clamp-2 leading-relaxed h-8 mb-6">
                {{ product.description || 'Minimalist design crafted for modern living spaces.' }}
            </p>

            <Link :href="getDomainUrl(user.name, `/product/${product.slug}`)"
                class="block w-full text-center py-4 bg-black text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] transition-all hover:bg-white hover:text-black hover:ring-1 hover:ring-black/10">
                View Detail
            </Link>
        </div>
    </div>
</template>
