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
    <!-- Login CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
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
