<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Healthcare Clinic System</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h1 class="auth-title">Create Account</h1>
                <p class="auth-subtitle">Join our healthcare community</p>
            </div>

            <form class="auth-form" method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required autofocus 
                           placeholder="Enter your full name"
                           class="@error('name') error @enderror"
                           value="{{ old('name') }}">
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required
                           placeholder="Enter your email"
                           class="@error('email') error @enderror"
                           value="{{ old('email') }}">
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required
                           placeholder="Create a password"
                           class="@error('password') error @enderror">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" 
                           name="password_confirmation" required
                           placeholder="Confirm your password">
                </div>

                <div class="form-group">
                    <label class="remember-me">
                        <input type="checkbox" name="terms" required>
                        <span>I agree to the <a href="/terms" class="text-primary">Terms of Service</a> and <a href="/privacy" class="text-primary">Privacy Policy</a></span>
                    </label>
                </div>

                <button type="submit" class="auth-submit">
                    Create Account
                </button>
            </form>

            <div class="social-auth">
                <div class="social-auth-divider">
                    <span>Or register with</span>
                </div>
                <div class="social-buttons">
                    <a href="#" class="social-button">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="#" class="social-button">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-button">
                        <i class="fab fa-apple"></i>
                    </a>
                </div>
            </div>

            <div class="auth-footer">
                Already have an account? <a href="{{ route('login') }}">Sign In</a>
            </div>
        </div>
    </div>
</body>
</html>
