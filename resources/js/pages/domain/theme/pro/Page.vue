<script setup>
import Layout from './Layout.vue';
import { defineAsyncComponent, computed } from 'vue';

const props = defineProps({
    user: Object,
    site: Object,
    page: Object,
    latest_posts: Array,
    products: Array,
    categories: Array,
});

// Assuming 'pro' uses a simple fallback for components if none defined
const componentMap = {
    Hero: defineAsyncComponent(() => import('./components/Hero.vue')),
    Featured: defineAsyncComponent(() => import('./components/Featured.vue')),
    Cta: defineAsyncComponent(() => import('./components/Cta.vue')),
    ContactForm: defineAsyncComponent(() => import('./components/ContactForm.vue')),
};

const activeComponents = computed(() => {
    return props.page?.content?.['pro'] || props.page?.content?.['default'] || [];
});

const sharedProps = computed(() => ({
    user: props.user,
    site: props.site,
    latest_posts: props.latest_posts,
    products: props.products,
    categories: props.categories,
}));
</script>

<template>
    <Layout :user="user" :site="site">

        <!-- Corporate Page Header -->
        <div class="bg-stone-100 py-16 lg:py-24 border-b-4 border-stone-900">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <h1 class="text-5xl md:text-7xl font-black text-stone-900 uppercase tracking-tighter leading-none">
                    {{ page?.title }}
                </h1>
            </div>
        </div>

        <template v-for="comp in activeComponents" :key="comp.id">
            <component v-if="componentMap[comp.type]" :is="componentMap[comp.type]" :settings="comp.settings"
                v-bind="sharedProps" />
        </template>

        <div v-if="activeComponents.length === 0"
            class="max-w-7xl mx-auto px-6 lg:px-12 py-32 text-center border-4 border-stone-200 border-dashed my-16">
            <h3 class="text-3xl font-black text-stone-900 uppercase tracking-tighter mb-4">No Content Specified</h3>
            <p class="text-sm font-medium text-stone-500">Page builder information is not yet available for this
                structure.</p>
        </div>

    </Layout>
</template>
