<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import type { User } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { LogOut, Settings } from 'lucide-vue-next';

interface Props {
    user: User;
}

const handleLogout = () => {
    router.flushAll();
};

defineProps<Props>();
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-3 py-3 text-left text-sm bg-gray-800 rounded-t-lg">
            <UserInfo :user="user" :show-email="true" />
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator class="border-gray-600" />
    <DropdownMenuGroup>
        <DropdownMenuItem 
            :as-child="true"
            class="px-3 py-2.5 text-gray-100 hover:text-emerald-300 hover:bg-gray-700 focus:text-emerald-300 focus:bg-gray-700"
        >
            <Link class="flex items-center w-full" :href="route('profile.edit')" prefetch as="button">
                <Settings class="mr-3 h-4 w-4 text-gray-300 group-hover:text-emerald-400" />
                <span class="font-medium">Settings</span>
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator class="border-gray-600" />
    <DropdownMenuItem 
        :as-child="true"
        class="px-3 py-2.5 text-gray-100 hover:text-red-300 hover:bg-gray-700 focus:text-red-300 focus:bg-gray-700"
    >
        <Link class="flex items-center w-full" method="post" :href="route('logout')" @click="handleLogout" as="button">
            <LogOut class="mr-3 h-4 w-4 text-gray-300 group-hover:text-red-400" />
            <span class="font-medium">Log out</span>
        </Link>
    </DropdownMenuItem>
</template>

<style scoped>
/* Custom hover effects */
:deep(.dropdown-menu-item) {
    transition: all 0.2s ease-in-out;
}

:deep(.dropdown-menu-item:hover) {
    transform: translateX(2px);
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}
</style>
