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
        Schema::create('gelombang_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gelombang_id')->constrained('gelombangs')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->integer('kuota_maksimal')->default(100);
            $table->integer('kuota_terisi')->default(0);
            $table->decimal('biaya_administrasi', 10, 2);
            $table->decimal('biaya_daftar_ulang', 10, 2);
            $table->boolean('aktif')->default(true);
            $table->json('persyaratan_khusus')->nullable(); // Persyaratan khusus untuk unit ini di gelombang ini
            $table->json('diskon')->nullable(); // Diskon khusus untuk unit ini di gelombang ini
            $table->timestamps();

            // Unique constraint untuk mencegah duplikasi
            $table->unique(['gelombang_id', 'unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gelombang_unit');
    }
}; 