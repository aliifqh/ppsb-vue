<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Santri;
use App\Models\OrangTua;
use App\Models\StatusPendaftaran;
use App\Models\Gelombang;

class SantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil gelombang pertama untuk testing
        $gelombang = Gelombang::first();
        if (!$gelombang) {
            $this->command->error('Gelombang tidak ditemukan! Jalankan GelombangSeeder terlebih dahulu.');
            return;
        }

        // Data santri dummy untuk testing dengan format yang sesuai
        $santriData = [
            [
                'gelombang_id' => $gelombang->id,
                'unit' => 'SD',
                'nama' => 'Ahmad Fadillah',
                'nisn' => '1234567890',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2015-05-15',
                'asal_sekolah' => 'SDN Jakarta 01',
                'anak_ke' => 1,
                'jumlah_saudara' => 2,
                'whatsapp' => '081234567890',
            ],
            [
                'gelombang_id' => $gelombang->id,
                'unit' => 'SMP',
                'nama' => 'Siti Nurhaliza',
                'nisn' => '1234567891',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2012-08-20',
                'asal_sekolah' => 'SMPN 1 Bandung',
                'anak_ke' => 2,
                'jumlah_saudara' => 3,
                'whatsapp' => '081234567891',
            ],
            [
                'gelombang_id' => $gelombang->id,
                'unit' => 'SMA',
                'nama' => 'Muhammad Rizki',
                'nisn' => '1234567892',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2009-12-10',
                'asal_sekolah' => 'SMAN 1 Surabaya',
                'anak_ke' => 1,
                'jumlah_saudara' => 1,
                'whatsapp' => '081234567892',
            ],
            [
                'gelombang_id' => $gelombang->id,
                'unit' => 'SMK',
                'nama' => 'Fatimah Azzahra',
                'nisn' => '1234567893',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2009-03-25',
                'asal_sekolah' => 'SMKN 1 Yogyakarta',
                'anak_ke' => 3,
                'jumlah_saudara' => 4,
                'whatsapp' => '081234567893',
            ],
            [
                'gelombang_id' => $gelombang->id,
                'unit' => 'SD',
                'nama' => 'Abdullah Rahman',
                'nisn' => '1234567894',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2014-07-08',
                'asal_sekolah' => 'SDN Semarang 05',
                'anak_ke' => 2,
                'jumlah_saudara' => 2,
                'whatsapp' => '081234567894',
            ],
        ];

        foreach ($santriData as $data) {
            // Buat santri (nomor pendaftaran akan di-generate otomatis)
            $santri = Santri::create($data);

            // Buat data orang tua untuk setiap santri
            OrangTua::create([
                'santri_id' => $santri->id,
                'nama_ayah' => 'Ayah ' . $santri->nama,
                'nama_ibu' => 'Ibu ' . $santri->nama,
                'pekerjaan_ayah' => 'Wiraswasta',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'pendidikan_ayah' => 'SMA',
                'pendidikan_ibu' => 'SMA',
                'wa_ayah' => '081234567890',
                'wa_ibu' => '081234567890',
                'alamat' => 'Jl. Contoh No. 123, Kota ' . $santri->tempat_lahir,
                'penghasilan_ortu' => '2000000-3000000',
                'provinsi_id' => '32',
                'kabupaten_id' => '3201',
                'kecamatan_id' => '320101',
                'desa_id' => '32010101',
                'kode_pos' => '12345',
            ]);

            // Buat status pendaftaran
            StatusPendaftaran::create([
                'santri_id' => $santri->id,
                'status' => 'submitted',
                'formulir_lengkap' => true,
                'dokumen_lengkap' => false,
                'pembayaran_lunas' => false,
                'verifikasi_admin' => false,
                'tgl_submit' => now(),
            ]);
        }

        $this->command->info('🎉 Data santri dummy berhasil dibuat!');
        $this->command->info('📋 Total santri yang dibuat: ' . count($santriData));
        $this->command->info('🔑 Kode unik untuk testing (4 huruf terakhir nomor pendaftaran):');
        
        // Tampilkan kode unik untuk testing
        $santriList = Santri::latest()->take(5)->get();
        foreach ($santriList as $santri) {
            $kodeUnik = substr($santri->nomor_pendaftaran, -4);
            $this->command->info("   • {$santri->nama} ({$santri->unit}): {$kodeUnik}");
        }
        
        $this->command->info('💡 Contoh login: Kode = ABCD, Nama = Ahmad Fadillah');
    }
} 