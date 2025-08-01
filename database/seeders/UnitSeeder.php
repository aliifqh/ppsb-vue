<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'kode' => 'ppim',
                'nama' => 'PPIM',
                'deskripsi' => 'Pondok Pesantren Islam Modern untuk lulusan SD/MI',
                'jenjang' => 'SMP',
                'usia_minimal' => 10,
                'usia_maksimal' => 14,
                'aktif' => true,
                'urutan' => 1,
                'persyaratan' => [
                    'Lulus SD/MI',
                    'Usia minimal 10 tahun',
                    'Membaca Al-Quran',
                    'Surat keterangan sehat',
                    'Akta kelahiran',
                    'Kartu keluarga',
                    'Ijazah SD/MI',
                ],
                'biaya' => [
                    'administrasi' => 500000,
                    'daftar_ulang' => 2000000,
                    'spp_bulanan' => 500000,
                    'makan' => 300000,
                    'asrama' => 200000,
                ],
            ],
            [
                'kode' => 'tks',
                'nama' => 'TKS',
                'deskripsi' => 'Taman Kanak-Kanak Santri untuk anak usia dini',
                'jenjang' => 'TK',
                'usia_minimal' => 4,
                'usia_maksimal' => 6,
                'aktif' => true,
                'urutan' => 2,
                'persyaratan' => [
                    'Usia minimal 4 tahun',
                    'Surat keterangan sehat',
                    'Akta kelahiran',
                    'Kartu keluarga',
                    'Foto 3x4 (2 lembar)',
                ],
                'biaya' => [
                    'administrasi' => 300000,
                    'daftar_ulang' => 1500000,
                    'spp_bulanan' => 300000,
                    'makan' => 200000,
                ],
            ],
            [
                'kode' => 'sma',
                'nama' => 'SMA',
                'deskripsi' => 'Sekolah Menengah Atas untuk lulusan SMP/MTs',
                'jenjang' => 'SMA',
                'usia_minimal' => 14,
                'usia_maksimal' => 18,
                'aktif' => false, // Belum aktif, untuk masa depan
                'urutan' => 3,
                'persyaratan' => [
                    'Lulus SMP/MTs',
                    'Usia minimal 14 tahun',
                    'Membaca Al-Quran',
                    'Surat keterangan sehat',
                    'Akta kelahiran',
                    'Kartu keluarga',
                    'Ijazah SMP/MTs',
                    'SKHUN',
                ],
                'biaya' => [
                    'administrasi' => 750000,
                    'daftar_ulang' => 2500000,
                    'spp_bulanan' => 600000,
                    'makan' => 350000,
                    'asrama' => 250000,
                ],
            ],
            [
                'kode' => 'smk',
                'nama' => 'SMK',
                'deskripsi' => 'Sekolah Menengah Kejuruan untuk lulusan SMP/MTs',
                'jenjang' => 'SMK',
                'usia_minimal' => 14,
                'usia_maksimal' => 18,
                'aktif' => false, // Belum aktif, untuk masa depan
                'urutan' => 4,
                'persyaratan' => [
                    'Lulus SMP/MTs',
                    'Usia minimal 14 tahun',
                    'Membaca Al-Quran',
                    'Surat keterangan sehat',
                    'Akta kelahiran',
                    'Kartu keluarga',
                    'Ijazah SMP/MTs',
                    'SKHUN',
                ],
                'biaya' => [
                    'administrasi' => 800000,
                    'daftar_ulang' => 3000000,
                    'spp_bulanan' => 700000,
                    'makan' => 350000,
                    'asrama' => 250000,
                    'praktikum' => 500000,
                ],
            ],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
} 