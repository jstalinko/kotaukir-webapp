<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { ref, computed } from 'vue';
import { Plus, Pencil, Trash2, Globe, FileText, Eye, Search } from 'lucide-vue-next';

const props = defineProps({
    posts: Array,
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Postingan', href: '/dashboard/post' },
];

const search = ref('');
const flash = usePage().props.flash;

const filtered = computed(() =>
    (props.posts ?? []).filter(p =>
        p.title.toLowerCase().includes(search.value.toLowerCase())
    )
);

const destroy = (id) => {
    if (confirm('Hapus postingan ini?')) {
        router.get(`/dashboard/post/${id}/delete`);
    }
};

const toggleStatus = (id) => {
    router.post(`/dashboard/post/${id}/toggle-status`);
};

const statusBadge = (status) =>
    status === 'published'
        ? 'bg-green-100 text-green-700'
        : 'bg-yellow-100 text-yellow-700';

const typeBadge = (type) =>
    type === 'post'
        ? 'bg-blue-100 text-blue-700'
        : 'bg-purple-100 text-purple-700';
</script>

<template>

    <Head title="Postingan" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 md:p-8 w-full mx-auto space-y-6">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Postingan</h1>
                    <p class="text-muted-foreground text-sm mt-1">Kelola artikel dan halaman website Anda.</p>
                </div>
                <Link href="/dashboard/post/create">
                    <Button class="bg-orange-600 hover:bg-orange-700 gap-2">
                        <Plus class="w-4 h-4" /> Tambah Postingan
                    </Button>
                </Link>
            </div>

            <!-- Flash -->
            <div v-if="flash?.success"
                class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                {{ flash.success }}
            </div>

            <!-- Search -->
            <div class="relative max-w-sm">
                <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                <input v-model="search" type="text" placeholder="Cari postingan..."
                    class="w-full pl-9 pr-4 py-2 rounded-xl border border-sidebar-border bg-background text-sm focus:ring-2 focus:ring-orange-600/20 outline-none" />
            </div>

            <!-- Table -->
            <div class="rounded-2xl border border-sidebar-border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-sidebar-accent/50 border-b border-sidebar-border">
                        <tr>
                            <th class="text-left p-4 font-semibold text-muted-foreground">Judul</th>
                            <th class="text-left p-4 font-semibold text-muted-foreground hidden md:table-cell">Kategori
                            </th>
                            <th class="text-left p-4 font-semibold text-muted-foreground hidden md:table-cell">Tipe</th>
                            <th class="text-left p-4 font-semibold text-muted-foreground">Status</th>
                            <th class="text-left p-4 font-semibold text-muted-foreground hidden lg:table-cell">Views
                            </th>
                            <th class="text-right p-4 font-semibold text-muted-foreground">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sidebar-border">
                        <tr v-if="filtered.length === 0">
                            <td colspan="6" class="text-center py-16 text-muted-foreground text-sm">
                                Belum ada postingan.
                            </td>
                        </tr>
                        <tr v-for="post in filtered" :key="post.id"
                            class="hover:bg-sidebar-accent/20 transition-colors">
                            <!-- Title -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div v-if="post.image"
                                        class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 bg-sidebar-accent">
                                        <img :src="post.image" class="w-full h-full object-cover" />
                                    </div>
                                    <div v-else
                                        class="w-10 h-10 rounded-lg bg-sidebar-accent flex items-center justify-center flex-shrink-0">
                                        <FileText class="w-4 h-4 text-muted-foreground" />
                                    </div>
                                    <div>
                                        <p class="font-medium line-clamp-1">{{ post.title }}</p>
                                        <p class="text-xs text-muted-foreground">/{{ post.slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <!-- Category -->
                            <td class="p-4 hidden md:table-cell text-muted-foreground">
                                {{ post.category?.name ?? '—' }}
                            </td>
                            <!-- Type -->
                            <td class="p-4 hidden md:table-cell">
                                <span :class="typeBadge(post.type)"
                                    class="px-2 py-0.5 rounded-full text-xs font-medium capitalize">
                                    {{ post.type }}
                                </span>
                            </td>
                            <!-- Status -->
                            <td class="p-4">
                                <button @click="toggleStatus(post.id)" :class="statusBadge(post.status)"
                                    class="px-2 py-0.5 rounded-full text-xs font-medium capitalize hover:opacity-80 transition-opacity">
                                    {{ post.status }}
                                </button>
                            </td>
                            <!-- Views -->
                            <td class="p-4 hidden lg:table-cell text-muted-foreground">
                                <div class="flex items-center gap-1">
                                    <Eye class="w-3 h-3" /> {{ post.views }}
                                </div>
                            </td>
                            <!-- Actions -->
                            <td class="p-4">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="`/dashboard/post/${post.id}/edit`">
                                        <Button variant="ghost" size="icon" class="h-8 w-8">
                                            <Pencil class="w-4 h-4" />
                                        </Button>
                                    </Link>
                                    <Button variant="ghost" size="icon"
                                        class="h-8 w-8 text-destructive hover:text-destructive"
                                        @click="destroy(post.id)">
                                        <Trash2 class="w-4 h-4" />
                                    </Button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p class="text-xs text-muted-foreground">Total: {{ filtered.length }} postingan</p>
        </div>
    </AppLayout>
</template>