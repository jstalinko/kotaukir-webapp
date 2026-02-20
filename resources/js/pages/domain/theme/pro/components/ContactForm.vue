<script setup>
defineProps({
    settings: Object,
    user: Object,
});
</script>

<template>
    <section class="bg-white py-16 lg:py-24">
        <div class="max-w-3xl mx-auto px-6 lg:px-12 border-4 border-stone-100 p-8">
            <div class="mb-8 border-b-4 border-stone-900 pb-4">
                <h2 class="text-3xl font-black text-stone-900 uppercase tracking-tighter">
                    {{ settings?.title || 'Contact Form' }}
                </h2>
                <p class="text-stone-500 font-medium mt-2">{{ settings?.subtitle || 'Send us a message directly.' }}</p>
            </div>
            <form class="flex flex-col gap-6" @submit.prevent>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="text" placeholder="Full Name"
                        class="p-4 border-2 border-stone-200 focus:border-orange-500 focus:outline-none font-black text-xs uppercase tracking-widest text-stone-900 bg-stone-50" />
                    <input type="email" placeholder="Email Address"
                        class="p-4 border-2 border-stone-200 focus:border-orange-500 focus:outline-none font-black text-xs uppercase tracking-widest text-stone-900 bg-stone-50" />
                </div>
                <textarea placeholder="Your Message" rows="5"
                    class="p-4 border-2 border-stone-200 focus:border-orange-500 focus:outline-none font-medium text-sm text-stone-900 bg-stone-50"></textarea>
                <button type="submit"
                    class="px-8 py-4 bg-stone-900 text-white font-black uppercase tracking-widest text-sm hover:bg-orange-600 transition-colors">
                    Submit Inquiry
                </button>
            </form>
        </div>
    </section>
</template>
