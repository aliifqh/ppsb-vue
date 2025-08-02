<script setup lang="ts">
    import {
        watch,
        ref,
        reactive,
        onMounted,
        onUnmounted
    } from 'vue';
    import {
        router,
        Head
    } from '@inertiajs/vue3';
    import flatpickr from 'flatpickr';
    import 'flatpickr/dist/flatpickr.css';
    import PublicLayout from '@/layouts/PublicLayout.vue';

    import {
        useFixedTheme
    } from '@/composables/useAppearance';

    useFixedTheme('light');

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
        biaya: Record < string,
        number > ;
        kuota_maksimal: number;
        kuota_terisi: number;
        sisa_kuota: number;
        biaya_administrasi: number;
        biaya_daftar_ulang: number;
        persyaratan_khusus: string[];
        diskon: Record < string,
        any > ;
    }

    defineProps < {
        gelombangAktif ? : any;
        units ? : Unit[];
        error ? : string;
    } > ();


    const isSubmitting = ref(false);

    // Initialize form data
    const localForm = reactive < FormData > ({
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
    const provinsiList = ref < Array < {
        id: string,
        name: string
    } >> ([]);
    const kabupatenList = ref < Array < {
        id: string,
        name: string
    } >> ([]);
    const kecamatanList = ref < Array < {
        id: string,
        name: string
    } >> ([]);
    const desaList = ref < Array < {
        id: string,
        name: string
    } >> ([]);
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
            const response = await fetch(
                `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${localForm.provinsi}.json`);
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
            const response = await fetch(
                `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${localForm.kabupaten}.json`);
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
            const response = await fetch(
                `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${localForm.kecamatan}.json`);
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
                        shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep',
                            'Okt', 'Nov', 'Des'
                        ],
                        longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                            'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ]
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
        }, {
            immediate: true
        }
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
    <PublicLayout>

        <Head title="Formulir Pendaftaran Santri" />

        <!-- Error State -->
        <div v-if="error"
            class="min-h-screen bg-gradient-to-br from-red-50 to-pink-50 flex items-center justify-center p-4">
            <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center">
                <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Pendaftaran Ditutup</h1>
                <p class="text-gray-600 mb-6">{{ error }}</p>
                <a href="/"
                    class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Main Form -->
        <div v-else
            class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-8">
            <div class="max-w-4xl mx-auto px-4">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        📝 Formulir Pendaftaran Santri
                    </h1>
                </div>

                <!-- Form Component -->
                <div
                    class="bg-white/70 dark:bg-white/10 backdrop-blur-xl rounded-2xl border border-white/30 dark:border-white/20 shadow-2xl p-8">
                    <form @submit.prevent="submitForm" class="space-y-8">
                        <div v-if="gelombangAktif"
                            class="mt-5 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800 shadow-lg">
                            <div class="flex items-center gap-4 mb-2">


                                <div class="flex-1">
                                    <p class="text-blue-700 dark:text-blue-300 font-semibold text-lg">
                                        {{ gelombangAktif . nama }}
                                    </p>
                                    <div v-if="gelombangAktif.tanggal_mulai && gelombangAktif.tanggal_selesai"
                                        class="flex items-center gap-2 mt-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-xs text-blue-600 dark:text-blue-400">
                                            Periode:
                                            {{ gelombangAktif . tanggal_mulai ? new Date(gelombangAktif . tanggal_mulai) . toLocaleDateString('id-ID') : '' }}
                                            -
                                            {{ gelombangAktif . tanggal_selesai ? new Date(gelombangAktif . tanggal_selesai) . toLocaleDateString('id-ID') : '' }}
                                        </span>
                                    </div>
                                    <div v-if="gelombangAktif.tanggal_selesai" class="flex items-center gap-2 mt-1">
                                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-xs text-orange-600 dark:text-orange-400 font-medium">
                                            ⏰ Sisa waktu:
                                            {{ gelombangAktif . tanggal_selesai ? Math . ceil((new Date(gelombangAktif . tanggal_selesai) . getTime() - new Date() . getTime()) / (1000 * 60 * 60 * 24)) : 0 }}
                                            hari lagi
                                        </span>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center gap-2 bg-blue-100 dark:bg-blue-800/50 px-3 py-2 rounded-lg">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Aktif</span>
                                </div>
                            </div>

                            <!-- Informasi Biaya -->
                            <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-blue-200 dark:border-blue-700">
                            <div class="bg-white/50 dark:bg-white/10 rounded-xl p-4 border border-blue-100 dark:border-blue-800">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Biaya Administrasi</p>
                                        <p class="text-lg font-bold text-blue-900 dark:text-blue-100">
                                            Rp {{ new Intl() . NumberFormat('id-ID') . format(Number(gelombangAktif . biaya_administrasi) || 0) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white/50 dark:bg-white/10 rounded-xl p-4 border border-blue-100 dark:border-blue-800">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Biaya Daftar Ulang</p>
                                        <p class="text-lg font-bold text-blue-900 dark:text-blue-100">
                                            Rp {{ new Intl() . NumberFormat('id-ID') . format(Number(gelombangAktif . biaya_daftar_ulang) || 0) }}
                                        </p>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <!-- Total Biaya -->
                        <!-- <div class="mt-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-green-700 dark:text-green-300 font-medium">Total Biaya Pendaftaran</p>
                                        <p class="text-xl font-bold text-green-800 dark:text-green-200">
                                            Rp {{ new Intl() . NumberFormat('id-ID') . format((Number(gelombangAktif . biaya_administrasi) || 0) + (Number(gelombangAktif . biaya_daftar_ulang) || 0)) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-green-600 dark:text-green-400">💡 Hemat & Terjangkau</p>
                                </div>
                            </div>
                        </div>
                    </div> -->

                        <!-- Unit Selection -->
                        <div class="space-y-4">
                            <label class="block text-gray-700 dark:text-gray-200 font-medium text-lg">Pilihan
                                Unit:</label>
                            <div class="space-y-2">
                                <label v-for="unit in units || []" :key="unit.id" class="relative block">
                                    <input type="radio" name="unit" :value="unit.kode" v-model="localForm.unit"
                                        class="peer sr-only" required :disabled="unit.sisa_kuota <= 0" />
                                    <div class="p-4 border-2 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 hover:border-blue-400 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all duration-200 shadow-sm"
                                        :class="{ 'opacity-50 cursor-not-allowed': unit.sisa_kuota <=
                                            0, 'ring-2 ring-blue-200 dark:ring-blue-800 shadow-md': localForm.unit ===
                                                unit.kode }">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <!-- Radio Button -->
                                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600 peer-checked:border-blue-600 peer-checked:bg-blue-600 flex items-center justify-center transition-all duration-200 shadow-sm"
                                                    :class="{ 'border-blue-600 bg-blue-600 ring-2 ring-blue-200 dark:ring-blue-800': localForm
                                                            .unit === unit.kode }">
                                                    <svg v-if="localForm.unit === unit.kode"
                                                        class="w-3 h-3 text-white" fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                        style="filter: drop-shadow(0 1px 2px rgba(0,0,0,0.5));">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>

                                                <!-- Unit Info -->
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">
                                                        {{ unit . nama }}</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        Kuota: <span
                                                            :class="unit.sisa_kuota <= 5 ?
                                                                'text-red-600 dark:text-red-400 font-bold' :
                                                                'text-green-600 dark:text-green-400'">
                                                            {{ unit . sisa_kuota }}/{{ unit . kuota_maksimal }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Selected indicator -->
                                            <div v-if="localForm.unit === unit.kode"
                                                class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded-lg">
                                                <svg class="w-5 h-5 drop-shadow-sm" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-sm font-medium">Dipilih</span>
                                            </div>
                                        </div>

                                        <!-- Warning jika kuota habis -->
                                        <div v-if="unit.sisa_kuota <= 0"
                                            class="mt-2 p-2 bg-red-100 dark:bg-red-900/30 rounded text-center">
                                            <span class="text-red-700 dark:text-red-300 font-bold text-sm">❌ Kuota
                                                Penuh</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Data Calon Santri -->
                        <div class="space-y-6">
                            <h3
                                class="text-xl font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3">
                                Data Calon Santri
                            </h3>

                            <div class="space-y-4">
                                <!-- Nama Lengkap -->
                                <div class="space-y-2">
                                    <label for="nama"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Nama
                                        Lengkap:</label>
                                    <input type="text" id="nama" name="nama" v-model="localForm.nama"
                                        @input="onNamaInput"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                                        placeholder="Masukkan nama lengkap sesuai ijazah" required />
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="space-y-2">
                                    <label for="jenis_kelamin"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Jenis
                                        Kelamin:</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" v-model="localForm.jenis_kelamin"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200 [&>option]:bg-white [&>option]:text-gray-900 dark:[&>option]:bg-gray-800 dark:[&>option]:text-white"
                                        required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="space-y-2">
                                    <label for="tempat_lahir"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Tempat
                                        Lahir:</label>
                                    <input type="text" id="tempat_lahir" name="tempat_lahir"
                                        v-model="localForm.tempat_lahir"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                                        placeholder="Masukkan kota/kabupaten tempat lahir" required />
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="space-y-2">
                                    <label for="tanggal_lahir"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Tanggal
                                        Lahir:</label>
                                    <input type="text" id="tanggal_lahir" name="tanggal_lahir"
                                        v-model="localForm.tanggal_lahir"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                                        placeholder="Pilih tanggal lahir" required readonly />
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Klik untuk memilih tanggal</p>
                                </div>

                                <!-- Asal Sekolah -->
                                <div class="space-y-2">
                                    <label for="asal_sekolah"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Asal
                                        Sekolah:</label>
                                    <input type="text" id="asal_sekolah" name="asal_sekolah"
                                        v-model="localForm.asal_sekolah"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                                        placeholder="Masukkan nama sekolah asal" required />
                                </div>

                                <!-- WhatsApp -->
                                <div class="space-y-2">
                                    <label for="whatsapp"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Nomor
                                        WhatsApp:</label>
                                    <input type="text" id="whatsapp" name="whatsapp"
                                        v-model="localForm.whatsapp" @input="onWhatsappInput" maxlength="15"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                                        placeholder="Contoh: 628123456789" required />
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Format otomatis: 62xxx</p>
                                </div>

                                <!-- Data Saudara -->
                                <div class="space-y-4">
                                    <label class="block text-gray-700 dark:text-gray-200 font-medium">Data
                                        Saudara:</label>
                                    <div
                                        class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Anak Ke -->
                                            <div class="space-y-2">
                                                <label class="block text-blue-700 dark:text-blue-300 font-medium">Anak
                                                    ke:</label>
                                                <div class="flex items-center gap-3">
                                                    <button type="button" @click="decrementNumber('anak_ke')"
                                                        class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-700 flex items-center justify-center transition-colors"
                                                        :class="{ 'opacity-50 cursor-not-allowed': localForm.anak_ke <= 1 }">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="number" name="anak_ke" v-model="localForm.anak_ke"
                                                        @input="onSaudaraInput"
                                                        class="w-20 text-center px-3 py-2 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200 appearance-none"
                                                        min="1" required readonly />
                                                    <button type="button" @click="incrementNumber('anak_ke')"
                                                        class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-700 flex items-center justify-center transition-colors"
                                                        :class="{ 'opacity-50 cursor-not-allowed': localForm.anak_ke >=
                                                                localForm.jumlah_saudara }">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Jumlah Saudara -->
                                            <div class="space-y-2">
                                                <label
                                                    class="block text-blue-700 dark:text-blue-300 font-medium">Jumlah
                                                    Saudara:</label>
                                                <div class="flex items-center gap-3">
                                                    <button type="button" @click="decrementNumber('jumlah_saudara')"
                                                        class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-700 flex items-center justify-center transition-colors"
                                                        :class="{ 'opacity-50 cursor-not-allowed': localForm.jumlah_saudara <=
                                                                localForm.anak_ke || localForm.jumlah_saudara <= 1 }">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="number" name="jumlah_saudara"
                                                        v-model="localForm.jumlah_saudara" @input="onSaudaraInput"
                                                        class="w-20 text-center px-3 py-2 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200 appearance-none"
                                                        min="1" required readonly />
                                                    <button type="button" @click="incrementNumber('jumlah_saudara')"
                                                        class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-700 flex items-center justify-center transition-colors"
                                                        :class="{ 'opacity-50 cursor-not-allowed': localForm.jumlah_saudara >=
                                                                20 }">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Orang Tua -->
                        <div class="space-y-6">
                            <h3
                                class="text-xl font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3">
                                Data Orang Tua
                            </h3>

                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label for="nama_ayah"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Nama Ayah:</label>
                                    <input type="text" id="nama_ayah" name="nama_ayah"
                                        v-model="localForm.nama_ayah" @input="onNamaAyahInput"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                                        placeholder="Masukkan nama lengkap ayah" required />
                                </div>
                                <div class="space-y-2">
                                    <label for="nama_ibu"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Nama Ibu:</label>
                                    <input type="text" id="nama_ibu" name="nama_ibu"
                                        v-model="localForm.nama_ibu" @input="onNamaIbuInput"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                                        placeholder="Masukkan nama lengkap ibu" required />
                                </div>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="space-y-6">
                            <h3
                                class="text-xl font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3">
                                Alamat
                            </h3>

                            <div class="space-y-4">
                                <!-- Provinsi -->
                                <div class="space-y-2">
                                    <label for="provinsi"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Provinsi:</label>
                                    <select id="provinsi" name="provinsi" v-model="localForm.provinsi"
                                        @change="loadKabupaten"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200 [&>option]:bg-white [&>option]:text-gray-900 dark:[&>option]:bg-gray-800 dark:[&>option]:text-white"
                                        required>
                                        <option value="">Pilih Provinsi</option>
                                        <option v-for="prov in provinsiList" :key="prov.id"
                                            :value="prov.id">{{ prov . name }}</option>
                                    </select>
                                    <div v-if="isLoadingProvinsi" class="text-sm text-blue-600 dark:text-blue-400">
                                        Loading provinsi...</div>
                                </div>

                                <!-- Kabupaten -->
                                <div class="space-y-2">
                                    <label for="kabupaten"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Kabupaten/Kota:</label>
                                    <select id="kabupaten" name="kabupaten" v-model="localForm.kabupaten"
                                        @change="loadKecamatan"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200 [&>option]:bg-white [&>option]:text-gray-900 dark:[&>option]:bg-gray-800 dark:[&>option]:text-white"
                                        required :disabled="!localForm.provinsi">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        <option v-for="kab in kabupatenList" :key="kab.id"
                                            :value="kab.id">{{ kab . name }}</option>
                                    </select>
                                    <div v-if="isLoadingKabupaten" class="text-sm text-blue-600 dark:text-blue-400">
                                        Loading kabupaten...</div>
                                </div>

                                <!-- Kecamatan -->
                                <div class="space-y-2">
                                    <label for="kecamatan"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Kecamatan:</label>
                                    <select id="kecamatan" name="kecamatan" v-model="localForm.kecamatan"
                                        @change="loadDesa"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200 [&>option]:bg-white [&>option]:text-gray-900 dark:[&>option]:bg-gray-800 dark:[&>option]:text-white"
                                        required :disabled="!localForm.kabupaten">
                                        <option value="">Pilih Kecamatan</option>
                                        <option v-for="kec in kecamatanList" :key="kec.id"
                                            :value="kec.id">{{ kec . name }}</option>
                                    </select>
                                    <div v-if="isLoadingKecamatan" class="text-sm text-blue-600 dark:text-blue-400">
                                        Loading kecamatan...</div>
                                </div>

                                <!-- Desa -->
                                <div class="space-y-2">
                                    <label for="desa"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Desa/Kelurahan:</label>
                                    <select id="desa" name="desa" v-model="localForm.desa"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200 [&>option]:bg-white [&>option]:text-gray-900 dark:[&>option]:bg-gray-800 dark:[&>option]:text-white"
                                        required :disabled="!localForm.kecamatan">
                                        <option value="">Pilih Desa/Kelurahan</option>
                                        <option v-for="des in desaList" :key="des.id"
                                            :value="des.id">{{ des . name }}</option>
                                    </select>
                                    <div v-if="isLoadingDesa" class="text-sm text-blue-600 dark:text-blue-400">Loading
                                        desa...</div>
                                </div>

                                <!-- Alamat Lengkap -->
                                <div class="space-y-2">
                                    <label for="alamat_lengkap"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Alamat
                                        Lengkap:</label>
                                    <textarea id="alamat_lengkap" name="alamat_lengkap" v-model="localForm.alamat_lengkap" @input="onAlamatLengkapInput"
                                        rows="3"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                                        placeholder="Masukkan alamat lengkap (RT/RW, nama jalan, dll)" required></textarea>
                                </div>

                                <!-- Kode Pos -->
                                <div class="space-y-2">
                                    <label for="kode_pos"
                                        class="block text-gray-700 dark:text-gray-200 font-medium">Kode Pos:</label>
                                    <input type="text" id="kode_pos" name="kode_pos"
                                        v-model="localForm.kode_pos" maxlength="5"
                                        class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                                        placeholder="Masukkan kode pos" required />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6">
                            <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-transparent disabled:opacity-50 disabled:cursor-not-allowed shadow-lg"
                                :disabled="isSubmitting">
                                <span v-if="isSubmitting" class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Memproses...
                                </span>
                                <span v-else>Daftar Sekarang</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
