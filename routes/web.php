<?php

// web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Middleware\JwtAuthMiddleware;
use App\Http\Middleware\JwtAdminMiddleware;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\VaccineController;
use App\Http\Controllers\Admin\PrescriptionController;
use App\Http\Controllers\Admin\PetListController;
use App\Http\Controllers\Admin\PetOwnerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VetBranchController;
use App\Http\Controllers\Users\HomeController;
use App\Http\Controllers\Users\BookController;
use App\Http\Controllers\Users\PetAdoptController;
use App\Http\Controllers\Users\ServicesController;
use App\Http\Controllers\Users\ProfileController;
use App\Http\Controllers\Users\PatrolController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SSE\PetsSseController;
use App\Http\Controllers\SSE\AppointmentSseController;
use App\Http\Controllers\LandingPageController;

Route::get('/run-appointments', function () {
    Artisan::call('appointments:cancel-past');
    return "Appointments cancellation command executed!";
});
Route::get('/run-queue', function () {
    Artisan::call('queue:work --once');
    return "status' => 'Queue processed successfully.";
});

//Login and Sign Up for Pet Owners
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('auth.signup');
Route::post('/signup', [AuthController::class, 'register'])->name('auth.signup.post');
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::post('/user-logout', [AuthController::class, 'logout'])->name('auth.logout');

// Google OAuth Routes
Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

//Fill additional data
Route::get('/auth/fill-details/{google_id}', [GoogleController::class, 'showDetailsForm'])->name('auth.fill-details');
Route::get('auth/google/login', [GoogleController::class, 'loginWithGoogle'])->name('auth.google.login');
Route::post('/auth/save-details', [GoogleController::class, 'saveDetails'])->name('auth.save-details');

//Login for Admin
Route::get('/bfc/login', [AdminAuthController::class, 'index'])->name('admin.login');
Route::post('/bfc/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/bfc/logout', [AdminAuthController::class, 'adminLogout'])->name('admin.logout');

// routes/web.php
Route::post('/send-otp', [VerificationController::class, 'sendOTP'])->name('auth.send-otp');
Route::post('/verify-otp', [VerificationController::class, 'verifyOTP'])->name('auth.verify-otp');

Route::get('/privacy-policy', function () {
    return view('agree.privacy-policy');
})->name('privacy.policy');
Route::get('/terms&conditions', function () {
    return view('agree.terms&conditions');
})->name('terms.conditions');

//Guests
Route::get('/', [LandingPageController::class, 'index'])->name('landing.page');
Route::get('/services', [ServicesController::class, 'index'])->name('services.page');
Route::get('/about', function () {
    return view('about.about-us');
})->name('about.page');
Route::get('/contact', function () {
    return view('contact.contact');
})->name('contact.page');

//Admin
Route::middleware([JwtAdminMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/backup', [DashboardController::class, 'backup'])->name('admin.backup');

    // Appointment page
    Route::get('/sse/appointments', [AppointmentSseController::class, 'stream'])->name('appointments.sse.stream');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('admin.appointments');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('admin.appointments.store');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('admin.appointments.update');
    Route::get('/bfc-animalclinic-innersystem/appointments/{appointment}', [AppointmentController::class, 'show'])->name('admin.appointments.show');
    Route::delete('/bfc-animalclinic-innersystem/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');
    Route::get('/bfc-animalclinic-innersystem/fetch-owners', [AppointmentController::class, 'fetchOwners'])->name('fetch.owners');
    Route::get('/bfc-animalclinic-innersystem/fetch-pets/{owner_id}', [AppointmentController::class, 'fetchPets'])->name('fetch.pets');
    Route::post('/appointments/update-status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

    // Service page
    Route::get('/service', [ServiceController::class, 'index'])->name('admin.services');
    Route::post('/services/store', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::get('/bfc-animalclinic-innersystem/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
    Route::put('/bfc-animalclinic-innersystem/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/bfc-animalclinic-innersystem/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');

    // Pets page
    Route::get('/sse/pets', [PetsSseController::class, 'stream']);
    Route::get('/pets', [PetController::class, 'index'])->name('admin.pets');
    Route::post('/pets/store', [App\Http\Controllers\Admin\PetController::class, 'store'])->name('admin.pets.store');
    Route::get('/fetch-owners', [PetController::class, 'fetchOwners'])->name('fetch.owners');
    Route::get('/pets/profile/{pet}', [PetController::class, 'show'])->name('admin.pets.profile');
    Route::put('/admin/pets/{id}', [PetController::class, 'update'])->name('admin.pets.update');
    Route::get('/bfc-animalclinic-innersystem/pets/{petId}', [PetController::class, 'show'])->name('admin.pet.show');
    Route::delete('/bfc-animalclinic-innersystem/pets/{id}', [PetController::class, 'destroy'])->name('admin.pets.destroy');
    Route::post('/vaccinations/store', [VaccineController::class, 'store'])->name('vaccinations.store');
    Route::post('/health/store', [PrescriptionController::class, 'store'])->name('health.store');
    Route::get('/prescription/{id}/download', [PrescriptionController::class, 'download'])->name('prescription.download');
    Route::post('/upload-signature', [PrescriptionController::class, 'upload'])->name('upload.signature');

    //Pet Listings
    Route::get('/pet-listings', [PetListController::class, 'index'])->name('admin.pet-listings');
    Route::post('/pet-listings', [PetListController::class, 'store'])->name('admin.pet-listings.store');
    Route::get('/pet-listings/{id}', [PetListController::class, 'show'])->name('admin.pet.profile');
    Route::put('/pet-update-listings/{id}', [PetListController::class, 'update'])->name('admin.pet-listing.update');
    Route::delete('/pet-listings/{id}', [PetListController::class, 'destroy'])->name('admin.pet-listing.destroy');

    // Owners page
    Route::get('/pet-owners', [PetOwnerController::class, 'index'])->name('admin.pet_owners');
    Route::post('/pet-owners', [PetOwnerController::class, 'store'])->name('admin.pet-owners.store');
    Route::delete('/pet-owners/{id}', [PetOwnerController::class, 'destroy'])->name('admin.pet-owners.destroy');

    // Users page
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/bfc-animalclinic-innersystem/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/bfc-animalclinic-innersystem/users/update/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/bfc-animalclinic-innersystem/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/bfc-animalclinic-innersystem/users/reset-password/{id}', [UserController::class, 'resetPassword'])->name('admin.users.reset-password');
    Route::post('/admin/change-password', [AdminAuthController::class, 'changePassword'])->name('admin.change-password');

    //Branches
    Route::get('/branches', [VetBranchController::class, 'index'])->name('admin.branches');
    Route::post('/branches', [VetBranchController::class, 'store'])->name('admin.branches.store');
    Route::get('/admin/branches/{id}', [VetBranchController::class, 'show']);
    Route::put('/admin/branches/{id}', [VetBranchController::class, 'update'])->name('admin.branches.update');
    Route::delete('/admin/branches/{id}', [VetBranchController::class, 'destroy'])->name('admin.branches.destroy');
});

//Pet Owners
Route::middleware([JwtAuthMiddleware::class])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.page');

    //Paw Care
    Route::get('/pawcare', [BookController::class, 'index'])->name('book.page');
    Route::get('/booked-pawcare', [BookController::class, 'showAppointments'])->name('appointments.page');
    Route::get('/search-services', [BookController::class, 'searchServices'])->name('search.services');
    Route::post('/booking/store', [BookController::class, 'store'])->name('booking.store');
    Route::get('/get-appointments', [BookController::class, 'fetchAppointments']);
    Route::get('/get-unavailable-timeslots', [BookController::class, 'getUnavailableTimeSlots']);

    //Pet Adopt Listing
    Route::get('/whisker-wishes', [PetAdoptController::class, 'index'])->name('adopt.page');
    Route::get('/pet-adopt/{id}', [PetAdoptController::class, 'show'])->name('pet.details');

    //Paw Patrol
    Route::get('/paw-patrol', [PatrolController::class, 'index'])->name('paw-patrol.page');

    //Profile
    Route::get('/pawfile', [ProfileController::class, 'index'])->name('profile.page');
    Route::get('/pawfile/add-pet', [ProfileController::class, 'addPet'])->name('addpet.page');
    Route::get('/my-pets', [ProfileController::class, 'myPet'])->name('mypets.page');
    Route::post('/pawfile/store', [ProfileController::class, 'storePet'])->name('pet.store');
    Route::delete('/release-pet/{id}', [ProfileController::class, 'destroyPet'])->name('pet.destroy');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
