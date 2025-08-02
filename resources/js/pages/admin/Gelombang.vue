<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Calendar, Clock, Users, Plus, Edit, Trash2, CheckCircle, AlertCircle, XCircle, TrendingUp, FileText } from 'lucide-vue-next';
import { ref, computed } from 'vue';

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
        case 'Aktif': return 'success';
        case 'Akan Datang': return 'info';
        case 'Selesai': return 'secondary';
        default: return 'secondary';
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
    if (percentage >= 90) return 'danger';
    if (percentage >= 75) return 'warning';
    return 'success';
};

const stats = computed(() => [
    { title: 'Total Gelombang', value: gelombang.value.length, icon: Calendar, color: 'info', bgColor: 'bg-gradient-info' },
    { title: 'Aktif', value: gelombang.value.filter(g => g.status === 'Aktif').length, icon: CheckCircle, color: 'success', bgColor: 'bg-gradient-success' },
    { title: 'Akan Datang', value: gelombang.value.filter(g => g.status === 'Akan Datang').length, icon: Clock, color: 'info', bgColor: 'bg-gradient-info' },
    { title: 'Selesai', value: gelombang.value.filter(g => g.status === 'Selesai').length, icon: XCircle, color: 'secondary', bgColor: 'bg-gradient-secondary' },
]);
</script>

<template>
    <Head title="Manajemen Gelombang - PPSB Al-Mukmin Ngruki" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container-fluid py-4">
            <!-- Header Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <h6 class="mb-0">Manajemen Gelombang</h6>
                                    <p class="text-secondary text-sm mb-0 ms-2">Kelola periode pendaftaran santri baru</p>
                                </div>
                                <div class="col-6 text-end">
                                    <ArgonButton color="info" variant="gradient" size="sm">
                                        <Plus class="me-2" />
                                        Tambah Gelombang
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

            <!-- Gelombang Cards -->
            <div class="row">
                <div v-for="item in gelombang" :key="item.id" class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="mb-0">{{ item.nama }}</h6>
                                    <p class="text-secondary text-sm mb-0">{{ item.periode }}</p>
                                </div>
                                <div class="col-4 text-end">
                                    <ArgonBadge :color="getStatusColor(item.status)" variant="gradient" size="sm">
                                        <component :is="getStatusIcon(item.status)" class="me-1" />
                                        {{ item.status }}
                                    </ArgonBadge>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <!-- Progress -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-xs font-weight-bold">Pendaftar: {{ item.terdaftar }} / {{ item.kuota }}</span>
                                    <span class="text-xs font-weight-bold">{{ getProgressPercentage(item.terdaftar, item.kuota).toFixed(1) }}%</span>
                                </div>
                                <ArgonProgress 
                                    :value="getProgressPercentage(item.terdaftar, item.kuota)" 
                                    :color="getProgressColor(getProgressPercentage(item.terdaftar, item.kuota))"
                                    size="sm"
                                />
                            </div>

                            <!-- Info -->
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <Calendar class="text-secondary me-2" style="font-size: 0.875rem;" />
                                    <span class="text-xs text-secondary">{{ item.tanggal_mulai }} - {{ item.tanggal_selesai }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <Users class="text-secondary me-2" style="font-size: 0.875rem;" />
                                    <span class="text-xs text-secondary">Kuota: {{ item.kuota }} santri</span>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-xs text-secondary mb-3">{{ item.deskripsi }}</p>

                            <!-- Actions -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group" role="group">
                                    <ArgonButton color="info" variant="text" size="sm" class="mb-0">
                                        <FileText />
                                    </ArgonButton>
                                    <ArgonButton color="success" variant="text" size="sm" class="mb-0">
                                        <TrendingUp />
                                    </ArgonButton>
                                    <ArgonButton color="warning" variant="text" size="sm" class="mb-0">
                                        <Edit />
                                    </ArgonButton>
                                    <ArgonButton color="danger" variant="text" size="sm" class="mb-0">
                                        <Trash2 />
                                    </ArgonButton>
                                </div>
                                <div v-if="item.status === 'Aktif'">
                                    <ArgonButton color="success" variant="gradient" size="sm">
                                        Aktifkan
                                    </ArgonButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline View -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Timeline Gelombang</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="timeline timeline-one-side" data-timeline="true">
                                <div v-for="item in gelombang" :key="item.id" class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <component :is="getStatusIcon(item.status)" :class="`text-gradient-${getStatusColor(item.status)}`" />
                                    </span>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">{{ item.nama }}</h6>
                                            <ArgonBadge :color="getStatusColor(item.status)" variant="gradient" size="sm">
                                                {{ item.status }}
                                            </ArgonBadge>
                                        </div>
                                        <p class="text-secondary text-xs mb-1">{{ item.periode }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-xs text-secondary">{{ item.terdaftar }} / {{ item.kuota }} pendaftar</span>
                                            <span class="text-xs font-weight-bold text-secondary">{{ getProgressPercentage(item.terdaftar, item.kuota).toFixed(1) }}% terisi</span>
                                        </div>
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
