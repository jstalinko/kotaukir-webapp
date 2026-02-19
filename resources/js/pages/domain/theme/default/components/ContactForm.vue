<script setup>
import { ref } from 'vue';
import { Mail, User, MessageSquare, CheckCircle, AlertCircle } from 'lucide-vue-next';
import axios from 'axios';

const props = defineProps({
    settings: Object,
    user: Object,
    site: Object,
});

const form = ref({ name: '', email: '', message: '' });
const status = ref(null);
const submitting = ref(false);

const handleSubmit = async () => {
    submitting.value = true;
    status.value = null;
    try {
        await axios.post(`/domain/${props.user?.name}/contact`, {
            ...form.value,
            site_id: props.site?.id,
        });
        status.value = 'success';
        form.value = { name: '', email: '', message: '' };
    } catch {
        status.value = 'error';
    } finally {
        submitting.value = false;
    }
};
</script>

<template>
    <section class="max-w-3xl mx-auto px-4 py-16">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-serif font-bold text-[#451A03]">
                {{ settings?.title || 'Hubungi Kami' }}
            </h2>
            <p class="text-gray-500 max-w-md mx-auto mt-3 text-sm">
                {{ settings?.subtitle || 'Kirimkan pesan Anda dan kami akan segera merespons.' }}
            </p>
        </div>

        <div v-if="status === 'success'"
            class="mb-8 p-5 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3">
            <CheckCircle class="w-5 h-5 text-emerald-600 flex-shrink-0" />
            <p class="text-sm font-medium text-emerald-800">Pesan berhasil terkirim! Kami akan menghubungi Anda segera.
            </p>
        </div>
        <div v-if="status === 'error'"
            class="mb-8 p-5 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3">
            <AlertCircle class="w-5 h-5 text-red-600 flex-shrink-0" />
            <p class="text-sm font-medium text-red-800">Terjadi kesalahan. Silakan coba lagi.</p>
        </div>

        <form @submit.prevent="handleSubmit"
            class="bg-white rounded-[40px] shadow-xl border border-gray-100 p-10 space-y-6">
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500">Nama Lengkap</label>
                <div class="relative">
                    <User class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                    <input v-model="form.name" type="text" required placeholder="Masukkan nama Anda"
                        class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-600/20 focus:border-orange-600 transition-all" />
                </div>
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500">Email</label>
                <div class="relative">
                    <Mail class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                    <input v-model="form.email" type="email" required placeholder="email@contoh.com"
                        class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-600/20 focus:border-orange-600 transition-all" />
                </div>
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500">Pesan</label>
                <div class="relative">
                    <MessageSquare class="absolute left-4 top-4 w-4 h-4 text-gray-400" />
                    <textarea v-model="form.message" rows="5" required placeholder="Tulis pesan Anda di sini..."
                        class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-600/20 focus:border-orange-600 transition-all resize-none"></textarea>
                </div>
            </div>
            <button type="submit" :disabled="submitting"
                class="w-full py-5 bg-[#451A03] text-white rounded-2xl font-bold text-sm uppercase tracking-widest hover:bg-[#2D241E] transition-all shadow-xl disabled:opacity-50">
                {{ submitting ? 'Mengirim...' : 'Kirim Pesan' }}
            </button>
        </form>
    </section>
</template>
