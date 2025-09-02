<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
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
    Route::get('/admindashboard', [AdminController::class, 'index'])->name('adminDashboard');

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
    Route::get('/appointments', [AdminController::class, 'appointments'])->name(name: 'admin.appointments');

    //Appointments
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::get('/appointments/{appointment}/edit', [AdminController::class, 'appointmentsEdit'])->name('admin.appointments.edit');
    Route::put('/appointments/{appointment}', [AdminController::class, 'appointmentsUpdate'])->name('admin.appointments.update');
    Route::delete('/appointments/{appointment}', [AdminController::class, 'appointmentsDestroy'])->name('admin.appointments.destroy');

});

// ==================================
// Patients Routes
// ==================================

Route::prefix('patient')->middleware(['auth', 'verified'])->group(function () {

    //  Dashboard 
    Route::get('/dashboard', [PatientController::class, 'index'])->name('patientDashboard');

    // Doctors
    Route::get('/doctors', [PatientController::class, 'doctors'])->name('patient.doctors');
   Route::get('/doctors/{id}', [PatientController::class, 'doctorShow'])->name('patient.doctor.show');

    // Invoices
    Route::get('/invoices', [PatientController::class, 'invoices'])->name('patient.invoices');

    // Appointments
    Route::get('/appointments', [PatientController::class, 'appointments'])->name(name: 'patient.appointments');

    // medical history
        Route::get('/medical_history', [PatientController::class, 'medicalHis'])->name(name: 'patient.medical_history');

    //Appointments
    Route::get('/appointments', [PatientController::class, 'appointments'])->name('patient.appointments'); // list + book form
    Route::get('/appointments/available', [PatientController::class, 'availableSlots'])->name('patient.appointments.available'); // JSON slots
    Route::post('/appointments', [PatientController::class, 'appointmentsStore'])->name('patient.appointments.store');
    Route::delete('/appointments/{appointment}', [PatientController::class, 'appointmentsCancel'])->name('patient.appointments.cancel');

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
