<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Store } from 'lucide-vue-next';
</script>

<template>

    <Head title="Theme Store" />
    <AppLayout>
        <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4">
            <div class="p-6 bg-orange-50 rounded-full mb-6">
                <Store class="w-10 h-10 text-orange-400" />
            </div>
            <h1 class="text-2xl font-bold text-foreground mb-2">Theme Store</h1>
            <p class="text-muted-foreground text-sm">Fitur ini belum tersedia.</p>
        </div>
    </AppLayout>
</template>