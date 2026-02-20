<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
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
import { Plus, Search, MoreHorizontal, Pencil, Trash2, Eye, EyeOff, ArrowUpDown } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Produk', href: '/dashboard/product' },
];

// Search & filter state
const searchQuery = ref('');
const sortKey = ref('id');
const sortOrder = ref('desc');
const filterPublish = ref('all'); // 'all', 'published', 'draft'

const toggleSort = (key) => {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortKey.value = key;
        sortOrder.value = 'asc';
    }
};

const filteredProducts = computed(() => {
    let items = [...props.products];

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
    if (filterPublish.value === 'published') {
        items = items.filter((p) => p.is_published);
    } else if (filterPublish.value === 'draft') {
        items = items.filter((p) => !p.is_published);
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

const handleDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        router.get(`/dashboard/product/${id}/delete`);
    }
};

const handleTogglePublish = (id) => {
    router.post(`/dashboard/product/${id}/toggle-publish`);
};

const parseImages = (images) => {
    if (Array.isArray(images)) return images;
    try {
        return JSON.parse(images);
    } catch {
        return ['https://placehold.co/600x400/8d6e63/FFFFFF?text=NO+IMAGE'];
    }
};
</script>

<template>

    <Head title="Produk" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4 md:p-6">
            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Produk</h1>
                    <p class="text-sm text-muted-foreground">Kelola semua produk Anda</p>
                </div>
                <Link href="/dashboard/product/create">
                    <Button class="bg-orange-600 hover:bg-orange-500 text-white gap-2">
                        <Plus class="h-4 w-4" />
                        Tambah Produk
                    </Button>
                </Link>
            </div>

            <!-- Filters -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative flex-1 max-w-sm">
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                    <Input v-model="searchQuery" placeholder="Cari produk..." class="pl-9" />
                </div>
                <div class="flex gap-2">
                    <Button variant="outline" size="sm" :class="{ 'bg-accent': filterPublish === 'all' }"
                        @click="filterPublish = 'all'">
                        Semua
                    </Button>
                    <Button variant="outline" size="sm" :class="{ 'bg-accent': filterPublish === 'published' }"
                        @click="filterPublish = 'published'">
                        Published
                    </Button>
                    <Button variant="outline" size="sm" :class="{ 'bg-accent': filterPublish === 'draft' }"
                        @click="filterPublish = 'draft'">
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
                        <TableRow v-if="filteredProducts.length === 0">
                            <TableCell colspan="7" class="h-24 text-center text-muted-foreground">
                                Tidak ada produk ditemukan.
                            </TableCell>
                        </TableRow>
                        <TableRow v-for="product in filteredProducts" :key="product.id" class="group">
                            <TableCell class="font-medium text-muted-foreground">
                                {{ product.id }}
                            </TableCell>
                            <TableCell>
                                <img :src="parseImages(product.images)[0]" :alt="product.title"
                                    class="h-10 w-10 rounded-lg object-cover border" />
                            </TableCell>
                            <TableCell>
                                <div>
                                    <p class="font-medium">{{ product.title }}</p>
                                    <p class="text-xs text-muted-foreground truncate max-w-[200px]">
                                        {{ product.slug }}
                                    </p>
                                </div>
                            </TableCell>
                            <TableCell>
                                <Badge variant="outline" v-if="product.category">
                                    {{ product.category.name }}
                                </Badge>
                                <span v-else class="text-xs text-muted-foreground">-</span>
                            </TableCell>
                            <TableCell>
                                {{ product.views.toLocaleString() }}
                            </TableCell>
                            <TableCell>
                                <Badge :variant="product.is_published ? 'default' : 'secondary'"
                                    :class="product.is_published ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' : 'bg-gray-500/10 text-gray-400 border-gray-500/20'">
                                    {{ product.is_published ? 'Published' : 'Draft' }}
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
                                            <Link :href="`/dashboard/product/${product.id}/edit`"
                                                class="flex items-center gap-2 cursor-pointer">
                                                <Pencil class="h-4 w-4" />
                                                Edit
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem @click="handleTogglePublish(product.id)"
                                            class="flex items-center gap-2 cursor-pointer">
                                            <component :is="product.is_published ? EyeOff : Eye" class="h-4 w-4" />
                                            {{ product.is_published ? 'Unpublish' : 'Publish' }}
                                        </DropdownMenuItem>
                                        <DropdownMenuSeparator />
                                        <DropdownMenuItem @click="handleDelete(product.id)"
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
                Menampilkan {{ filteredProducts.length }} dari {{ products.length }} produk
            </div>
        </div>
    </AppLayout>
</template>