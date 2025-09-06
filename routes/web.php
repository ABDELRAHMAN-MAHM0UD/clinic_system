<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AppointmentBookedMail;
use App\Models\Appointment;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

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
    Route::get('/admindashboard', [AdminController::class, 'index'])->name('admindashboard');

    // Doctors
    Route::get('/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
    Route::get('/doctors/create', [AdminController::class, 'createDoctor'])->name('admin.doctors.create');
    Route::post('/doctors/store', [AdminController::class, 'storeDoctor'])->name('admin.doctors.store');
    Route::get('/doctors/{id}', [AdminController::class, 'doctorShow'])->name('admin.doctor.show');

    // Patients
    Route::get('/patients', [AdminController::class, 'patients'])->name('admin.patients');

    // Invoices
    Route::get('/invoices', [PatientController::class, 'AdminInvoices'])->name('admin.invoices');

    // Appointments
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::get('/appointments/{appointment}/edit', [AdminController::class, 'appointmentsEdit'])->name('admin.appointments.edit');
    Route::put('/appointments/{appointment}', [AdminController::class, 'appointmentsUpdate'])->name('admin.appointments.update');
    Route::delete('/appointments/{appointment}', [AdminController::class, 'appointmentsDestroy'])->name('admin.appointments.destroy');

});

// ==================================
// Patients Routes
// ==================================
Route::prefix('patient')->middleware(['auth', 'verified'])->group(function () {

    // Dashboard 
    Route::get('/dashboard', [PatientController::class, 'index'])->name('patientDashboard');

    // Doctors
    Route::get('/doctors', [PatientController::class, 'doctors'])->name('patient.doctors');
    Route::get('/doctors/{id}', [PatientController::class, 'doctorShow'])->name('patient.doctor.show');

    // Invoices
    Route::get('/invoices', [PatientController::class, 'userInvoices'])->name('patient.invoices');

    // Appointments
    Route::get('/appointments', [PatientController::class, 'appointments'])->name('patient.appointments');
    Route::get('/appointments/available', [PatientController::class, 'availableSlots'])->name('patient.appointments.available');
    Route::post('/appointments', [PatientController::class, 'appointmentsStore'])->name('patient.appointments.store');
    Route::delete('/appointments/{appointment}', [PatientController::class, 'appointmentsCancel'])->name('patient.appointments.cancel');

    // Medical History
    Route::get('/medical_history', [PatientController::class, 'medicalHis'])->name('patient.medical_history');

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

// Test email route
Route::get('/test-mail', function () {
    try {
        config(['mail.mailers.smtp.verify_peer' => false]);
        config(['mail.mailers.smtp.verify_peer_name' => false]);
        
        $debug = [];
        $debug['config'] = config('mail');
        
        Log::info('Starting email test...');
        
        // Send test email with timestamp to avoid duplicate filtering
        $timestamp = now()->format('Y-m-d H:i:s');
        Mail::raw("Test email from clinic system at {$timestamp}", function($message) use ($timestamp) {
            $message->to('ziadelmaghraby0@gmail.com')
                    ->subject("Test Email {$timestamp}")
                    ->priority(1);
        });
        
        $debug['success'] = true;
        $debug['time'] = $timestamp;
        
        Log::info('Email test completed', $debug);
        
        return response()->json($debug);
    } catch (\Exception $e) {
        Log::error('Email test failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'config' => config('mail')
        ], 500);
    }
});
