<script setup>
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { Menu } from 'lucide-vue-next';
import { ref } from 'vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
    DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu';
import { Button } from '@/components/ui/button';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import { HomeIcon, GlobeIcon, InfoIcon, PhoneIcon } from 'lucide-vue-next';

const page = usePage();
const isOpen = ref(false);

const isAuthenticated = computed(() => !!page.props.auth?.user);
const user = computed(() => page.props.auth?.user);

const handleLogout = () => {
    const form = new FormData();
    fetch(route('logout'), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': page.props.csrf_token,
        },
        body: form,
    }).then(() => {
        window.location.href = '/';
    });
};
</script>

<template>
    <div class="fixed top-6 left-0 right-0 z-50 px-4">
        <nav
            class="max-w-4xl mx-auto bg-black/40 backdrop-blur-xl border border-white/10 rounded-full px-6 py-2 shadow-2xl">
            <div class="flex items-center justify-between">
                <!-- Brand Logo -->
                <Link href="/" class="flex items-center gap-2 font-bold transition-transform hover:scale-105">
                    <img src="/logo.png" alt="Logo" class="h-6 w-auto" />
                </Link>

                <!-- Desktop Navigation -->
                <div class="hidden items-center gap-1 md:flex">
                    <Link href="/"
                        class="group/nav relative flex items-center gap-0 text-gray-400 hover:text-white transition-all duration-300 text-xs font-medium px-3 py-2 rounded-full hover:bg-white/5">
                        <HomeIcon class="w-4 h-4 shrink-0" />
                        <span
                            class="max-w-0 overflow-hidden opacity-0 group-hover/nav:max-w-[80px] group-hover/nav:opacity-100 group-hover/nav:ml-2 transition-all duration-300 whitespace-nowrap">
                            Beranda
                        </span>
                    </Link>
                    <Link href="/explore"
                        class="group/nav relative flex items-center gap-0 text-gray-400 hover:text-white transition-all duration-300 text-xs font-medium px-3 py-2 rounded-full hover:bg-white/5">
                        <GlobeIcon class="w-4 h-4 shrink-0" />
                        <span
                            class="max-w-0 overflow-hidden opacity-0 group-hover/nav:max-w-[80px] group-hover/nav:opacity-100 group-hover/nav:ml-2 transition-all duration-300 whitespace-nowrap">
                            Discover
                        </span>
                    </Link>
                    <Link href="/about"
                        class="group/nav relative flex items-center gap-0 text-gray-400 hover:text-white transition-all duration-300 text-xs font-medium px-3 py-2 rounded-full hover:bg-white/5">
                        <InfoIcon class="w-4 h-4 shrink-0" />
                        <span
                            class="max-w-0 overflow-hidden opacity-0 group-hover/nav:max-w-[80px] group-hover/nav:opacity-100 group-hover/nav:ml-2 transition-all duration-300 whitespace-nowrap">
                            Tentang
                        </span>
                    </Link>
                    <Link href="/contact"
                        class="group/nav relative flex items-center gap-0 text-gray-400 hover:text-white transition-all duration-300 text-xs font-medium px-3 py-2 rounded-full hover:bg-white/5">
                        <PhoneIcon class="w-4 h-4 shrink-0" />
                        <span
                            class="max-w-0 overflow-hidden opacity-0 group-hover/nav:max-w-[80px] group-hover/nav:opacity-100 group-hover/nav:ml-2 transition-all duration-300 whitespace-nowrap">
                            Buat Web
                        </span>
                    </Link>
                </div>

                <!-- Desktop Auth Section -->
                <div class="hidden items-center gap-3 md:flex">
                    <template v-if="isAuthenticated">
                        <!-- Authenticated User Menu -->
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="ghost" size="sm"
                                    class="gap-2 text-gray-400 hover:text-white hover:bg-white/5 rounded-full">
                                    <div
                                        class="h-5 w-5 rounded-full bg-gradient-to-tr from-orange-500 to-orange-400 shadow-lg shadow-orange-500/20">
                                    </div>
                                    <span class="text-xs font-medium">{{
                                        user?.name
                                    }}</span>
                                    <Menu class="h-3 w-3 opacity-50" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end"
                                class="w-48 bg-black/90 backdrop-blur-xl border-white/10 text-white">
                                <div
                                    class="px-2 py-1.5 text-[10px] font-semibold text-gray-500 uppercase tracking-widest">
                                    {{ user?.email }}
                                </div>
                                <DropdownMenuSeparator class="bg-white/10" />
                                <DropdownMenuItem as-child>
                                    <Link href="/dashboard"
                                        class="cursor-pointer focus:bg-orange-500 focus:text-white transition-colors">
                                        Dashboard
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem as-child>
                                    <Link href="/profile"
                                        class="cursor-pointer focus:bg-orange-500 focus:text-white transition-colors">
                                        Profil
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuSeparator class="bg-white/10" />
                                <DropdownMenuItem @click="handleLogout"
                                    class="cursor-pointer text-red-400 focus:bg-red-500/10 focus:text-red-400">
                                    Keluar
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </template>
                    <template v-else>
                        <!-- Unauthenticated User Menu -->
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="ghost" size="sm"
                                    class="text-gray-300 hover:text-white hover:bg-white/5 rounded-full px-4 gap-2 border border-white/5">
                                    <div
                                        class="h-4 w-4 rounded-full border border-gray-400 flex items-center justify-center p-0.5">
                                        <div class="w-full h-full rounded-full border-t-2 border-gray-400"></div>
                                    </div>
                                    <span class="text-xs">Akun</span>
                                    <Menu class="h-3 w-3 opacity-50" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end"
                                class="w-48 bg-black/90 backdrop-blur-xl border-white/10 text-white">
                                <DropdownMenuItem as-child>
                                    <Link href="/login" class="cursor-pointer focus:bg-orange-500 focus:text-white">
                                        Masuk
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem as-child>
                                    <Link href="/register"
                                        class="cursor-pointer focus:bg-orange-500 focus:text-white text-orange-400">
                                        Daftar
                                    </Link>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </template>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <Sheet v-model:open="isOpen">
                        <SheetTrigger as-child>
                            <Button variant="ghost" size="icon"
                                class="text-gray-400 hover:text-white hover:bg-white/5 rounded-full">
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="right"
                            class="w-full sm:w-80 bg-black/95 backdrop-blur-xl border-l border-white/10">
                            <div class="mt-8 flex flex-col gap-6">
                                <!-- Mobile Navigation -->
                                <div class="flex flex-col gap-1">
                                    <h3 class="px-3 text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">
                                        Menu
                                    </h3>
                                    <Link href="/" @click="isOpen = false"
                                        class="px-4 py-3 text-sm text-gray-300 hover:bg-white/5 rounded-xl transition-all">
                                        Beranda
                                    </Link>
                                    <Link href="/explore" @click="isOpen = false"
                                        class="px-4 py-3 text-sm text-gray-300 hover:bg-white/5 rounded-xl transition-all">
                                        Discover
                                    </Link>
                                    <Link href="/about" @click="isOpen = false"
                                        class="px-4 py-3 text-sm text-gray-300 hover:bg-white/5 rounded-xl transition-all">
                                        Tentang Kami
                                    </Link>
                                    <Link href="/contact" @click="isOpen = false"
                                        class="px-4 py-3 text-sm text-gray-300 hover:bg-white/5 rounded-xl transition-all">
                                        Buat Web
                                    </Link>
                                </div>

                                <!-- Mobile Auth Section -->
                                <div class="border-t border-white/10 pt-6">
                                    <template v-if="isAuthenticated">
                                        <div class="mb-6 rounded-2xl border border-white/5 bg-white/5 p-4">
                                            <p
                                                class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1">
                                                Masuk sebagai
                                            </p>
                                            <p class="font-semibold text-white">{{ user?.name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ user?.email }}
                                            </p>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <Link href="/dashboard" @click="isOpen = false"
                                                class="px-4 py-3 text-sm text-gray-300 hover:bg-white/5 rounded-xl transition-all">
                                                Dashboard
                                            </Link>
                                            <Link href="/profile" @click="isOpen = false"
                                                class="px-4 py-3 text-sm text-gray-300 hover:bg-white/5 rounded-xl transition-all">
                                                Profil
                                            </Link>
                                            <div class="mt-4 px-2">
                                                <Button variant="destructive" class="w-full rounded-xl h-11" @click="
                                                    handleLogout();
                                                isOpen = false;
                                                ">
                                                    Keluar
                                                </Button>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="flex flex-col gap-2 px-2">
                                            <Link href="/login" @click="isOpen = false"
                                                class="flex items-center justify-center px-4 h-11 text-sm font-medium text-gray-300 hover:text-white border border-white/10 rounded-xl transition-colors">
                                                Masuk
                                            </Link>
                                            <Link href="/register" @click="isOpen = false"
                                                class="flex items-center justify-center px-4 h-11 text-sm font-bold bg-orange-600 text-white hover:bg-orange-500 rounded-xl shadow-lg shadow-orange-600/20 transition-all">
                                                Daftar
                                            </Link>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>
            </div>
        </nav>
    </div>
</template>
