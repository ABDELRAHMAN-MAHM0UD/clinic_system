<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::get('/adminDashboard', [AdminController::class, 'index'])->name('adminDashboard');

Route::get('/admin/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
Route::get('/admin/patients', [AdminController::class, 'patients'])->name('admin.patients');
Route::get('/admin/invoices', [AdminController::class, 'invoices'])->name('admin.invoices');
Route::get('/admin/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
