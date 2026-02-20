<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import { ArrowLeft, Clock, Eye } from 'lucide-vue-next';
import { getDomainUrl } from '../../../../lib/domain';

const props = defineProps({
    user: Object,
    site: Object,
    post: Object,
});

</script>

<template>

    <Head :title="`${post?.title} - ${site?.site_name || user.name}`" />

    <Layout :user="user" :site="site">
        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 min-h-[70vh]">
            <Link :href="getDomainUrl(user.name, '/post')"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-brown-600 mb-12 transition-colors">
                <ArrowLeft class="w-4 h-4" /> Back to Journal
            </Link>

            <header class="mb-12">
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <span
                        class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-gray-400">
                        <Clock class="w-3.5 h-3.5" />
                        {{ new Date(post.created_at).toLocaleDateString('en-US', {
                            day: 'numeric', month: 'long', year:
                                'numeric'
                        }) }}
                    </span>
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <span
                        class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-gray-400">
                        <Eye class="w-3.5 h-3.5" />
                        {{ post.views || 0 }} Views
                    </span>
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <span
                        class="text-xs font-bold uppercase tracking-widest px-3 py-1 bg-brown-50 rounded-full text-brown-600">{{
                            post.category?.name || 'Uncategorized' }}</span>
                </div>

                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-tight leading-tight">{{ post.title
                }}</h1>
            </header>

            <div v-if="post.image" class="aspect-video w-full rounded-3xl overflow-hidden mb-16 bg-gray-100 shadow-md">
                <img :src="post.image" class="w-full h-full object-cover" />
            </div>

            <div class="prose prose-lg prose-gray max-w-none 
                        prose-headings:font-bold prose-headings:tracking-tight prose-headings:text-gray-900 
                        prose-p:text-gray-600 prose-p:leading-relaxed 
                        prose-a:text-brown-600 prose-a:font-semibold prose-a:underline-offset-4 hover:prose-a:text-brown-800
                        prose-strong:font-bold prose-strong:text-gray-900
                        prose-img:rounded-2xl prose-img:shadow-sm" v-html="post.content">
            </div>

            <hr class="my-16 border-gray-100" />

            <!-- Author block -->
            <div class="flex items-center justify-between bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold text-lg">
                        {{ user.name.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-gray-400 block mb-1">Author</span>
                        <p class="font-bold text-gray-900">{{ user.name }}</p>
                    </div>
                </div>
                <div class="text-right hidden sm:block">
                    <button
                        class="px-4 py-2 bg-white border border-gray-200 text-sm font-semibold text-gray-700 rounded-full hover:bg-gray-50 transition-colors shadow-sm">
                        Share Article
                    </button>
                </div>
            </div>
        </article>
    </Layout>
</template>
