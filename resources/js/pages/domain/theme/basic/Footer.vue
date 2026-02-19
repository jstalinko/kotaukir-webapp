<script setup>
const props = defineProps({
    site: Object,
    user: Object,
});
</script>

<template>
    <footer class="bg-white border-t border-black/5 py-20">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="flex flex-col md:flex-row justify-between items-center gap-12">
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-4">
                        <div v-if="!site?.site_logo"
                            class="w-8 h-8 bg-black rounded-full flex items-center justify-center text-white font-bold text-xs">
                            {{ (site?.site_name || user.name).charAt(0).toUpperCase() }}
                        </div>
                        <img v-else :src="site.site_logo" class="h-8 w-auto object-contain" />
                        <span class="text-lg font-black tracking-tighter text-black uppercase">{{ site?.site_name ||
                            user.name }}</span>
                    </div>
                    <p class="text-sm text-black/40 max-w-xs font-medium">
                        {{ site?.site_description || 'Modern essentials for the contemporary home.' }}
                    </p>
                </div>

                <div class="flex gap-8">
                    <a href="#"
                        class="text-xs font-bold uppercase tracking-widest text-black/50 hover:text-black">Instagram</a>
                    <a href="#"
                        class="text-xs font-bold uppercase tracking-widest text-black/50 hover:text-black">Catalog</a>
                    <a href="#"
                        class="text-xs font-bold uppercase tracking-widest text-black/50 hover:text-black">WhatsApp</a>
                </div>
            </div>

            <div
                class="mt-20 pt-8 border-t border-black/5 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-black/30">
                    &copy; {{ new Date().getFullYear() }} {{ site?.site_name || user.name }}. All rights reserved.
                </p>
                <div class="flex gap-6 uppercase tracking-[0.2em] text-[10px] font-bold text-black/30">
                    <a href="#" class="hover:text-black">Privacy</a>
                    <a href="#" class="hover:text-black">Terms</a>
                </div>
            </div>
        </div>
    </footer>
</template>
