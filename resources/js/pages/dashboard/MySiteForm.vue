<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, watch, computed } from 'vue';
import { Settings2, Palette, FileText, Layout, ExternalLink, Save, Loader2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Tabs, TabsList, TabsTrigger, TabsContent } from '@/components/ui/tabs';
import defaultComponents from '../domain/theme/default/components.json';
import basicComponents from '../domain/theme/basic/components.json';
import GeneralTab from './my-site/GeneralTab.vue';
import ThemeTab from './my-site/ThemeTab.vue';
import PagesTab from './my-site/PagesTab.vue';
import BuilderTab from './my-site/BuilderTab.vue';

const props = defineProps({ site: Object });

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'My Site', href: '/dashboard/my-site' },
];

const activeTab = ref('general');
const activePage = ref(null);

const initialComponents = props.site?.components || {};
const normalizedComponents = Array.isArray(initialComponents)
    ? { [props.site?.theme || 'default']: initialComponents }
    : initialComponents;

const form = useForm({
    site_name: props.site?.site_name || '',
    site_logo: props.site?.site_logo || '',
    site_description: props.site?.site_description || '',
    site_keywords: props.site?.site_keywords || '',
    site_slogan: props.site?.site_slogan || '',
    theme: props.site?.theme || 'default',
    components: normalizedComponents,
    pages: props.site?.pages || [],
    menus: props.site?.menus || [],
});

watch(() => props.site, (newSite) => {
    if (!newSite) return;
    form.site_name = newSite.site_name || '';
    form.site_logo = newSite.site_logo || '';
    form.site_description = newSite.site_description || '';
    form.site_keywords = newSite.site_keywords || '';
    form.site_slogan = newSite.site_slogan || '';
    form.theme = newSite.theme || 'default';
    const initComps = newSite.components || {};
    form.components = Array.isArray(initComps) ? { [newSite.theme || 'default']: initComps } : initComps;
    form.pages = newSite.pages || [];
    form.menus = newSite.menus || [];
}, { deep: true });

const themes = [
    { id: 'default', name: 'Furniture Gallery', description: 'Premium, warm, and elegant design for furniture catalogs.', preview: 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80' },
    { id: 'basic', name: 'Basic Modern', description: 'Minimalist monochrome design with centered glassmorphism navigation.', preview: 'https://images.unsplash.com/photo-1513506003901-1e6a35072c63?auto=format&fit=crop&q=80' },
];

const themeComponentsMap = { default: defaultComponents, basic: basicComponents };
const availableComponents = computed(() => themeComponentsMap[form.theme] || defaultComponents);

const mergeDefaults = (comps) => comps.map(comp => {
    const def = availableComponents.value.find(c => c.type === comp.type);
    if (def?.defaultSettings) comp.settings = { ...def.defaultSettings, ...comp.settings };
    return comp;
});

const currentComponents = computed({
    get: () => {
        if (activePage.value === 'home') return mergeDefaults(form.components[form.theme] || []);
        if (activePage.value && typeof activePage.value === 'object') {
            if (!activePage.value.content) activePage.value.content = {};
            if (!activePage.value.content[form.theme]) activePage.value.content[form.theme] = [];
            return mergeDefaults(activePage.value.content[form.theme]);
        }
        return [];
    },
    set: (val) => {
        if (activePage.value === 'home') form.components[form.theme] = val;
        else if (activePage.value && typeof activePage.value === 'object')
            activePage.value.content[form.theme] = val;
    },
});

// Tab actions
const tabs = [
    { key: 'general', label: 'General', icon: Settings2 },
    { key: 'theme', label: 'Theme', icon: Palette },
    { key: 'pages', label: 'Pages', icon: FileText },
];

// Menu
const addMenuItem = () => form.menus.push({ id: Date.now(), label: 'New Link', url: '/' });
const removeMenuItem = (i) => form.menus.splice(i, 1);

// Components
const addComponent = (type) => {
    const def = availableComponents.value.find(c => c.type === type);
    const newComp = { id: Date.now(), type, settings: JSON.parse(JSON.stringify(def?.defaultSettings || {})) };
    if (activePage.value === 'home') {
        if (!form.components[form.theme]) form.components[form.theme] = [];
        form.components[form.theme].push(newComp);
    } else if (activePage.value && typeof activePage.value === 'object') {
        if (!activePage.value.content) activePage.value.content = {};
        if (!activePage.value.content[form.theme]) activePage.value.content[form.theme] = [];
        activePage.value.content[form.theme].push(newComp);
    }
};
const removeComponent = (i) => {
    if (activePage.value === 'home') form.components[form.theme].splice(i, 1);
    else if (activePage.value) activePage.value.content[form.theme].splice(i, 1);
};

// Pages
const editHomeLayout = () => { activePage.value = 'home'; activeTab.value = 'builder'; };
const editPageLayout = (page) => { activePage.value = page; activeTab.value = 'builder'; };
const removePage = (i) => form.pages.splice(i, 1);
const createPage = (data) => {
    form.pages.push({ id: Date.now(), title: data.title, slug: data.slug, content: {} });
};

// Submit
const submit = () => {
    form.post('/dashboard/my-site/update', { preserveScroll: true });
};
</script>

<template>

    <Head title="My Site Settings" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 md:p-8 max-w-7xl mx-auto">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-foreground">My Site Settings</h1>
                    <p class="text-muted-foreground mt-1 text-sm">Configure your website appearance and behavior.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a :href="`/domain/${$page.props.auth.user.name}`" target="_blank"
                        class="flex items-center gap-2 px-4 py-2 bg-secondary text-secondary-foreground rounded-lg text-sm font-medium hover:bg-secondary/80 transition-all border border-sidebar-border">
                        <ExternalLink class="w-4 h-4" /> Preview Site
                    </a>
                    <Button @click="submit" :disabled="form.processing"
                        class="bg-orange-600 hover:bg-orange-700 min-w-[140px]">
                        <Loader2 v-if="form.processing" class="w-4 h-4 mr-2 animate-spin" />
                        <Save v-else class="w-4 h-4 mr-2" />
                        {{ form.processing ? 'Saving...' : 'Update Settings' }}
                    </Button>
                </div>
            </div>

            <!-- Global Loading Bar -->
            <div v-if="form.processing" class="fixed top-0 left-0 right-0 h-1 z-[100] bg-orange-100 overflow-hidden">
                <div class="h-full bg-orange-600 animate-progress origin-left"></div>
            </div>

            <!-- ===== TABS BAR ===== -->
            <Tabs v-model="activeTab" class="mb-8">
                <TabsList :class="activeTab === 'builder' ? 'grid grid-cols-4 w-full' : 'grid grid-cols-3 w-full'">
                    <TabsTrigger value="general" class="flex items-center gap-2">
                        <Settings2 class="w-4 h-4" /> General
                    </TabsTrigger>
                    <TabsTrigger value="theme" class="flex items-center gap-2">
                        <Palette class="w-4 h-4" /> Theme
                    </TabsTrigger>
                    <TabsTrigger value="pages" class="flex items-center gap-2">
                        <FileText class="w-4 h-4" /> Pages
                    </TabsTrigger>
                    <TabsTrigger v-if="activeTab === 'builder'" value="builder" class="flex items-center gap-2">
                        <Layout class="w-4 h-4" /> Builder: {{ activePage === 'home' ? 'Home' : activePage?.title }}
                    </TabsTrigger>
                </TabsList>
            </Tabs>

            <!-- ===== TAB CONTENT ===== -->
            <form @submit.prevent="submit">
                <div v-show="activeTab === 'general'" class="animate-in fade-in duration-300">
                    <GeneralTab :form="form" @add-menu-item="addMenuItem" @remove-menu-item="removeMenuItem" />
                </div>

                <div v-show="activeTab === 'theme'" class="animate-in fade-in duration-300">
                    <ThemeTab :form="form" :themes="themes" />
                </div>

                <div v-show="activeTab === 'pages'" class="animate-in fade-in duration-300">
                    <PagesTab :form="form" @edit-home="editHomeLayout" @edit-page="editPageLayout"
                        @remove-page="removePage" @create-page="createPage" />
                </div>

                <div v-show="activeTab === 'builder'" class="animate-in fade-in duration-300">
                    <BuilderTab :form="form" :active-page="activePage" :current-components="currentComponents"
                        :available-components="availableComponents" :themes="themes" @back="activeTab = 'pages'"
                        @add-component="addComponent" @remove-component="removeComponent" />
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<style scoped>
.animate-in {
    animation-fill-mode: both;
}

@keyframes progress {
    0% {
        transform: scaleX(0);
    }

    50% {
        transform: scaleX(0.7);
    }

    100% {
        transform: scaleX(1);
    }
}

.animate-progress {
    animation: progress 2s ease-in-out infinite;
}
</style>
