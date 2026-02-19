<script setup>
import { Save } from 'lucide-vue-next';

defineProps({
    form: Object,
    themes: Array,
});
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="theme in themes" :key="theme.id" @click="form.theme = theme.id"
            :class="[form.theme === theme.id ? 'border-orange-600 ring-2 ring-orange-600/20' : 'border-sidebar-border hover:border-sidebar-border-hover']"
            class="group cursor-pointer bg-card rounded-2xl overflow-hidden border transition-all duration-300 relative">
            <div class="aspect-[16/10] overflow-hidden relative">
                <img :src="theme.preview"
                    class="w-full h-full object-cover transition-transform group-hover:scale-110" />
                <div v-if="form.theme === theme.id"
                    class="absolute inset-0 bg-orange-600/10 flex items-center justify-center">
                    <div class="bg-orange-600 text-white p-2 rounded-full shadow-xl">
                        <Save class="w-5 h-5 fill-current" />
                    </div>
                </div>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-foreground">{{ theme.name }}</h3>
                <p class="text-xs text-muted-foreground mt-1">{{ theme.description }}</p>
            </div>
        </div>
    </div>
</template>
