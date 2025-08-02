<script setup lang="ts">
import { useAppearance } from '@/composables/useAppearance';
import { Moon, Sun } from 'lucide-vue-next';

const { appearance, updateAppearance } = useAppearance();
</script>

<template>
    <div class="inline-flex gap-1 rounded-lg bg-neutral-100 p-1">
        <button
            @click="updateAppearance('light')"
            :class="[
                'flex items-center rounded-md px-3.5 py-1.5 transition-colors',
                appearance === 'light'
                    ? 'bg-white shadow-xs text-neutral-900'
                    : 'text-neutral-500 hover:bg-neutral-200/60 hover:text-black',
            ]"
        >
            <Sun class="-ml-1 h-4 w-4" />
            <span class="ml-1.5 text-sm">Light</span>
        </button>
        <button
            @click="updateAppearance('dark')"
            :class="[
                'flex items-center rounded-md px-3.5 py-1.5 transition-colors',
                appearance === 'dark'
                    ? 'bg-neutral-700 shadow-xs text-neutral-100'
                    : 'text-neutral-500 hover:bg-neutral-200/60 hover:text-black',
            ]"
        >
            <Moon class="-ml-1 h-4 w-4" />
            <span class="ml-1.5 text-sm">Dark</span>
        </button>
    </div>
</template> 