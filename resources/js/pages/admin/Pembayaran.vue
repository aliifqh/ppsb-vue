<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { CreditCard, DollarSign, CheckCircle, Clock, XCircle, Download, Eye, Edit, Plus, Banknote, Receipt } from 'lucide-vue-next';
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
        case 'Lunas': return 'success';
        case 'Pending': return 'warning';
        case 'Belum Bayar': return 'danger';
        default: return 'secondary';
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

const stats = computed(() => [
    { title: 'Total Transaksi', value: pembayaran.value.length, icon: CreditCard, color: 'info', bgColor: 'bg-gradient-info' },
    { title: 'Lunas', value: pembayaran.value.filter(p => p.status === 'Lunas').length, icon: CheckCircle, color: 'success', bgColor: 'bg-gradient-success' },
    { title: 'Pending', value: pembayaran.value.filter(p => p.status === 'Pending').length, icon: Clock, color: 'warning', bgColor: 'bg-gradient-warning' },
    { title: 'Total Pendapatan', value: formatCurrency(totalPendapatan.value), icon: DollarSign, color: 'primary', bgColor: 'bg-gradient-primary' },
]);

const paymentMethods = computed(() => [
    { name: 'Transfer Bank', count: pembayaran.value.filter(p => p.metode === 'Transfer Bank').length, icon: Banknote, color: 'info' },
    { name: 'Cash', count: pembayaran.value.filter(p => p.metode === 'Cash').length, icon: Receipt, color: 'success' },
    { name: 'Belum Bayar', count: pembayaran.value.filter(p => p.status === 'Belum Bayar').length, icon: XCircle, color: 'danger' },
]);
</script>

<template>
    <Head title="Manajemen Pembayaran - PPSB Al-Mukmin Ngruki" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container-fluid py-4">
            <!-- Header Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <h6 class="mb-0">Manajemen Pembayaran</h6>
                                    <p class="text-secondary text-sm mb-0 ms-2">Kelola transaksi pembayaran santri baru</p>
                                </div>
                                <div class="col-6 text-end">
                                    <ArgonButton color="secondary" variant="outline" size="sm" class="me-2">
                                        <Download class="me-2" />
                                        Export
                                    </ArgonButton>
                                    <ArgonButton color="info" variant="gradient" size="sm">
                                        <Plus class="me-2" />
                                        Input Pembayaran
                                    </ArgonButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div v-for="stat in stats" :key="stat.title" class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ stat.title }}</p>
                                        <h5 class="font-weight-bolder mb-0">{{ stat.value }}</h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div :class="`icon icon-shape ${stat.bgColor} shadow text-center border-radius-md`">
                                        <component :is="stat.icon" class="text-lg opacity-10" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Summary & Payment Methods -->
            <div class="row">
                <!-- Revenue Summary -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Ringkasan Pendapatan</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm bg-gradient-success shadow text-center"></div>
                                    <div class="ms-3">
                                        <h6 class="text-dark mb-0">Pendapatan Lunas</h6>
                                        <p class="text-secondary text-sm mb-0">{{ formatCurrency(totalPendapatan) }}</p>
                                    </div>
                                </div>
                                <ArgonBadge color="success" variant="gradient" size="sm">
                                    {{ pembayaran.filter(p => p.status === 'Lunas').length }} transaksi
                                </ArgonBadge>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm bg-gradient-warning shadow text-center"></div>
                                    <div class="ms-3">
                                        <h6 class="text-dark mb-0">Pendapatan Pending</h6>
                                        <p class="text-secondary text-sm mb-0">{{ formatCurrency(totalPending) }}</p>
                                    </div>
                                </div>
                                <ArgonBadge color="warning" variant="gradient" size="sm">
                                    {{ pembayaran.filter(p => p.status === 'Pending').length }} transaksi
                                </ArgonBadge>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Metode Pembayaran</h6>
                        </div>
                        <div class="card-body p-3">
                            <div v-for="method in paymentMethods" :key="method.name" class="d-flex justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <component :is="method.icon" :class="`text-${method.color} me-2`" />
                                    <span class="text-sm font-weight-bold">{{ method.name }}</span>
                                </div>
                                <ArgonBadge :color="method.color" variant="gradient" size="sm">
                                    {{ method.count }}
                                </ArgonBadge>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <ArgonInput
                                        v-model="searchQuery"
                                        placeholder="Cari nama atau NIS..."
                                        icon="fas fa-search"
                                        size="sm"
                                    />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <select
                                        v-model="selectedStatus"
                                        class="form-select form-select-sm"
                                    >
                                        <option value="all">Semua Status</option>
                                        <option value="Lunas">Lunas</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Belum Bayar">Belum Bayar</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <select
                                        v-model="selectedMetode"
                                        class="form-select form-select-sm"
                                    >
                                        <option value="all">Semua Metode</option>
                                        <option value="Transfer Bank">Transfer Bank</option>
                                        <option value="Cash">Cash</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Data Pembayaran</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Santri</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Metode</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in filteredPembayaran" :key="item.id">
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <ArgonAvatar
                                                            :img="`https://ui-avatars.com/api/?name=${item.nama_santri}&background=random`"
                                                            size="sm"
                                                            class="me-3"
                                                        />
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ item.nama_santri }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ item.nis }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ formatCurrency(item.jumlah) }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-secondary">{{ item.metode }}</span>
                                                <p v-if="item.bank !== '-'" class="text-xs text-secondary mb-0">{{ item.bank }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <ArgonBadge :color="getStatusColor(item.status)" variant="gradient" size="sm">
                                                    <component :is="getStatusIcon(item.status)" class="me-1" />
                                                    {{ item.status }}
                                                </ArgonBadge>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ item.tanggal }}</span>
                                                <p class="text-xs text-secondary mb-0">{{ item.waktu }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ item.keterangan }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <ArgonButton color="info" variant="text" size="sm" class="mb-0">
                                                        <Eye />
                                                    </ArgonButton>
                                                    <ArgonButton color="success" variant="text" size="sm" class="mb-0">
                                                        <Edit />
                                                    </ArgonButton>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="filteredPembayaran.length === 0" class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <CreditCard class="text-secondary mb-3" style="font-size: 3rem;" />
                            <h6 class="text-dark mb-2">Tidak ada data pembayaran</h6>
                            <p class="text-secondary text-sm mb-0">Coba ubah filter atau input pembayaran baru.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
