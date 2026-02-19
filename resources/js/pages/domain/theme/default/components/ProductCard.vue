<script setup>
import { Link } from '@inertiajs/vue3';
import { Eye, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
    product: Object,
    user: Object,
});

const parseImages = (images) => {
    if (Array.isArray(images)) return images;
    try {
        const parsed = JSON.parse(images);
        return Array.isArray(parsed) ? parsed : [images];
    } catch {
        return images ? [images] : ['https://placehold.co/600x600/brown/white?text=Furniture'];
    }
};

const firstImage = parseImages(props.product.images)[0];
</script>

<template>
    <div
        class="group bg-white rounded-2xl overflow-hidden border border-brown-100/5 shadow-sm hover:shadow-xl transition-all duration-500 scale-100 hover:scale-[1.02]">
        <Link :href="`/domain/${user.name}/product/${product.slug}`"
            class="block relative aspect-[4/5] overflow-hidden">
            <img :src="firstImage" :alt="product.title"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />

            <div
                class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center gap-4">
                <div
                    class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-[#451A03] shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <Eye class="w-5 h-5" />
                </div>
            </div>

            <div v-if="product.category" class="absolute top-4 left-4">
                <span
                    class="px-3 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-[#451A03] rounded-full shadow-sm">
                    {{ product.category.name }}
                </span>
            </div>
        </Link>

        <div class="p-6 space-y-3">
            <div class="flex justify-between items-start">
                <Link :href="`/domain/${user.name}/product/${product.slug}`" class="block group/title">
                    <h3
                        class="text-lg font-serif font-bold text-[#451A03] group-hover/title:text-orange-600 transition-colors line-clamp-1">
                        {{ product.title }}
                    </h3>
                </Link>
            </div>

            <div class="flex items-center justify-between pt-2">
                <div class="flex flex-col">
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Koleksi Terbatas</span>
                    <span class="text-orange-600 font-bold">Lihat Detail</span>
                </div>
                <Link :href="`/domain/${user.name}/product/${product.slug}`"
                    class="w-10 h-10 border border-brown-100/10 rounded-full flex items-center justify-center text-[#451A03] hover:bg-[#451A03] hover:text-white transition-all">
                    <ChevronRight class="w-5 h-5" />
                </Link>
            </div>
        </div>
    </div>
</template>
