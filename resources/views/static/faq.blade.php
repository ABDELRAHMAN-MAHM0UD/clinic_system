@extends('layouts.static')

@section('title', 'Frequently Asked Questions - Healthcare Clinic System')
@section('meta_description', 'Find answers to commonly asked questions about our healthcare services, appointments, insurance, and more.')
@section('page_title', 'Frequently Asked Questions')

@section('content')
<div class="content-section">
    <div class="faq-container">
        <div class="faq-item">
            <h3 class="faq-question">How do I schedule an appointment?</h3>
            <div class="faq-answer">
                <p>You can schedule an appointment in three ways:</p>
                <ul>
                    <li>Online through our patient portal</li>
                    <li>By calling our appointment line at +1 (555) 123-4567</li>
                    <li>In person at our clinic during business hours</li>
                </ul>
            </div>
        </div>

        <div class="faq-item">
            <h3 class="faq-question">What insurance plans do you accept?</h3>
            <div class="faq-answer">
                <p>We accept most major insurance plans including Medicare and Medicaid. Please visit our Insurance Partners page for a complete list or contact our billing department for specific inquiries.</p>
            </div>
        </div>

        <div class="faq-item">
            <h3 class="faq-question">What should I bring to my first appointment?</h3>
            <div class="faq-answer">
                <ul>
                    <li>Valid photo ID</li>
                    <li>Insurance card</li>
                    <li>List of current medications</li>
                    <li>Medical history records</li>
                    <li>Any relevant test results or imaging</li>
                </ul>
            </div>
        </div>

        <div class="faq-item">
            <h3 class="faq-question">How do I access my medical records?</h3>
            <div class="faq-answer">
                <p>You can access your medical records through our secure patient portal. First-time users need to register using their patient ID. For assistance, please contact our medical records department.</p>
            </div>
        </div>

        <div class="faq-item">
            <h3 class="faq-question">What are your hours of operation?</h3>
            <div class="faq-answer">
                <p>Our regular clinic hours are:</p>
                <ul>
                    <li>Monday - Friday: 8:00 AM - 6:00 PM</li>
                    <li>Saturday: 9:00 AM - 2:00 PM</li>
                    <li>Sunday: Closed</li>
                </ul>
                <p>Emergency services are available 24/7.</p>
            </div>
        </div>

        <div class="faq-item">
            <h3 class="faq-question">How do I get my prescription refilled?</h3>
            <div class="faq-answer">
                <p>Prescription refills can be requested through:</p>
                <ul>
                    <li>Our patient portal</li>
                    <li>Calling your pharmacy directly</li>
                    <li>Contacting our prescription department</li>
                </ul>
                <p>Please allow 48 hours for processing refill requests.</p>
            </div>
        </div>
    </div>
</div>
@endsection
