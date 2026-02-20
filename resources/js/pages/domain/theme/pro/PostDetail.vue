<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import { ArrowLeft, Share2, Calendar, Eye } from 'lucide-vue-next';
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
        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-12 py-12 lg:py-20 min-h-[70vh]">

            <div class="mb-10 text-center relative z-10 w-full flex justify-between">
                <Link :href="getDomainUrl(user.name, '/post')"
                    class="inline-flex items-center justify-center w-10 h-10 md:w-auto md:h-auto md:px-4 md:py-2 bg-white rounded-full md:rounded-xl border border-zinc-200 shadow-sm hover:border-orange-300 hover:text-orange-600 transition-all text-zinc-600 font-bold text-sm gap-2">
                    <ArrowLeft class="w-4 h-4" /> <span class="hidden md:inline">Back</span>
                </Link>
                <button
                    class="w-10 h-10 bg-white rounded-full border border-zinc-200 shadow-sm flex items-center justify-center text-zinc-600 hover:border-orange-300 hover:text-orange-600 transition-all">
                    <Share2 class="w-4 h-4" />
                </button>
            </div>

            <header class="mb-12 text-center md:text-left">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mb-6">
                    <span
                        class="inline-flex items-center gap-1.5 py-1 px-3 rounded bg-orange-100 text-orange-700 text-xs font-bold">
                        {{ post.category?.name || 'Journal' }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-zinc-400">
                        <Calendar class="w-3.5 h-3.5" />
                        {{ new Date(post.created_at).toLocaleDateString('en-US', {
                            day: 'numeric', month: 'long', year:
                        'numeric' }) }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-zinc-400">
                        <Eye class="w-3.5 h-3.5" />
                        {{ post.views || 0 }} Views
                    </span>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-zinc-900 tracking-tight leading-[1.1]">
                    {{ post.title }}
                </h1>
            </header>

            <div v-if="post.image"
                class="aspect-[16/9] md:aspect-[21/9] w-full bg-zinc-100 mb-12 rounded-3xl overflow-hidden shadow-sm">
                <img :src="post.image" class="w-full h-full object-cover" />
            </div>

            <div class="prose prose-sm md:prose-base lg:prose-lg prose-zinc max-w-none 
                        prose-headings:font-extrabold prose-headings:tracking-tight prose-headings:text-zinc-900
                        prose-p:text-zinc-600 prose-p:leading-loose prose-p:font-medium
                        prose-a:text-orange-600 prose-a:font-bold prose-a:no-underline hover:prose-a:underline hover:prose-a:text-orange-700 transition-colors
                        prose-strong:font-bold prose-strong:text-zinc-900
                        prose-img:rounded-2xl prose-img:border prose-img:border-zinc-200" v-html="post.content">
            </div>

            <div class="mt-20 pt-10 border-t border-zinc-200">
                <div class="flex items-center gap-5 p-6 md:p-8 bg-zinc-50 rounded-3xl border border-zinc-100">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl text-white flex items-center justify-center font-bold text-xl shadow-inner shrink-0">
                        {{ user.name.charAt(0) }}
                    </div>
                    <div>
                        <span
                            class="text-[10px] font-bold uppercase tracking-widest text-zinc-400 block mb-1">Author</span>
                        <p class="font-bold text-zinc-900 text-lg tracking-tight">{{ user.name }}</p>
                    </div>
                </div>
            </div>
        </article>
    </Layout>
</template>

<style>
/* Custom resets for the Pro theme prose */
.prose blockquote {
    border-left-width: 4px;
    border-left-color: #f97316;
    /* orange-500 */
    background-color: #fafaf9;
    /* zinc-50 */
    padding: 1.5rem 2rem;
    border-radius: 0 1rem 1rem 0;
    font-style: normal;
    font-weight: 500;
    color: #3f3f46;
    /* zinc-700 */
}
</style>
