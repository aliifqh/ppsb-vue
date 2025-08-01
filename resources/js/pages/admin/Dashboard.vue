<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Users, GraduationCap, CreditCard, TrendingUp, Clock, CheckCircle, AlertCircle } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

// Mock data - nanti bisa diganti dengan data real dari backend
const stats = [
    { title: 'Total Santri', value: '1,247', icon: Users, color: 'blue', change: '+12%' },
    { title: 'Gelombang Aktif', value: '3', icon: GraduationCap, color: 'green', change: '+2' },
    { title: 'Pembayaran Pending', value: '89', icon: CreditCard, color: 'yellow', change: '-5%' },
    { title: 'Pendaftar Baru', value: '156', icon: TrendingUp, color: 'purple', change: '+23%' },
];

const recentActivities = [
    { title: 'Ahmad Fadillah mendaftar', time: '2 menit yang lalu', type: 'success' },
    { title: 'Pembayaran dari Siti Nurhaliza', time: '15 menit yang lalu', type: 'success' },
    { title: 'Gelombang 2 akan ditutup', time: '1 jam yang lalu', type: 'warning' },
    { title: 'Backup database selesai', time: '2 jam yang lalu', type: 'info' },
];
</script>

<template>
    <Head title="Dashboard - PPSB Al-Mukmin Ngruki" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div v-for="stat in stats" :key="stat.title" class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ stat.title }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ stat.value }}</p>
                            <p class="text-xs text-green-600 dark:text-green-400 mt-1">{{ stat.change }} dari bulan lalu</p>
                        </div>
                        <div :class="`w-12 h-12 bg-${stat.color}-100 dark:bg-${stat.color}-900/30 rounded-lg flex items-center justify-center`">
                            <component :is="stat.icon" :class="`w-6 h-6 text-${stat.color}-600`" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Activities -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick Actions -->
                <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <button class="flex flex-col items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                            <Users class="w-6 h-6 text-blue-600 mb-2" />
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tambah Santri</span>
                        </button>
                        <button class="flex flex-col items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                            <GraduationCap class="w-6 h-6 text-green-600 mb-2" />
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Buat Gelombang</span>
                        </button>
                        <button class="flex flex-col items-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/30 transition-colors">
                            <CreditCard class="w-6 h-6 text-yellow-600 mb-2" />
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Input Bayar</span>
                        </button>
                        <button class="flex flex-col items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                            <TrendingUp class="w-6 h-6 text-purple-600 mb-2" />
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Laporan</span>
                        </button>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aktivitas Terbaru</h2>
                    <div class="space-y-4">
                        <div v-for="activity in recentActivities" :key="activity.title" class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <CheckCircle v-if="activity.type === 'success'" class="w-5 h-5 text-green-500" />
                                <AlertCircle v-else-if="activity.type === 'warning'" class="w-5 h-5 text-yellow-500" />
                                <Clock v-else class="w-5 h-5 text-blue-500" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ activity.title }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ activity.time }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pendaftaran Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pendaftaran Bulan Ini</h2>
                    <div class="h-64 flex items-center justify-center bg-gray-50 dark:bg-slate-700 rounded-lg">
                        <div class="text-center">
                            <TrendingUp class="w-12 h-12 text-blue-500 mx-auto mb-2" />
                            <p class="text-gray-600 dark:text-gray-400">Chart akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran Status -->
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status Pembayaran</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Lunas</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">1,158</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pending</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">89</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Belum Bayar</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">156</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
