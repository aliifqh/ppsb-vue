<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Gelombang;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'aliifqh',
            'email' => 'aliifqh@almukmin.sch.id',
            'password' => bcrypt('mamalemon'),
        ]);

        // Create sample gelombangs
        Gelombang::create([
            'nama' => 'Gelombang 1 - Early Bird',
            'kode' => 'GEL-001',
            'tanggal_mulai' => '2025-01-01',
            'tanggal_selesai' => '2025-03-31',
            'biaya_administrasi' => 500000,
            'biaya_daftar_ulang' => 2000000,
            'kuota_maksimal' => 100,
            'kuota_terisi' => 0,
            'status' => 'aktif',
            'deskripsi' => 'Gelombang pendaftaran awal dengan diskon khusus',
        ]);

        Gelombang::create([
            'nama' => 'Gelombang 2 - Regular',
            'kode' => 'GEL-002',
            'tanggal_mulai' => '2025-04-01',
            'tanggal_selesai' => '2025-06-30',
            'biaya_administrasi' => 750000,
            'biaya_daftar_ulang' => 2500000,
            'kuota_maksimal' => 150,
            'kuota_terisi' => 0,
            'status' => 'aktif',
            'deskripsi' => 'Gelombang pendaftaran reguler',
        ]);

        Gelombang::create([
            'nama' => 'Gelombang 3 - Final',
            'kode' => 'GEL-003',
            'tanggal_mulai' => '2025-07-01',
            'tanggal_selesai' => '2025-08-31',
            'biaya_administrasi' => 1000000,
            'biaya_daftar_ulang' => 3000000,
            'kuota_maksimal' => 50,
            'kuota_terisi' => 0,
            'status' => 'aktif',
            'deskripsi' => 'Gelombang pendaftaran terakhir',
        ]);

        // Create additional users for testing
        User::factory(5)->create();

        // Seed Units dan Gelombang-Unit
        $this->call([
            UnitSeeder::class,
            GelombangUnitSeeder::class,
        ]);
    }
}
