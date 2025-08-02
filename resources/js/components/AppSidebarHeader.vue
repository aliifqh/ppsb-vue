<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import type { BreadcrumbItemType } from '@/types';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItemType[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);
</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center gap-2 border-b border-gray-200 dark:border-gray-700 px-6 transition-[width,height] ease-linear md:px-4 pb-20 md:pb-0 bg-white dark:bg-gray-900"
    >
        <div class="flex items-center gap-2">
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>
        
        <!-- Mobile menu indicator -->
        <div class="ml-auto flex items-center gap-2 md:hidden">
            <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                <div class="w-1 h-1 bg-emerald-500 rounded-full animate-pulse"></div>
                <span>Menu</span>
            </div>
        </div>
    </header>
</template>

<style scoped>
/* Custom animations */
@keyframes pulse-glow {
    0%, 100% {
        opacity: 0.5;
        transform: scale(1);
    }
    50% {
        opacity: 1;
        transform: scale(1.05);
    }
}

.animate-pulse {
    animation: pulse-glow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}
</style>
