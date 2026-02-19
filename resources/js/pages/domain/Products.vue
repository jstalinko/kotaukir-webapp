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

// Dynamically import the theme's Products component
const ThemeProducts = defineAsyncComponent(() =>
    import(`./theme/${props.theme}/Products.vue`)
);
</script>

<template>
    <ThemeProducts v-bind="$props" />
</template>
