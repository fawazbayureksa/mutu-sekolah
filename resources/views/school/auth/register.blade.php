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

                    <div class="form-floating mb-1">
                        <input type="text" class="form-control @error('npsn') is-invalid @enderror" id="npsn"
                            name="npsn" placeholder="NPSN" value="{{ old('npsn') }}" required maxlength="8"
                            inputmode="numeric" autocomplete="off" autofocus>
                        <label for="npsn">
                            <i class="bi bi-building me-2"></i>NPSN
                        </label>
                        @error('npsn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <small class="text-muted"><span id="npsn-count">{{ strlen(old('npsn', '')) }}</span> / 8
                            digit</small>
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

                    <div class="form-floating mb-1 position-relative">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Password" required minlength="8"
                            style="padding-right: 3rem;">
                        <label for="password">
                            <i class="bi bi-lock me-2"></i>Password
                        </label>
                        <button type="button" class="btn btn-link text-muted p-0 position-absolute"
                            style="right:.75rem;top:50%;transform:translateY(-50%);z-index:5;line-height:1;"
                            onclick="togglePassword('password','eye-password')" tabindex="-1">
                            <i class="bi bi-eye fs-5" id="eye-password"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text text-muted mb-1">Minimal 8 karakter.</div>
                    <div class="mb-3">
                        <div class="d-flex gap-1 mb-1">
                            <div id="str-seg1" style="height:4px;flex:1;background:#dee2e6;border-radius:2px;"></div>
                            <div id="str-seg2" style="height:4px;flex:1;background:#dee2e6;border-radius:2px;"></div>
                            <div id="str-seg3" style="height:4px;flex:1;background:#dee2e6;border-radius:2px;"></div>
                            <div id="str-seg4" style="height:4px;flex:1;background:#dee2e6;border-radius:2px;"></div>
                        </div>
                        <small id="str-label" class="text-muted"></small>
                    </div>

                    <div class="form-floating mb-4 position-relative">
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="Konfirmasi Password" required minlength="8"
                            style="padding-right: 3rem;">
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
        // NPSN: digits only + live counter
        const npsnInput = document.getElementById('npsn');
        document.getElementById('npsn-count').textContent = npsnInput.value.length;
        npsnInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 8);
            document.getElementById('npsn-count').textContent = this.value.length;
        });

        // Password show/hide toggle
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

        // Password strength meter
        document.getElementById('password').addEventListener('input', function() {
            const val = this.value;
            const segs = [
                document.getElementById('str-seg1'),
                document.getElementById('str-seg2'),
                document.getElementById('str-seg3'),
                document.getElementById('str-seg4'),
            ];
            const label = document.getElementById('str-label');
            segs.forEach(s => s.style.background = '#dee2e6');
            if (!val) {
                label.textContent = '';
                label.className = 'text-muted';
                return;
            }
            if (val.length < 8) {
                segs[0].style.background = '#dc3545';
                label.textContent = 'Terlalu pendek';
                label.className = 'small text-danger';
                return;
            }
            let score = 1;
            if (val.length >= 12) score++;
            if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
            if (/[0-9]/.test(val) && /[^A-Za-z0-9]/.test(val)) score++;
            const cfg = [{
                    color: '#dc3545',
                    cls: 'text-danger',
                    text: 'Lemah'
                },
                {
                    color: '#fd7e14',
                    cls: 'text-warning',
                    text: 'Cukup'
                },
                {
                    color: '#ffc107',
                    cls: 'text-warning',
                    text: 'Baik'
                },
                {
                    color: '#198754',
                    cls: 'text-success',
                    text: 'Kuat'
                },
            ];
            const level = cfg[score - 1];
            for (let i = 0; i < score; i++) segs[i].style.background = level.color;
            label.textContent = level.text;
            label.className = 'small ' + level.cls;
        });

        // Spinner on submit
        document.getElementById('registerForm').addEventListener('submit', function() {
            document.getElementById('btnSpinner').classList.remove('d-none');
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>

</html>
