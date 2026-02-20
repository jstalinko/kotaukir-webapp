<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import { ArrowLeft, ArrowRight, Calendar } from 'lucide-vue-next';
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-12 lg:py-20 min-h-[70vh]">

            <div class="mb-12 border-b border-zinc-200 pb-10">
                <Link :href="getDomainUrl(user.name, '/')"
                    class="inline-flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-orange-600 mb-8 transition-colors">
                    <ArrowLeft class="w-4 h-4" /> Return to Homepage
                </Link>

                <div class="max-w-3xl">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-orange-100/80 text-orange-700 text-[10px] md:text-xs font-bold tracking-widest uppercase mb-4 border border-orange-200">
                        Official Publication
                    </span>
                    <h1
                        class="text-4xl md:text-5xl lg:text-7xl font-extrabold text-zinc-900 tracking-tight leading-[1.05]">
                        Corporate <br class="hidden sm:block" />Journal
                    </h1>
                </div>
            </div>

            <div v-if="posts && posts.length > 0" class="flex flex-col gap-8 md:gap-12">
                <Link v-for="post in posts" :key="post.id" :href="getDomainUrl(user.name, `/post/${post.slug}`)"
                    class="group block bg-white border border-zinc-200 rounded-3xl overflow-hidden hover:border-orange-300 hover:shadow-xl hover:shadow-orange-900/5 transition-all">

                    <div class="grid grid-cols-1 md:grid-cols-12 items-stretch">
                        <div class="md:col-span-4 aspect-video md:aspect-[4/3] bg-zinc-100 overflow-hidden relative">
                            <img v-if="post.image" :src="post.image"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                            <div v-else
                                class="w-full h-full flex items-center justify-center font-bold text-zinc-400 text-xs">
                                No Media
                            </div>
                        </div>

                        <div class="md:col-span-8 p-6 md:p-8 lg:p-10 flex flex-col justify-center bg-transparent">
                            <div class="flex items-center gap-3 text-xs font-bold text-zinc-400 mb-4">
                                <div class="flex items-center gap-1.5 bg-zinc-100 rounded-full px-3 py-1">
                                    <Calendar class="w-3.5 h-3.5 text-orange-500" />
                                    <span>{{ new Date(post.created_at).toLocaleDateString() }}</span>
                                </div>
                                <span class="w-1.5 h-1.5 bg-zinc-300 rounded-full"></span>
                                <span>{{ post.views || 0 }} Views</span>
                            </div>

                            <h2
                                class="text-2xl md:text-3xl font-extrabold text-zinc-900 tracking-tight mb-4 group-hover:text-orange-600 transition-colors line-clamp-2 leading-tight py-1">
                                {{ post.title }}
                            </h2>

                            <p class="text-sm md:text-base text-zinc-500 line-clamp-3 leading-relaxed mb-6 font-medium">
                                {{ stripHtml(post.content) || 'Read the full report...' }}
                            </p>

                            <div
                                class="mt-auto inline-flex items-center gap-2 text-sm font-bold text-zinc-900 group-hover:text-orange-600 transition-colors">
                                Read Article
                                <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                            </div>
                        </div>
                    </div>
                </Link>
            </div>

            <div v-else class="py-24 text-center border border-zinc-200 border-dashed rounded-3xl bg-zinc-50">
                <h3 class="text-2xl font-extrabold text-zinc-400 tracking-tight mb-2">No Publications</h3>
                <p class="text-sm font-medium text-zinc-500">Check back later for official statements and news.</p>
            </div>
        </div>
    </Layout>
</template>
