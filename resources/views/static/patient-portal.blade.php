@extends('layouts.static')

@section('title', 'Patient Portal - Healthcare Clinic System')
@section('meta_description', 'Access your medical records, schedule appointments, and manage your healthcare through our secure patient portal.')
@section('page_title', 'Patient Portal')

@section('content')
<div class="content-section">
    <div class="portal-grid">
        <div class="portal-card">
            <div class="portal-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3>Appointments</h3>
            <ul class="portal-features">
                <li>Schedule new appointments</li>
                <li>View upcoming appointments</li>
                <li>Cancel or reschedule</li>
                <li>Set reminders</li>
            </ul>
            <a href="/login" class="btn-link">Access Now</a>
        </div>

        <div class="portal-card">
            <div class="portal-icon">
                <i class="fas fa-file-medical"></i>
            </div>
            <h3>Medical Records</h3>
            <ul class="portal-features">
                <li>View test results</li>
                <li>Access medical history</li>
                <li>Download records</li>
                <li>Track medications</li>
            </ul>
            <a href="/login" class="btn-link">Access Now</a>
        </div>

        <div class="portal-card">
            <div class="portal-icon">
                <i class="fas fa-pills"></i>
            </div>
            <h3>Prescriptions</h3>
            <ul class="portal-features">
                <li>Request refills</li>
                <li>View current medications</li>
                <li>Check interactions</li>
                <li>Set medication reminders</li>
            </ul>
            <a href="/login" class="btn-link">Access Now</a>
        </div>

        <div class="portal-card">
            <div class="portal-icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <h3>Billing & Insurance</h3>
            <ul class="portal-features">
                <li>View statements</li>
                <li>Make payments</li>
                <li>Insurance information</li>
                <li>Payment history</li>
            </ul>
            <a href="/login" class="btn-link">Access Now</a>
        </div>
    </div>
</div>

<div class="content-section">
    <h2 class="section-title">First Time Users</h2>
    <div class="section-content">
        <div class="registration-info">
            <p>To register for the patient portal, you will need:</p>
            <ul class="requirements-list">
                <li>Your patient ID number (found on your clinic card)</li>
                <li>A valid email address</li>
                <li>Your date of birth</li>
                <li>A mobile phone for verification</li>
            </ul>
            <div class="action-buttons">
                <a href="/register" class="btn-link">Register Now</a>
                <a href="/contact" class="btn-link" style="background: var(--secondary-color);">Need Help?</a>
            </div>
        </div>
    </div>
</div>
@endsection
