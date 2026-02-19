<script setup>
import { computed, defineAsyncComponent } from 'vue';

const props = defineProps({
    theme: {
        type: String,
        default: 'default',
    },
    user: Object,
    site: Object,
    product: Object,
});

// Dynamically import the theme's ProductDetail component
const ThemeProductDetail = defineAsyncComponent(() =>
    import(`./theme/${props.theme}/ProductDetail.vue`)
);
</script>

<template>
    <ThemeProductDetail v-bind="$props" />
</template>
