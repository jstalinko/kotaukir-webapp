<template>

    <!-- Latest Articles / Posts -->
    <section v-if="latest_posts && latest_posts.length > 0"
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 bg-gray-50 my-12 rounded-3xl">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ settings.title }}</h2>
                <p class="text-gray-500 mt-2 font-medium">{{ settings.subtitle }}</p>
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
                    <div class="flex items-center gap-3 text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
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
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    latest_posts: Array,
    user: Object,
    settings: Object,
});

import { getDomainUrl } from '../../../../../lib/domain';
</script>