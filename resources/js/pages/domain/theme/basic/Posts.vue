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
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-20 min-h-[70vh]">
            <div class="mb-12">
                <Link :href="getDomainUrl(user.name, '/')"
                    class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-black/50 hover:text-black mb-10 transition-colors">
                    <ArrowLeft class="w-4 h-4" /> Back to Home
                </Link>

                <div class="max-w-3xl">
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-black/30 block mb-4">Read
                        Our</span>
                    <h1 class="text-6xl md:text-8xl font-black text-black tracking-tighter uppercase italic">Journal
                    </h1>
                </div>
            </div>

            <div v-if="posts.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <Link v-for="post in posts" :key="post.id" :href="getDomainUrl(user.name, `/post/${post.slug}`)"
                    class="group block">
                    <div class="aspect-[4/3] rounded-[32px] overflow-hidden bg-black/5 mb-6">
                        <img v-if="post.image" :src="post.image"
                            class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105" />
                        <div v-else
                            class="w-full h-full flex items-center justify-center text-black/20 font-black uppercase tracking-widest text-xs">
                            No Cover</div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-black uppercase tracking-widest text-black/40">{{ new
                                Date(post.created_at).toLocaleDateString() }}</span>
                            <span class="w-8 h-[1px] bg-black/10"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-black/40">{{ post.views
                                || 0 }} Views</span>
                        </div>
                        <h2
                            class="text-2xl font-black uppercase tracking-tight line-clamp-2 group-hover:text-black/60 transition-colors">
                            {{ post.title }}</h2>
                        <p class="text-black/50 line-clamp-3 leading-relaxed">{{ stripHtml(post.content) ||
                            'Click to read full article...' }}</p>
                    </div>
                </Link>
            </div>

            <div v-else class="py-40 text-center bg-[#FAFAFA] rounded-[48px] border border-black/5">
                <h3 class="text-2xl font-black uppercase tracking-tighter">No articles yet</h3>
                <p class="text-black/40 mt-4">Check back later for new content.</p>
            </div>
        </div>
    </Layout>
</template>
