<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Calendar, Folder, Home, LayoutGrid, Users, User, Bell, HelpCircle, CreditCard, MessageCircle } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { ref, onMounted, onUnmounted } from 'vue';

// Sidebar menu items (Desktop)
const sidebarNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Santri',
        href: '/santri',
        icon: Users,
    },
    {
        title: 'Pembayaran',
        href: '/pembayaran',
        icon: CreditCard,
    },
    {
        title: 'Gelombang',
        href: '/gelombang',
        icon: Calendar,
    },
    {
        title: 'Whatsapp Integrasi',
        href: '/whatsapp-integrasi',
        icon: MessageCircle,
    }
];

const footerNavItems: NavItem[] = [
    {
        title: 'Front Page',
        href: '/',
        icon: Home,
    },
    {
        title: 'Github Repo',
        href: 'https://github.com/aliifqh/ppsb-vue',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://github1s.com/aliifqh/ppsb-vue',
        icon: BookOpen,
    },
];

// Bottom menu items (Mobile) - Different content
const bottomMenuItems: NavItem[] = [
    {
        title: 'Home',
        href: '/',
        icon: Home,
    },
    {
        title: 'Santri',
        href: '/santri',
        icon: Users,
    },
    {
        title: 'Profile',
        href: '/profile',
        icon: User,
    },
    {
        title: 'Notifications',
        href: '/notifications',
        icon: Bell,
    },
    {
        title: 'Help',
        href: '/help',
        icon: HelpCircle,
    },
];

// Mobile detection
const isMobile = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth < 768; // md breakpoint
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
});
</script>

<template>
    <!-- Desktop Sidebar - Always Dark Mode -->
    <Sidebar variant="inset" class="hidden md:block sidebar-dark">
        <SidebarHeader class="border-b border-gray-600 bg-gray-800 rounded-t-lg">
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child class="hover:bg-gray-700 transition-all duration-200">
                        <Link :href="route('dashboard')" class="p-4">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent class="px-3 py-4 bg-gray-800">
            <NavMain :items="sidebarNavItems" />
        </SidebarContent>

        <SidebarFooter class="border-t border-gray-600 bg-gray-800 rounded-b-lg ">
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    
    <!-- Mobile Bottom Menu -->
    <div 
        v-if="isMobile" 
        class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg transition-all duration-300 ease-in-out md:hidden"
    >
        <div class="flex items-center justify-around px-4 py-2">
            <Link 
                v-for="item in bottomMenuItems" 
                :key="item.title"
                :href="item.href"
                class="flex flex-col items-center gap-1 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 group"
                :class="{ 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400': $page.url === item.href }"
            >
                <component 
                    :is="item.icon" 
                    class="w-5 h-5 transition-all duration-200 group-hover:scale-110"
                    :class="{ 'text-emerald-600 dark:text-emerald-400': $page.url === item.href, 'text-gray-600 dark:text-gray-400': $page.url !== item.href }"
                />
                <span class="text-xs font-medium transition-colors duration-200" :class="{ 'text-emerald-600 dark:text-emerald-400': $page.url === item.href, 'text-gray-600 dark:text-gray-400': $page.url !== item.href }">
                    {{ item.title }}
                </span>
            </Link>
        </div>
    </div>
    
    <slot />
</template>

<style scoped>
/* Custom animations for bottom menu */
@keyframes slide-up {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.fixed.bottom-0 {
    animation: slide-up 0.3s ease-out;
}

/* Sidebar Gray Theme Styling */
:deep(.sidebar-dark .sidebar-header .sidebar-content .sidebar-footer) {
    background: linear-gradient(180deg, #374151 0%, #4b5563 100%);
    border-right: 1px solid #6b7280;
    color: #f9fafb;
    border-radius: 0 8px 8px 0;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
}

:deep(.sidebar-dark .sidebar-header) {
    background: #374151;
    border-bottom: 1px solid #6b7280;
    border-radius: 8px 8px 0 0;
}

:deep(.sidebar-dark .sidebar-content) {
    background: #374151;
}

:deep(.sidebar-dark .sidebar-footer) {
    background: #374151;
    border-top: 1px solid #6b7280;
    border-radius: 0 0 8px 8px;
}

/* Custom scrollbar for sidebar */
:deep(.sidebar-dark) {
    scrollbar-width: thin;
    scrollbar-color: rgba(156, 163, 175, 0.3) transparent;
}

:deep(.sidebar-dark::-webkit-scrollbar) {
    width: 4px;
}

:deep(.sidebar-dark::-webkit-scrollbar-track) {
    background: transparent;
}

:deep(.sidebar-dark::-webkit-scrollbar-thumb) {
    background: rgba(156, 163, 175, 0.3);
    border-radius: 2px;
}

:deep(.sidebar-dark::-webkit-scrollbar-thumb:hover) {
    background: rgba(156, 163, 175, 0.5);
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}
</style>
