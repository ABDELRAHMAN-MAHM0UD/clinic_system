<?php

use App\Http\Controllers\StaticPagesController;
use Illuminate\Support\Facades\Route;

// About Section Routes
Route::get('/about', [StaticPagesController::class, 'about'])->name('about');
Route::get('/mission', [StaticPagesController::class, 'mission'])->name('mission');
Route::get('/team', [StaticPagesController::class, 'team'])->name('team');
Route::get('/careers', [StaticPagesController::class, 'careers'])->name('careers');

// Services Section Routes
Route::get('/services', [StaticPagesController::class, 'services'])->name('services');
Route::get('/services/emergency', [StaticPagesController::class, 'emergency'])->name('services.emergency');
Route::get('/services/specialties', [StaticPagesController::class, 'specialties'])->name('services.specialties');
Route::get('/services/insurance', [StaticPagesController::class, 'insurance'])->name('services.insurance');

// Quick Links Routes
Route::get('/patients', [StaticPagesController::class, 'patientPortal'])->name('patients.portal');
Route::get('/faq', [StaticPagesController::class, 'faq'])->name('faq');
Route::get('/privacy', [StaticPagesController::class, 'privacy'])->name('privacy');
Route::get('/terms', [StaticPagesController::class, 'terms'])->name('terms');
Route::get('/contact', [StaticPagesController::class, 'contact'])->name('contact');
