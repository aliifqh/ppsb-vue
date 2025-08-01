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
        Schema::create('gelombangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique(); // GEL-001, GEL-002, etc
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            // Biaya per gelombang
            $table->unsignedBigInteger('biaya_administrasi');
            $table->unsignedBigInteger('biaya_daftar_ulang');

            // Kuota dan status
            $table->integer('kuota_maksimal')->nullable();
            $table->integer('kuota_terisi')->default(0);
            $table->enum('status', ['aktif', 'nonaktif', 'selesai'])->default('aktif');
            $table->text('deskripsi')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gelombangs');
    }
};
