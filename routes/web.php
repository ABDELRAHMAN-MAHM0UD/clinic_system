<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==================================
// Public / Welcome Route
// ==================================
Route::get('/', function () {
    return view('welcome');
});

// ==================================
// Authenticated Dashboard
// ==================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==================================
// Admin Routes
// ==================================
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('adminDashboard');

    // Doctors
    Route::get('/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
    Route::get('/doctors/create', [AdminController::class, 'createDoctor'])->name('admin.doctors.create');
    Route::post('/doctors/store', [AdminController::class, 'storeDoctor'])->name('admin.doctors.store');
    Route::get('/doctors/{id}', [AdminController::class, 'doctorShow'])->name('admin.doctor.show');

    // Patients
    Route::get('/patients', [AdminController::class, 'patients'])->name('admin.patients');

    // Invoices
    Route::get('/invoices', [AdminController::class, 'invoices'])->name('admin.invoices');

    // Appointments
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
});

// ==================================
// Profile Routes
// ==================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================================
// Auth routes
// ==================================
require __DIR__.'/auth.php';
