<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

interface Santri {
  id: number;
  nomor_pendaftaran: string;
  nama: string;
  unit: string;
  created_at: string;
}

defineProps<{
  santri: Santri;
}>();

const handlePrint = () => {
  if (typeof window !== 'undefined') {
    window.print();
  }
};
</script>

<template>
  <Head title="Pendaftaran Berhasil" />
  
  <div class="min-h-screen bg-gradient-to-br from-teal-50 to-blue-50 flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
      <!-- Success Card -->
      <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
        <!-- Success Icon -->
        <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
          <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>

        <!-- Success Message -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">
          🎉 Pendaftaran Berhasil!
        </h1>
        
        <p class="text-gray-600 mb-8 text-lg">
          Selamat! Data pendaftaran Anda telah berhasil disimpan. 
          Simpan nomor pendaftaran Anda dengan baik.
        </p>

        <!-- Registration Details -->
        <div class="bg-teal-50 rounded-xl p-6 mb-8">
          <h2 class="text-xl font-semibold text-teal-800 mb-4">
            Detail Pendaftaran
          </h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
            <div>
              <p class="text-sm text-gray-600">Nomor Pendaftaran</p>
              <p class="text-lg font-bold text-teal-700">{{ santri.nomor_pendaftaran }}</p>
            </div>
            
            <div>
              <p class="text-sm text-gray-600">Nama Santri</p>
              <p class="text-lg font-semibold text-gray-800">{{ santri.nama }}</p>
            </div>
            
            <div>
              <p class="text-sm text-gray-600">Unit</p>
              <p class="text-lg font-semibold text-gray-800">
                {{ santri.unit === 'ppim' ? 'PPIM (Lulusan SD/MI)' : 'TKS (Lulusan SMP/MTs)' }}
              </p>
            </div>
            
            <div>
              <p class="text-sm text-gray-600">Tanggal Pendaftaran</p>
              <p class="text-lg font-semibold text-gray-800">{{ new Date(santri.created_at).toLocaleDateString('id-ID') }}</p>
            </div>
          </div>
        </div>

        <!-- Important Notes -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
          <h3 class="text-lg font-semibold text-yellow-800 mb-3">
            ⚠️ Penting untuk Diperhatikan
          </h3>
          
          <ul class="text-left text-yellow-700 space-y-2">
            <li class="flex items-start">
              <span class="mr-2">•</span>
              <span>Simpan nomor pendaftaran <strong>{{ santri.nomor_pendaftaran }}</strong> dengan baik</span>
            </li>
            <li class="flex items-start">
              <span class="mr-2">•</span>
              <span>Nomor ini akan digunakan untuk melengkapi dokumen dan pembayaran</span>
            </li>
            <li class="flex items-start">
              <span class="mr-2">•</span>
              <span>Proses selanjutnya akan diinformasikan melalui email atau WhatsApp</span>
            </li>
            <li class="flex items-start">
              <span class="mr-2">•</span>
              <span>Pastikan data yang diisi sudah benar dan lengkap</span>
            </li>
          </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <button 
            @click="handlePrint"
            class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors flex items-center justify-center"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Cetak Bukti Pendaftaran
          </button>
          
          <a 
            href="/"
            class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors flex items-center justify-center"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Kembali ke Beranda
          </a>
        </div>

        <!-- Contact Info -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <p class="text-sm text-gray-500">
            Jika ada pertanyaan, silakan hubungi kami di:
          </p>
          <div class="flex justify-center space-x-6 mt-2">
            <a href="https://wa.me/6281234567890" class="text-teal-600 hover:text-teal-700 font-medium">
              📱 WhatsApp
            </a>
            <a href="mailto:info@ppsb-ngruki.sch.id" class="text-teal-600 hover:text-teal-700 font-medium">
              📧 Email
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@media print {
  .bg-gradient-to-br {
    background: white !important;
  }
  
  .shadow-xl {
    box-shadow: none !important;
  }
  
  button, a {
    display: none !important;
  }
}
</style> 