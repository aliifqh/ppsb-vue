<script setup lang="ts">
import { SidebarGroup, SidebarGroupContent, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';

interface Props {
    items: NavItem[];
    class?: string;
}

defineProps<Props>();
</script>

<template>
    <SidebarGroup :class="`group-data-[collapsible=icon]:p-0 ${$props.class || ''}`">
        <SidebarGroupContent class="px-3 py-2">
            <SidebarMenu class="space-y-1">
                <SidebarMenuItem v-for="item in items" :key="item.title">
                    <SidebarMenuButton 
                        class="group relative overflow-hidden rounded-lg transition-all duration-300 hover:bg-gray-700 hover:shadow-sm hover:scale-[1.02]" 
                        as-child
                    >
                        <a 
                            :href="item.href" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="flex items-center gap-3 px-3 py-2.5 w-full"
                        >
                            <div class="relative">
                                <component 
                                    :is="item.icon" 
                                    class="w-5 h-5 transition-all duration-200 group-hover:scale-110 group-hover:text-blue-400"
                                    :class="{
                                        'text-gray-200': true
                                    }"
                                />
                                
                                <!-- External link indicator -->
                                <div class="absolute -right-1 -top-1 w-2 h-2 bg-blue-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            </div>
                            
                            <span class="font-medium transition-all duration-200 text-gray-100 group-hover:text-blue-300">
                                {{ item.title }}
                            </span>
                            
                            <!-- External link arrow -->
                            <svg 
                                class="w-4 h-4 ml-auto text-gray-200 group-hover:text-blue-400 transition-all duration-200 group-hover:translate-x-0.5" 
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            
                            <!-- Hover effect overlay -->
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg"></div>
                        </a>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarGroupContent>
    </SidebarGroup>
</template>

<style scoped>
/* Custom hover animations */
@keyframes slide-in {
    from {
        transform: translateX(-10px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.group:hover .group-hover\:translate-x-0\.5 {
    animation: slide-in 0.2s ease-out;
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}
</style>
