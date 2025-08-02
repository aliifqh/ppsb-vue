<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Users, GraduationCap, CreditCard, TrendingUp, Clock, CheckCircle, AlertCircle, Plus, FileText, BarChart3 } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

// Mock data - nanti bisa diganti dengan data real dari backend
const stats = [
    { title: 'Total Santri', value: '1,247', icon: Users, color: 'info', change: '+12%', bgColor: 'bg-gradient-info' },
    { title: 'Gelombang Aktif', value: '3', icon: GraduationCap, color: 'success', change: '+2', bgColor: 'bg-gradient-success' },
    { title: 'Pembayaran Pending', value: '89', icon: CreditCard, color: 'warning', change: '-5%', bgColor: 'bg-gradient-warning' },
    { title: 'Pendaftar Baru', value: '156', icon: TrendingUp, color: 'primary', change: '+23%', bgColor: 'bg-gradient-primary' },
];

const recentActivities = [
    { title: 'Ahmad Fadillah mendaftar', time: '2 menit yang lalu', type: 'success', icon: CheckCircle },
    { title: 'Pembayaran dari Siti Nurhaliza', time: '15 menit yang lalu', type: 'success', icon: CheckCircle },
    { title: 'Gelombang 2 akan ditutup', time: '1 jam yang lalu', type: 'warning', icon: AlertCircle },
    { title: 'Backup database selesai', time: '2 jam yang lalu', type: 'info', icon: Clock },
];

const quickActions = [
    { title: 'Tambah Santri', icon: Plus, color: 'info', href: '/admin/santri/create' },
    { title: 'Buat Gelombang', icon: GraduationCap, color: 'success', href: '/admin/gelombang/create' },
    { title: 'Input Bayar', icon: CreditCard, color: 'warning', href: '/admin/pembayaran/create' },
    { title: 'Laporan', icon: FileText, color: 'primary', href: '/admin/laporan' },
];

const paymentStatus = [
    { status: 'Lunas', count: '1,158', color: 'success', percentage: 75 },
    { status: 'Pending', count: '89', color: 'warning', percentage: 15 },
    { status: 'Belum Bayar', count: '156', color: 'danger', percentage: 10 },
];
</script>

<template>
    <Head title="Dashboard - PPSB Al-Mukmin Ngruki" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container-fluid py-4">
            <!-- Stats Cards -->
            <div class="row">
                <div v-for="stat in stats" :key="stat.title" class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ stat.title }}</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ stat.value }}
                                            <span class="text-success text-sm font-weight-bolder">{{ stat.change }}</span>
                                        </h5>
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

            <!-- Quick Actions & Recent Activities -->
            <div class="row">
                <!-- Quick Actions -->
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Quick Actions</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div v-for="action in quickActions" :key="action.title" class="col-md-6 col-lg-3 mb-3">
                                    <ArgonButton 
                                        :color="action.color" 
                                        variant="gradient" 
                                        size="sm" 
                                        class="w-100"
                                        :href="action.href"
                                    >
                                        <div class="d-flex align-items-center">
                                            <component :is="action.icon" class="me-2" />
                                            {{ action.title }}
                                        </div>
                                    </ArgonButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Aktivitas Terbaru</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="timeline timeline-one-side" data-timeline="true">
                                <div v-for="activity in recentActivities" :key="activity.title" class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <component :is="activity.icon" class="text-gradient-info" />
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">{{ activity.title }}</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ activity.time }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row">
                <!-- Pendaftaran Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Pendaftaran Bulan Ini</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart-container" style="height: 300px;">
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="text-center">
                                        <BarChart3 class="text-gradient-info mb-3" style="font-size: 3rem;" />
                                        <h6 class="text-dark mb-0">Chart akan ditampilkan di sini</h6>
                                        <p class="text-secondary text-sm">Data pendaftaran bulanan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran Status -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Status Pembayaran</h6>
                        </div>
                        <div class="card-body p-3">
                            <div v-for="payment in paymentStatus" :key="payment.status" class="d-flex justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <div :class="`icon icon-shape icon-sm bg-gradient-${payment.color} shadow text-center`"></div>
                                    <div class="ms-3">
                                        <h6 class="text-dark mb-0">{{ payment.status }}</h6>
                                        <p class="text-secondary text-sm mb-0">{{ payment.count }} santri</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <ArgonBadge :color="payment.color" variant="gradient" size="sm">
                                        {{ payment.percentage }}%
                                    </ArgonBadge>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
