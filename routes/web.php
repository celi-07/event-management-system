<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;

Route::get('/profile', function () {
    return view('profile', [
        'page' => 'Profile',
    ]);
})->name('profile');

Route::controller(EventController::class)->group(function () {
    Route::get('/discover', 'discover')->name('discover');
    Route::get('/events/{id}', 'getDetail')->name('events.show');
    Route::get('/create/events', 'getCreate')->name('create.events');
    Route::get('/events/{id}/edit', 'getEdit')->name('edit.events');
    Route::get('/my-events', 'getMyEvents')->name('my.events');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth', 'getAuth')->name('auth');
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(InvitationController::class)->group(function () {
    Route::get('/invitations', 'getInvitations')->name('invitations');
});

Route::get('/', [DashboardController::class, 'getMyData'])->name('dashboard');