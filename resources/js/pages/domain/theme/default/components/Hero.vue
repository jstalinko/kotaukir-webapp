<script setup>
import { ArrowRight, Star, Quote } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

defineProps({
    settings: Object,
    user: Object,
    site: Object,
    products: Array,
    categories: Array,
});
</script>

<template>
    <section class="relative pt-10 pb-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8 relative z-10 animate-in fade-in slide-in-from-left-8 duration-1000">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-orange-100/50 rounded-full text-orange-700 text-xs font-bold uppercase tracking-widest shadow-sm">
                        <Star class="w-3 h-3 fill-orange-700" />
                        Premium Furniture Collection
                    </div>

                    <h1 v-html="settings?.title || 'Keindahan <span class=\'text-orange-600 italic\'>Klasik</span> untuk Rumah Anda.'"
                        class="text-6xl md:text-8xl font-serif font-bold text-[#451A03] leading-[1.1] tracking-tight">
                    </h1>

                    <p v-html="settings?.subtitle || 'Temukan koleksi furniture kayu jati pilihan yang dikerjakan dengan presisi tinggi.'"
                        class="text-lg text-brown-900/60 max-w-lg leading-relaxed font-light">
                    </p>

                    <div class="flex flex-wrap gap-4 pt-4">
                        <Link :href="`/domain/${user?.name}/products`"
                            class="px-10 py-5 bg-[#451A03] text-white rounded-2xl font-bold shadow-2xl shadow-brown-900/20 hover:bg-[#2D241E] transition-all flex items-center gap-3 group">
                            Lihat Koleksi
                            <ArrowRight class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                        </Link>
                        <button
                            class="px-10 py-5 bg-white border border-brown-100/20 text-[#451A03] rounded-2xl font-bold hover:bg-orange-50 transition-all">
                            Custom Order
                        </button>
                    </div>
                </div>

                <div class="relative animate-in fade-in zoom-in duration-1000 delay-200">
                    <div
                        class="absolute -inset-10 bg-orange-100 rounded-[60px] blur-3xl opacity-30 -rotate-3 translate-x-10 translate-y-10">
                    </div>
                    <div class="relative aspect-[4/5] rounded-[40px] overflow-hidden shadow-2xl border-8 border-white">
                        <img :src="settings?.image || 'https://images.unsplash.com/photo-1581539250439-c96689b516dd?auto=format&fit=crop&q=80'"
                            class="w-full h-full object-cover" alt="Furniture Hero" />
                        <div
                            class="absolute bottom-8 left-8 right-8 p-6 bg-white/90 backdrop-blur-md rounded-3xl shadow-xl border border-white/20">
                            <Quote class="w-8 h-8 text-orange-200 absolute -top-4 -left-2 rotate-180" />
                            <p class="text-sm font-serif italic text-[#451A03] leading-relaxed">
                                "Kualitas kayunya luar biasa. Detail ukirannya sangat halus dan memberikan kesan mewah
                                pada ruang tamu kami."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
