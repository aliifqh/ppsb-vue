<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Calendar, Clock, Users, Plus, Edit, Trash2, CheckCircle, AlertCircle, XCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gelombang',
        href: '/gelombang',
    },
];

// Mock data - nanti bisa diganti dengan data real dari backend
const gelombang = ref([
    { 
        id: 1, 
        nama: 'Gelombang 1', 
        periode: 'Januari - Maret 2024', 
        status: 'Aktif', 
        kuota: 500, 
        terdaftar: 450, 
        tanggal_mulai: '2024-01-01', 
        tanggal_selesai: '2024-03-31',
        deskripsi: 'Gelombang pendaftaran awal untuk tahun ajaran 2024/2025'
    },
    { 
        id: 2, 
        nama: 'Gelombang 2', 
        periode: 'April - Juni 2024', 
        status: 'Aktif', 
        kuota: 300, 
        terdaftar: 280, 
        tanggal_mulai: '2024-04-01', 
        tanggal_selesai: '2024-06-30',
        deskripsi: 'Gelombang pendaftaran kedua dengan kuota terbatas'
    },
    { 
        id: 3, 
        nama: 'Gelombang 3', 
        periode: 'Juli - September 2024', 
        status: 'Akan Datang', 
        kuota: 200, 
        terdaftar: 0, 
        tanggal_mulai: '2024-07-01', 
        tanggal_selesai: '2024-09-30',
        deskripsi: 'Gelombang pendaftaran terakhir untuk tahun ajaran 2024/2025'
    },
    { 
        id: 4, 
        nama: 'Gelombang 2023', 
        periode: 'Januari - Desember 2023', 
        status: 'Selesai', 
        kuota: 1000, 
        terdaftar: 980, 
        tanggal_mulai: '2023-01-01', 
        tanggal_selesai: '2023-12-31',
        deskripsi: 'Gelombang pendaftaran tahun ajaran 2023/2024'
    },
]);

const getStatusColor = (status: string) => {
    switch (status) {
        case 'Aktif': return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
        case 'Akan Datang': return 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400';
        case 'Selesai': return 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400';
        default: return 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400';
    }
};

const getStatusIcon = (status: string) => {
    switch (status) {
        case 'Aktif': return CheckCircle;
        case 'Akan Datang': return Clock;
        case 'Selesai': return XCircle;
        default: return AlertCircle;
    }
};

const getProgressPercentage = (terdaftar: number, kuota: number) => {
    return Math.min((terdaftar / kuota) * 100, 100);
};

const getProgressColor = (percentage: number) => {
    if (percentage >= 90) return 'bg-red-500';
    if (percentage >= 75) return 'bg-yellow-500';
    return 'bg-green-500';
};
</script>

<template>
    <Head title="Manajemen Gelombang - PPSB Al-Mukmin Ngruki" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Gelombang</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola periode pendaftaran santri baru</p>
                </div>
                <div class="flex items-center space-x-3 mt-4 sm:mt-0">
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <Plus class="w-4 h-4 mr-2" />
                        Tambah Gelombang
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <Calendar class="w-6 h-6 text-blue-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Gelombang</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ gelombang.length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <CheckCircle class="w-6 h-6 text-green-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Aktif</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ gelombang.filter(g => g.status === 'Aktif').length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <Clock class="w-6 h-6 text-blue-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Akan Datang</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ gelombang.filter(g => g.status === 'Akan Datang').length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-900/30 rounded-lg flex items-center justify-center">
                            <XCircle class="w-6 h-6 text-gray-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Selesai</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ gelombang.filter(g => g.status === 'Selesai').length }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gelombang Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div v-for="item in gelombang" :key="item.id" class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700 hover:shadow-xl transition-shadow">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ item.nama }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ item.periode }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span :class="`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusColor(item.status)}`">
                                <component :is="getStatusIcon(item.status)" class="w-3 h-3 mr-1" />
                                {{ item.status }}
                            </span>
                            <div class="flex items-center space-x-1">
                                <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    <Edit class="w-4 h-4" />
                                </button>
                                <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Progress -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                            <span>Pendaftar: {{ item.terdaftar }} / {{ item.kuota }}</span>
                            <span>{{ getProgressPercentage(item.terdaftar, item.kuota).toFixed(1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div 
                                :class="`h-2 rounded-full transition-all duration-300 ${getProgressColor(getProgressPercentage(item.terdaftar, item.kuota))}`"
                                :style="`width: ${getProgressPercentage(item.terdaftar, item.kuota)}%`"
                            ></div>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <Calendar class="w-4 h-4 mr-2" />
                            <span>{{ item.tanggal_mulai }} - {{ item.tanggal_selesai }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <Users class="w-4 h-4 mr-2" />
                            <span>Kuota: {{ item.kuota }} santri</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ item.deskripsi }}</p>

                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <div class="flex items-center space-x-4">
                            <button class="text-sm text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                Lihat Detail
                            </button>
                            <button class="text-sm text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 font-medium">
                                Export Data
                            </button>
                        </div>
                        <div v-if="item.status === 'Aktif'" class="flex items-center space-x-2">
                            <button class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium rounded-full hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                                Aktifkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline View -->
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Timeline Gelombang</h2>
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                    
                    <!-- Timeline Items -->
                    <div class="space-y-6">
                        <div v-for="(item, index) in gelombang" :key="item.id" class="relative flex items-start">
                            <!-- Timeline Dot -->
                            <div class="flex-shrink-0 w-12 h-12 rounded-full border-4 border-white dark:border-slate-800 shadow-lg flex items-center justify-center z-10"
                                 :class="{
                                     'bg-green-500': item.status === 'Aktif',
                                     'bg-blue-500': item.status === 'Akan Datang',
                                     'bg-gray-500': item.status === 'Selesai'
                                 }">
                                <component :is="getStatusIcon(item.status)" class="w-5 h-5 text-white" />
                            </div>
                            
                            <!-- Content -->
                            <div class="ml-6 flex-1">
                                <div class="bg-gray-50 dark:bg-slate-700 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ item.nama }}</h3>
                                        <span :class="`inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${getStatusColor(item.status)}`">
                                            {{ item.status }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ item.periode }}</p>
                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                        <span>{{ item.terdaftar }} / {{ item.kuota }} pendaftar</span>
                                        <span>{{ getProgressPercentage(item.terdaftar, item.kuota).toFixed(1) }}% terisi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
