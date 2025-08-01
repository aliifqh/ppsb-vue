<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { CreditCard, DollarSign, TrendingUp, CheckCircle, Clock, XCircle, Search, Filter, Download, Eye, Edit } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pembayaran',
        href: '/pembayaran',
    },
];

// Mock data - nanti bisa diganti dengan data real dari backend
const pembayaran = ref([
    { 
        id: 1, 
        nama_santri: 'Ahmad Fadillah', 
        nis: '2024001', 
        jumlah: 2500000, 
        metode: 'Transfer Bank', 
        status: 'Lunas', 
        tanggal: '2024-01-15', 
        waktu: '14:30',
        bank: 'BCA',
        no_rekening: '1234567890',
        keterangan: 'Pembayaran DP Gelombang 1'
    },
    { 
        id: 2, 
        nama_santri: 'Siti Nurhaliza', 
        nis: '2024002', 
        jumlah: 2500000, 
        metode: 'Cash', 
        status: 'Pending', 
        tanggal: '2024-01-16', 
        waktu: '09:15',
        bank: '-',
        no_rekening: '-',
        keterangan: 'Pembayaran DP Gelombang 1'
    },
    { 
        id: 3, 
        nama_santri: 'Muhammad Rizki', 
        nis: '2024003', 
        jumlah: 2500000, 
        metode: 'Transfer Bank', 
        status: 'Lunas', 
        tanggal: '2024-01-17', 
        waktu: '16:45',
        bank: 'Mandiri',
        no_rekening: '0987654321',
        keterangan: 'Pembayaran DP Gelombang 2'
    },
    { 
        id: 4, 
        nama_santri: 'Fatimah Azzahra', 
        nis: '2024004', 
        jumlah: 0, 
        metode: '-', 
        status: 'Belum Bayar', 
        tanggal: '-', 
        waktu: '-',
        bank: '-',
        no_rekening: '-',
        keterangan: 'Belum melakukan pembayaran'
    },
    { 
        id: 5, 
        nama_santri: 'Abdullah Rahman', 
        nis: '2024005', 
        jumlah: 2500000, 
        metode: 'Transfer Bank', 
        status: 'Lunas', 
        tanggal: '2024-01-19', 
        waktu: '11:20',
        bank: 'BNI',
        no_rekening: '1122334455',
        keterangan: 'Pembayaran DP Gelombang 3'
    },
]);

const searchQuery = ref('');
const selectedStatus = ref('all');
const selectedMetode = ref('all');

const filteredPembayaran = computed(() => {
    return pembayaran.value.filter(item => {
        const matchesSearch = item.nama_santri.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            item.nis.includes(searchQuery.value);
        const matchesStatus = selectedStatus.value === 'all' || item.status === selectedStatus.value;
        const matchesMetode = selectedMetode.value === 'all' || item.metode === selectedMetode.value;
        
        return matchesSearch && matchesStatus && matchesMetode;
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

const getStatusIcon = (status: string) => {
    switch (status) {
        case 'Lunas': return CheckCircle;
        case 'Pending': return Clock;
        case 'Belum Bayar': return XCircle;
        default: return XCircle;
    }
};

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(amount);
};

const totalPendapatan = computed(() => {
    return pembayaran.value
        .filter(item => item.status === 'Lunas')
        .reduce((total, item) => total + item.jumlah, 0);
});

const totalPending = computed(() => {
    return pembayaran.value
        .filter(item => item.status === 'Pending')
        .reduce((total, item) => total + item.jumlah, 0);
});
</script>

<template>
    <Head title="Manajemen Pembayaran - PPSB Al-Mukmin Ngruki" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Pembayaran</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola transaksi pembayaran santri baru</p>
                </div>
                <div class="flex items-center space-x-3 mt-4 sm:mt-0">
                    <button class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <Download class="w-4 h-4 mr-2" />
                        Export
                    </button>
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <CreditCard class="w-4 h-4 mr-2" />
                        Input Pembayaran
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <CreditCard class="w-6 h-6 text-blue-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Transaksi</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ pembayaran.length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <CheckCircle class="w-6 h-6 text-green-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Lunas</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ pembayaran.filter(p => p.status === 'Lunas').length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                            <Clock class="w-6 h-6 text-yellow-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ pembayaran.filter(p => p.status === 'Pending').length }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <DollarSign class="w-6 h-6 text-purple-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pendapatan</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ formatCurrency(totalPendapatan) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Summary -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ringkasan Pendapatan</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pendapatan Lunas</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ formatCurrency(totalPendapatan) }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pendapatan Pending</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ formatCurrency(totalPending) }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Metode Pembayaran</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Transfer Bank</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ pembayaran.filter(p => p.metode === 'Transfer Bank').length }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Cash</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ pembayaran.filter(p => p.metode === 'Cash').length }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Belum Bayar</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ pembayaran.filter(p => p.status === 'Belum Bayar').length }}</span>
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
                        v-model="selectedMetode"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                    >
                        <option value="all">Semua Metode</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Cash">Cash</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Santri</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Metode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                            <tr v-for="item in filteredPembayaran" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ item.nama_santri }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ item.nis }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ formatCurrency(item.jumlah) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ item.metode }}</div>
                                    <div v-if="item.bank !== '-'" class="text-xs text-gray-400 dark:text-gray-500">{{ item.bank }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="`inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full ${getStatusColor(item.status)}`">
                                        <component :is="getStatusIcon(item.status)" class="w-3 h-3 mr-1" />
                                        {{ item.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ item.tanggal }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ item.waktu }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">{{ item.keterangan }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <Eye class="w-4 h-4" />
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                            <Edit class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Empty State -->
                <div v-if="filteredPembayaran.length === 0" class="text-center py-12">
                    <CreditCard class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada data pembayaran</h3>
                    <p class="text-gray-500 dark:text-gray-400">Coba ubah filter atau input pembayaran baru.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
