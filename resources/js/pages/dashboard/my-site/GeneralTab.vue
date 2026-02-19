<script setup>
import { GripVertical, Plus, Trash2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import ImagePicker from '@/components/ImagePicker.vue';
import draggable from 'vuedraggable';

defineProps({
    form: Object,
});
</script>

<template>
    <div class="space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Logo -->
            <div class="lg:col-span-4 space-y-4">
                <Label>Site Logo</Label>
                <div class="p-6 border-2 border-dashed border-sidebar-border rounded-2xl bg-sidebar-accent/50">
                    <ImagePicker v-model="form.site_logo" />
                    <p class="text-[10px] text-muted-foreground mt-4 text-center">
                        Format: PNG, JPG (recommended PNG transparent). Max size 2MB.
                    </p>
                </div>
            </div>
            <!-- Info -->
            <div class="lg:col-span-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <Label for="site_name">Site Name</Label>
                        <Input id="site_name" v-model="form.site_name" placeholder="E.g. Jati Ukir Abadi" />
                    </div>
                    <div class="space-y-2">
                        <Label for="site_slogan">Site Slogan</Label>
                        <Input id="site_slogan" v-model="form.site_slogan"
                            placeholder="E.g. Sentuhan Estetik untuk Rumah Anda" />
                    </div>
                </div>
                <div class="space-y-2">
                    <Label for="site_description">Site Description (SEO)</Label>
                    <textarea id="site_description" v-model="form.site_description" rows="4"
                        class="w-full rounded-xl bg-background border border-sidebar-border p-4 text-sm focus:ring-2 focus:ring-orange-600/20 outline-none transition-all"
                        placeholder="Jelaskan secara singkat tentang website Anda..."></textarea>
                </div>
                <div class="space-y-2">
                    <Label for="site_keywords">Keywords (Comma separated)</Label>
                    <Input id="site_keywords" v-model="form.site_keywords"
                        placeholder="furniture, kayu jati, ukiran, jepara" />
                </div>
            </div>
        </div>

        <!-- Navigation Builder -->
        <div class="border-t border-sidebar-border pt-8">
            <div class="flex items-center justify-between mb-6">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold">Menu Navigation</h3>
                    <p class="text-xs text-muted-foreground">Drag to reorder. Edit label and URL.</p>
                </div>
                <Button type="button" size="sm" variant="outline" @click="$emit('add-menu-item')">
                    <Plus class="h-4 w-4 mr-2" /> Add Menu Item
                </Button>
            </div>
            <div class="space-y-3 max-w-3xl">
                <draggable v-model="form.menus" item-key="id" handle=".menu-drag-handle" ghost-class="opacity-40"
                    animation="200" tag="div" class="space-y-3">
                    <template #item="{ element: item, index }">
                        <div
                            class="p-4 bg-sidebar-accent/30 rounded-xl border border-sidebar-border flex items-center gap-3">
                            <div class="menu-drag-handle cursor-grab active:cursor-grabbing">
                                <GripVertical class="w-4 h-4 text-muted-foreground flex-shrink-0" />
                            </div>
                            <div class="flex-1 grid grid-cols-2 gap-4">
                                <Input v-model="item.label" placeholder="Label (e.g. Home)"
                                    class="h-9 text-sm font-medium" />
                                <Input v-model="item.url" placeholder="URL (e.g. /about)" class="h-9 text-sm" />
                            </div>
                            <Button type="button" variant="ghost" size="icon"
                                class="h-8 w-8 text-muted-foreground hover:text-destructive"
                                @click="$emit('remove-menu-item', index)">
                                <Trash2 class="w-4 h-4" />
                            </Button>
                        </div>
                    </template>
                </draggable>
                <div v-if="form.menus.length === 0"
                    class="text-center py-8 text-muted-foreground text-xs italic opacity-50 bg-sidebar-accent/10 rounded-xl border border-dashed border-sidebar-border">
                    No menu items yet. Default links will be shown.
                </div>
            </div>
        </div>
    </div>
</template>
