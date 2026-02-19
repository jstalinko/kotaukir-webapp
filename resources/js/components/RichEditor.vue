<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Link from '@tiptap/extension-link'
import { watch, onBeforeUnmount } from 'vue'
import {
    Bold,
    Italic,
    List,
    ListOrdered,
    Link as LinkIcon,
    Heading1,
    Heading2,
    Undo,
    Redo
} from 'lucide-vue-next'
import { Button } from '@/components/ui/button'

const props = defineProps({
    modelValue: String
})

const emit = defineEmits(['update:modelValue'])

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit,
        Link.configure({
            openOnClick: false,
        }),
    ],
    onUpdate: () => {
        emit('update:modelValue', editor.value?.getHTML())
    },
    editorProps: {
        attributes: {
            class: 'prose prose-invert max-w-none focus:outline-none min-h-[200px] p-4 text-sm bg-black/20 rounded-b-xl border-t border-white/5',
        },
    },
})

watch(() => props.modelValue, (value) => {
    const isSame = editor.value?.getHTML() === value
    if (isSame) return
    editor.value?.commands.setContent(value, false)
})

onBeforeUnmount(() => {
    editor.value?.destroy()
})

const setLink = () => {
    const previousUrl = editor.value?.getAttributes('link').href
    const url = window.prompt('URL', previousUrl)

    if (url === null) return
    if (url === '') {
        editor.value?.chain().focus().extendMarkRange('link').unsetLink().run()
        return
    }

    editor.value?.chain().focus().extendMarkRange('link').setLink({ href: url }).run()
}
</script>

<template>
    <div
        class="w-full border border-white/10 rounded-xl overflow-hidden bg-[#0a0a0a] ring-offset-background focus-within:ring-1 focus-within:ring-orange-500/50 transition-all">
        <div v-if="editor"
            class="flex flex-wrap items-center gap-1 p-2 bg-white/5 backdrop-blur-sm border-b border-white/5">
            <Button type="button" variant="ghost" size="icon" class="h-8 w-8 text-gray-400 hover:text-white"
                :class="{ 'bg-white/10 text-white': editor.isActive('bold') }"
                @click="editor.chain().focus().toggleBold().run()">
                <Bold class="h-4 w-4" />
            </Button>
            <Button type="button" variant="ghost" size="icon" class="h-8 w-8 text-gray-400 hover:text-white"
                :class="{ 'bg-white/10 text-white': editor.isActive('italic') }"
                @click="editor.chain().focus().toggleItalic().run()">
                <Italic class="h-4 w-4" />
            </Button>

            <div class="w-[1px] h-4 bg-white/10 mx-1"></div>

            <Button type="button" variant="ghost" size="icon" class="h-8 w-8 text-gray-400 hover:text-white"
                :class="{ 'bg-white/10 text-white': editor.isActive('heading', { level: 1 }) }"
                @click="editor.chain().focus().toggleHeading({ level: 1 }).run()">
                <Heading1 class="h-4 w-4" />
            </Button>
            <Button type="button" variant="ghost" size="icon" class="h-8 w-8 text-gray-400 hover:text-white"
                :class="{ 'bg-white/10 text-white': editor.isActive('heading', { level: 2 }) }"
                @click="editor.chain().focus().toggleHeading({ level: 2 }).run()">
                <Heading2 class="h-4 w-4" />
            </Button>

            <div class="w-[1px] h-4 bg-white/10 mx-1"></div>

            <Button type="button" variant="ghost" size="icon" class="h-8 w-8 text-gray-400 hover:text-white"
                :class="{ 'bg-white/10 text-white': editor.isActive('bulletList') }"
                @click="editor.chain().focus().toggleBulletList().run()">
                <List class="h-4 w-4" />
            </Button>
            <Button type="button" variant="ghost" size="icon" class="h-8 w-8 text-gray-400 hover:text-white"
                :class="{ 'bg-white/10 text-white': editor.isActive('orderedList') }"
                @click="editor.chain().focus().toggleOrderedList().run()">
                <ListOrdered class="h-4 w-4" />
            </Button>

            <div class="w-[1px] h-4 bg-white/10 mx-1"></div>

            <Button type="button" variant="ghost" size="icon" class="h-8 w-8 text-gray-400 hover:text-white"
                :class="{ 'bg-white/10 text-white': editor.isActive('link') }" @click="setLink">
                <LinkIcon class="h-4 w-4" />
            </Button>

            <div class="flex-1"></div>

            <Button type="button" variant="ghost" size="icon"
                class="h-8 w-8 text-gray-400 hover:text-white disabled:opacity-30"
                @click="editor.chain().focus().undo().run()" :disabled="!editor.can().undo()">
                <Undo class="h-4 w-4" />
            </Button>
            <Button type="button" variant="ghost" size="icon"
                class="h-8 w-8 text-gray-400 hover:text-white disabled:opacity-30"
                @click="editor.chain().focus().redo().run()" :disabled="!editor.can().redo()">
                <Redo class="h-4 w-4" />
            </Button>
        </div>
        <EditorContent :editor="editor" />
    </div>
</template>

<style>
/* Tiptap styles */
.prose-invert {
    --tw-prose-body: #d1d5db;
    --tw-prose-headings: #f9fafb;
    --tw-prose-links: #fb923c;
    --tw-prose-bold: #f9fafb;
    --tw-prose-counters: #9ca3af;
    --tw-prose-bullets: #4b5563;
    --tw-prose-hr: #374151;
    --tw-prose-quotes: #f3f4f6;
    --tw-prose-quote-borders: #e5e7eb;
    --tw-prose-captions: #9ca3af;
    --tw-prose-code: #f9fafb;
    --tw-prose-pre-code: #d1d5db;
    --tw-prose-pre-bg: #111827;
    --tw-prose-th-borders: #4b5563;
    --tw-prose-td-borders: #374151;
}

.ProseMirror p.is-editor-empty:first-child::before {
    content: attr(data-placeholder);
    float: left;
    color: #6b7280;
    pointer-events: none;
    height: 0;
}
</style>
