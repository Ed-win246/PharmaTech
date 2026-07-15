<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('/pharmacies', [PharmacyController::class, 'dashboard'])->name('pharmacies');
    Route::post('/pharmacies',[PharmacyController::class,'store'])->name('pharmacies.store');
    Route::put('/pharmacies/{pharmacy}',[PharmacyController::class,'update'])->name('pharmacies.update');
    Route::delete('/pharmacies/{pharmacy}',[PharmacyController::class,'destroy'])->name('pharmacies.destroy');
});

require __DIR__.'/settings.php';
