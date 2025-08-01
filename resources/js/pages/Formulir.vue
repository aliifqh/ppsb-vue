<script setup lang="ts">
import { watch, ref, reactive, onMounted, onUnmounted } from 'vue';
import { router, Head } from '@inertiajs/vue3';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';

interface FormData {
  unit: string;
  nama: string;
  jenis_kelamin: string;
  tempat_lahir: string;
  tanggal_lahir: string; // Format: YYYY-MM-DD
  asal_sekolah: string;
  anak_ke: number;
  jumlah_saudara: number;
  whatsapp: string;
  nama_ayah: string;
  nama_ibu: string;
  provinsi: string;
  kabupaten: string;
  kecamatan: string;
  desa: string;
  alamat_lengkap: string;
  kode_pos: string;
}

interface Unit {
  id: number;
  kode: string;
  nama: string;
  deskripsi: string;
  jenjang: string;
  usia_minimal: number;
  usia_maksimal: number;
  aktif: boolean;
  urutan: number;
  persyaratan: string[];
  biaya: Record<string, number>;
  kuota_maksimal: number;
  kuota_terisi: number;
  sisa_kuota: number;
  biaya_administrasi: number;
  biaya_daftar_ulang: number;
  persyaratan_khusus: string[];
  diskon: Record<string, any>;
}

defineProps<{
  gelombangAktif?: any;
  units?: Unit[];
  error?: string;
}>();

const currentStep = 1;
const isSubmitting = ref(false);

// Initialize form data
const localForm = reactive<FormData>({
  unit: '',
  nama: '',
  jenis_kelamin: '',
  tempat_lahir: '',
  tanggal_lahir: '',
  asal_sekolah: '',
  anak_ke: 1,
  jumlah_saudara: 1,
  whatsapp: '',
  nama_ayah: '',
  nama_ibu: '',
  provinsi: '',
  kabupaten: '',
  kecamatan: '',
  desa: '',
  alamat_lengkap: '',
  kode_pos: '',
});



// State untuk dropdown alamat EMSIFA
const provinsiList = ref<Array<{id: string, name: string}>>([]);
const kabupatenList = ref<Array<{id: string, name: string}>>([]);
const kecamatanList = ref<Array<{id: string, name: string}>>([]);
const desaList = ref<Array<{id: string, name: string}>>([]);
const isLoadingProvinsi = ref(false);
const isLoadingKabupaten = ref(false);
const isLoadingKecamatan = ref(false);
const isLoadingDesa = ref(false);

// Load data alamat dari API EMSIFA
async function loadProvinsi() {
  isLoadingProvinsi.value = true;
  try {
    const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
    const data = await response.json();
    provinsiList.value = data;
  } catch (error) {
    console.error('Error loading provinsi:', error);
  } finally {
    isLoadingProvinsi.value = false;
  }
}

async function loadKabupaten() {
  if (!localForm.provinsi) return;
  
  isLoadingKabupaten.value = true;
  kabupatenList.value = [];
  kecamatanList.value = [];
  desaList.value = [];
  localForm.kabupaten = '';
  localForm.kecamatan = '';
  localForm.desa = '';
  
  try {
    const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${localForm.provinsi}.json`);
    const data = await response.json();
    kabupatenList.value = data;
  } catch (error) {
    console.error('Error loading kabupaten:', error);
  } finally {
    isLoadingKabupaten.value = false;
  }
}

async function loadKecamatan() {
  if (!localForm.kabupaten) return;
  
  isLoadingKecamatan.value = true;
  kecamatanList.value = [];
  desaList.value = [];
  localForm.kecamatan = '';
  localForm.desa = '';
  
  try {
    const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${localForm.kabupaten}.json`);
    const data = await response.json();
    kecamatanList.value = data;
  } catch (error) {
    console.error('Error loading kecamatan:', error);
  } finally {
    isLoadingKecamatan.value = false;
  }
}

async function loadDesa() {
  if (!localForm.kecamatan) return;
  
  isLoadingDesa.value = true;
  desaList.value = [];
  localForm.desa = '';
  
  try {
    const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${localForm.kecamatan}.json`);
    const data = await response.json();
    desaList.value = data;
  } catch (error) {
    console.error('Error loading desa:', error);
  } finally {
    isLoadingDesa.value = false;
  }
}

// Load provinsi saat component mount
loadProvinsi();

// Inisialisasi flatpickr untuk tanggal lahir
let tanggalLahirPicker: any = null;

onMounted(() => {
  // Inisialisasi flatpickr dengan konfigurasi default
  const tanggalLahirInput = document.getElementById('tanggal_lahir') as HTMLInputElement;
  if (tanggalLahirInput) {
    tanggalLahirPicker = flatpickr(tanggalLahirInput, {
      dateFormat: 'Y-m-d',
      allowInput: true,
      clickOpens: true,
      locale: {
        firstDayOfWeek: 1,
        weekdays: {
          shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
          longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
        },
        months: {
          shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
          longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
        }
      },
      onChange: function(selectedDates, dateStr) {
        localForm.tanggal_lahir = dateStr;
      }
    });
  }
});

// Cleanup flatpickr saat component unmount
onUnmounted(() => {
  if (tanggalLahirPicker) {
    tanggalLahirPicker.destroy();
  }
});

// Watcher untuk validasi data saudara setiap kali berubah
watch(
  () => [localForm.anak_ke, localForm.jumlah_saudara],
  ([anakKe, jumlahSaudara]) => {
    let anak = parseInt(anakKe.toString());
    let jumlah = parseInt(jumlahSaudara.toString());
    if (isNaN(anak) || anak < 1) anak = 1;
    if (isNaN(jumlah) || jumlah < 1) jumlah = 1;
    if (jumlah > 20) jumlah = 20;
    if (anak > jumlah) anak = jumlah;
    if (localForm.anak_ke !== anak) localForm.anak_ke = anak;
    if (localForm.jumlah_saudara !== jumlah) localForm.jumlah_saudara = jumlah;
  },
  { immediate: true }
);

function capitalizeWords(str: string): string {
  return str.replace(/\b\w+/g, w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase());
}

function onNamaInput(e: Event): void {
  const target = e.target as HTMLInputElement;
  let val = target.value.replace(/[^a-zA-Z\s']/g, '');
  val = val.replace(/\s{2,}/g, ' ');
  localForm.nama = capitalizeWords(val);
}

function onWhatsappInput(e: Event): void {
  const target = e.target as HTMLInputElement;
  let val = target.value.replace(/\D/g, '');
  
  // Auto prefix 62 jika dimulai dengan 0
  if (val.startsWith('0')) {
    val = '62' + val.substring(1);
  }
  
  // Pastikan dimulai dengan 62
  if (val && !val.startsWith('62')) {
    val = '62' + val;
  }
  
  localForm.whatsapp = val;
}

function onSaudaraInput(): void {
  let anakKe = parseInt(localForm.anak_ke.toString());
  let jumlahSaudara = parseInt(localForm.jumlah_saudara.toString());
  if (isNaN(anakKe) || anakKe < 1) anakKe = 1;
  if (isNaN(jumlahSaudara) || jumlahSaudara < 1) jumlahSaudara = 1;
  if (jumlahSaudara > 20) jumlahSaudara = 20;
  if (anakKe > jumlahSaudara) anakKe = jumlahSaudara;
  localForm.anak_ke = anakKe;
  localForm.jumlah_saudara = jumlahSaudara;
}

function onNamaAyahInput(e: Event): void {
  const target = e.target as HTMLInputElement;
  let val = target.value.replace(/[^a-zA-Z\s']/g, '');
  val = val.replace(/\s{2,}/g, ' ');
  localForm.nama_ayah = capitalizeWords(val);
}

function onNamaIbuInput(e: Event): void {
  const target = e.target as HTMLInputElement;
  let val = target.value.replace(/[^a-zA-Z\s']/g, '');
  val = val.replace(/\s{2,}/g, ' ');
  localForm.nama_ibu = capitalizeWords(val);
}

function onAlamatLengkapInput(e: Event): void {
  const target = e.target as HTMLInputElement;
  const val = target.value;
  localForm.alamat_lengkap = val;
}

function incrementNumber(field: string): void {
  if (field === 'anak_ke' && localForm.anak_ke < localForm.jumlah_saudara) {
    localForm.anak_ke++;
  } else if (field === 'jumlah_saudara' && localForm.jumlah_saudara < 20) {
    localForm.jumlah_saudara++;
  }
}

function decrementNumber(field: string): void {
  if (field === 'anak_ke' && localForm.anak_ke > 1) {
    localForm.anak_ke--;
  } else if (field === 'jumlah_saudara' && localForm.jumlah_saudara > localForm.anak_ke) {
    localForm.jumlah_saudara--;
  }
}

async function submitForm() {
  // Validasi minimal aja
  if (!localForm.unit || !localForm.nama || !localForm.whatsapp) {
    alert('Isi data yang diperlukan');
    return;
  }
  
  isSubmitting.value = true;
  
  try {
    // Get CSRF token from meta tag or use default
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    // Debug: log data yang akan dikirim
    console.log('Data yang akan dikirim:', localForm);
    
    const response = await fetch('/formulir', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: JSON.stringify(localForm)
    });
    
    // Check if response is ok
    if (!response.ok) {
      if (response.status === 419) {
        alert('Sesi telah berakhir. Silakan refresh halaman dan coba lagi.');
        return;
      }
      
      // Handle validation errors
      if (response.status === 422) {
        const errorData = await response.json();
        let errorMessage = 'Validasi gagal:\n';
        
        if (errorData.errors) {
          Object.keys(errorData.errors).forEach(field => {
            errorMessage += `- ${errorData.errors[field][0]}\n`;
          });
        } else {
          errorMessage += errorData.message || 'Terjadi kesalahan validasi';
        }
        
        alert(errorMessage);
        return;
      }
      
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const result = await response.json();
    
    if (result.success) {
      // Redirect ke halaman success
      router.visit(`/formulir/success/${result.data.nomor_pendaftaran}`);
    } else {
      alert(result.message || 'Terjadi kesalahan');
    }
  } catch (error) {
    console.error('Error submitting form:', error);
    alert('Terjadi kesalahan sistem. Silakan coba lagi.');
  } finally {
    isSubmitting.value = false;
  }
}
</script>

<template>
  <Head title="Formulir Pendaftaran Santri" />
  
  <div v-if="error" class="min-h-screen bg-gradient-to-br from-red-50 to-pink-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center">
      <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
      </div>
      <h1 class="text-2xl font-bold text-gray-800 mb-4">Pendaftaran Ditutup</h1>
      <p class="text-gray-600 mb-6">{{ error }}</p>
      <a href="/" class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
        Kembali ke Beranda
      </a>
    </div>
  </div>

  <div v-else class="min-h-screen bg-gradient-to-br from-teal-50 to-blue-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
      <!-- Header -->
      <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-teal-800 mb-4">
          📝 Formulir Pendaftaran Santri
        </h1>
        <p class="text-lg text-gray-600">
          PPIM & TKS Pondok Pesantren Sunan Giri Ngruki
        </p>
        <div v-if="gelombangAktif" class="mt-4 bg-teal-100 rounded-lg p-4 inline-block">
          <p class="text-teal-800 font-medium">
            🎯 Gelombang: {{ gelombangAktif.nama }}
          </p>
        </div>
      </div>
      
      <!-- Form Component -->
      <div class="bg-white rounded-2xl shadow-xl p-8">
        <div v-if="currentStep === 1" class="space-y-6">
          <h2 class="text-2xl font-semibold text-teal-700">Data Calon Santri</h2>
    
    <!-- Unit Selection -->
    <div class="space-y-2">
      <label class="block text-teal-700 font-medium">Pilihan Unit:</label>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <label v-for="unit in units" :key="unit.id" class="relative">
            <input type="radio" name="unit" :value="unit.kode" v-model="localForm.unit" class="peer sr-only" required :disabled="unit.sisa_kuota <= 0" />
            <div class="p-4 border-2 rounded-lg cursor-pointer peer-checked:border-teal-600 peer-checked:bg-teal-50 hover:border-teal-400 hover:bg-teal-50/50" :class="{'opacity-50 cursor-not-allowed': unit.sisa_kuota <= 0}">
              <span class="block text-center font-medium">{{ unit.nama }}</span>
              <span class="block text-center text-sm text-gray-600 mt-1">{{ unit.deskripsi }}</span>
              <span class="block text-center text-xs text-teal-600 mt-1">Usia: {{ unit.usia_minimal }}-{{ unit.usia_maksimal }} tahun</span>
              
              <!-- Info Kuota & Biaya -->
              <div class="mt-3 p-2 bg-gray-50 rounded text-xs">
                <div class="flex justify-between items-center mb-1">
                  <span>Kuota:</span>
                  <span :class="unit.sisa_kuota <= 5 ? 'text-red-600 font-bold' : 'text-green-600'">
                    {{ unit.sisa_kuota }}/{{ unit.kuota_maksimal }}
                  </span>
                </div>
                <div class="flex justify-between items-center mb-1">
                  <span>Biaya Admin:</span>
                  <span class="font-medium">Rp {{ unit.biaya_administrasi.toLocaleString() }}</span>
                </div>
                <div class="flex justify-between items-center">
                  <span>Daftar Ulang:</span>
                  <span class="font-medium">Rp {{ unit.biaya_daftar_ulang.toLocaleString() }}</span>
                </div>
                
                <!-- Diskon Info -->
                <div v-if="unit.diskon && unit.diskon.administrasi > 0" class="mt-2 p-1 bg-green-100 rounded text-center">
                  <span class="text-green-700 font-bold">🎉 Diskon {{ unit.diskon.keterangan }}</span>
                </div>
              </div>
              
              <!-- Warning jika kuota habis -->
              <div v-if="unit.sisa_kuota <= 0" class="mt-2 p-1 bg-red-100 rounded text-center">
                <span class="text-red-700 font-bold">❌ Kuota Penuh</span>
              </div>
            </div>
          </label>
        </div>
    </div>

    <!-- Nama Lengkap -->
    <div class="space-y-2">
      <label for="nama" class="block text-teal-700 font-medium">Nama Lengkap:</label>
      <input type="text" id="nama" name="nama" v-model="localForm.nama" @input="onNamaInput" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Masukkan nama lengkap sesuai ijazah" required />
    </div>

    <!-- Jenis Kelamin -->
    <div class="space-y-2">
      <label for="jenis_kelamin" class="block text-teal-700 font-medium">Jenis Kelamin:</label>
      <select id="jenis_kelamin" name="jenis_kelamin" v-model="localForm.jenis_kelamin" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>
        <option value="">Pilih Jenis Kelamin</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>
    </div>

    <!-- Tempat Lahir -->
    <div class="space-y-2">
      <label for="tempat_lahir" class="block text-teal-700 font-medium">Tempat Lahir:</label>
      <input type="text" id="tempat_lahir" name="tempat_lahir" v-model="localForm.tempat_lahir" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Masukkan kota/kabupaten tempat lahir" required />
    </div>

    <!-- Tanggal Lahir -->
    <div class="space-y-2">
      <label for="tanggal_lahir" class="block text-teal-700 font-medium">Tanggal Lahir:</label>
      <input type="text" id="tanggal_lahir" name="tanggal_lahir" v-model="localForm.tanggal_lahir" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Pilih tanggal lahir" required readonly />
      <p class="mt-1 text-sm text-gray-500">Klik untuk memilih tanggal</p>
    </div>

    <!-- Asal Sekolah -->
    <div class="space-y-2">
      <label for="asal_sekolah" class="block text-teal-700 font-medium">Asal Sekolah:</label>
      <input type="text" id="asal_sekolah" name="asal_sekolah" v-model="localForm.asal_sekolah" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Masukkan nama sekolah asal" required />
    </div>

    <!-- WhatsApp -->
    <div class="space-y-2">
      <label for="whatsapp" class="block text-teal-700 font-medium">Nomor WhatsApp:</label>
      <input type="text" id="whatsapp" name="whatsapp" v-model="localForm.whatsapp" @input="onWhatsappInput" maxlength="15" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Contoh: 628123456789" required />
      <p class="mt-1 text-sm text-gray-500">Format otomatis: 62xxx</p>
    </div>

    <!-- Data Saudara -->
    <div class="space-y-4">
      <label class="block text-teal-700 font-medium">Data Saudara:</label>
      <div class="bg-teal-50 rounded-lg p-6 border border-teal-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Anak Ke -->
          <div class="space-y-2">
            <label class="block text-teal-700 font-medium">Anak ke:</label>
            <div class="flex items-center gap-3">
              <button type="button" @click="decrementNumber('anak_ke')" class="w-10 h-10 rounded-lg bg-teal-100 text-teal-600 hover:bg-teal-200 flex items-center justify-center transition-colors" :class="{'opacity-50 cursor-not-allowed': localForm.anak_ke <= 1}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
              </button>
              <input type="number" name="anak_ke" v-model="localForm.anak_ke" @input="onSaudaraInput" class="w-20 text-center px-3 py-2 border-2 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 appearance-none" min="1" required readonly />
              <button type="button" @click="incrementNumber('anak_ke')" class="w-10 h-10 rounded-lg bg-teal-100 text-teal-600 hover:bg-teal-200 flex items-center justify-center transition-colors" :class="{'opacity-50 cursor-not-allowed': localForm.anak_ke >= localForm.jumlah_saudara}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
              </button>
            </div>
          </div>
          <!-- Jumlah Saudara -->
          <div class="space-y-2">
            <label class="block text-teal-700 font-medium">Jumlah Saudara:</label>
            <div class="flex items-center gap-3">
              <button type="button" @click="decrementNumber('jumlah_saudara')" class="w-10 h-10 rounded-lg bg-teal-100 text-teal-600 hover:bg-teal-200 flex items-center justify-center transition-colors" :class="{'opacity-50 cursor-not-allowed': localForm.jumlah_saudara <= localForm.anak_ke || localForm.jumlah_saudara <= 1}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
              </button>
              <input type="number" name="jumlah_saudara" v-model="localForm.jumlah_saudara" @input="onSaudaraInput" class="w-20 text-center px-3 py-2 border-2 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 appearance-none" min="1" required readonly />
              <button type="button" @click="incrementNumber('jumlah_saudara')" class="w-10 h-10 rounded-lg bg-teal-100 text-teal-600 hover:bg-teal-200 flex items-center justify-center transition-colors" :class="{'opacity-50 cursor-not-allowed': localForm.jumlah_saudara >= 20}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Orang Tua -->
    <div class="space-y-6">
      <h3 class="text-xl font-semibold text-teal-700">Data Orang Tua</h3>
      
      <!-- Data Orang Tua -->
      <div class="bg-blue-50 rounded-lg p-6 border border-blue-100">
        <h4 class="text-lg font-medium text-blue-700 mb-4">Data Orang Tua</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="space-y-2">
            <label for="nama_ayah" class="block text-blue-700 font-medium">Nama Ayah:</label>
            <input type="text" id="nama_ayah" name="nama_ayah" v-model="localForm.nama_ayah" @input="onNamaAyahInput" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan nama lengkap ayah" required />
          </div>
          <div class="space-y-2">
            <label for="nama_ibu" class="block text-blue-700 font-medium">Nama Ibu:</label>
            <input type="text" id="nama_ibu" name="nama_ibu" v-model="localForm.nama_ibu" @input="onNamaIbuInput" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan nama lengkap ibu" required />
          </div>
        </div>
      </div>

      <!-- Alamat -->
      <div class="bg-green-50 rounded-lg p-6 border border-green-100">
        <h4 class="text-lg font-medium text-green-700 mb-4">Alamat</h4>
        
        <!-- Provinsi -->
        <div class="space-y-2 mb-4">
          <label for="provinsi" class="block text-green-700 font-medium">Provinsi:</label>
          <select id="provinsi" name="provinsi" v-model="localForm.provinsi" @change="loadKabupaten" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
            <option value="">Pilih Provinsi</option>
            <option v-for="prov in provinsiList" :key="prov.id" :value="prov.id">{{ prov.name }}</option>
          </select>
          <div v-if="isLoadingProvinsi" class="text-sm text-green-600">Loading provinsi...</div>
        </div>

        <!-- Kabupaten -->
        <div class="space-y-2 mb-4">
          <label for="kabupaten" class="block text-green-700 font-medium">Kabupaten/Kota:</label>
          <select id="kabupaten" name="kabupaten" v-model="localForm.kabupaten" @change="loadKecamatan" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required :disabled="!localForm.provinsi">
            <option value="">Pilih Kabupaten/Kota</option>
            <option v-for="kab in kabupatenList" :key="kab.id" :value="kab.id">{{ kab.name }}</option>
          </select>
          <div v-if="isLoadingKabupaten" class="text-sm text-green-600">Loading kabupaten...</div>
        </div>

        <!-- Kecamatan -->
        <div class="space-y-2 mb-4">
          <label for="kecamatan" class="block text-green-700 font-medium">Kecamatan:</label>
          <select id="kecamatan" name="kecamatan" v-model="localForm.kecamatan" @change="loadDesa" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required :disabled="!localForm.kabupaten">
            <option value="">Pilih Kecamatan</option>
            <option v-for="kec in kecamatanList" :key="kec.id" :value="kec.id">{{ kec.name }}</option>
          </select>
          <div v-if="isLoadingKecamatan" class="text-sm text-green-600">Loading kecamatan...</div>
        </div>

        <!-- Desa -->
        <div class="space-y-2 mb-4">
          <label for="desa" class="block text-green-700 font-medium">Desa/Kelurahan:</label>
          <select id="desa" name="desa" v-model="localForm.desa" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required :disabled="!localForm.kecamatan">
            <option value="">Pilih Desa/Kelurahan</option>
            <option v-for="des in desaList" :key="des.id" :value="des.id">{{ des.name }}</option>
          </select>
          <div v-if="isLoadingDesa" class="text-sm text-green-600">Loading desa...</div>
        </div>

        <!-- Alamat Lengkap -->
        <div class="space-y-2 mb-4">
          <label for="alamat_lengkap" class="block text-green-700 font-medium">Alamat Lengkap:</label>
          <textarea id="alamat_lengkap" name="alamat_lengkap" v-model="localForm.alamat_lengkap" @input="onAlamatLengkapInput" rows="3" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Masukkan alamat lengkap (RT/RW, nama jalan, dll)" required></textarea>
        </div>

        <!-- Kode Pos -->
        <div class="space-y-2">
          <label for="kode_pos" class="block text-green-700 font-medium">Kode Pos:</label>
          <input type="text" id="kode_pos" name="kode_pos" v-model="localForm.kode_pos" maxlength="5" class="w-full px-4 py-2 border-2 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Masukkan kode pos" required />
        </div>
      </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="flex justify-end space-x-4 pt-6">
      <button type="button" @click="submitForm" class="px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors" :disabled="isSubmitting">
        {{ isSubmitting ? 'Memproses...' : 'Daftar Sekarang' }}
      </button>
    </div>
        </div>
      </div>
    </div>
  </div>
</template>