@extends('layouts.admin')

@section('title', 'Lihat Pertanyaan')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Detail Pertanyaan</h1>
            <div>
                <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('admin.questions.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-question-circle"></i> Informasi Pertanyaan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Kode Pertanyaan:</strong>
                            </div>
                            <div class="col-md-8">
                                <code class="fs-6">{{ $question->question_code }}</code>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Teks Pertanyaan:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $question->question_text }}
                            </div>
                        </div>

                        @if ($question->help_text)
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Teks Bantuan:</strong>
                                </div>
                                <div class="col-md-8">
                                    <small class="text-muted">{{ $question->help_text }}</small>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Aspek Penilaian:</strong>
                            </div>
                            <div class="col-md-8">
                                <span class="badge bg-info">{{ $question->indicator->aspect->aspect_name ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Indicator:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $question->indicator->indicator_name ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Tipe Jawaban:</strong>
                            </div>
                            <div class="col-md-8">
                                <span class="badge bg-secondary">{{ ucfirst($question->answer_type) }}</span>
                            </div>
                        </div>

                        @if ($question->answer_type === 'scale')
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Rentang Nilai:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $question->min_score }} sampai {{ $question->max_score }}
                                    @if ($question->scaleTemplate)
                                        <small class="text-muted">(Menggunakan template:
                                            {{ $question->scaleTemplate->name }})</small>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($question->answer_type === 'choice' && $question->answer_options)
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Opsi Jawaban:</strong>
                                </div>
                                <div class="col-md-8">
                                    <ul class="mb-0">
                                        @foreach ($question->answer_options as $option)
                                            <li>{{ $option }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Bobot:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $question->weight }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Urutan Tampilan:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $question->order }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Wajib:</strong>
                            </div>
                            <div class="col-md-8">
                                @if ($question->is_required)
                                    <span class="badge bg-danger">Ya</span>
                                @else
                                    <span class="badge bg-secondary">Tidak</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Status:</strong>
                            </div>
                            <div class="col-md-8">
                                @if ($question->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <strong>Waktu:</strong>
                            </div>
                            <div class="col-md-8">
                                <small class="text-muted">
                                    Dibuat: {{ $question->created_at->format('M d, Y H:i') }}<br>
                                    Diperbarui: {{ $question->updated_at->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-graph-up"></i> Statistik Penggunaan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle"></i>
                            Pertanyaan ini digunakan dalam <strong>{{ $usageCount }}</strong> instrumen.
                        </div>

                        @if ($instruments->count() > 0)
                            <h6>Instrumen yang menggunakan pertanyaan ini:</h6>
                            <div class="list-group">
                                @foreach ($instruments as $instrument)
                                    <a href="{{ route('admin.instruments.show', $instrument) }}"
                                        class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $instrument->name }}</h6>
                                            <small>
                                                @if ($instrument->status === 'published')
                                                    <span class="badge bg-success">Diterbitkan</span>
                                                @else
                                                    <span class="badge bg-secondary">Draf</span>
                                                @endif
                                            </small>
                                        </div>
                                        <p class="mb-1 small text-muted">
                                            <code>{{ $instrument->code }}</code> - Version
                                            {{ $instrument->version }}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Pertanyaan ini saat ini tidak digunakan dalam instrumen apa pun.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aksi</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Edit Pertanyaan
                            </a>

                            <form action="{{ route('admin.questions.duplicate', $question) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-secondary w-100">
                                    <i class="bi bi-files"></i> Duplikat Pertanyaan
                                </button>
                            </form>

                            @if ($question->is_active)
                                <form action="{{ route('admin.questions.deactivate', $question) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning w-100">
                                        <i class="bi bi-pause-circle"></i> Nonaktifkan
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.questions.activate', $question) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-play-circle"></i> Aktifkan
                                    </button>
                                </form>
                            @endif

                            <hr>

                            @if ($usageCount > 0)
                                <button type="button" class="btn btn-danger w-100" disabled
                                    title="Tidak dapat menghapus: pertanyaan sedang digunakan">
                                    <i class="bi bi-trash"></i> Hapus Pertanyaan (Digunakan)
                                </button>
                                <small class="text-muted">Hapus dari semua instrumen sebelum menghapus</small>
                            @else
                                <form action="{{ route('admin.questions.destroy', $question) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-trash"></i> Hapus Pertanyaan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Terkait</h5>
                    </div>
                    <div class="card-body">
                        <h6>Detail Indikator:</h6>
                        @if ($question->indicator)
                            <p class="small mb-2">
                                <strong>Kode:</strong> <code>{{ $question->indicator->indicator_code }}</code><br>
                                <strong>Nama:</strong> {{ $question->indicator->indicator_name }}<br>
                                <strong>Aspek:</strong> {{ $question->indicator->aspect->aspect_name ?? 'N/A' }}
                            </p>
                        @else
                            <p class="text-muted small">Tidak ada indikator yang terhubung</p>
                        @endif

                        <hr>

                        <h6>Info Tipe Jawaban:</h6>
                        <p class="small mb-0">
                            @switch($question->answer_type)
                                @case('text')
                                    Teks bebas memungkinkan responden memberikan jawaban tertulis yang rinci.
                                @break

                                @case('number')
                                    Hanya input angka - berguna untuk kuantitas, persentase, atau jumlah.
                                @break

                                @case('scale')
                                    Skala rating dari {{ $question->min_score }} sampai {{ $question->max_score }} - umumnya digunakan untuk
                                    pertanyaan tipe Likert.
                                @break

                                @case('choice')
                                    Pilihan ganda dengan {{ count($question->answer_options ?? []) }} opsi yang telah ditentukan.
                                @break

                                @case('date')
                                    Input pemilih tanggal - berguna untuk mengumpulkan tanggal atau periode waktu tertentu.
                                @break
                            @endswitch
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
