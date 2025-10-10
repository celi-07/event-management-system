<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Route::middleware(['web','auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');