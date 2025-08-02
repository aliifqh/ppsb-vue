<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

// Props untuk breadcrumbs
interface Props {
    breadcrumbs?: Array<{
        title: string;
        url?: string;
    }>;
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => []
});

// Sidebar state
const sidebarOpen = ref(false);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

// Navigation items
const navigation = [
    {
        name: 'Dashboard',
        href: '/dashboard',
        icon: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z',
        current: false
    },
    {
        name: 'Santri',
        href: '/santri',
        icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z',
        current: false
    },
    {
        name: 'Gelombang',
        href: '/gelombang',
        icon: 'M8 7V3a4 4 0 118 0v4m-4 6v6m-4-6h8m-8 0H4',
        current: false
    },
    {
        name: 'Unit',
        href: '/unit',
        icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
        current: false
    },
    {
        name: 'Pembayaran',
        href: '/pembayaran',
        icon: 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
        current: false
    },
    {
        name: 'Laporan',
        href: '/laporan',
        icon: 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        current: false
    }
];
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar for mobile -->
        <div v-if="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
            <div class="fixed inset-0 z-40 flex">
                <div class="relative flex w-full max-w-xs flex-1 flex-col bg-white pb-4 pt-5">
                    <div class="absolute right-0 top-0 -mr-12 pt-2">
                        <button
                            type="button"
                            class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            @click="toggleSidebar"
                        >
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Sidebar component for mobile -->
                    <div class="flex flex-shrink-0 items-center px-4">
                        <img class="h-8 w-auto" src="/img/logo-ppin.png" alt="Logo" />
                        <span class="ml-2 text-lg font-semibold text-gray-900">Admin Panel</span>
                    </div>
                    <div class="mt-5 h-0 flex-1 overflow-y-auto">
                        <nav class="space-y-1 px-2">
                            <Link
                                v-for="item in navigation"
                                :key="item.name"
                                :href="item.href"
                                :class="[
                                    $page.url === item.href
                                        ? 'bg-gray-100 text-gray-900'
                                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                                    'group flex items-center px-2 py-2 text-base font-medium rounded-md'
                                ]"
                            >
                                <svg
                                    :class="[
                                        $page.url === item.href ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500',
                                        'mr-4 flex-shrink-0 h-6 w-6'
                                    ]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" :d="item.icon" />
                                </svg>
                                {{ item.name }}
                            </Link>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
            <div class="flex min-h-0 flex-1 flex-col border-r border-gray-200 bg-white">
                <div class="flex flex-1 flex-col overflow-y-auto pt-5 pb-4">
                    <div class="flex flex-shrink-0 items-center px-4">
                        <img class="h-8 w-auto" src="/img/logo-ppin.png" alt="Logo" />
                        <span class="ml-2 text-lg font-semibold text-gray-900">Admin Panel</span>
                    </div>
                    <nav class="mt-5 flex-1 space-y-1 px-2">
                        <Link
                            v-for="item in navigation"
                            :key="item.name"
                            :href="item.href"
                            :class="[
                                $page.url === item.href
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                                'group flex items-center px-2 py-2 text-sm font-medium rounded-md'
                            ]"
                        >
                            <svg
                                :class="[
                                    $page.url === item.href ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500',
                                    'mr-3 flex-shrink-0 h-6 w-6'
                                ]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" :d="item.icon" />
                            </svg>
                            {{ item.name }}
                        </Link>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-1 flex-col lg:pl-64">
            <!-- Top bar -->
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button
                    type="button"
                    class="-m-2.5 p-2.5 text-gray-700 lg:hidden"
                    @click="toggleSidebar"
                >
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Separator -->
                <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true"></div>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <!-- Breadcrumbs -->
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-4">
                            <li>
                                <div>
                                    <Link href="/dashboard" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                        </svg>
                                        <span class="sr-only">Home</span>
                                    </Link>
                                </div>
                            </li>
                            <li v-for="(breadcrumb, index) in breadcrumbs" :key="index">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <Link
                                        v-if="breadcrumb.url"
                                        :href="breadcrumb.url"
                                        class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                                    >
                                        {{ breadcrumb.title }}
                                    </Link>
                                    <span v-else class="ml-4 text-sm font-medium text-gray-700">
                                        {{ breadcrumb.title }}
                                    </span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <!-- Profile dropdown -->
                        <div class="relative">
                            <button
                                type="button"
                                class="-m-1.5 flex items-center p-1.5"
                                id="user-menu-button"
                                aria-expanded="false"
                                aria-haspopup="true"
                            >
                                <span class="sr-only">Open user menu</span>
                                <img
                                    class="h-8 w-8 rounded-full bg-gray-50"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt=""
                                />
                                <span class="hidden lg:flex lg:items-center">
                                    <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">
                                        Admin User
                                    </span>
                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1">
                <div class="py-6">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <slot />
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<style scoped>
/* Additional styles if needed */
</style> 