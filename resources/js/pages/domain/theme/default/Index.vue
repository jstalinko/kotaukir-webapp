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

        <!-- Latest Articles / Posts -->
        <section v-if="latest_posts && latest_posts.length > 0"
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 bg-gray-50 my-12 rounded-3xl">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Latest Articles</h2>
                    <p class="text-gray-500 mt-2 font-medium">Insights and updates</p>
                </div>
                <Link :href="getDomainUrl(user.name, '/post')"
                    class="text-sm font-bold text-brown-600 hover:text-brown-800 transition-colors uppercase tracking-wider">
                    View All &rarr;
                </Link>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <Link v-for="post in latest_posts" :key="post.id" :href="getDomainUrl(user.name, `/post/${post.slug}`)"
                    class="group block overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="aspect-video w-full bg-gray-100 overflow-hidden">
                        <img v-if="post.image" :src="post.image"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <div v-else class="w-full h-full flex items-center justify-center text-gray-400 font-medium">No
                            Image</div>
                    </div>
                    <div class="p-6">
                        <div
                            class="flex items-center gap-3 text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                            <span>{{ new Date(post.created_at).toLocaleDateString() }}</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span>{{ post.views || 0 }} Views</span>
                        </div>
                        <h3
                            class="text-xl font-bold text-gray-900 mb-3 group-hover:text-brown-600 transition-colors line-clamp-2">
                            {{ post.title }}</h3>
                        <p class="text-gray-500 line-clamp-3 text-sm leading-relaxed">{{
                            post.content?.replace(/<[^>]* >?/gm, '') ||
                            'Read more...' }}</p>
                    </div>
                </Link>
            </div>
        </section>
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
