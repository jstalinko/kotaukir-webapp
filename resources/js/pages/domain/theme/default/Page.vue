<script setup>
import Layout from './Layout.vue';
import { defineAsyncComponent, computed } from 'vue';

const props = defineProps({
    user: Object,
    site: Object,
    page: Object,
});

// Same componentMap pattern as Index.vue
const componentMap = {
    Hero: defineAsyncComponent(() => import('./components/Hero.vue')),
    Featured: defineAsyncComponent(() => import('./components/Featured.vue')),
    Cta: defineAsyncComponent(() => import('./components/Cta.vue')),
    ContactForm: defineAsyncComponent(() => import('./components/ContactForm.vue')),
};

// Get active components for this page under the 'default' theme
const activeComponents = computed(() => {
    return props.page?.content?.['default'] || [];
});

const sharedProps = computed(() => ({
    user: props.user,
    site: props.site,
}));
</script>

<template>
    <Layout :user="user" :site="site">
        <!-- Page Title -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-12 pb-4">
            <h1 class="text-4xl font-serif font-bold text-[#451A03]">{{ page?.title }}</h1>
        </div>

        <!-- Dynamic Components — same pattern as Index.vue -->
        <template v-for="comp in activeComponents" :key="comp.id">
            <component v-if="componentMap[comp.type]" :is="componentMap[comp.type]" :settings="comp.settings"
                v-bind="sharedProps" />
        </template>

        <!-- Empty state -->
        <div v-if="activeComponents.length === 0" class="max-w-7xl mx-auto px-4 py-20 text-center text-gray-400">
            <p class="text-sm">Halaman ini belum memiliki konten.</p>
        </div>
    </Layout>
</template>
