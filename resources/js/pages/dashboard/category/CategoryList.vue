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
} from '@/components/ui/dropdown-menu';
import { Plus, Search, MoreHorizontal, Pencil, Trash2 } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Kategori', href: '/dashboard/category' },
];

const searchQuery = ref('');

const filteredCategories = computed(() => {
    if (!searchQuery.value) return props.categories;
    const q = searchQuery.value.toLowerCase();
    return props.categories.filter((c) =>
        c.name.toLowerCase().includes(q) ||
        (c.description || '').toLowerCase().includes(q)
    );
});

const handleDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        router.get(`/dashboard/category/${id}/delete`);
    }
};
</script>

<template>

    <Head title="Kategori" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4 md:p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Kategori</h1>
                    <p class="text-sm text-muted-foreground">Kelola kategori produk Anda</p>
                </div>
                <Link href="/dashboard/category/create">
                    <Button class="gap-2">
                        <Plus class="h-4 w-4" />
                        Tambah Kategori
                    </Button>
                </Link>
            </div>

            <div class="relative max-w-sm">
                <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                <Input v-model="searchQuery" placeholder="Cari kategori..." class="pl-9" />
            </div>

            <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-card">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-16">ID</TableHead>
                            <TableHead>Nama</TableHead>
                            <TableHead>Slug</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right">Aksi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="filteredCategories.length === 0">
                            <TableCell colspan="5" class="h-24 text-center text-muted-foreground">
                                Tidak ada kategori ditemukan.
                            </TableCell>
                        </TableRow>
                        <TableRow v-for="category in filteredCategories" :key="category.id">
                            <TableCell class="text-muted-foreground">{{ category.id }}</TableCell>
                            <TableCell class="font-medium">{{ category.name }}</TableCell>
                            <TableCell class="text-xs text-muted-foreground">{{ category.slug }}</TableCell>
                            <TableCell>
                                <Badge :variant="category.is_published ? 'default' : 'secondary'">
                                    {{ category.is_published ? 'Published' : 'Draft' }}
                                </Badge>
                            </TableCell>
                            <TableCell class="text-right">
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                        <Button variant="ghost" size="icon">
                                            <MoreHorizontal class="h-4 w-4" />
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem as-child>
                                            <Link :href="`/dashboard/category/${category.id}/edit`"
                                                class="flex items-center gap-2 cursor-pointer">
                                                <Pencil class="h-4 w-4" />
                                                Edit
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem @click="handleDelete(category.id)"
                                            class="flex items-center gap-2 cursor-pointer text-red-500">
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
        </div>
    </AppLayout>
</template>