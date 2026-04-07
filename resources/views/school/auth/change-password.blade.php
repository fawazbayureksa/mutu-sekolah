@extends('school.layouts.school')

@section('title', 'Buat Password - Portal Sekolah')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm mt-4">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-shield-lock fs-1 text-primary"></i>
                            <h4 class="mt-2 mb-1">Buat Password Baru</h4>
                            <p class="text-muted small mb-0">
                                Akun Anda belum memiliki password. Buat password untuk melindungi akun.
                            </p>
                        </div>

                        @if (session('info'))
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                {{ session('info') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('school.password.update') }}" id="changePasswordForm">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">NPSN</label>
                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->npsn }}"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">
                                    Password Baru <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required minlength="8" placeholder="Minimal 8 karakter">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold small">
                                    Konfirmasi Password <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" required minlength="8" placeholder="Ulangi password baru">
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                <span id="btnText">Simpan & Lanjutkan ke Dasbor</span>
                                <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('changePasswordForm').addEventListener('submit', function() {
            document.getElementById('btnSpinner').classList.remove('d-none');
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
@endpush
