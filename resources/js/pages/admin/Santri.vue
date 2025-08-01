<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Users, Search, Plus, Filter, Edit, Trash2, Eye, Download } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Santri',
        href: '/santri',
    },
];

// Mock data - nanti bisa diganti dengan data real dari backend
const santri = ref([
    { id: 1, nama: 'Ahmad Fadillah', nis: '2024001', gelombang: 'Gelombang 1', status: 'Lunas', tanggal_daftar: '2024-01-15', no_hp: '081234567890' },
    { id: 2, nama: 'Siti Nurhaliza', nis: '2024002', gelombang: 'Gelombang 1', status: 'Pending', tanggal_daftar: '2024-01-16', no_hp: '081234567891' },
    { id: 3, nama: 'Muhammad Rizki', nis: '2024003', gelombang: 'Gelombang 2', status: 'Lunas', tanggal_daftar: '2024-01-17', no_hp: '081234567892' },
    { id: 4, nama: 'Fatimah Azzahra', nis: '2024004', gelombang: 'Gelombang 2', status: 'Belum Bayar', tanggal_daftar: '2024-01-18', no_hp: '081234567893' },
    { id: 5, nama: 'Abdullah Rahman', nis: '2024005', gelombang: 'Gelombang 3', status: 'Lunas', tanggal_daftar: '2024-01-19', no_hp: '081234567894' },
]);

const searchQuery = ref('');
const selectedStatus = ref('all');
const selectedGelombang = ref('all');

const filteredSantri = computed(() => {
    return santri.value.filter(item => {
        const matchesSearch = item.nama.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            item.nis.includes(searchQuery.value);
        const matchesStatus = selectedStatus.value === 'all' || item.status === selectedStatus.value;
        const matchesGelombang = selectedGelombang.value === 'all' || item.gelombang === selectedGelombang.value;
        
        return matchesSearch && matchesStatus && matchesGelombang;
    });
});

const getStatusColor = (status: string) => {
    switch (status) {
        case 'Lunas': return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
        case 'Pending': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
        case 'Belum Bayar': return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
        default: return 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400';
    }
};
</script>

<template>
    <Head title="Manajemen Santri - PPSB Al-Mukmin Ngruki" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Santri</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola data santri PPSB Al-Mukmin Ngruki</p>
                </div>
                <div class="flex items-center space-x-3 mt-4 sm:mt-0">
                    <button class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <Download class="w-4 h-4 mr-2" />
                        Export
                    </button>
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <Plus class="w-4 h-4 mr-2" />
                        Tambah Santri
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <Users class="w-6 h-6 text-blue-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Santri</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ santri.length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <div class="w-6 h-6 bg-green-500 rounded-full"></div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Lunas</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ santri.filter(s => s.status === 'Lunas').length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                            <div class="w-6 h-6 bg-yellow-500 rounded-full"></div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ santri.filter(s => s.status === 'Pending').length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                            <div class="w-6 h-6 bg-red-500 rounded-full"></div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Belum Bayar</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ santri.filter(s => s.status === 'Belum Bayar').length }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" />
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Cari nama atau NIS..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                        />
                    </div>
                    
                    <select
                        v-model="selectedStatus"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                    >
                        <option value="all">Semua Status</option>
                        <option value="Lunas">Lunas</option>
                        <option value="Pending">Pending</option>
                        <option value="Belum Bayar">Belum Bayar</option>
                    </select>
                    
                    <select
                        v-model="selectedGelombang"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                    >
                        <option value="all">Semua Gelombang</option>
                        <option value="Gelombang 1">Gelombang 1</option>
                        <option value="Gelombang 2">Gelombang 2</option>
                        <option value="Gelombang 3">Gelombang 3</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">NIS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Gelombang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No. HP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                            <tr v-for="item in filteredSantri" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ item.nama }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ item.nis }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ item.gelombang }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${getStatusColor(item.status)}`">
                                        {{ item.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ item.tanggal_daftar }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ item.no_hp }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <Eye class="w-4 h-4" />
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                            <Edit class="w-4 h-4" />
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <Trash2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Empty State -->
                <div v-if="filteredSantri.length === 0" class="text-center py-12">
                    <Users class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada data santri</h3>
                    <p class="text-gray-500 dark:text-gray-400">Coba ubah filter atau tambah santri baru.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
