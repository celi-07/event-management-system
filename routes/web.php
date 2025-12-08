<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;

// Route::middleware(['web','auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });

Route::get('/profile', function () {
    return view('profile', [
        'page' => 'Profile',
    ]);
})->name('profile');

Route::controller(EventController::class)->group(function () {
    Route::get('/', 'getMyData')->name('dashboard');
    Route::get('/discover', 'discover')->name('discover');
    Route::get('/events/{id}', 'getDetail')->name('events.show');
    Route::get('/create/events', 'getCreate')->name('create.events');
    Route::get('/events/{id}/edit', 'getEdit')->name('edit.events');
    Route::get('/my-events', 'getMyEvents')->name('my.events');
});

Route::get('/invitations', [InvitationController::class, 'getInvitations'])->name('invitations');
Route::get('/auth', [AuthController::class, 'getAuth'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');