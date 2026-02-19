<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BookOpen, Box, Folder, LayoutGrid, MessageCircle, Palette, ExternalLink, Globe, Newspaper, Tag } from 'lucide-vue-next';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import AppLogo from './AppLogo.vue';
import { dashboard } from '@/routes';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'My Sites',
        href: '/dashboard/my-site',
        icon: Globe,
    },
    {
        title: 'Produk',
        href: '/dashboard/product',
        icon: Box,
    },
    {
        title: 'Postingan',
        href: '/dashboard/post',
        icon: Newspaper,
    },
    {
        title: 'Kategori',
        href: '/dashboard/category',
        icon: Tag,
    },
    {
        title: 'Theme Store',
        href: '/dashboard/theme-store',
        icon: Palette,
    }
];

const footerNavItems: NavItem[] = [
    {
        title: 'Kunjungi Website',
        href: 'https://jembut.id',
        icon: ExternalLink,
    },
    {
        title: 'Butuh Bantuan?',
        href: 'https://javara.digital/whatsapp',
        icon: MessageCircle,
    },
    {
        title: 'Tutorial',
        href: 'https://www.youtube.com/@jstdigitalgroup/search?query=kotaukir',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
