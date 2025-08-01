<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
          <div class="flex items-center">
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Santri</h1>
          </div>
          <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600">Selamat datang, {{ santri.nama }}</span>
            <button @click="logout" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
              Logout
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Info Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Nomor Pendaftaran</p>
              <p class="text-lg font-semibold text-gray-900">{{ santri.nomor_pendaftaran }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Status</p>
              <p class="text-lg font-semibold text-gray-900">{{ santri.status_pendaftaran || 'Menunggu' }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Biaya</p>
              <p class="text-lg font-semibold text-gray-900">Rp {{ formatNumber(santri.biaya_pendaftaran || 0) }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
              <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Tanggal Daftar</p>
              <p class="text-lg font-semibold text-gray-900">{{ formatDate(santri.created_at) }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Detail Information -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Data Pribadi -->
        <div class="bg-white rounded-lg shadow">
          <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Data Pribadi</h3>
          </div>
          <div class="p-6">
            <dl class="space-y-4">
              <div>
                <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ santri.nama }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Tempat Lahir</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ santri.tempat_lahir || '-' }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ formatDate(santri.tanggal_lahir) || '-' }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ santri.jenis_kelamin || '-' }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ santri.alamat || '-' }}</dd>
              </div>
            </dl>
          </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="bg-white rounded-lg shadow">
          <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Data Orang Tua</h3>
          </div>
          <div class="p-6">
            <dl class="space-y-4">
              <div>
                <dt class="text-sm font-medium text-gray-500">Nama Ayah</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ santri.orang_tua?.nama_ayah || '-' }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Nama Ibu</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ santri.orang_tua?.nama_ibu || '-' }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Pekerjaan Ayah</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ santri.orang_tua?.pekerjaan_ayah || '-' }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Pekerjaan Ibu</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ santri.orang_tua?.pekerjaan_ibu || '-' }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">No. HP</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ santri.orang_tua?.no_hp || '-' }}</dd>
              </div>
            </dl>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="mt-8 flex flex-wrap gap-4">
        <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
          Cek Status Pembayaran
        </button>
        <button class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
          Download Kartu Pendaftaran
        </button>
        <button class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">
          Lihat Jadwal Ujian
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';

interface Props {
  santri: {
    id: number;
    nomor_pendaftaran: string;
    nama: string;
    tempat_lahir?: string;
    tanggal_lahir?: string;
    jenis_kelamin?: string;
    alamat?: string;
    status_pendaftaran?: string;
    biaya_pendaftaran?: number;
    created_at: string;
    orang_tua?: {
      nama_ayah?: string;
      nama_ibu?: string;
      pekerjaan_ayah?: string;
      pekerjaan_ibu?: string;
      no_hp?: string;
    };
  };
}

defineProps<Props>();

function formatNumber(num: number): string {
  return new Intl.NumberFormat('id-ID').format(num);
}

function formatDate(dateString: string | undefined): string {
  if (!dateString) return '-';
  return new Date(dateString).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
}

function logout() {
  router.post('/santri/logout');
}
</script> 