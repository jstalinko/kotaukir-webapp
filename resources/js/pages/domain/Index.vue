<script setup>
import { computed, defineAsyncComponent } from 'vue';

const props = defineProps({
    theme: {
        type: String,
        default: 'default',
    },
    user: Object,
    site: Object,
    products: Array,
    categories: Array,
    latest_posts: Array,
    category: Object, // Optional, for category pages
});

// Dynamically import the theme's Index component
const ThemeIndex = defineAsyncComponent(() =>
    import(`./theme/${props.theme}/Index.vue`)
);
</script>

<template>
    <ThemeIndex v-bind="$props" />
</template>