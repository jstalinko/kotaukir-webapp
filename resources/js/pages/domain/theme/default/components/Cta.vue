<script setup>
import { MessageCircle } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps({
    settings: Object,
    user: Object,
    site: Object,
    product: Object,
});

const whatsappLink = computed(() => {
    const number = props.settings?.whatsapp_number || '6281234567890';
    const text = props.settings?.message || `Halo, saya ingin bertanya tentang produk di ${props.site?.site_name || props.user?.name}.`;
    return `https://wa.me/${number}?text=${encodeURIComponent(text)}`;
});
</script>

<template>
    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex justify-center">
            <a :href="whatsappLink" target="_blank"
                class="inline-flex items-center gap-3 px-10 py-5 bg-[#25D366] text-white rounded-2xl font-bold text-lg shadow-xl shadow-green-600/20 hover:scale-[1.02] active:scale-95 transition-all">
                <MessageCircle class="w-6 h-6" />
                {{ settings?.text || 'Tanya via WhatsApp' }}
            </a>
        </div>
    </section>
</template>
