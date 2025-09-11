@extends('layouts.static')

@section('title', 'Services - Healthcare Clinic System')
@section('meta_description', 'Explore our comprehensive healthcare services including medical specialties, emergency care, and more.')
@section('page_title', 'Our Services')

@section('content')
<div class="content-section">
    <h2 class="section-title">Comprehensive Healthcare Services</h2>
    <div class="section-content">
        <div class="services-grid">
            <div class="service-card">
                <i class="fas fa-calendar-check"></i>
                <h3>Online Appointments</h3>
                <p>Book your appointments online with our easy-to-use scheduling system.</p>
                <a href="/services/appointments" class="service-link">Learn More</a>
            </div>
            
            <div class="service-card">
                <i class="fas fa-ambulance"></i>
                <h3>Emergency Care</h3>
                <p>24/7 emergency medical services with rapid response teams.</p>
                <a href="/services/emergency" class="service-link">Learn More</a>
            </div>
            
            <div class="service-card">
                <i class="fas fa-stethoscope"></i>
                <h3>Medical Specialties</h3>
                <p>Expert care across various medical specialties.</p>
                <a href="/services/specialties" class="service-link">Learn More</a>
            </div>
            
            <div class="service-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Insurance Partners</h3>
                <p>Information about accepted insurance providers and coverage.</p>
                <a href="/services/insurance" class="service-link">Learn More</a>
            </div>
        </div>
    </div>
</div>
@endsection
