<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Badge } from '@/components/ui/badge';
import { ArrowLeft, Save, Info, FileText, Image as ImageIcon, Settings2, LayoutGrid } from 'lucide-vue-next';
import { computed } from 'vue';
import RichEditor from '@/components/RichEditor.vue';
import ImagePicker from '@/components/ImagePicker.vue';

const props = defineProps({
    isEdit: Boolean,
    post: Object,
    categories: Array,
});

const breadcrumbs = computed(() => [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Postingan', href: '/dashboard/post' },
    { title: props.isEdit ? 'Edit Postingan' : 'Tambah Postingan', href: '#' },
]);

const form = useForm({
    title: props.post?.title ?? '',
    content: props.post?.content ?? '',
    category_id: props.post?.category_id ?? '',
    image: props.post?.image ?? '',
    status: props.post?.status ?? 'draft',
    type: props.post?.type ?? 'post',
});

const handleSubmit = () => {
    const url = props.isEdit
        ? `/dashboard/post/${props.post.id}/update`
        : '/dashboard/post/store';
    form.post(url);
};
</script>

<template>

    <Head :title="isEdit ? 'Edit Postingan' : 'Tambah Postingan'" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 overflow-x-hidden rounded-xl p-4 md:p-8 bg-[#050505] text-white">

            <!-- Hero Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-white/10">
                <div class="flex items-start gap-4">
                    <Button variant="ghost" size="icon"
                        class="h-10 w-10 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl"
                        @click="router.get('/dashboard/post')">
                        <ArrowLeft class="h-5 w-5" />
                    </Button>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <Badge variant="outline"
                                class="bg-orange-500/10 text-orange-400 border-orange-500/20 px-2 py-0 text-[10px] uppercase tracking-wider font-bold">
                                {{ isEdit ? 'Update Mode' : 'New Post' }}
                            </Badge>
                        </div>
                        <h1
                            class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                            {{ isEdit ? 'Edit Postingan' : 'Tambah Postingan' }}
                        </h1>
                        <p class="text-sm text-gray-400 mt-1 max-w-lg">
                            Tulis konten artikel atau halaman Anda dengan editor yang powerful.
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <Button variant="ghost" @click="router.get('/dashboard/post')"
                        class="text-gray-400 hover:text-white">
                        Batal
                    </Button>
                    <Button @click="handleSubmit" :disabled="form.processing"
                        class="bg-orange-600 hover:bg-orange-500 text-white px-8 h-11 rounded-xl shadow-lg shadow-orange-600/20 group transition-all">
                        <Save class="h-4 w-4 mr-2 group-hover:scale-110 transition-transform" />
                        {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Simpan Perubahan' : 'Simpan Post') }}
                    </Button>
                </div>
            </div>

            <!-- Body -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Left: Main Content -->
                <div class="lg:col-span-8 space-y-8">

                    <!-- Title Card -->
                    <div
                        class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-3xl p-6 md:p-8 shadow-2xl">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-orange-500/10 rounded-lg text-orange-400">
                                <FileText class="h-5 w-5" />
                            </div>
                            <h2 class="text-xl font-bold">Informasi Utama</h2>
                        </div>
                        <div class="space-y-6">
                            <div class="grid gap-3">
                                <Label for="title" class="text-sm font-semibold text-gray-300 ml-1">Judul Postingan
                                    *</Label>
                                <Input id="title" v-model="form.title" placeholder="Tulis judul yang menarik..."
                                    class="h-12 bg-black/40 border-white/10 focus:border-orange-500/50 rounded-xl px-4 text-white" />
                                <p v-if="form.errors.title" class="text-xs text-red-500 italic ml-1">{{
                                    form.errors.title }}</p>
                            </div>

                            <div class="grid gap-3">
                                <Label class="text-sm font-semibold text-gray-300 ml-1">Konten *</Label>
                                <RichEditor v-model="form.content" />
                                <p v-if="form.errors.content" class="text-xs text-red-500 italic ml-1">{{
                                    form.errors.content }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Cover Image Card -->
                    <div
                        class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-3xl p-6 md:p-8 shadow-2xl">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-500/10 rounded-lg text-blue-400">
                                    <ImageIcon class="h-5 w-5" />
                                </div>
                                <h2 class="text-xl font-bold">Gambar Cover</h2>
                            </div>
                            <span class="text-xs text-gray-500 font-medium">PNG, JPG — Maks 2MB</span>
                        </div>
                        <ImagePicker v-model="form.image" :multiple="false" upload-url="/dashboard/my-site/upload" />
                    </div>
                </div>

                <!-- Right: Settings Sidebar -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- Publish Settings -->
                    <div class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-2xl">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-purple-500/10 rounded-lg text-purple-400">
                                <Settings2 class="h-5 w-5" />
                            </div>
                            <h2 class="text-lg font-bold">Pengaturan</h2>
                        </div>
                        <div class="space-y-4">
                            <!-- Status -->
                            <div class="grid gap-2">
                                <Label class="text-xs text-gray-400 font-bold uppercase tracking-wider">Status</Label>
                                <select v-model="form.status"
                                    class="w-full h-11 bg-black/40 border border-white/10 rounded-xl px-3 text-sm focus:outline-none focus:border-orange-500/50 appearance-none text-white">
                                    <option value="draft" class="bg-[#050505]">Draft</option>
                                    <option value="published" class="bg-[#050505]">Published</option>
                                </select>
                            </div>
                            <!-- Type -->
                            <div class="grid gap-2">
                                <Label class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tipe</Label>
                                <select v-model="form.type"
                                    class="w-full h-11 bg-black/40 border border-white/10 rounded-xl px-3 text-sm focus:outline-none focus:border-orange-500/50 appearance-none text-white">
                                    <option value="post" class="bg-[#050505]">Post / Artikel</option>
                                    <option value="page" class="bg-[#050505]">Page / Halaman</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-2xl">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-400">
                                <LayoutGrid class="h-5 w-5" />
                            </div>
                            <h2 class="text-lg font-bold">Kategori</h2>
                        </div>
                        <div class="grid gap-2">
                            <select v-model="form.category_id"
                                class="w-full h-11 bg-black/40 border border-white/10 rounded-xl px-3 text-sm focus:outline-none focus:border-orange-500/50 appearance-none text-white">
                                <option value="" class="bg-[#050505]">— Pilih Kategori —</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id" class="bg-[#0a0a0a]">
                                    {{ cat.name }}
                                </option>
                            </select>
                            <div v-if="categories.length === 0"
                                class="p-3 bg-red-500/5 border border-red-500/20 rounded-xl mt-2">
                                <p class="text-[10px] text-red-400 leading-relaxed font-medium">
                                    Belum ada kategori. Buat kategori terlebih dahulu.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tip Card -->
                    <div class="bg-orange-500/5 border border-orange-500/20 rounded-3xl p-6">
                        <div class="flex gap-4">
                            <Info class="h-6 w-6 text-orange-400 shrink-0 mt-0.5" />
                            <div class="space-y-1">
                                <h3 class="text-sm font-bold text-orange-200">Tips Konten</h3>
                                <p class="text-xs text-orange-200/60 leading-relaxed">
                                    Judul yang menarik dan konten minimal 300 kata meningkatkan kemungkinan artikel Anda
                                    tampil di mesin pencari.
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
}
</style>