<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->foreignId('gelombang_id')->constrained('gelombangs')->cascadeOnDelete();

                        // Jenis pembayaran dan nominal
            $table->enum('jenis', ['administrasi', 'daftar_ulang']);
            $table->decimal('nominal', 12, 2); // Nominal yang harus dibayar
            $table->decimal('dibayar', 12, 2)->default(0); // Nominal yang sudah dibayar
            $table->decimal('sisa', 12, 2); // Sisa yang belum dibayar

            // Status dan verifikasi
            $table->enum('status', ['belum', 'sebagian', 'lunas', 'verifikasi'])->default('belum');
            $table->string('bukti_pembayaran')->nullable(); // File bukti dari santri
            $table->string('bukti_verifikasi')->nullable(); // File bukti dari admin
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tgl_bayar')->nullable();
            $table->timestamp('tgl_verifikasi')->nullable();

            // Catatan dan metadata
            $table->text('catatan_santri')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->json('metadata')->nullable(); // Untuk data tambahan

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
