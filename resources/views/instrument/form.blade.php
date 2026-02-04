@extends('layouts.app')

@section('title', 'Isi Instrumen - Penjaminan Mutu SMK Bidang KPTK')

@section('styles')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .form-card {
            background: #fff;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            padding: 2.5rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #343a40;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .indicator-item {
            background: #fdfdfe;
            border: 1px solid #e9ecef;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.2s;
        }

        .indicator-item:hover {
            border-color: #dee2e6;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .indicator-code {
            background: #e7f1ff;
            color: #0d6efd;
            padding: 0.35rem 0.85rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-bottom: 0.75rem;
        }

        .indicator-text {
            font-size: 1rem;
            line-height: 1.6;
            color: #212529;
            font-weight: 500;
        }

        .section-title {
            background: linear-gradient(to right, #0d6efd, #0056b3);
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
            /* Negative margin to pull header to edges of the card */
            margin: -2.5rem -2.5rem 2rem -2.5rem;
            padding: 1.25rem 2.5rem;
            border-radius: 1rem 1rem 0 0;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
        }

        .section-title i {
            margin-right: 0.75rem;
            font-size: 1.4rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .btn-check:checked+.btn-outline-primary {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
        }

        .btn-outline-primary {
            border-radius: 2rem;
            padding: 0.5rem 1.75rem;
            font-weight: 500;
            margin-right: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-2 text-primary">Instrumen Penjaminan Mutu</h2>
                    <p class="text-secondary small">Lengkapi data sekolah dan penilaian di bawah ini dengan seksama</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('instrument.submit') }}" method="POST">
                    @csrf

                    @error('school_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <!-- Section 1: Identitas Sekolah -->
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-building"></i>
                            <strong>
                                Identitas Sekolah
                            </strong>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                                <input type="text" name="school_name"
                                    class="form-control @error('school_name') is-invalid @enderror" required
                                    value="{{ old('school_name') }}">
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NPSN</label>
                                <input type="text" name="npsn" class="form-control" value="{{ old('npsn') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" name="province"
                                    class="form-control @error('province') is-invalid @enderror" required
                                    value="{{ old('province') }}">
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                                <input type="text" name="city"
                                    class="form-control @error('city') is-invalid @enderror" required
                                    value="{{ old('city') }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Data Responden -->
                    <div class="form-card mt-3">
                        <div class="section-title mb-3">
                            <i class="bi bi-person-badge"></i>
                            <strong>
                                Data Responden
                            </strong>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Responden <span class="text-danger">*</span></label>
                                <input type="text" name="respondent_name"
                                    class="form-control @error('respondent_name') is-invalid @enderror" required
                                    value="{{ old('respondent_name') }}">
                                @error('respondent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan Responden <span class="text-danger">*</span></label>
                                <input type="text" name="respondent_position"
                                    class="form-control @error('respondent_position') is-invalid @enderror" required
                                    value="{{ old('respondent_position') }}">
                                @error('respondent_position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Instrument Sections -->
                    @php
                        $groupedItems = $instrument->items->groupBy('section');
                    @endphp

                    @foreach ($groupedItems as $section => $items)
                        <div class="form-card mt-3">
                            <div class="section-title">
                                <i class="bi bi-journal-text"></i> <strong>{{ $section }}</strong>
                            </div>

                            @foreach ($items as $item)
                                <div class="indicator-item mb-3">
                                    <div class="mb-3">
                                        <span class="indicator-code">{{ $item->indicator_code }}</span>
                                        <p class="mb-0 indicator-text">{{ $item->indicator_text }}</p>
                                    </div>

                                    <div class="answer-input">
                                        @if ($item->answer_type === 'boolean')
                                            <div class="btn-group" role="group" aria-label="Yes/No">
                                                <input type="radio" class="btn-check" name="answers[{{ $item->id }}]"
                                                    id="yes_{{ $item->id }}" value="Yes"
                                                    @if (old("answers.{$item->id}") === 'Yes') checked @endif required>
                                                <label class="btn btn-outline-primary"
                                                    for="yes_{{ $item->id }}">Ya</label>

                                                <input type="radio" class="btn-check" name="answers[{{ $item->id }}]"
                                                    id="no_{{ $item->id }}" value="No"
                                                    @if (old("answers.{$item->id}") === 'No') checked @endif>
                                                <label class="btn btn-outline-primary"
                                                    for="no_{{ $item->id }}">Tidak</label>
                                            </div>
                                        @elseif($item->answer_type === 'scale' || $item->answer_type === 'number')
                                            <input type="number" name="answers[{{ $item->id }}]"
                                                class="form-control" required value="{{ old("answers.{$item->id}") }}"
                                                placeholder="Masukkan nilai">
                                        @elseif($item->answer_type === 'option')
                                            <select name="answers[{{ $item->id }}]" class="form-select" required>
                                                <option value="">Pilih opsi</option>
                                                <option value="Sangat Baik"
                                                    @if (old("answers.{$item->id}") === 'Sangat Baik') selected @endif>Sangat Baik</option>
                                                <option value="Baik" @if (old("answers.{$item->id}") === 'Baik') selected @endif>
                                                    Baik</option>
                                                <option value="Cukup" @if (old("answers.{$item->id}") === 'Cukup') selected @endif>
                                                    Cukup</option>
                                                <option value="Kurang" @if (old("answers.{$item->id}") === 'Kurang') selected @endif>
                                                    Kurang</option>
                                                <option value="Sangat Kurang"
                                                    @if (old("answers.{$item->id}") === 'Sangat Kurang') selected @endif>Sangat Kurang
                                                </option>
                                            </select>
                                        @else
                                            <input type="text" name="answers[{{ $item->id }}]"
                                                class="form-control" required value="{{ old("answers.{$item->id}") }}"
                                                placeholder="Jawaban Anda">
                                        @endif
                                    </div>

                                    @error("answers.{$item->id}")
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <!-- Submit Button -->
                    <div class="d-grid gap-3 col-lg-6 mx-auto mt-5 mb-5">
                        <button type="submit" class="btn btn-primary btn-lg shadow rounded-pill py-3 fw-bold"
                            style="font-size: 1rem;">
                            <i class="bi bi-send-fill me-2"></i> Kirim Data Instrumen
                        </button>
                        <a href="{{ route('landing') }}" class="btn btn-outline-secondary rounded-pill border-0">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Halaman Utama
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Optional: Add confirmation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin data yang diisi sudah benar?')) {
                e.preventDefault();
            }
        });
    </script>
@endsection
