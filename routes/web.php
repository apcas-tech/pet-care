<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\User\Dashboard;
use App\Livewire\Admin\Dashboard as AdminDashboard;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->prefix('pet-owner')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('user.dashboard');

    Route::view('/profile', 'livewire.user.profile')->name('user.profile');
});

Route::prefix('bfc-clinic')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
});


require __DIR__ . '/auth.php';
