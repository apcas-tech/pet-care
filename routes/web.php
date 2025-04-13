<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\User\Dashboard;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->prefix('pet-owner')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('user.dashboard');

    Route::view('/profile', 'livewire.user.profile')->name('user.profile');
});




require __DIR__ . '/auth.php';
