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

// Dynamically import the theme's Single component
const ThemeSingle = defineAsyncComponent(() =>
    import(`./theme/${props.theme}/Single.vue`)
);
</script>

<template>
    <ThemeSingle v-bind="$props" />
</template>