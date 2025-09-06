<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Healthcare Clinic System - Professional Healthcare Services')">
    <title>@yield('title', 'Healthcare Clinic System')</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="static-page">
    <header class="site-header">
        <div class="header-container">
            <a href="/" class="logo">
                <i class="fas fa-heartbeat" style="color: var(--primary-color); font-size: 24px;"></i>
                <span class="logo-text">HealthCare Plus</span>
            </a>
            <nav class="nav-links">
                <a href="/services" class="nav-link">Services</a>
                <a href="/doctors" class="nav-link">Our Doctors</a>
                <a href="/about" class="nav-link">About Us</a>
                <a href="/contact" class="nav-link">Contact</a>
                <a href="/login" class="btn-link" style="padding: 8px 16px;">Sign In</a>
            </nav>
        </div>
    </header>

    <main class="static-content">
        <div class="page-header">
            <h1>@yield('page_title')</h1>
        </div>

        <div class="content-container">
            @yield('content')
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3 class="footer-title">About Us</h3>
                <div class="footer-links">
                    <a href="/about" class="footer-link">Our Story</a>
                    <a href="/mission" class="footer-link">Mission & Vision</a>
                    <a href="/team" class="footer-link">Medical Team</a>
                    <a href="/careers" class="footer-link">Careers</a>
                </div>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">Services</h3>
                <div class="footer-links">
                    <a href="/services/appointments" class="footer-link">Online Appointments</a>
                    <a href="/services/emergency" class="footer-link">Emergency Care</a>
                    <a href="/services/specialties" class="footer-link">Medical Specialties</a>
                    <a href="/services/insurance" class="footer-link">Insurance Partners</a>
                </div>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">Contact Us</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+1 (555) 123-4567</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>contact@healthcareplus.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-location-dot"></i>
                        <span>123 Medical Center Drive<br>Suite 100<br>City, State 12345</span>
                    </div>
                </div>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">Quick Links</h3>
                <div class="footer-links">
                    <a href="/patients" class="footer-link">Patient Portal</a>
                    <a href="/faq" class="footer-link">FAQs</a>
                    <a href="/privacy" class="footer-link">Privacy Policy</a>
                    <a href="/terms" class="footer-link">Terms of Service</a>
                </div>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 HealthCare Plus. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
