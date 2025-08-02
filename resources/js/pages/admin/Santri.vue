<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Users, Plus, Edit, Trash2, Eye, Download, UserCheck, Clock, AlertCircle } from 'lucide-vue-next';
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
        case 'Lunas': return 'success';
        case 'Pending': return 'warning';
        case 'Belum Bayar': return 'danger';
        default: return 'secondary';
    }
};

const getStatusIcon = (status: string) => {
    switch (status) {
        case 'Lunas': return UserCheck;
        case 'Pending': return Clock;
        case 'Belum Bayar': return AlertCircle;
        default: return Users;
    }
};

const stats = computed(() => [
    { title: 'Total Santri', value: santri.value.length, icon: Users, color: 'info', bgColor: 'bg-gradient-info' },
    { title: 'Lunas', value: santri.value.filter(s => s.status === 'Lunas').length, icon: UserCheck, color: 'success', bgColor: 'bg-gradient-success' },
    { title: 'Pending', value: santri.value.filter(s => s.status === 'Pending').length, icon: Clock, color: 'warning', bgColor: 'bg-gradient-warning' },
    { title: 'Belum Bayar', value: santri.value.filter(s => s.status === 'Belum Bayar').length, icon: AlertCircle, color: 'danger', bgColor: 'bg-gradient-danger' },
]);
</script>

<template>
    <Head title="Manajemen Santri - PPSB Al-Mukmin Ngruki" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container-fluid py-4">
            <!-- Header Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <h6 class="mb-0">Manajemen Santri</h6>
                                    <p class="text-secondary text-sm mb-0 ms-2">Kelola data santri PPSB Al-Mukmin Ngruki</p>
                                </div>
                                <div class="col-6 text-end">
                                    <ArgonButton color="secondary" variant="outline" size="sm" class="me-2">
                                        <Download class="me-2" />
                                        Export
                                    </ArgonButton>
                                    <ArgonButton color="info" variant="gradient" size="sm">
                                        <Plus class="me-2" />
                                        Tambah Santri
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
                                        v-model="selectedGelombang"
                                        class="form-select form-select-sm"
                                    >
                                        <option value="all">Semua Gelombang</option>
                                        <option value="Gelombang 1">Gelombang 1</option>
                                        <option value="Gelombang 2">Gelombang 2</option>
                                        <option value="Gelombang 3">Gelombang 3</option>
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
                            <h6>Data Santri</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIS</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Gelombang</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Daftar</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. HP</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in filteredSantri" :key="item.id">
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <ArgonAvatar
                                                            :img="`https://ui-avatars.com/api/?name=${item.nama}&background=random`"
                                                            size="sm"
                                                            class="me-3"
                                                        />
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ item.nama }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ item.nis }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-secondary">{{ item.gelombang }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <ArgonBadge :color="getStatusColor(item.status)" variant="gradient" size="sm">
                                                    <component :is="getStatusIcon(item.status)" class="me-1" />
                                                    {{ item.status }}
                                                </ArgonBadge>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ item.tanggal_daftar }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ item.no_hp }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <ArgonButton color="info" variant="text" size="sm" class="mb-0">
                                                        <Eye />
                                                    </ArgonButton>
                                                    <ArgonButton color="success" variant="text" size="sm" class="mb-0">
                                                        <Edit />
                                                    </ArgonButton>
                                                    <ArgonButton color="danger" variant="text" size="sm" class="mb-0">
                                                        <Trash2 />
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
            <div v-if="filteredSantri.length === 0" class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <Users class="text-secondary mb-3" style="font-size: 3rem;" />
                            <h6 class="text-dark mb-2">Tidak ada data santri</h6>
                            <p class="text-secondary text-sm mb-0">Coba ubah filter atau tambah santri baru.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
