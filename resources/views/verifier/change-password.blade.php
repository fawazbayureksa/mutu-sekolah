@extends('verifier.layouts.verifier')

@section('title', 'Ganti Password - Verifier Panel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Ganti Password</h2>
            <p class="text-muted mb-0">Perbarui kata sandi akun Anda</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4"
                    role="alert">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start gap-2 mb-4"
                    role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 mt-1"></i>
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center gap-2 py-3">
                    <i class="bi bi-shield-lock fs-5 text-primary"></i>
                    <strong class="mb-0">Ubah Kata Sandi</strong>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('verifier.change-password.update') }}" method="POST" id="changePasswordForm">
                        @csrf

                        <div class="mb-4">
                            <label for="current_password" class="form-label fw-semibold">
                                Password Saat Ini <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password" id="current_password" name="current_password"
                                    class="form-control border-start-0 @error('current_password') is-invalid @enderror"
                                    placeholder="Masukkan password saat ini" required autocomplete="current-password">
                                <button class="btn btn-outline-secondary border toggle-password" type="button"
                                    data-target="current_password">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                Password Baru <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-key text-muted"></i>
                                </span>
                                <input type="password" id="password" name="password"
                                    class="form-control border-start-0 @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password baru" required autocomplete="new-password">
                                <button class="btn btn-outline-secondary border toggle-password" type="button"
                                    data-target="password">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text text-muted mt-1">
                                <i class="bi bi-info-circle me-1"></i>
                                Minimal 8 karakter, kombinasi huruf dan angka direkomendasikan.
                            </div>

                            {{-- Password strength bar --}}
                            <div class="mt-2" id="strengthWrapper" style="display:none;">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Kekuatan password:</small>
                                    <small id="strengthLabel" class="fw-semibold"></small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                Konfirmasi Password Baru <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-key-fill text-muted"></i>
                                </span>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control border-start-0" placeholder="Ulangi password baru" required
                                    autocomplete="new-password">
                                <button class="btn btn-outline-secondary border toggle-password" type="button"
                                    data-target="password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div id="passwordMatchFeedback" class="mt-1" style="display:none;"></div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold" id="submitBtn">
                                Simpan Password Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tips card --}}
            <div class="card mt-3 border-0 bg-light">
                <div class="card-body py-3 px-4">
                    <h6 class="mb-2 text-muted"><i class="bi bi-lightbulb me-1 text-warning"></i>Tips keamanan password:
                    </h6>
                    <ul class="mb-0 ps-3 small text-muted">
                        <li>Gunakan minimal 8 karakter</li>
                        <li>Kombinasikan huruf besar, kecil, angka, dan simbol</li>
                        <li>Hindari menggunakan informasi pribadi seperti tanggal lahir</li>
                        <li>Jangan gunakan password yang sama di layanan lain</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('bi-eye', 'bi-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('bi-eye-slash', 'bi-eye');
                    }
                });
            });

            // Password strength checker
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('strengthBar');
            const strengthLabel = document.getElementById('strengthLabel');
            const strengthWrapper = document.getElementById('strengthWrapper');

            passwordInput.addEventListener('input', function() {
                const val = this.value;
                if (val.length === 0) {
                    strengthWrapper.style.display = 'none';
                    return;
                }
                strengthWrapper.style.display = 'block';

                let strength = 0;
                if (val.length >= 8) strength++;
                if (/[A-Z]/.test(val)) strength++;
                if (/[0-9]/.test(val)) strength++;
                if (/[^A-Za-z0-9]/.test(val)) strength++;

                const levels = [{
                        label: 'Sangat Lemah',
                        color: 'bg-danger',
                        width: '25%'
                    },
                    {
                        label: 'Lemah',
                        color: 'bg-warning',
                        width: '50%'
                    },
                    {
                        label: 'Cukup',
                        color: 'bg-info',
                        width: '75%'
                    },
                    {
                        label: 'Kuat',
                        color: 'bg-success',
                        width: '100%'
                    },
                ];
                const level = levels[Math.max(0, strength - 1)];
                strengthBar.className = 'progress-bar ' + level.color;
                strengthBar.style.width = level.width;
                strengthLabel.textContent = level.label;
                strengthLabel.className = 'fw-semibold ' + level.color.replace('bg-', 'text-');
            });

            // Password match feedback
            const confirmInput = document.getElementById('password_confirmation');
            const matchFeedback = document.getElementById('passwordMatchFeedback');

            function checkMatch() {
                if (confirmInput.value.length === 0) {
                    matchFeedback.style.display = 'none';
                    return;
                }
                matchFeedback.style.display = 'block';
                if (passwordInput.value === confirmInput.value) {
                    matchFeedback.innerHTML =
                        '<small class="text-success"><i class="bi bi-check-circle me-1"></i>Password cocok</small>';
                } else {
                    matchFeedback.innerHTML =
                        '<small class="text-danger"><i class="bi bi-x-circle me-1"></i>Password tidak cocok</small>';
                }
            }

            confirmInput.addEventListener('input', checkMatch);
            passwordInput.addEventListener('input', checkMatch);
        });
    </script>
@endpush
