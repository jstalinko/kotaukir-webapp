<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import { ArrowLeft } from 'lucide-vue-next';

const props = defineProps({
    user: Object,
    site: Object,
    post: Object,
});

</script>

<template>

    <Head :title="`${post?.title} - ${site?.site_name || user.name}`" />

    <Layout :user="user" :site="site">
        <article class="max-w-4xl mx-auto px-6 lg:px-10 py-20 min-h-[70vh]">
            <Link :href="`/${user.name}/post`"
                class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-black/50 hover:text-black mb-16 transition-colors">
                <ArrowLeft class="w-4 h-4" /> Back to Journal
            </Link>

            <header class="mb-16">
                <div class="flex flex-wrap items-center gap-4 mb-8">
                    <span class="text-[10px] font-black uppercase tracking-widest text-black/40">{{ new
                        Date(post.created_at).toLocaleDateString('en-US', {
                            day: 'numeric', month: 'long', year:
                        'numeric' }) }}</span>
                    <span class="w-10 h-[1px] bg-black/10"></span>
                    <span
                        class="text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 bg-black/5 rounded-full text-black/60">{{
                            post.category?.name || 'Uncategorized' }}</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-black text-black tracking-tighter uppercase leading-[0.95]">{{
                    post.title }}</h1>
            </header>

            <div v-if="post.image" class="aspect-video w-full rounded-[40px] overflow-hidden mb-16 bg-[#F0F0F0]">
                <img :src="post.image" class="w-full h-full object-cover" />
            </div>

            <div class="prose prose-lg prose-neutral max-w-none 
                        prose-headings:font-black prose-headings:tracking-tighter prose-headings:uppercase 
                        prose-p:text-black/70 prose-p:leading-relaxed prose-p:text-lg
                        prose-a:text-black prose-a:font-bold prose-a:underline-offset-4 hover:prose-a:text-black/70
                        prose-strong:font-black prose-strong:text-black" v-html="post.content">
            </div>

            <hr class="my-20 border-black/10" />

            <!-- Author minimal block -->
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-black/40 block mb-2">Written
                        By</span>
                    <p class="font-bold tracking-tight uppercase">{{ user.name }}</p>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-black uppercase tracking-widest text-black/40 block mb-2">Share</span>
                    <div class="flex gap-4">
                        <button
                            class="font-bold text-sm tracking-tight hover:text-black/60 transition-colors uppercase">Copy
                            Link</button>
                    </div>
                </div>
            </div>
        </article>
    </Layout>
</template>

<style>
/* Adjust tiptap rendered content if needed */
.prose img {
    border-radius: 24px;
    margin: 2rem 0;
}

.prose blockquote {
    border-left-width: 4px;
    border-left-color: black;
    font-style: italic;
    font-weight: 500;
}
</style>
