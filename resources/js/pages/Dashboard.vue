<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import { computed } from 'vue';
import { Box, FolderOpen, Eye, Shield } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const page = usePage();
const stats = computed(() => page.props.stats as {
    totalProducts: number;
    totalCategories: number;
    totalViews: number;
    accountLevel: string;
});

const levelConfig: Record<string, { label: string; color: string; bg: string }> = {
    basic: { label: 'Basic', color: 'text-gray-400', bg: 'bg-gray-500/10 border-gray-500/20' },
    professional: { label: 'Professional', color: 'text-orange-400', bg: 'bg-orange-500/10 border-orange-500/20' },
    business: { label: 'Business', color: 'text-emerald-400', bg: 'bg-emerald-500/10 border-emerald-500/20' },
};

const currentLevel = computed(() => levelConfig[stats.value.accountLevel] || levelConfig.basic);

const statCards = computed(() => [
    {
        title: 'Total Produk',
        value: stats.value.totalProducts,
        icon: Box,
        color: 'text-orange-400',
        bg: 'bg-orange-500/10',
        borderColor: 'border-orange-500/20',
    },
    {
        title: 'Total Kategori',
        value: stats.value.totalCategories,
        icon: FolderOpen,
        color: 'text-blue-400',
        bg: 'bg-blue-500/10',
        borderColor: 'border-blue-500/20',
    },
    {
        title: 'Total Views',
        value: stats.value.totalViews,
        icon: Eye,
        color: 'text-emerald-400',
        bg: 'bg-emerald-500/10',
        borderColor: 'border-emerald-500/20',
    },
]);
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4 md:p-6">
            <!-- Stats Overview Grid -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <!-- Stat Cards -->
                <div v-for="(card, index) in statCards" :key="index"
                    class="group relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-card p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                    <!-- Subtle glow on hover -->
                    <div :class="[card.bg]"
                        class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>

                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">{{ card.title }}</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-foreground">
                                {{ card.value.toLocaleString() }}
                            </p>
                        </div>
                        <div :class="[card.bg, card.borderColor]"
                            class="flex h-12 w-12 items-center justify-center rounded-xl border">
                            <component :is="card.icon" :class="card.color" class="h-6 w-6" />
                        </div>
                    </div>
                </div>

                <!-- Account Status Card -->
                <div
                    class="group relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-card p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                    <div :class="[currentLevel.bg.replace('border-', '')]"
                        class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>

                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Status Akun</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight" :class="currentLevel.color">
                                {{ currentLevel.label }}
                            </p>
                        </div>
                        <div :class="[currentLevel.bg]"
                            class="flex h-12 w-12 items-center justify-center rounded-xl border"
                            :style="{ borderColor: 'inherit' }">
                            <Shield :class="currentLevel.color" class="h-6 w-6" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content area placeholder -->
            <div
                class="relative min-h-[40vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-card p-6">
                <div class="flex h-full items-center justify-center">
                    <div class="text-center space-y-2">
                        <p class="text-lg font-semibold text-muted-foreground">Selamat Datang di Dashboard</p>
                        <p class="text-sm text-muted-foreground/70">Kelola produk, kategori, dan website Anda dari sini.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
