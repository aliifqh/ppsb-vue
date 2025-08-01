<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')->constrained('pembayaran')->cascadeOnDelete();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();

            // Detail transaksi
            $table->decimal('jumlah_bayar', 12, 2);
            $table->enum('metode_pembayaran', ['transfer', 'tunai']);
            $table->string('nomor_referensi')->nullable(); // Nomor transaksi bank/QRIS
            $table->string('bukti_transaksi')->nullable(); // File bukti

            // Status dan verifikasi
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tgl_transaksi');
            $table->timestamp('tgl_verifikasi')->nullable();

            // Catatan
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pembayaran');
    }
};
