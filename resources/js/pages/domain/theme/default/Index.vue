<script setup>
import Layout from './Layout.vue';
import { defineAsyncComponent, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { getDomainUrl } from '../../../../lib/domain';

const props = defineProps({
    user: Object,
    site: Object,
    products: Array,
    categories: Array,
    category: Object,
    latest_posts: Array,
});

const stripHtml = (html) => {
    if (!html) return '';
    return html.replace(/<[^>]*>?/gm, '');
};

// Dynamic component map — each component is its own file
// Add new components here without touching the template
const componentMap = {
    Hero: defineAsyncComponent(() => import('./components/Hero.vue')),
    Featured: defineAsyncComponent(() => import('./components/Featured.vue')),
    Cta: defineAsyncComponent(() => import('./components/Cta.vue')),
    ContactForm: defineAsyncComponent(() => import('./components/ContactForm.vue')),
    Post: defineAsyncComponent(() => import('./components/Post.vue')),
};

// Get the active components for the default theme
const activeComponents = computed(() => {
    const comps = props.site?.components;
    if (!comps) return [];
    // Support both new { default: [] } structure and legacy flat array
    if (Array.isArray(comps)) return comps;
    return comps['default'] || [];
});

// Shared props passed to ALL components
const sharedProps = computed(() => ({
    user: props.user,
    site: props.site,
    products: props.products,
    categories: props.categories,
    latest_posts: props.latest_posts,
}));
</script>

<template>
    <Layout :user="user" :site="site">
        <!-- Dynamic Component Rendering — same pattern as javara's User.vue -->
        <template v-for="comp in activeComponents" :key="comp.id">
            <component v-if="componentMap[comp.type]" :is="componentMap[comp.type]" :settings="comp.settings"
                v-bind="sharedProps" />
        </template>

        <!-- Fallback: show categories + all products if no components are configured -->
        <template v-if="activeComponents.length === 0">
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="flex items-center gap-4 overflow-x-auto pb-4 mb-10 scrollbar-hide">
                    <Link v-for="cat in categories" :key="cat.id"
                        :href="getDomainUrl(user?.name, `/category/${cat.slug}`)"
                        class="px-8 py-3 bg-white border border-brown-100/10 rounded-full shadow-sm whitespace-nowrap text-sm font-bold text-[#451A03] hover:bg-[#451A03] hover:text-white transition-all">
                        {{ cat.name }}
                    </Link>
                </div>

                <div v-if="products && products.length > 0"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <component :is="componentMap.Hero ? null : null" />
                </div>
            </section>
        </template>


    </Layout>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
