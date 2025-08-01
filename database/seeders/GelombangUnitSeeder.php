<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gelombang;
use App\Models\Unit;

class GelombangUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil gelombang dan unit yang sudah ada
        $gelombang1 = Gelombang::where('kode', 'GEL-001')->first();
        $gelombang2 = Gelombang::where('kode', 'GEL-002')->first();
        $gelombang3 = Gelombang::where('kode', 'GEL-003')->first();

        $ppim = Unit::where('kode', 'ppim')->first();
        $tks = Unit::where('kode', 'tks')->first();

        // Gelombang 1 - Early Bird (Diskon besar)
        if ($gelombang1 && $ppim) {
            $gelombang1->units()->attach($ppim->id, [
                'kuota_maksimal' => 50,
                'kuota_terisi' => 0,
                'biaya_administrasi' => 300000, // Diskon 40%
                'biaya_daftar_ulang' => 1500000, // Diskon 25%
                'aktif' => true,
                'persyaratan_khusus' => json_encode([
                    'Pendaftaran dibuka lebih awal',
                    'Diskon khusus early bird',
                    'Prioritas asrama'
                ]),
                'diskon' => json_encode([
                    'administrasi' => 40,
                    'daftar_ulang' => 25,
                    'keterangan' => 'Early Bird Discount'
                ])
            ]);
        }

        if ($gelombang1 && $tks) {
            $gelombang1->units()->attach($tks->id, [
                'kuota_maksimal' => 30,
                'kuota_terisi' => 0,
                'biaya_administrasi' => 200000, // Diskon 33%
                'biaya_daftar_ulang' => 1000000, // Diskon 33%
                'aktif' => true,
                'persyaratan_khusus' => json_encode([
                    'Pendaftaran dibuka lebih awal',
                    'Diskon khusus early bird',
                    'Prioritas asrama'
                ]),
                'diskon' => json_encode([
                    'administrasi' => 33,
                    'daftar_ulang' => 33,
                    'keterangan' => 'Early Bird Discount'
                ])
            ]);
        }

        // Gelombang 2 - Regular (Diskon sedang)
        if ($gelombang2 && $ppim) {
            $gelombang2->units()->attach($ppim->id, [
                'kuota_maksimal' => 75,
                'kuota_terisi' => 0,
                'biaya_administrasi' => 400000, // Diskon 20%
                'biaya_daftar_ulang' => 1800000, // Diskon 10%
                'aktif' => true,
                'persyaratan_khusus' => json_encode([
                    'Pendaftaran reguler',
                    'Diskon sedang',
                    'Asrama tersedia'
                ]),
                'diskon' => json_encode([
                    'administrasi' => 20,
                    'daftar_ulang' => 10,
                    'keterangan' => 'Regular Discount'
                ])
            ]);
        }

        if ($gelombang2 && $tks) {
            $gelombang2->units()->attach($tks->id, [
                'kuota_maksimal' => 45,
                'kuota_terisi' => 0,
                'biaya_administrasi' => 250000, // Diskon 17%
                'biaya_daftar_ulang' => 1250000, // Diskon 17%
                'aktif' => true,
                'persyaratan_khusus' => json_encode([
                    'Pendaftaran reguler',
                    'Diskon sedang',
                    'Asrama tersedia'
                ]),
                'diskon' => json_encode([
                    'administrasi' => 17,
                    'daftar_ulang' => 17,
                    'keterangan' => 'Regular Discount'
                ])
            ]);
        }

        // Gelombang 3 - Final (Harga normal)
        if ($gelombang3 && $ppim) {
            $gelombang3->units()->attach($ppim->id, [
                'kuota_maksimal' => 25,
                'kuota_terisi' => 0,
                'biaya_administrasi' => 500000, // Harga normal
                'biaya_daftar_ulang' => 2000000, // Harga normal
                'aktif' => true,
                'persyaratan_khusus' => json_encode([
                    'Pendaftaran terakhir',
                    'Kuota terbatas',
                    'Asrama sesuai ketersediaan'
                ]),
                'diskon' => json_encode([
                    'administrasi' => 0,
                    'daftar_ulang' => 0,
                    'keterangan' => 'Harga Normal'
                ])
            ]);
        }

        if ($gelombang3 && $tks) {
            $gelombang3->units()->attach($tks->id, [
                'kuota_maksimal' => 15,
                'kuota_terisi' => 0,
                'biaya_administrasi' => 300000, // Harga normal
                'biaya_daftar_ulang' => 1500000, // Harga normal
                'aktif' => true,
                'persyaratan_khusus' => json_encode([
                    'Pendaftaran terakhir',
                    'Kuota terbatas',
                    'Asrama sesuai ketersediaan'
                ]),
                'diskon' => json_encode([
                    'administrasi' => 0,
                    'daftar_ulang' => 0,
                    'keterangan' => 'Harga Normal'
                ])
            ]);
        }
    }
} 