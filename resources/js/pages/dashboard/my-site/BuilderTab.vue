<script setup>
import { Layout, GripVertical, Plus, Trash2, ChevronLeft } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import ImagePicker from '@/components/ImagePicker.vue';
import draggable from 'vuedraggable';

defineProps({
    form: Object,
    activePage: [String, Object],
    currentComponents: Array,
    availableComponents: Array,
    themes: Array,
});

defineEmits(['back', 'add-component', 'remove-component']);
</script>

<template>
    <div class="space-y-6">
        <!-- Top Bar -->
        <div
            class="flex items-center justify-between bg-card p-4 rounded-xl border border-sidebar-border flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <Button type="button" variant="ghost" size="sm" @click="$emit('back')">
                    <ChevronLeft class="w-4 h-4 mr-1" /> Back
                </Button>
                <div>
                    <h2 class="font-bold text-lg flex items-center gap-2">
                        Editing: <span class="text-orange-600">{{ activePage === 'home' ? 'Home Page' :
                            activePage?.title }}</span>
                    </h2>
                    <p class="text-xs text-muted-foreground">Theme: {{themes.find(t => t.id === form.theme)?.name}}
                    </p>
                </div>
            </div>
            <div class="flex gap-2 flex-wrap">
                <Button v-for="comp in availableComponents" :key="comp.type" type="button" size="sm" variant="outline"
                    @click="$emit('add-component', comp.type)" class="border-dashed">
                    <Plus class="w-3 h-3 mr-2" /> {{ comp.name }}
                </Button>
            </div>
        </div>

        <!-- Component List -->
        <div class="space-y-4 max-w-4xl mx-auto">
            <draggable :list="currentComponents" item-key="id" handle=".drag-handle" ghost-class="opacity-40"
                animation="200" tag="div" class="space-y-4">
                <template #item="{ element: comp, index }">
                    <div
                        class="group p-6 bg-card rounded-2xl border border-sidebar-border shadow-sm hover:shadow-md transition-all relative">
                        <div
                            class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <Button type="button" variant="destructive" size="icon" class="h-8 w-8 rounded-full"
                                @click="$emit('remove-component', index)">
                                <Trash2 class="w-4 h-4" />
                            </Button>
                        </div>

                        <div class="flex items-center gap-3 mb-6 border-b border-sidebar-border pb-4">
                            <div
                                class="drag-handle p-2 rounded-lg hover:bg-sidebar-accent/50 cursor-grab active:cursor-grabbing text-muted-foreground">
                                <GripVertical class="w-4 h-4" />
                            </div>
                            <div class="p-2 bg-orange-600/10 text-orange-600 rounded-lg">
                                <Layout class="w-4 h-4" />
                            </div>
                            <h3 class="font-bold text-sm">{{ comp.type }} Settings</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <template v-for="[key] in Object.entries(comp.settings || {})" :key="key">
                                <div v-if="key === 'image' || key === 'background_image'"
                                    class="space-y-2 col-span-full">
                                    <Label class="text-xs uppercase text-muted-foreground">{{ key }}</Label>
                                    <div class="p-4 rounded-xl border border-sidebar-border bg-sidebar-accent/20">
                                        <ImagePicker :modelValue="comp.settings[key]"
                                            @update:modelValue="v => comp.settings[key] = v" :multiple="false"
                                            upload-url="/dashboard/my-site/upload" />
                                    </div>
                                </div>
                                <div v-else class="space-y-2">
                                    <Label class="text-xs uppercase text-muted-foreground">{{ key }}</Label>
                                    <Input v-model="comp.settings[key]" class="text-sm" />
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </draggable>

            <div v-if="currentComponents.length === 0"
                class="text-center py-24 bg-sidebar-accent/10 border-2 border-dashed border-sidebar-border rounded-[32px] flex flex-col items-center justify-center gap-4">
                <div class="p-4 bg-background rounded-full shadow-sm">
                    <Layout class="w-8 h-8 text-muted-foreground" />
                </div>
                <div class="max-w-xs mx-auto">
                    <h3 class="font-bold text-foreground">Empty Layout</h3>
                    <p class="text-muted-foreground text-sm mt-1">Add components from the top bar to build your
                        {{ activePage === 'home' ? 'home page' : 'page' }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
