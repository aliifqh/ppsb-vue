<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\Santri\SantriController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('admin/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('santri', function () {
    return Inertia::render('admin/Santri');
})->middleware(['auth', 'verified'])->name('santri');

Route::get('pembayaran', function () {
    return Inertia::render('admin/Pembayaran');
})->middleware(['auth', 'verified'])->name('pembayaran');

Route::get('gelombang', function () {
    return Inertia::render('admin/Gelombang');
})->middleware(['auth', 'verified'])->name('gelombang');

Route::get('whatsapp-integrasi', function () {
    return Inertia::render('admin/WhatsappIntegrasi');
})->middleware(['auth', 'verified'])->name('whatsapp-integrasi');

//Public Routes

// Formulir Pendaftaran Routes
Route::get('formulir', [FormulirController::class, 'index'])->name('formulir.index');
Route::post('formulir', [FormulirController::class, 'store'])->name('formulir.store');
Route::get('formulir/success/{nomorPendaftaran}', [FormulirController::class, 'success'])->name('formulir.success');

// Santri Routes
Route::prefix('santri')->name('santri.')->group(function () {
    Route::get('login', [SantriController::class, 'login'])->name('login');
    Route::post('check', [SantriController::class, 'check'])->name('check');
    Route::get('dashboard/{nomor_pendaftaran}', [SantriController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [SantriController::class, 'logout'])->name('logout');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
