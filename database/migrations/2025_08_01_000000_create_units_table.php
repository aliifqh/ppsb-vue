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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // ppim, tks, sma, smk, dll
            $table->string('nama'); // PPIM, TKS, SMA, SMK, dll
            $table->text('deskripsi')->nullable();
            $table->string('jenjang'); // SD, SMP, SMA, SMK, dll
            $table->integer('usia_minimal')->default(10);
            $table->integer('usia_maksimal')->default(18);
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(1);
            $table->json('persyaratan')->nullable(); // Persyaratan khusus unit
            $table->json('biaya')->nullable(); // Biaya per unit
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
}; 