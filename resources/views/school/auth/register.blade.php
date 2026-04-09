<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun - Penjaminan Mutu SMK KPTK</title>
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
                    <h1 class="login-title">Daftar Akun Sekolah</h1>
                    <p class="login-subtitle">Penjaminan Mutu SMK Bidang KPTK</p>
                </div>

                <div class="alert alert-info d-flex align-items-start mb-4">
                    <i class="bi bi-info-circle-fill me-2 mt-1 flex-shrink-0"></i>
                    <div>
                        Daftarkan akun sekolah Anda menggunakan NPSN. Setelah mendaftar, masuk dan lengkapi data
                        sekolah.
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

                <form method="POST" action="{{ route('school.register') }}" id="registerForm">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('npsn') is-invalid @enderror" id="npsn"
                            name="npsn" placeholder="NPSN" value="{{ old('npsn') }}" required maxlength="20"
                            autofocus>
                        <label for="npsn">
                            <i class="bi bi-building me-2"></i>NPSN
                        </label>
                        @error('npsn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('school_name') is-invalid @enderror"
                            id="school_name" name="school_name" placeholder="Nama Sekolah"
                            value="{{ old('school_name') }}" required maxlength="255">
                        <label for="school_name">
                            <i class="bi bi-card-text me-2"></i>Nama Sekolah
                        </label>
                        @error('school_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Password" required minlength="8">
                        <label for="password">
                            <i class="bi bi-lock me-2"></i>Password
                        </label>
                        <div class="form-text text-muted">Minimal 8 karakter.</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="Konfirmasi Password" required minlength="8">
                        <label for="password_confirmation">
                            <i class="bi bi-lock-fill me-2"></i>Konfirmasi Password
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                        <span id="btnText">Daftar Akun</span>
                        <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                    </button>
                </form>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        Sudah punya akun?
                        <a href="{{ route('school.login') }}">Masuk di sini</a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function() {
            document.getElementById('btnSpinner').classList.remove('d-none');
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>

</html>
