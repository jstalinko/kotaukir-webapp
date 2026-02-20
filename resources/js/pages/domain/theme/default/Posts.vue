<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import { ArrowLeft } from 'lucide-vue-next';
import { getDomainUrl } from '../../../../lib/domain';

const props = defineProps({
    user: Object,
    site: Object,
    posts: Array,
});

const stripHtml = (html) => {
    if (!html) return '';
    return html.replace(/<[^>]*>?/gm, '');
};
</script>

<template>

    <Head :title="`Journal - ${site?.site_name || user.name}`" />

    <Layout :user="user" :site="site">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 min-h-[70vh]">
            <div class="mb-12">
                <Link :href="getDomainUrl(user.name, '/')"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-brown-600 mb-8 transition-colors">
                    <ArrowLeft class="w-4 h-4" /> Back to Home
                </Link>

                <div class="max-w-3xl">
                    <span class="text-sm font-bold uppercase tracking-widest text-brown-600/80 block mb-3">Read
                        Our</span>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-tight">Journal & Updates</h1>
                </div>
            </div>

            <div v-if="posts && posts.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <Link v-for="post in posts" :key="post.id" :href="getDomainUrl(user.name, `/post/${post.slug}`)"
                    class="group block overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100">
                    <div class="aspect-video w-full bg-gray-100 overflow-hidden">
                        <img v-if="post.image" :src="post.image"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <div v-else
                            class="w-full h-full flex items-center justify-center text-gray-400 font-medium bg-gray-50 text-sm">
                            No Cover Image</div>
                    </div>
                    <div class="p-6">
                        <div
                            class="flex items-center gap-3 text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                            <span>{{ new Date(post.created_at).toLocaleDateString() }}</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span>{{ post.views || 0 }} Views</span>
                        </div>
                        <h2
                            class="text-xl font-bold text-gray-900 mb-3 group-hover:text-brown-600 transition-colors line-clamp-2">
                            {{ post.title }}</h2>
                        <p class="text-gray-500 line-clamp-3 text-sm leading-relaxed">{{ stripHtml(post.content) ||
                            'Click to read full article...' }}</p>
                    </div>
                </Link>
            </div>

            <div v-else class="py-32 text-center bg-gray-50 rounded-3xl border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-900 tracking-tight">No articles yet</h3>
                <p class="text-gray-500 mt-3 font-medium">Check back later for new content from {{ site?.site_name ||
                    user.name }}.</p>
            </div>
        </div>
    </Layout>
</template>
