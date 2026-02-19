<script setup>
import { ref, watch } from 'vue'
import { Plus, X, Image as ImageIcon, Loader2 } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import axios from 'axios'

const props = defineProps({
    modelValue: [Array, String],
    uploadUrl: {
        type: String,
        default: '/dashboard/my-site/upload'
    },
    multiple: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:modelValue'])

const parseImages = (images) => {
    if (Array.isArray(images)) return images.filter(Boolean)
    try {
        const parsed = JSON.parse(images)
        return Array.isArray(parsed) ? parsed.filter(Boolean) : (images ? [images] : [])
    } catch {
        return images ? [images] : []
    }
}

const images = ref(parseImages(props.modelValue))
const fileInput = ref(null)
const isUploading = ref(false)

watch(() => props.modelValue, (val) => {
    images.value = parseImages(val)
}, { deep: true })

const handleFileChange = async (event) => {
    const target = event.target
    const files = target.files
    if (!files || files.length === 0) return

    isUploading.value = true

    try {
        for (let i = 0; i < files.length; i++) {
            const file = files[i]
            const formData = new FormData()
            formData.append('file', file)

            const response = await axios.post(props.uploadUrl, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })

            const url = response.data.url
            if (url && !images.value.includes(url)) {
                if (props.multiple) {
                    images.value.push(url)
                } else {
                    images.value = [url]
                }
                emit('update:modelValue', props.multiple ? images.value : images.value[0] || '')
            }
        }
    } catch (err) {
        console.error('Image upload failed:', err)
    } finally {
        isUploading.value = false
        if (fileInput.value) fileInput.value.value = ''
    }
}

const removeImage = (index) => {
    images.value.splice(index, 1)
    emit('update:modelValue', props.multiple ? images.value : images.value[0] || '')
}

const triggerInput = () => {
    fileInput.value?.click()
}
</script>

<template>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <!-- Existing Previews -->
        <div v-for="(img, index) in images" :key="index"
            class="group relative aspect-square rounded-xl overflow-hidden border border-white/10 bg-white/5 transition-all hover:border-orange-500/50">
            <img :src="img"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
            <div
                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                <Button type="button" variant="destructive" size="icon" class="h-8 w-8 rounded-full"
                    @click="removeImage(index)">
                    <X class="h-4 w-4" />
                </Button>
            </div>
        </div>

        <!-- Add Button / Uploading state -->
        <button type="button" @click="triggerInput" :disabled="isUploading"
            class="group relative aspect-square flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-white/10 bg-white/5 transition-all hover:bg-white/10 hover:border-orange-500/50 disabled:opacity-50 disabled:cursor-wait">
            <div v-if="isUploading" class="flex flex-col items-center gap-2 text-orange-400">
                <Loader2 class="h-6 w-6 animate-spin" />
                <span class="text-xs font-medium">Uploading...</span>
            </div>
            <div v-else
                class="flex flex-col items-center gap-2 text-gray-400 group-hover:text-orange-400 transition-colors">
                <div class="p-3 rounded-full bg-white/5 group-hover:bg-orange-500/10 transition-colors">
                    <Plus class="h-6 w-6" />
                </div>
                <span class="text-xs font-medium">Tambah Foto</span>
            </div>
            <input ref="fileInput" type="file" :multiple="multiple" accept="image/*" class="hidden"
                @change="handleFileChange" />
        </button>

        <!-- Placeholder if empty -->
        <div v-if="images.length === 0"
            class="col-span-full py-8 text-center border-2 border-dashed border-white/5 rounded-xl bg-white/[0.02]">
            <div class="flex flex-col items-center gap-2 text-gray-500">
                <ImageIcon class="h-8 w-8 opacity-20" />
                <p class="text-xs">Belum ada foto yang dipilih</p>
            </div>
        </div>
    </div>
</template>
