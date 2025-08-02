<script setup lang="ts">
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type User } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { ChevronsUpDown, User as UserIcon } from 'lucide-vue-next';
import UserMenuContent from './UserMenuContent.vue';

const page = usePage();
const user = page.props.auth.user as User;
</script>

<template>
    <SidebarMenu class="mt-auto">
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton 
                        size="lg" 
                        class="group relative overflow-hidden rounded-lg transition-all duration-300 hover:bg-gray-700 hover:shadow-lg hover:scale-[1.02] border border-transparent hover:border-gray-500"
                    >
                        <div class="flex items-center gap-3 w-full">
                            <!-- User Avatar Section -->
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                                    <UserIcon class="w-5 h-5 text-white" />
                                </div>
                                
                                <!-- Online status indicator -->
                                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-gray-900 animate-pulse"></div>
                                
                                <!-- Hover glow effect -->
                                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm"></div>
                            </div>
                            
                            <!-- User Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-100 truncate group-hover:text-emerald-300 transition-colors duration-200">
                                            {{ user.name }}
                                        </p>
                                        <p class="text-xs text-gray-200 truncate group-hover:text-emerald-400 transition-colors duration-200">
                                            {{ user.email }}
                                        </p>
                                    </div>
                                    
                                    <!-- Dropdown Arrow -->
                                    <ChevronsUpDown class="ml-2 h-4 w-4 text-gray-200 group-hover:text-emerald-400 transition-all duration-200 group-hover:rotate-180" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hover effect overlay -->
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg"></div>
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                
                <DropdownMenuContent
                    class="w-full max-w-[calc(100vw-2rem)] rounded-xl shadow-xl border border-gray-600 bg-gray-800 backdrop-blur-sm z-50"
                    side="top"
                    align="start"
                    :side-offset="4"
                    :align-offset="0"
                    :avoid-collisions="false"
                    :force-mount="false"
                >
                    <UserMenuContent :user="user" />
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
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
