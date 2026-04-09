<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Password - Penjaminan Mutu SMK KPTK</title>
    <link rel="icon" href="{{ asset('images/tut-wuri-handayani.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="login-card" style="max-width: 480px;">
            <div class="login-body">
                <div class="logo-section">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
                    <h1 class="login-title">Buat Password Akun</h1>
                    <p class="login-subtitle">Penjaminan Mutu SMK Bidang KPTK</p>
                </div>

                <div class="alert alert-info d-flex align-items-start mb-4">
                    <i class="bi bi-info-circle-fill me-2 mt-1 flex-shrink-0"></i>
                    <div>
                        <strong>Akun baru terdeteksi.</strong><br>
                        NPSN <strong>{{ $npsn }}</strong> ({{ $school->school_name }}) belum memiliki password.
                        Buat password untuk mengaktifkan akun Anda.
                    </div>
                </div>

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

                <form method="POST" action="{{ route('school.first-login.store') }}" id="firstLoginForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">NPSN</label>
                        <input type="text" class="form-control bg-light" value="{{ $npsn }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Nama Sekolah</label>
                        <input type="text" class="form-control bg-light" value="{{ $school->school_name }}" readonly>
                    </div>

                    <div class="form-floating mb-1 position-relative">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Password baru" required minlength="8"
                            style="padding-right: 3rem;">
                        <label for="password">
                            <i class="bi bi-lock me-2"></i>Password Baru
                        </label>
                        <button type="button" class="btn btn-link text-muted p-0 position-absolute"
                            style="right:.75rem;top:50%;transform:translateY(-50%);z-index:5;line-height:1;"
                            onclick="togglePassword('password','eye-password')" tabindex="-1">
                            <i class="bi bi-eye fs-5" id="eye-password"></i>
                        </button>
                    </div>
                    <div class="form-text text-muted mb-3">Minimal 8 karakter.</div>

                    <div class="form-floating mb-4 position-relative">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password"
                            required minlength="8" style="padding-right: 3rem;">
                        <label for="password_confirmation">
                            <i class="bi bi-lock-fill me-2"></i>Konfirmasi Password
                        </label>
                        <button type="button" class="btn btn-link text-muted p-0 position-absolute"
                            style="right:.75rem;top:50%;transform:translateY(-50%);z-index:5;line-height:1;"
                            onclick="togglePassword('password_confirmation','eye-confirm')" tabindex="-1">
                            <i class="bi bi-eye fs-5" id="eye-confirm"></i>
                        </button>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                        <span id="btnText">Aktifkan Akun & Masuk</span>
                        <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('school.login') }}" class="text-muted small">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke halaman masuk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash fs-5';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye fs-5';
            }
        }

        document.getElementById('firstLoginForm').addEventListener('submit', function() {
            document.getElementById('btnSpinner').classList.remove('d-none');
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>

</html>
