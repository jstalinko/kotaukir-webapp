<script setup>
import { Link } from '@inertiajs/vue3';
import { Facebook, Instagram, Twitter, MapPin, Phone, Mail } from 'lucide-vue-next';

defineProps({
    user: Object,
    site: Object,
});
</script>

<template>
    <footer class="bg-[#2D241E] text-white pt-20 pb-10 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div v-if="!site?.site_logo"
                            class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center text-white font-serif text-xl font-bold">
                            {{ (site?.site_name || user.name).charAt(0).toUpperCase() }}
                        </div>
                        <img v-else :src="site.site_logo" class="h-10 w-auto object-contain" />
                        <span class="text-2xl font-bold font-serif tracking-tight">{{ site?.site_name || user.name
                            }}</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                        MenGhadirkan keindahan alam ke dalam hunian Anda dengan furniture kayu jati berkualitas tinggi
                        dan desain klasik yang abadi.
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="#"
                            class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-orange-600 hover:border-orange-600 transition-all text-gray-400 hover:text-white">
                            <Instagram class="w-4 h-4" />
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-orange-600 hover:border-orange-600 transition-all text-gray-400 hover:text-white">
                            <Facebook class="w-4 h-4" />
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-orange-600 hover:border-orange-600 transition-all text-gray-400 hover:text-white">
                            <Twitter class="w-4 h-4" />
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-lg font-bold font-serif mb-6">Navigasi</h4>
                    <ul class="space-y-4">
                        <li>
                            <Link :href="`/domain/${user.name}`"
                                class="text-gray-400 hover:text-orange-400 text-sm transition-colors">Utama</Link>
                        </li>
                        <li>
                            <Link :href="`/domain/${user.name}/category/all`"
                                class="text-gray-400 hover:text-orange-400 text-sm transition-colors">Koleksi Produk
                            </Link>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-orange-400 text-sm transition-colors">Tentang
                                Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-orange-400 text-sm transition-colors">Cara
                                Pemesanan</a></li>
                    </ul>
                </div>

                <!-- Info -->
                <div>
                    <h4 class="text-lg font-bold font-serif mb-6">Layanan</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-400 hover:text-orange-400 text-sm transition-colors">Custom
                                Order</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-orange-400 text-sm transition-colors">Syarat &
                                Ketentuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-orange-400 text-sm transition-colors">Kebijakan
                                Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-orange-400 text-sm transition-colors">FAQ</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-bold font-serif mb-6">Kontak Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <MapPin class="w-5 h-5 text-orange-600 shrink-0 mt-0.5" />
                            <span class="text-gray-400 text-sm leading-snug">Jl. Raya Ukir Jepara No. 123, Central Java,
                                Indonesia</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <Phone class="w-5 h-5 text-orange-600 shrink-0" />
                            <span class="text-gray-400 text-sm">+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <Mail class="w-5 h-5 text-orange-600 shrink-0" />
                            <span class="text-gray-400 text-sm">info@kotaukir.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-white/5 text-center">
                <p class="text-xs text-gray-500 font-medium tracking-wider uppercase">
                    &copy; {{ new Date().getFullYear() }} {{ user.name }}. crafted with pride in Jepara.
                </p>
            </div>
        </div>
    </footer>
</template>