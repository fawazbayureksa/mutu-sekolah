@extends('layouts.admin')

@section('title', 'Impor Pertanyaan')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Impor Pertanyaan dari Excel</h1>
            <a href="{{ route('admin.questions.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Unggah File Excel</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.questions.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="file" class="form-label">Pilih File Excel <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                    id="file" name="file" accept=".xlsx,.xls,.csv" required>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format yang didukung: .xlsx, .xls, .csv (Maks: 5MB)</small>
                            </div>

                            <div class="alert alert-warning">
                                <h6><i class="bi bi-exclamation-triangle"></i> Catatan Penting:</h6>
                                <ul class="mb-0 small">
                                    <li>File Excel harus mengikuti format template yang diperlukan</li>
                                    <li>Semua kolom wajib harus ada</li>
                                    <li>Kode pertanyaan harus unik</li>
                                    <li>Kode aspek dan indikator harus ada dalam sistem</li>
                                    <li>Baris tidak valid akan dilewati dengan laporan kesalahan</li>
                                </ul>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload"></i> Impor Pertanyaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-info-circle"></i> Format yang Diperlukan
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="small mb-2"><strong>Kolom Wajib:</strong></p>
                        <ul class="small">
                            <li><code>question_code</code> - Pengenal unik</li>
                            <li><code>indicator_code</code> - Kode indikator</li>
                            <li><code>question_text</code> - Konten pertanyaan</li>
                            <li><code>answer_type</code> - teks/angka/skala/pilihan/tanggal</li>
                        </ul>

                        <p class="small mb-2 mt-3"><strong>Kolom Opsional:</strong></p>
                        <ul class="small">
                            <li><code>help_text</code> - Panduan tambahan</li>
                            <li><code>weight</code> - Bobot pertanyaan (1-10)</li>
                            <li><code>order</code> - Urutan tampilan</li>
                            <li><code>is_required</code> - true/false</li>
                            <li><code>min_score</code> - Untuk pertanyaan skala</li>
                            <li><code>max_score</code> - Untuk pertanyaan skala</li>
                            <li><code>answer_options</code> - Untuk pilihan (pemisah koma)</li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-download"></i> Unduh Template
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="small">Unduh template Excel dengan format yang benar dan data contoh:</p>
                        <a href="#" class="btn btn-success w-100"
                            onclick="alert('Unduhan template akan diimplementasikan'); return false;">
                            <i class="bi bi-file-earmark-excel"></i> Unduh Template
                        </a>
                        <small class="text-muted d-block mt-2">
                            Template ini mencakup:
                            <ul class="small mt-1 mb-0">
                                <li>Semua kolom wajib</li>
                                <li>Baris data contoh</li>
                                <li>Panduan format</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Format Data Contoh</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>question_code</th>
                                        <th>indicator_code</th>
                                        <th>question_text</th>
                                        <th>answer_type</th>
                                        <th>weight</th>
                                        <th>is_required</th>
                                        <th>help_text</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>Q001</code></td>
                                        <td><code>IND001</code></td>
                                        <td>How would you rate the school facilities?</td>
                                        <td>scale</td>
                                        <td>3</td>
                                        <td>true</td>
                                        <td>Rate from 1 (poor) to 5 (excellent)</td>
                                    </tr>
                                    <tr>
                                        <td><code>Q002</code></td>
                                        <td><code>IND001</code></td>
                                        <td>Which teaching method is most effective?</td>
                                        <td>choice</td>
                                        <td>2</td>
                                        <td>true</td>
                                        <td>Select one option</td>
                                    </tr>
                                    <tr>
                                        <td><code>Q003</code></td>
                                        <td><code>IND002</code></td>
                                        <td>Provide additional comments</td>
                                        <td>text</td>
                                        <td>1</td>
                                        <td>false</td>
                                        <td>Optional feedback</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
