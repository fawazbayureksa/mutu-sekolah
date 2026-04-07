<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk Sekolah - Penjaminan Mutu SMK KPTK</title>
    <link rel="icon" href="{{ asset('images/tut-wuri-handayani.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-body">
                <div class="logo-section">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
                    <h1 class="login-title">Portal Sekolah</h1>
                    <p class="login-subtitle">Penjaminan Mutu SMK Bidang KPTK</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        {{ session('info') }}
                    </div>
                @endif

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

                <form method="POST" action="{{ route('school.login') }}" id="loginForm">
                    @csrf

                    <div class="form-floating">
                        <input type="text" class="form-control @error('npsn') is-invalid @enderror" id="npsn"
                            name="npsn" placeholder="Nomor NPSN" value="{{ old('npsn') }}" required autofocus
                            maxlength="20">
                        <label for="npsn">
                            <i class="bi bi-building me-2"></i>NPSN
                        </label>
                        @error('npsn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mt-2" id="password-field"
                        style="{{ $errors->has('password') || old('npsn') ? '' : 'display:none;' }}">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Password">
                        <label for="password">
                            <i class="bi bi-lock me-2"></i>Password
                        </label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted mt-1 small">
                            Jika pertama kali masuk, biarkan kosong — akun akan dibuat otomatis.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3" id="submitBtn">
                        <span id="btnText">{{ old('npsn') ? 'Masuk' : 'Lanjutkan' }}</span>
                        <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                    </button>
                </form>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Administrator? <a href="{{ route('login') }}">Masuk di sini</a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const npsnInput = document.getElementById('npsn');
        const passwordField = document.getElementById('password-field');
        const btnText = document.getElementById('btnText');

        // Show password field when NPSN has a value
        npsnInput.addEventListener('input', function() {
            if (this.value.trim().length > 0) {
                passwordField.style.display = '';
                btnText.textContent = 'Masuk';
            } else {
                passwordField.style.display = 'none';
                btnText.textContent = 'Lanjutkan';
            }
        });

        document.getElementById('loginForm').addEventListener('submit', function() {
            document.getElementById('btnSpinner').classList.remove('d-none');
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>

</html>
