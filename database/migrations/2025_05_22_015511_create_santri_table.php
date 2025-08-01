<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel 1: Data Santri
        Schema::create('santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gelombang_id')->nullable()->constrained('gelombangs')->onDelete('set null');
            $table->string('nomor_pendaftaran')->unique();
            $table->string('unit');
            $table->string('nama');
            $table->string('nisn', 10)->nullable();
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir'); // Changed to date for proper date handling
            $table->string('asal_sekolah');
            $table->integer('anak_ke');
            $table->integer('jumlah_saudara');
            $table->string('whatsapp'); // Added WhatsApp field
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabel 2: Data Orang Tua dan Alamat
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('wa_ayah')->nullable();
            $table->string('wa_ibu')->nullable();
            $table->string('penghasilan_ortu')->nullable();
            $table->string('provinsi_id');
            $table->string('kabupaten_id');
            $table->string('kecamatan_id');
            $table->string('desa_id');
            $table->text('alamat')->nullable();
            $table->string('kode_pos', 5);
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabel 3: Dokumen Santri (Struktur Baru yang Lebih Efektif)
        Schema::create('dokumen_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->enum('jenis', ['ktp', 'kk', 'akta', 'ijazah', 'foto', 'surat_sehat', 'lainnya']);
            $table->string('nama_file');
            $table->string('path');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_santri');
        Schema::dropIfExists('orang_tua');
        Schema::dropIfExists('santri');
    }
};
