<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('admin/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('santri', function () {
    return Inertia::render('admin/Santri');
})->middleware(['auth', 'verified'])->name('santri');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
