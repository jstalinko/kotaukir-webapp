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
    category: Object,
});

// Dynamically import the theme's Categories component
const ThemeCategories = defineAsyncComponent(() =>
    import(`./theme/${props.theme}/Categories.vue`)
);
</script>

<template>
    <ThemeCategories v-bind="$props" />
</template>
