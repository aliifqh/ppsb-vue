<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{
    items: NavItem[];
}>();

const page = usePage();
</script>

<template>
    <SidebarGroup class="px-3 py-2">
        <SidebarGroupLabel class="text-xs font-semibold text-gray-200 uppercase tracking-wider mb-3 px-2">
            Platform
        </SidebarGroupLabel>
        <SidebarMenu class="space-y-1">
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton 
                    as-child 
                    :is-active="item.href === page.url" 
                    :tooltip="item.title"
                    class="group relative overflow-hidden rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-sm"
                    :class="{
                        'bg-gray-100 shadow-md border border-gray-300 text-gray-800': item.href === page.url,
                        'hover:scale-[1.02]': item.href !== page.url
                    }"
                >
                    <Link :href="item.href" class="flex items-center gap-3 px-3 py-2.5 w-full">
                        <div class="relative">
                            <component 
                                :is="item.icon" 
                                class="w-5 h-5 transition-all duration-200 group-hover:scale-110"
                                :class="{
                                    'text-emerald-600': item.href === page.url,
                                    'text-gray-200 group-hover:text-emerald-400': item.href !== page.url
                                }"
                            />
                            <!-- Active indicator -->
                            <div 
                                v-if="item.href === page.url"
                                class="absolute -right-1 -top-1 w-2 h-2 bg-emerald-500 rounded-full animate-pulse"
                            ></div>
                        </div>
                        <span 
                            class="font-medium transition-all duration-200"
                            :class="{
                                'text-gray-800': item.href === page.url,
                                'text-gray-100 group-hover:text-emerald-300': item.href !== page.url
                            }"
                        >
                            {{ item.title }}
                        </span>
                        <!-- Hover effect overlay -->
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg"></div>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>

<style scoped>
/* Custom scrollbar for sidebar */
::-webkit-scrollbar {
    width: 4px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.3);
    border-radius: 2px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.5);
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}
</style>
