<script setup>
import { computed, defineAsyncComponent } from 'vue';

const props = defineProps({
    theme: {
        type: String,
        default: 'default',
    },
    user: Object,
    site: Object,
    page: Object,
    latest_posts: Array,
    products: Array,
    categories: Array,
});

// Dynamically import the theme's Page component
// Falls back gracefully if not found
const ThemePage = defineAsyncComponent({
    loader: () => import(`./theme/${props.theme}/Page.vue`),
    errorComponent: {
        template: `<div class="text-center py-40 text-gray-400">Page component not found for this theme.</div>`
    }
});
</script>

<template>
    <ThemePage v-bind="$props" />
</template>
