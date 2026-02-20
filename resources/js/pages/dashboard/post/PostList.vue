<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Badge } from '@/components/ui/badge';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
    DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu';
import { Plus, Search, MoreHorizontal, Pencil, Trash2, Eye, EyeOff, ArrowUpDown, FileText } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps({
    posts: {
        type: Array,
        default: () => [],
    },
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Postingan', href: '/dashboard/post' },
];

const flash = usePage().props.flash;

// Search & filter state
const searchQuery = ref('');
const sortKey = ref('id');
const sortOrder = ref('desc');
const filterStatus = ref('all'); // 'all', 'published', 'draft'

const toggleSort = (key) => {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortKey.value = key;
        sortOrder.value = 'asc';
    }
};

const filteredPosts = computed(() => {
    let items = [...props.posts];

    // Search filter
    if (searchQuery.value) {
        const q = searchQuery.value.toLowerCase();
        items = items.filter(
            (p) =>
                p.title.toLowerCase().includes(q) ||
                (p.category?.name || '').toLowerCase().includes(q)
        );
    }

    // Publish filter
    if (filterStatus.value === 'published') {
        items = items.filter((p) => p.status === 'published');
    } else if (filterStatus.value === 'draft') {
        items = items.filter((p) => p.status !== 'published');
    }

    // Sort
    items.sort((a, b) => {
        let valA = a[sortKey.value];
        let valB = b[sortKey.value];

        if (typeof valA === 'string') {
            valA = valA.toLowerCase();
            valB = (valB || '').toLowerCase();
        }

        if (valA < valB) return sortOrder.value === 'asc' ? -1 : 1;
        if (valA > valB) return sortOrder.value === 'asc' ? 1 : -1;
        return 0;
    });

    return items;
});

const destroy = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus postingan ini?')) {
        router.get(`/dashboard/post/${id}/delete`);
    }
};

const toggleStatus = (id) => {
    router.post(`/dashboard/post/${id}/toggle-status`);
};
</script>

<template>

    <Head title="Postingan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4 md:p-6">
            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Postingan</h1>
                    <p class="text-sm text-muted-foreground">Kelola artikel dan halaman website Anda.</p>
                </div>
                <Link href="/dashboard/post/create">
                    <Button class="bg-orange-600 hover:bg-orange-500 text-white gap-2">
                        <Plus class="h-4 w-4" />
                        Tambah Postingan
                    </Button>
                </Link>
            </div>

            <!-- Flash -->
            <div v-if="flash?.success"
                class="px-4 py-3 bg-green-500/10 border border-green-500/20 text-emerald-500 rounded-xl text-sm">
                {{ flash.success }}
            </div>

            <!-- Filters -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative flex-1 max-w-sm">
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                    <Input v-model="searchQuery" placeholder="Cari postingan..." class="pl-9" />
                </div>
                <div class="flex gap-2">
                    <Button variant="outline" size="sm" :class="{ 'bg-accent': filterStatus === 'all' }"
                        @click="filterStatus = 'all'">
                        Semua
                    </Button>
                    <Button variant="outline" size="sm" :class="{ 'bg-accent': filterStatus === 'published' }"
                        @click="filterStatus = 'published'">
                        Published
                    </Button>
                    <Button variant="outline" size="sm" :class="{ 'bg-accent': filterStatus === 'draft' }"
                        @click="filterStatus = 'draft'">
                        Draft
                    </Button>
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-card">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-16">
                                <button @click="toggleSort('id')" class="flex items-center gap-1 hover:text-foreground">
                                    #
                                    <ArrowUpDown class="h-3 w-3" />
                                </button>
                            </TableHead>
                            <TableHead>Image</TableHead>
                            <TableHead>
                                <button @click="toggleSort('title')"
                                    class="flex items-center gap-1 hover:text-foreground">
                                    Judul
                                    <ArrowUpDown class="h-3 w-3" />
                                </button>
                            </TableHead>
                            <TableHead>Kategori</TableHead>
                            <TableHead>Tipe</TableHead>
                            <TableHead>
                                <button @click="toggleSort('views')"
                                    class="flex items-center gap-1 hover:text-foreground">
                                    Views
                                    <ArrowUpDown class="h-3 w-3" />
                                </button>
                            </TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right">Aksi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="filteredPosts.length === 0">
                            <TableCell colspan="8" class="h-24 text-center text-muted-foreground">
                                Tidak ada postingan ditemukan.
                            </TableCell>
                        </TableRow>
                        <TableRow v-for="post in filteredPosts" :key="post.id" class="group">
                            <TableCell class="font-medium text-muted-foreground">
                                {{ post.id }}
                            </TableCell>
                            <TableCell>
                                <div v-if="post.image" class="h-10 w-10 rounded-lg overflow-hidden border">
                                    <img :src="post.image" :alt="post.title" class="w-full h-full object-cover" />
                                </div>
                                <div v-else
                                    class="h-10 w-10 rounded-lg border flex items-center justify-center bg-black/5 dark:bg-white/5">
                                    <FileText class="w-4 h-4 text-muted-foreground" />
                                </div>
                            </TableCell>
                            <TableCell>
                                <div>
                                    <p class="font-medium text-foreground line-clamp-1">{{ post.title }}</p>
                                    <p class="text-xs text-muted-foreground truncate max-w-[200px]">
                                        /{{ post.slug }}
                                    </p>
                                </div>
                            </TableCell>
                            <TableCell>
                                <Badge variant="outline" v-if="post.category">
                                    {{ post.category.name }}
                                </Badge>
                                <span v-else class="text-xs text-muted-foreground">-</span>
                            </TableCell>
                            <TableCell>
                                <Badge variant="outline"
                                    :class="post.type === 'post' ? 'bg-blue-500/10 text-blue-500 border-blue-500/20' : 'bg-purple-500/10 text-purple-500 border-purple-500/20'">
                                    {{ post.type === 'post' ? 'Post' : 'Page' }}
                                </Badge>
                            </TableCell>
                            <TableCell>
                                {{ post.views?.toLocaleString() || 0 }}
                            </TableCell>
                            <TableCell>
                                <Badge :variant="post.status === 'published' ? 'default' : 'secondary'"
                                    :class="post.status === 'published' ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' : 'bg-gray-500/10 text-gray-400 border-gray-500/20'">
                                    {{ post.status === 'published' ? 'Published' : 'Draft' }}
                                </Badge>
                            </TableCell>
                            <TableCell class="text-right">
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                        <Button variant="ghost" size="icon" class="h-8 w-8">
                                            <MoreHorizontal class="h-4 w-4" />
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem as-child>
                                            <Link :href="`/dashboard/post/${post.id}/edit`"
                                                class="flex items-center gap-2 cursor-pointer">
                                                <Pencil class="h-4 w-4" />
                                                Edit
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem @click="toggleStatus(post.id)"
                                            class="flex items-center gap-2 cursor-pointer">
                                            <component :is="post.status === 'published' ? EyeOff : Eye"
                                                class="h-4 w-4" />
                                            {{ post.status === 'published' ? 'Unpublish' : 'Publish' }}
                                        </DropdownMenuItem>
                                        <DropdownMenuSeparator />
                                        <DropdownMenuItem @click="destroy(post.id)"
                                            class="flex items-center gap-2 cursor-pointer text-red-500 focus:text-red-500">
                                            <Trash2 class="h-4 w-4" />
                                            Hapus
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <!-- Info -->
            <div class="text-sm text-muted-foreground">
                Menampilkan {{ filteredPosts.length }} dari {{ posts.length }} postingan
            </div>
        </div>
    </AppLayout>
</template>