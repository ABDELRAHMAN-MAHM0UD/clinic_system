@extends('layouts.static')

@section('title', 'Medical Team - Healthcare Clinic System')
@section('meta_description', 'Meet our experienced team of medical professionals dedicated to providing exceptional healthcare services.')
@section('page_title', 'Our Medical Team')

@section('content')
<div class="content-section">
    <h2 class="section-title">Expert Healthcare Professionals</h2>
    <div class="section-content">
        <p>Our team consists of highly qualified doctors, nurses, and healthcare professionals committed to providing the best possible care for our patients.</p>
    </div>
</div>

<div class="content-section">
    <h2 class="section-title">Department Heads</h2>
    <div class="section-content">
        <div class="team-grid">
            @foreach($doctors as $doctor)
            <div class="team-member">
                <div class="member-image">
                    <img src="{{ $doctor->image_url ?? '/images/default-doctor.jpg' }}" alt="Dr. {{ $doctor->name }}">
                </div>
                <div class="member-info">
                    <h3>Dr. {{ $doctor->name }}</h3>
                    <p class="specialty">{{ $doctor->specialty }}</p>
                    <p class="credentials">{{ $doctor->qualifications }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
