<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Penjaminan Mutu SMK KPTK</title>
    <link rel="icon" href="{{ asset('images/tut-wuri-handayani.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1e40af;
            --primary-light: #60a5fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #3b5be9 0%, #35318a 50%, #939dfb 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Tahoma, sans-serif;
            padding: 1rem;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            animation: cardSlideIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes cardSlideIn {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-body {
            padding: 2.5rem 2rem;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-img {
            width: 140px;
            height: 140px;
            object-fit: contain;
            margin-bottom: 1rem;
            /* animation: logoFloat 3s ease-in-out infinite; */
        }

        @keyframes logoFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
            font-weight: 400;
        }

        .form-floating {
            margin-bottom: 1.25rem;
        }

        .form-floating>.form-control {
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 1rem 1rem;
            height: 60px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-floating>.form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            background: white;
        }

        .form-floating>label {
            padding: 1rem 1rem;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-check {
            margin-bottom: 1.75rem;
        }

        .form-check-input {
            width: 1.15rem;
            height: 1.15rem;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-check-label {
            color: #4b5563;
            font-size: 0.9rem;
            cursor: pointer;
            margin-left: 0.5rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.95rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-back {
            width: 100%;
            padding: 0.95rem;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 14px;
            background: #f3f4f6;
            border: 2px solid transparent;
            color: #4b5563;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: white;
            border-color: #e5e7eb;
            color: #1f2937;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .alert {
            border-radius: 14px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            animation: alertSlide 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes alertSlide {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border-left: 4px solid #16a34a;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            padding: 0 1rem;
            color: #9ca3af;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.85rem;
        }

        .footer-text a {
            color: white;
            text-decoration: underline;
            font-weight: 500;
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15rem;
        }

        @media (max-width: 480px) {
            .login-body {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-body">
                <!-- Logo Section -->
                <div class="logo-section">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
                    <h1 class="login-title">Masuk Administrator</h1>
                    <p class="login-subtitle">Penjaminan Mutu SMK KPTK</p>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email -->
                    <div class="form-floating">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="nama@example.com" value="{{ old('email') }}" required
                            autofocus>
                        <label for="email">
                            <i class="bi bi-envelope me-2"></i>Email Address
                        </label>
                    </div>

                    <!-- Password -->
                    <div class="form-floating">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Password" required>
                        <label for="password">
                            <i class="bi bi-lock me-2"></i>Password
                        </label>
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-login" id="btnLogin">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        <span id="btnText">Masuk</span>
                        <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                    </button>

                    <!-- Divider -->
                    <div class="divider">
                        <span>atau</span>
                    </div>

                    <!-- Back to Home -->
                    <a href="{{ route('landing') }}" class="btn btn-back">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
                    </a>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-text">
            <p class="mb-0">&copy; {{ date('Y') }} BPPMPV KPTK. All rights reserved.</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Loading state on form submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnLogin');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');

            btn.disabled = true;
            btnText.textContent = 'Memproses...';
            btnSpinner.classList.remove('d-none');
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>

</html>
