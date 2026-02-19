<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import { Badge } from '@/components/ui/badge';
import { ArrowLeft, Save, FolderOpen, Info, LayoutGrid, Settings2, Sparkles } from 'lucide-vue-next';
import { computed } from 'vue';
import ImagePicker from '@/components/ImagePicker.vue';

const props = defineProps({
    isEdit: Boolean,
    category: Object,
});

const breadcrumbs = computed(() => [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Kategori', href: '/dashboard/category' },
    { title: props.isEdit ? 'Edit Kategori' : 'Tambah Kategori', href: '#' },
]);

// Prepare image data
const parseImage = (image) => {
    if (!image) return [];
    try {
        const parsed = typeof image === 'string' ? JSON.parse(image) : image;
        return Array.isArray(parsed) ? parsed : [image];
    } catch {
        return [image];
    }
};

const form = useForm({
    name: props.category?.name || '',
    description: props.category?.description || '',
    image: parseImage(props.category?.image),
    is_published: props.category?.is_published ?? true,
});

const handleSubmit = () => {
    const url = props.isEdit
        ? `/dashboard/category/${props.category.id}/update`
        : '/dashboard/category/store';

    form.transform((data) => ({
        ...data,
        // If we only want one image for category, we just send the first one or the whole array as JSON
        // The controller currently expects a string for category image, let's keep it consistent
        image: data.image.length > 0 ? JSON.stringify(data.image) : null,
    })).post(url);
};
</script>

<template>

    <Head :title="isEdit ? 'Edit Kategori' : 'Tambah Kategori'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 overflow-x-hidden rounded-xl p-4 md:p-8 bg-[#050505] text-white">

            <!-- Hero Header Section -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-white/10">
                <div class="flex items-start gap-4">
                    <Button variant="ghost" size="icon"
                        class="h-10 w-10 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl"
                        @click="router.get('/dashboard/category')">
                        <ArrowLeft class="h-5 w-5" />
                    </Button>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <Badge variant="outline"
                                class="bg-orange-500/10 text-orange-400 border-orange-500/20 px-2 py-0 text-[10px] uppercase tracking-wider font-bold">
                                {{ isEdit ? 'Update Category' : 'New Category' }}
                            </Badge>
                        </div>
                        <h1
                            class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                            {{ isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}
                        </h1>
                        <p class="text-sm text-gray-400 mt-1 max-w-lg">
                            Kelola kategori produk Anda untuk memudahkan navigasi pembeli dan SEO website Anda.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <Button variant="ghost" @click="router.get('/dashboard/category')"
                        class="text-gray-400 hover:text-white">
                        Batal
                    </Button>
                    <Button @click="handleSubmit" :disabled="form.processing"
                        class="bg-orange-600 hover:bg-orange-500 text-white px-8 h-11 rounded-xl shadow-lg shadow-orange-600/20 group transition-all">
                        <Save class="h-4 w-4 mr-2 group-hover:scale-110 transition-transform" />
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Kategori' }}
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
                                <FolderOpen class="h-5 w-5" />
                            </div>
                            <h2 class="text-xl font-bold">Detail Kategori</h2>
                        </div>

                        <div class="space-y-6">
                            <div class="grid gap-3">
                                <Label for="name" class="text-sm font-semibold text-gray-300 ml-1">Nama Kategori
                                    *</Label>
                                <Input id="name" v-model="form.name" placeholder="Contoh: Kursi Jati, Meja Ukir, dll"
                                    class="h-12 bg-black/40 border-white/10 focus:border-orange-500/50 rounded-xl px-4 text-white" />
                                <p v-if="form.errors.name" class="text-xs text-red-500 italic ml-1">{{ form.errors.name
                                    }}</p>
                            </div>

                            <div class="grid gap-3">
                                <Label for="description"
                                    class="text-sm font-semibold text-gray-300 ml-1">Deskripsi</Label>
                                <textarea id="description" v-model="form.description" rows="4"
                                    placeholder="Berikan deskripsi singkat tentang kategori ini..."
                                    class="flex min-h-[120px] w-full rounded-2xl border border-white/10 bg-black/40 px-4 py-3 text-sm shadow-sm focus-visible:outline-none focus:border-orange-500/50 transition-colors text-white"></textarea>
                                <p v-if="form.errors.description" class="text-xs text-red-500 italic ml-1">{{
                                    form.errors.description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Image Section -->
                    <div
                        class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-3xl p-6 md:p-8 shadow-2xl">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-500/10 rounded-lg text-blue-400">
                                    <Sparkles class="h-5 w-5" />
                                </div>
                                <h2 class="text-xl font-bold">Thumbnail Kategori</h2>
                            </div>
                            <span class="text-xs text-gray-500 font-medium">Optional</span>
                        </div>

                        <ImagePicker v-model="form.image" />
                    </div>
                </div>

                <!-- Right Column: Settings -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Visibility Card -->
                    <div class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-2xl">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-purple-500/10 rounded-lg text-purple-400">
                                <Settings2 class="h-5 w-5" />
                            </div>
                            <h2 class="text-lg font-bold">Pengaturan</h2>
                        </div>

                        <div class="space-y-6">
                            <div class="p-4 bg-white/5 border border-white/10 rounded-2xl">
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col gap-1">
                                        <Label for="publish"
                                            class="text-sm font-bold cursor-pointer">Visibilitas</Label>
                                        <span class="text-[10px] text-gray-500">Tampilkan kategori ini ke publik</span>
                                    </div>
                                    <Checkbox id="publish" :checked="form.is_published"
                                        @update:checked="form.is_published = $event"
                                        class="h-6 w-6 border-white/20 data-[state=checked]:bg-orange-600 data-[state=checked]:border-orange-600" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats / Info Card -->
                    <div class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-2xl">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-400">
                                <LayoutGrid class="h-5 w-5" />
                            </div>
                            <h2 class="text-lg font-bold">Informasi SEO</h2>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 bg-orange-500/5 border border-orange-500/20 rounded-2xl">
                                <div class="flex gap-3">
                                    <Info class="h-5 w-5 text-orange-400 shrink-0" />
                                    <p class="text-[10px] text-orange-200/70 leading-relaxed font-medium">
                                        Slug kategori akan dibuat secara otomatis berdasarkan nama kategori untuk ramah
                                        SEO.
                                    </p>
                                </div>
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
</style>