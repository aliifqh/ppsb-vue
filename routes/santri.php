<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Santri\SantriController;

// Santri Routes
Route::prefix('santri')->name('santri.')->group(function () {
    Route::get('login', [SantriController::class, 'login'])->name('login');
    Route::post('check', [SantriController::class, 'check'])->name('check');
    Route::get('dashboard/{nomor_pendaftaran}', [SantriController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [SantriController::class, 'logout'])->name('logout');
});