<script setup>
defineProps({
    settings: Object,
});
</script>

<template>
    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-16 lg:py-24">
        <div class="bg-stone-900 text-white p-12 text-center border-b-8 border-orange-500">
            <h2 class="text-4xl font-black uppercase tracking-tighter mb-4">{{ settings?.title || 'Ready to Start?' }}
            </h2>
            <p class="text-stone-400 font-medium mb-8 max-w-xl mx-auto">
                {{ settings?.subtitle || 'Contact us today for a consultation.' }}
            </p>
            <button
                class="px-8 py-4 bg-orange-600 font-black uppercase tracking-widest text-white hover:bg-stone-800 transition-colors">
                Get in Touch
            </button>
        </div>
    </section>
</template>
