<script setup>
defineProps({
    settings: Object,
    user: Object,
});
</script>

<template>
    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-16 lg:py-24">
        <div class="border-4 border-orange-500 p-8 lg:p-16 relative bg-white">
            <h1 class="text-4xl md:text-6xl font-black text-stone-900 uppercase tracking-tighter leading-[1.1] mb-6">
                {{ settings?.title || 'Professional Services' }}
            </h1>
            <p class="text-lg font-medium text-stone-500 max-w-2xl mb-10 leading-relaxed">
                {{ settings?.subtitle || 'Expert solutions tailored for commercial environments.' }}
            </p>
        </div>
    </section>
</template>
