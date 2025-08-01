<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FormulirController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('admin/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('santri', function () {
    return Inertia::render('admin/Santri');
})->middleware(['auth', 'verified'])->name('santri');

// Formulir Pendaftaran Routes
Route::get('formulir', [FormulirController::class, 'index'])->name('formulir.index');
Route::post('formulir', [FormulirController::class, 'store'])->name('formulir.store');
Route::get('formulir/success/{nomorPendaftaran}', [FormulirController::class, 'success'])->name('formulir.success');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
