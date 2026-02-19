<script setup>
import { computed, ref, onMounted } from 'vue';
import { Check, Moon, Sun } from 'lucide-vue-next';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Button } from '@/components/ui/button';

const mode = ref('system');
const isDark = ref(false);

onMounted(() => {
    // Get stored theme or system preference
    const stored = localStorage.getItem('theme-mode');
    if (stored) {
        mode.value = stored;
    } else {
        mode.value = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
    applyTheme(mode.value);
});

const isLight = computed(() => mode.value === 'light');
const isDarkMode = computed(() => mode.value === 'dark');
const isSystem = computed(() => mode.value === 'system');

const applyTheme = (theme) => {
    localStorage.setItem('theme-mode', theme);
    
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
        isDark.value = true;
    } else if (theme === 'light') {
        document.documentElement.classList.remove('dark');
        isDark.value = false;
    } else if (theme === 'system') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (prefersDark) {
            document.documentElement.classList.add('dark');
            isDark.value = true;
        } else {
            document.documentElement.classList.remove('dark');
            isDark.value = false;
        }
    }
};

const setTheme = (themeMode) => {
    mode.value = themeMode;
    applyTheme(themeMode);
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button
                variant="ghost"
                size="icon"
                class="rounded-full hover:bg-orange-500/20"
            >
                <Sun
                    v-if="!isDark"
                    class="h-5 w-5 text-orange-600 dark:hidden"
                />
                <Moon
                    v-if="isDark"
                    class="h-5 w-5 text-orange-400"
                />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuItem
                @click="setTheme('light')"
                class="cursor-pointer flex items-center gap-2"
            >
                <Sun class="h-4 w-4" />
                <span>Terang</span>
                <Check v-if="isLight" class="ml-auto h-4 w-4" />
            </DropdownMenuItem>
            <DropdownMenuItem
                @click="setTheme('dark')"
                class="cursor-pointer flex items-center gap-2"
            >
                <Moon class="h-4 w-4" />
                <span>Gelap</span>
                <Check v-if="isDarkMode" class="ml-auto h-4 w-4" />
            </DropdownMenuItem>
            <DropdownMenuItem
                @click="setTheme('system')"
                class="cursor-pointer flex items-center gap-2"
            >
                <div class="h-4 w-4 rounded-sm border border-current" />
                <span>Sistem</span>
                <Check v-if="isSystem" class="ml-auto h-4 w-4" />
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>


