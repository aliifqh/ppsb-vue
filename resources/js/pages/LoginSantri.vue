<template>
  <PublicLayout>
    <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
          <h2 class="text-3xl font-bold text-center text-teal-700 mb-2">Cek Status Pendaftaran</h2>
          <p class="text-center text-gray-600 mb-6">Masukkan kode unik dan nama lengkap untuk melihat status pendaftaran Anda.</p>
          <form @submit.prevent="onSubmit" class="space-y-6">
            <div class="space-y-4">
              <div>
                <label for="kode" class="block text-teal-700 font-medium mb-1">Kode Unik</label>
                <input id="kode" v-model="kode" name="kode" type="text" required
                  class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-300 placeholder-gray-400"
                  placeholder="Masukkan 4 kode unik (contoh: ABCD)" />
                <p v-if="errors.kode" class="mt-1 text-sm text-red-600">{{ errors.kode }}</p>
              </div>
              <div>
                <label for="nama" class="block text-teal-700 font-medium mb-1">Nama Lengkap</label>
                <input id="nama" v-model="nama" name="nama" type="text" required
                  class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-300 placeholder-gray-400"
                  placeholder="Masukkan nama lengkap" />
                <p v-if="errors.nama" class="mt-1 text-sm text-red-600">{{ errors.nama }}</p>
              </div>
            </div>
            <div v-if="errorMessage" class="rounded-lg bg-red-50 border border-red-200 p-4 mt-2">
              <div class="flex items-center">
                <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414M6.343 17.657l-1.414-1.414M5.636 5.636l1.414 1.414M17.657 17.657l1.414-1.414M12 8v4m0 4h.01" />
                </svg>
                <span class="text-sm font-medium text-red-800">{{ errorMessage }}</span>
              </div>
            </div>
            <button type="submit" :disabled="isLoading"
              class="w-full py-2.5 px-4 bg-gradient-to-r from-teal-600 to-teal-500 text-white font-semibold rounded-lg shadow-md hover:from-teal-700 hover:to-teal-600 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
              <span v-if="isLoading" class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
              </span>
              <span v-else>Cek Status</span>
            </button>
          </form>
          <div class="text-center mt-6">
            <router-link to="/" class="font-medium text-teal-600 hover:text-teal-700 transition-colors">Kembali ke Beranda</router-link>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';

interface Errors {
  kode?: string;
  nama?: string;
}

const kode = ref('');
const nama = ref('');
const errors = ref<Errors>({});
const errorMessage = ref('');
const isLoading = ref(false);

async function onSubmit() {
  errors.value = {};
  errorMessage.value = '';
  isLoading.value = true;

  try {
    // Validasi client-side
    if (!kode.value.match(/^[A-Za-z0-9]{4}$/)) {
      errors.value.kode = 'Kode unik harus 4 karakter.';
      return;
    }
    if (!nama.value.trim()) {
      errors.value.nama = 'Nama lengkap wajib diisi.';
      return;
    }

    // Kirim request ke backend
    await router.post('/santri/check', {
      kode: kode.value,
      nama: nama.value
    }, {
      onError: (err: any) => {
        if (err.error) {
          errorMessage.value = err.error;
        }
        if (err.kode) {
          errors.value.kode = err.kode;
        }
        if (err.nama) {
          errors.value.nama = err.nama;
        }
      }
    });
  } catch {
    errorMessage.value = 'Terjadi kesalahan. Silakan coba lagi.';
  } finally {
    isLoading.value = false;
  }
}
</script>
