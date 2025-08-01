<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();

            // Status pendaftaran
            $table->enum('status', [
                'draft',           // Masih mengisi formulir
                'submitted',       // Sudah submit formulir
                'review',          // Sedang direview admin
                'approved',        // Diterima
                'rejected',        // Ditolak
                'waitlist',        // Masuk waiting list
                'registered'       // Sudah daftar ulang
            ])->default('draft');

            // Progress pendaftaran
            $table->boolean('formulir_lengkap')->default(false);
            $table->boolean('dokumen_lengkap')->default(false);
            $table->boolean('pembayaran_lunas')->default(false);
            $table->boolean('verifikasi_admin')->default(false);

            // Timeline
            $table->timestamp('tgl_submit')->nullable();
            $table->timestamp('tgl_review')->nullable();
            $table->timestamp('tgl_approved')->nullable();
            $table->timestamp('tgl_registered')->nullable();

            // Admin yang handle
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');

            // Catatan
            $table->text('catatan_review')->nullable();
            $table->text('catatan_approval')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_pendaftaran');
    }
};
