<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import { Badge } from '@/components/ui/badge';
import { ArrowLeft, Save, Info, Sparkles, LayoutGrid, Package, Settings2 } from 'lucide-vue-next';
import { computed } from 'vue';
import RichEditor from '@/components/RichEditor.vue';
import ImagePicker from '@/components/ImagePicker.vue';

const props = defineProps({
    isEdit: Boolean,
    product: Object,
    categories: Array,
});

const breadcrumbs = computed(() => [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Produk', href: '/dashboard/product' },
    { title: props.isEdit ? 'Edit Produk' : 'Tambah Produk', href: '#' },
]);

// Parse existing data for edit
const parseTags = (tags) => {
    if (Array.isArray(tags)) return tags.join(', ');
    try {
        const parsed = typeof tags === 'string' ? JSON.parse(tags) : tags;
        return Array.isArray(parsed) ? parsed.join(', ') : '';
    } catch {
        return '';
    }
};

const parseImages = (images) => {
    if (Array.isArray(images)) return images;
    try {
        const parsed = typeof images === 'string' ? JSON.parse(images) : images;
        return Array.isArray(parsed) ? parsed : [];
    } catch {
        return [];
    }
};

// Form state using Inertia useForm
const form = useForm({
    title: props.product?.title || '',
    category_id: props.product?.category_id || '',
    content: props.product?.content || '',
    tags: parseTags(props.product?.tags),
    images: parseImages(props.product?.images),
    is_published: props.product?.is_published ?? true,
});

const handleSubmit = () => {
    // Transform data for the backend if needed
    // useForm's post will handle the values, but we can transform strings/arrays if necessary
    // However, useForm values are reactive. We can transform them right before submission or in a computed.
    // For tags, we'll transform it to an array.

    const url = props.isEdit
        ? `/dashboard/product/${props.product.id}/update`
        : '/dashboard/product/store';

    form.transform((data) => ({
        ...data,
        category_id: parseInt(data.category_id),
        tags: data.tags
            .split(',')
            .map((t) => t.trim())
            .filter(Boolean),
    })).post(url);
};
</script>

<template>

    <Head :title="isEdit ? 'Edit Produk' : 'Tambah Produk'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 overflow-x-hidden rounded-xl p-4 md:p-8 bg-[#050505] text-white">

            <!-- Hero Header Section -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-white/10">
                <div class="flex items-start gap-4">
                    <Button variant="ghost" size="icon"
                        class="h-10 w-10 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl"
                        @click="router.get('/dashboard/product')">
                        <ArrowLeft class="h-5 w-5" />
                    </Button>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <Badge variant="outline"
                                class="bg-orange-500/10 text-orange-400 border-orange-500/20 px-2 py-0 text-[10px] uppercase tracking-wider font-bold">
                                {{ isEdit ? 'Update Mode' : 'New Product' }}
                            </Badge>
                        </div>
                        <h1
                            class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                            {{ isEdit ? 'Edit Produk' : 'Tambah Produk' }}
                        </h1>
                        <p class="text-sm text-gray-400 mt-1 max-w-lg">
                            Kelola detail produk Anda dengan RichEditor dan visual yang menarik untuk meningkatkan
                            konversi.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <Button variant="ghost" @click="router.get('/dashboard/product')"
                        class="text-gray-400 hover:text-white">
                        Batal
                    </Button>
                    <Button @click="handleSubmit" :disabled="form.processing"
                        class="bg-orange-600 hover:bg-orange-500 text-white px-8 h-11 rounded-xl shadow-lg shadow-orange-600/20 group transition-all">
                        <Save class="h-4 w-4 mr-2 group-hover:scale-110 transition-transform" />
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Produk' }}
                    </Button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column: Main Info -->
                <div class="lg:col-span-8 space-y-8">
                    <!-- Basic Information Card -->
                    <div
                        class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-3xl p-6 md:p-8 shadow-2xl">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="p-2 bg-orange-500/10 rounded-lg text-orange-400">
                                <Package class="h-5 w-5" />
                            </div>
                            <h2 class="text-xl font-bold">Informasi Utama</h2>
                        </div>

                        <div class="space-y-6">
                            <div class="grid gap-3">
                                <Label for="title" class="text-sm font-semibold text-gray-300 ml-1">Nama Produk
                                    *</Label>
                                <Input id="title" v-model="form.title" placeholder="Contoh: Kursi Jati Mewah Klasik"
                                    class="h-12 bg-black/40 border-white/10 focus:border-orange-500/50 rounded-xl px-4 text-white" />
                                <p v-if="form.errors.title" class="text-xs text-red-500 italic ml-1">{{
                                    form.errors.title
                                    }}</p>
                            </div>

                            <div class="grid gap-3">
                                <Label class="text-sm font-semibold text-gray-300 ml-1">Kontent *</Label>
                                <RichEditor v-model="form.content" />
                                <p v-if="form.errors.content" class="text-xs text-red-500 italic ml-1">{{
                                    form.errors.content }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Images Gallery Section -->
                    <div
                        class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-3xl p-6 md:p-8 shadow-2xl">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-500/10 rounded-lg text-blue-400">
                                    <Sparkles class="h-5 w-5" />
                                </div>
                                <h2 class="text-xl font-bold">Galeri Produk</h2>
                            </div>
                            <span class="text-xs text-gray-500 font-medium">Multiple images supported</span>
                        </div>

                        <ImagePicker v-model="form.images" />
                    </div>
                </div>

                <!-- Right Column: Settings -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Categorization Card -->
                    <div class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-2xl">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-400">
                                <LayoutGrid class="h-5 w-5" />
                            </div>
                            <h2 class="text-lg font-bold">Kategorisasi</h2>
                        </div>

                        <div class="space-y-4">
                            <div class="grid gap-2">
                                <Label for="category"
                                    class="text-xs text-gray-400 font-bold uppercase tracking-wider">Pilih
                                    Kategori</Label>
                                <select id="category" v-model="form.category_id"
                                    class="w-full h-11 bg-black/40 border border-white/10 rounded-xl px-3 text-sm focus:outline-none focus:border-orange-500/50 appearance-none">
                                    <option value="" disabled class="bg-[#050505]">Pilih kategori</option>
                                    <option v-for="cat in categories" :key="cat.id" :value="cat.id"
                                        class="bg-[#0a0a0a]">
                                        {{ cat.name }}
                                    </option>
                                </select>
                                <p v-if="form.errors.category_id" class="text-xs text-red-500 italic ml-1">{{
                                    form.errors.category_id }}</p>
                            </div>

                            <div v-if="categories.length === 0"
                                class="p-3 bg-red-500/5 border border-red-500/20 rounded-xl">
                                <p class="text-[10px] text-red-400 leading-relaxed font-medium">
                                    Anda belum memiliki kategori. Silakan buat kategori di menu Kategori sebelum
                                    menambahkan produk.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Settings Card -->
                    <div class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-2xl">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-purple-500/10 rounded-lg text-purple-400">
                                <Settings2 class="h-5 w-5" />
                            </div>
                            <h2 class="text-lg font-bold">Metadata</h2>
                        </div>

                        <div class="space-y-6">
                            <div class="grid gap-2">
                                <Label for="tags" class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tags
                                    (Keywords)</Label>
                                <Input id="tags" v-model="form.tags" placeholder="kayu, jati, jepara"
                                    class="h-11 bg-black/40 border-white/10 focus:border-orange-500/50 rounded-xl px-4" />
                                <p class="text-[10px] text-gray-500 ml-1">Pisahkan dengan koma untuk SEO yang lebih
                                    baik.</p>
                            </div>

                            <div class="p-4 bg-white/5 border border-white/10 rounded-2xl">
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col gap-1">
                                        <Label for="publish"
                                            class="text-sm font-bold cursor-pointer">Visibilitas</Label>
                                        <span class="text-[10px] text-gray-500">Produk akan tampil publik</span>
                                    </div>
                                    <Checkbox id="publish" :checked="form.is_published"
                                        @update:checked="form.is_published = $event"
                                        class="h-6 w-6 border-white/20 data-[state=checked]:bg-orange-600 data-[state=checked]:border-orange-600" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pro Tip Card -->
                    <div class="bg-orange-500/5 border border-orange-500/20 rounded-3xl p-6">
                        <div class="flex gap-4">
                            <Info class="h-6 w-6 text-orange-400 shrink-0" />
                            <div class="space-y-1">
                                <h3 class="text-sm font-bold text-orange-200">Tips Optimasi</h3>
                                <p class="text-xs text-orange-200/60 leading-relaxed">
                                    Gunakan deskripsi yang detail dan minimal 3 foto berkualitas tinggi untuk
                                    meningkatkan kepercayaan pembeli hingga 40%.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Hidden scrollbar but functional */
div::-webkit-scrollbar {
    display: none;
}

div {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}
</style>