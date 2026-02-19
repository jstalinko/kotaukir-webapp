<script setup>
import { Layout, Plus, Trash2, Pencil } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Dialog, DialogContent, DialogDescription, DialogFooter,
    DialogHeader, DialogTitle, DialogTrigger,
} from '@/components/ui/dialog';
import { ref } from 'vue';

defineProps({
    form: Object,
});

const emit = defineEmits(['edit-home', 'edit-page', 'remove-page', 'create-page']);

const isPageModalOpen = ref(false);
const newPageForm = ref({ title: '', slug: '' });

const handleCreate = () => {
    emit('create-page', { ...newPageForm.value });
    newPageForm.value = { title: '', slug: '' };
    isPageModalOpen.value = false;
};
</script>

<template>
    <div class="space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Home Page Card -->
            <div class="p-6 bg-card rounded-2xl border border-sidebar-border hover:border-orange-600/30 transition-all cursor-pointer group relative overflow-hidden"
                @click="$emit('edit-home')">
                <div class="absolute top-0 left-0 w-1 h-full bg-orange-600"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold">Home Page</h3>
                        <p class="text-xs text-muted-foreground mt-1">Main landing page</p>
                    </div>
                    <div class="p-2 bg-orange-100 text-orange-600 rounded-lg">
                        <Layout class="w-5 h-5" />
                    </div>
                </div>
                <div class="mt-6 flex items-center text-sm font-bold text-orange-600 group-hover:underline">
                    Edit Layout
                    <Pencil class="w-3 h-3 ml-2" />
                </div>
            </div>

            <!-- User Created Pages -->
            <div v-for="(page, index) in form.pages" :key="page.id"
                class="p-6 bg-card rounded-2xl border border-sidebar-border hover:border-sidebar-border-hover transition-all group relative">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold">{{ page.title }}</h3>
                        <p class="text-xs text-muted-foreground mt-1">/{{ page.slug }}</p>
                    </div>
                    <button type="button" @click.stop="$emit('remove-page', index)"
                        class="p-2 hover:bg-destructive/10 hover:text-destructive rounded-lg transition-colors">
                        <Trash2 class="w-4 h-4" />
                    </button>
                </div>
                <div class="mt-6">
                    <Button type="button" variant="outline"
                        class="w-full justify-between group-hover:border-orange-600/30"
                        @click="$emit('edit-page', page)">
                        Edit Content
                        <Pencil class="w-3 h-3" />
                    </Button>
                </div>
            </div>

            <!-- Add New Page -->
            <Dialog v-model:open="isPageModalOpen">
                <DialogTrigger as-child>
                    <button type="button"
                        class="p-6 bg-sidebar-accent/30 rounded-2xl border-2 border-dashed border-sidebar-border hover:border-orange-600/50 hover:bg-orange-50/50 transition-all flex flex-col items-center justify-center gap-3 text-muted-foreground hover:text-orange-600 min-h-[160px]">
                        <div class="p-3 bg-background rounded-full shadow-sm">
                            <Plus class="w-6 h-6" />
                        </div>
                        <span class="font-bold text-sm">Create New Page</span>
                    </button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Create New Page</DialogTitle>
                        <DialogDescription>Add a new custom page to your site.</DialogDescription>
                    </DialogHeader>
                    <div class="space-y-4 py-4">
                        <div class="space-y-2">
                            <Label>Page Title</Label>
                            <Input v-model="newPageForm.title" placeholder="e.g. About Us" />
                        </div>
                        <div class="space-y-2">
                            <Label>URL Slug</Label>
                            <Input v-model="newPageForm.slug" placeholder="e.g. about-us" />
                        </div>
                    </div>
                    <DialogFooter>
                        <Button @click="handleCreate">Create Page</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    </div>
</template>
