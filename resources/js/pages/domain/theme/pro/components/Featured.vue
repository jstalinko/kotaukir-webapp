<script setup>
defineProps({
    settings: Object,
    products: Array,
});
</script>

<template>
    <section class="bg-stone-100 py-16 lg:py-24 border-y-4 border-stone-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="mb-12 border-b-4 border-stone-900 pb-6">
                <span class="text-xs font-black uppercase tracking-widest text-orange-600 block mb-2">Featured</span>
                <h2 class="text-4xl font-black text-stone-900 uppercase tracking-tighter">{{ settings?.title ||
                    'Featured Inventory' }}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Fallback empty blocks since Featured involves manual product selection usually -->
                <div v-for="i in 3" :key="i" class="border-2 border-stone-200 p-4 bg-white">
                    <div class="aspect-square bg-stone-50 mb-4"></div>
                    <div class="h-4 w-2/3 bg-stone-200 mb-2"></div>
                    <div class="h-4 w-1/3 bg-stone-200"></div>
                </div>
            </div>
        </div>
    </section>
</template>
