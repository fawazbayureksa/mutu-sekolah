@extends('layouts.admin')

@section('title', isset($question) ? 'Edit Pertanyaan' : 'Buat Pertanyaan')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ isset($question) ? 'Edit Pertanyaan' : 'Buat Pertanyaan Baru' }}</h1>
            <a href="{{ route('admin.questions.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Kesalahan Validasi:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ isset($question) ? route('admin.questions.update', $question) : route('admin.questions.store') }}"
            method="POST">
            @csrf
            @if (isset($question))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Detail Pertanyaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="question_code" class="form-label">Kode Pertanyaan <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('question_code') is-invalid @enderror"
                                    id="question_code" name="question_code"
                                    value="{{ old('question_code', $question->question_code ?? '') }}" required>
                                @error('question_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Pengenal unik untuk pertanyaan ini (mis., Q001,
                                    ASP1_IND1_Q1)</small>
                            </div>

                            <div class="mb-3">
                                <label for="question_text" class="form-label">Teks Pertanyaan <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('question_text') is-invalid @enderror" id="question_text" name="question_text"
                                    rows="4" required>{{ old('question_text', $question->question_text ?? '') }}</textarea>
                                @error('question_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="help_text" class="form-label">Teks Bantuan (Opsional)</label>
                                <textarea class="form-control @error('help_text') is-invalid @enderror" id="help_text" name="help_text" rows="2">{{ old('help_text', $question->help_text ?? '') }}</textarea>
                                @error('help_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror>
                                <small class="form-text text-muted">Panduan atau penjelasan tambahan untuk
                                    responden</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="aspect_id" class="form-label">Aspek Penilaian <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('aspect_id') is-invalid @enderror" id="aspect_id"
                                        required>
                                        <option value="">Pilih Aspek</option>
                                        @foreach ($aspects as $aspect)
                                            <option value="{{ $aspect->id }}"
                                                {{ old('aspect_id', $question->indicator->aspect_id ?? '') == $aspect->id ? 'selected' : '' }}>
                                                {{ $aspect->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('aspect_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">

                                    <label for="indicator_id" class="form-label">Indikator <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('indicator_id') is-invalid @enderror"
                                        id="indicator_id" name="indicator_id" required>
                                        <option value="">Pilih Indikator</option>
                                        @if (isset($question) && $question->indicator)
                                            <option value="{{ $question->indicator_id }}" selected>
                                                {{ $question->indicator->code . ' ' . $question->indicator->description }}
                                            </option>
                                        @endif
                                    </select>
                                    @error('indicator_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="answer_type" class="form-label">Tipe Jawaban <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('answer_type') is-invalid @enderror" id="answer_type"
                                        name="answer_type" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="text"
                                            {{ old('answer_type', $question->answer_type ?? '') == 'text' ? 'selected' : '' }}>
                                            Teks</option>
                                        <option value="number"
                                            {{ old('answer_type', $question->answer_type ?? '') == 'number' ? 'selected' : '' }}>
                                            Angka</option>
                                        <option value="scale"
                                            {{ old('answer_type', $question->answer_type ?? '') == 'scale' ? 'selected' : '' }}>
                                            Skala (Rating)</option>
                                        <option value="choice"
                                            {{ old('answer_type', $question->answer_type ?? '') == 'choice' ? 'selected' : '' }}>
                                            Pilihan Ganda</option>
                                        <option value="date"
                                            {{ old('answer_type', $question->answer_type ?? '') == 'date' ? 'selected' : '' }}>
                                            Tanggal</option>
                                        <option value="structure"
                                            {{ old('answer_type', $question->answer_type ?? '') == 'structure' ? 'selected' : '' }}>
                                            Struktur</option>
                                    </select>
                                    @error('answer_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="weight" class="form-label">Bobot</label>
                                    <input type="number" class="form-control @error('weight') is-invalid @enderror"
                                        id="weight" name="weight" min="1" max="10" step="1"
                                        value="{{ old('weight', $question->weight ?? 1) }}">
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="order" class="form-label">Urutan Tampilan</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                                        id="order" name="order" min="1"
                                        value="{{ old('order', $question->order ?? 999) }}">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dynamic fields based on answer type -->
                            <div id="scaleOptions" style="display: none;">
                                <div class="mb-3">
                                    <label for="scale_template_id" class="form-label">Template Skala</label>
                                    <select class="form-select" id="scale_template_id" name="scale_template_id">
                                        <option value="">Pilih Template</option>
                                        @foreach ($scaleTemplates as $template)
                                            <option value="{{ $template->id }}" data-min="{{ $template->min_value }}"
                                                data-max="{{ $template->max_value }}"
                                                {{ old('scale_template_id', $question->scale_template_id ?? '') == $template->id ? 'selected' : '' }}>
                                                {{ $template->name }} ({{ $template->min_value }} -
                                                {{ $template->max_value }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Atur nilai min/maks kustom di bawah</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="min_score" class="form-label">Nilai Minimum</label>
                                        <input type="number" class="form-control" id="min_score" name="min_score"
                                            value="{{ old('min_score', $question->min_score ?? 1) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="max_score" class="form-label">Nilai Maksimum</label>
                                        <input type="number" class="form-control" id="max_score" name="max_score"
                                            value="{{ old('max_score', $question->max_score ?? 5) }}">
                                    </div>
                                </div>
                            </div>

                            <div id="choiceOptions" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Opsi Jawaban (Satu per baris)</label>
                                    <textarea class="form-control" id="answer_options_choice" name="answer_options" rows="5"
                                        placeholder="Opsi 1&#10;Opsi 2&#10;Opsi 3">{{ old('answer_type') === 'choice' ? old('answer_options', is_array($question->answer_options ?? null) ? implode("\n", $question->answer_options) : '') : '' }}</textarea>
                                    <small class="form-text text-muted">Setiap opsi pada baris baru</small>
                                </div>
                            </div>

                            <div id="structureOptions" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Konfigurasi Struktur (JSON)</label>
                                    @php
                                        $structureValue = '';
                                        if (old('answer_type') === 'structure') {
                                            $structureValue = old('answer_options');
                                        } elseif (isset($question) && $question->answer_type === 'structure') {
                                            // Use helper to handle both array and string cases safely
                                            $opts = $question->getAnswerOptionsArray();
                                            $structureValue = !empty($opts)
                                                ? json_encode($opts, JSON_PRETTY_PRINT)
                                                : $question->answer_options ?? '';

                                            // If it's still a raw string (not decoded by helper/model), try to prettify it
                                            if (
                                                is_string($structureValue) &&
                                                is_string($question->answer_options) &&
                                                empty($opts)
                                            ) {
                                                $decoded = json_decode($question->answer_options);
                                                if (json_last_error() === JSON_ERROR_NONE) {
                                                    $structureValue = json_encode($decoded, JSON_PRETTY_PRINT);
                                                }
                                            }
                                        }
                                    @endphp
                                    <textarea class="form-control font-monospace" id="answer_options_structure" name="answer_options" rows="10"
                                        placeholder='{"type":"table","columns":[...],"rows":[...]}'>{{ $structureValue }}</textarea>
                                    <small class="form-text text-muted">Masukkan konfigurasi JSON yang valid untuk struktur
                                        tabel.</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_required" name="is_required"
                                        value="1"
                                        {{ old('is_required', $question->is_required ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_required">
                                        Pertanyaan Wajib
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> {{ isset($question) ? 'Perbarui Pertanyaan' : 'Buat Pertanyaan' }}
                        </button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Bantuan & Pedoman</h5>
                        </div>
                        <div class="card-body">
                            <h6>Tipe Pertanyaan:</h6>
                            <ul class="small">
                                <li>
                                    <strong>Struktur:</strong> Konfigurasi tabel dengan kolom dan baris
                                    <button type="button" class="btn btn-sm btn-outline-info ms-2"
                                        data-bs-toggle="modal" data-bs-target="#structureExampleModal">
                                        <i class="bi bi-lightbulb"></i> Lihat Contoh
                                    </button>
                                </li>
                                <li><strong>Teks:</strong> Teks bebas</li>
                                <li><strong>Angka:</strong> Hanya input angka</li>
                                <li><strong>Skala:</strong> Skala rating (mis., 1-5, 1-10)</li>
                                <li><strong>Pilihan:</strong> Beberapa opsi untuk dipilih</li>
                                <li><strong>Tanggal:</strong> Input pemilih tanggal</li>
                            </ul>

                            <h6 class="mt-3">Praktik Terbaik:</h6>
                            <ul class="small">
                                <li>Gunakan teks pertanyaan yang jelas dan ringkas</li>
                                <li>Berikan teks bantuan untuk pertanyaan kompleks</li>
                                <li>Atur bobot yang sesuai untuk penilaian</li>
                                <li>Hubungkan pertanyaan ke indikator yang benar</li>
                                <li>Uji pertanyaan sebelum memublikasikan</li>
                            </ul>

                            @if (isset($question))
                                <hr>
                                <h6>Info Pertanyaan:</h6>
                                <ul class="small mb-0">
                                    <li>Dibuat: {{ $question->created_at->format('M d, Y') }}</li>
                                    <li>Diperbarui: {{ $question->updated_at->format('M d, Y') }}</li>
                                    <li>Status: {{ $question->is_active ? 'Aktif' : 'Tidak Aktif' }}</li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Structure Example Modal -->
    <div class="modal fade" id="structureExampleModal" tabindex="-1" aria-labelledby="structureExampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="structureExampleModalLabel">
                        <i class="bi bi-table"></i> Contoh Konfigurasi Struktur Tabel
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-3" id="structureExampleTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="example1-tab" data-bs-toggle="tab"
                                data-bs-target="#example1" type="button" role="tab">
                                <i class="bi bi-table"></i> Tabel Dasar
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="example2-tab" data-bs-toggle="tab" data-bs-target="#example2"
                                type="button" role="tab">
                                <i class="bi bi-list-ol"></i> Tabel dengan Nomor Baris
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="example3-tab" data-bs-toggle="tab" data-bs-target="#example3"
                                type="button" role="tab">
                                <i class="bi bi-plus-circle"></i> Tabel Dinamis
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="structureExampleTabsContent">
                        <!-- Example 1: Basic Table -->
                        <div class="tab-pane fade show active" id="example1" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h6 class="fw-bold mb-3">
                                        <i class="bi bi-code-square"></i> Konfigurasi JSON - Tabel Dasar:
                                    </h6>
                                    <div class="position-relative">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 m-2"
                                            onclick="copyStructureExample('structureExampleJson1')">
                                            <i class="bi bi-clipboard"></i> Salin
                                        </button>
                                        <pre class="border rounded p-3 bg-light" style="max-height: 400px; overflow-y: auto;"><code id="structureExampleJson1">{
    "type": "table",
    "columns": [
        {
            "key": "year",
            "label": "Tahun",
            "type": "number",
            "width": "15%"
        },
        {
            "key": "total_participants",
            "label": "Jumlah Peserta",
            "type": "number",
            "width": "20%"
        },
        {
            "key": "total_passed",
            "label": "Jumlah Lulus",
            "type": "number",
            "width": "20%"
        },
        {
            "key": "pass_rate",
            "label": "Tingkat Kelulusan (%)",
            "type": "percentage",
            "read_only": true,
            "calculate": "(row.total_passed / row.total_participants) * 100"
        },
        {
            "key": "organizer",
            "label": "Lembaga Sertifikasi",
            "type": "text",
            "width": "25%"
        }
    ],
    "rows": [
        { "label": "UKK Mandiri" },
        { "label": "UKK LSP" },
        { "label": "Sertifikasi Profesi" }
    ]
}</code></pre>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-eye"></i> Preview:</h6>
                                    <div class="border rounded p-3 bg-white">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Jenis</th>
                                                        <th>Tahun</th>
                                                        <th>Jumlah Peserta</th>
                                                        <th>Jumlah Lulus</th>
                                                        <th>Tingkat Kelulusan (%)</th>
                                                        <th>Lembaga Sertifikasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><strong>UKK Mandiri</strong></td>
                                                        <td><input type="number" class="form-control form-control-sm"
                                                                value="2024"></td>
                                                        <td><input type="number" class="form-control form-control-sm"
                                                                value="150"></td>
                                                        <td><input type="number" class="form-control form-control-sm"
                                                                value="142"></td>
                                                        <td><input type="text"
                                                                class="form-control form-control-sm bg-light"
                                                                value="94.67" readonly></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="Sekolah"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>UKK LSP</strong></td>
                                                        <td><input type="number" class="form-control form-control-sm"
                                                                value="2024"></td>
                                                        <td><input type="number" class="form-control form-control-sm"
                                                                value="80"></td>
                                                        <td><input type="number" class="form-control form-control-sm"
                                                                value="75"></td>
                                                        <td><input type="text"
                                                                class="form-control form-control-sm bg-light"
                                                                value="93.75" readonly></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="LSP P1"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Example 2: Table with Row Numbers -->
                        <div class="tab-pane fade" id="example2" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h6 class="fw-bold mb-3">
                                        <i class="bi bi-code-square"></i> Konfigurasi JSON - Dengan Nomor Baris:
                                    </h6>
                                    <div class="position-relative">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 m-2"
                                            onclick="copyStructureExample('structureExampleJson2')">
                                            <i class="bi bi-clipboard"></i> Salin
                                        </button>
                                        <pre class="border rounded p-3 bg-light" style="max-height: 400px; overflow-y: auto;"><code id="structureExampleJson2">{
    "type": "table",
    "show_row_number": true,
    "row_label_header": "No",
    "columns": [
        {
            "key": "name",
            "label": "Nama Sarana/Prasarana",
            "type": "text",
            "width": "30%"
        },
        {
            "key": "quantity",
            "label": "Jumlah",
            "type": "number",
            "width": "15%"
        },
        {
            "key": "condition",
            "label": "Kondisi",
            "type": "text",
            "width": "20%"
        },
        {
            "key": "notes",
            "label": "Keterangan",
            "type": "text",
            "width": "25%"
        }
    ],
    "rows": [
        { "label": "Komputer" },
        { "label": "Laptop" },
        { "label": "Proyektor" },
        { "label": "Router/Switch" }
    ]
}</code></pre>
                                    </div>
                                    <div class="alert alert-info mt-3">
                                        <small>
                                            <i class="bi bi-info-circle"></i>
                                            <strong>show_row_number:</strong> Menampilkan nomor urut baris otomatis<br>
                                            <strong>row_label_header:</strong> Label header untuk kolom nomor (default:
                                            "No")
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-eye"></i> Preview:</h6>
                                    <div class="border rounded p-3 bg-white">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 50px">No</th>
                                                        <th>Nama Sarana/Prasarana</th>
                                                        <th>Jumlah</th>
                                                        <th>Kondisi</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td>Komputer</td>
                                                        <td><input type="number" class="form-control form-control-sm"
                                                                value="25"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="Baik"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="-"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">2</td>
                                                        <td>Laptop</td>
                                                        <td><input type="number" class="form-control form-control-sm"
                                                                value="10"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="Baik"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="-"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">3</td>
                                                        <td>Proyektor</td>
                                                        <td><input type="number" class="form-control form-control-sm"
                                                                value="5"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="Cukup"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="1 rusak"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Example 3: Dynamic Table -->
                        <div class="tab-pane fade" id="example3" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h6 class="fw-bold mb-3">
                                        <i class="bi bi-code-square"></i> Konfigurasi JSON - Tabel Dinamis:
                                    </h6>
                                    <div class="position-relative">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 m-2"
                                            onclick="copyStructureExample('structureExampleJson3')">
                                            <i class="bi bi-clipboard"></i> Salin
                                        </button>
                                        <pre class="border rounded p-3 bg-light" style="max-height: 400px; overflow-y: auto;"><code id="structureExampleJson3">{
    "type": "table",
    "show_row_number": true,
    "row_label_header": "No",
    "dynamic_rows": true,
    "min_rows": 1,
    "max_rows": 20,
    "columns": [
        {
            "key": "partner_name",
            "label": "Nama Mitra/DUDI",
            "type": "text",
            "width": "30%"
        },
        {
            "key": "cooperation_type",
            "label": "Jenis Kerjasama",
            "type": "text",
            "width": "25%"
        },
        {
            "key": "mou_number",
            "label": "No. MoU",
            "type": "text",
            "width": "20%"
        },
        {
            "key": "valid_until",
            "label": "Berlaku Sampai",
            "type": "text",
            "width": "15%"
        }
    ],
    "rows": []
}</code></pre>
                                    </div>
                                    <div class="alert alert-warning mt-3">
                                        <small>
                                            <i class="bi bi-plus-circle"></i>
                                            <strong>dynamic_rows:</strong> User dapat menambah/hapus baris<br>
                                            <strong>min_rows:</strong> Minimal jumlah baris (default: 1)<br>
                                            <strong>max_rows:</strong> Maksimal jumlah baris (default: 20)<br>
                                            <strong>rows:</strong> Kosong [] untuk tabel dinamis murni
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-eye"></i> Preview:</h6>
                                    <div class="border rounded p-3 bg-white">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 50px">No</th>
                                                        <th>Nama Mitra/DUDI</th>
                                                        <th>Jenis Kerjasama</th>
                                                        <th>No. MoU</th>
                                                        <th>Berlaku Sampai</th>
                                                        <th style="width: 50px">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="PT. ABC"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="PKL"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="001/MoU/2024"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                value="2026"></td>
                                                        <td><button class="btn btn-sm btn-outline-danger" disabled><i
                                                                    class="bi bi-trash"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">2</td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                placeholder="..."></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                placeholder="..."></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                placeholder="..."></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                placeholder="..."></td>
                                                        <td><button class="btn btn-sm btn-outline-danger"><i
                                                                    class="bi bi-trash"></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button class="btn btn-sm btn-outline-primary mt-2" disabled>
                                            <i class="bi bi-plus"></i> Tambah Baris
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Reference -->
                    <div class="card mt-4 bg-light">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-book"></i> Referensi Properti Konfigurasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Properti Utama:</h6>
                                    <ul class="small mb-0">
                                        <li><code>type</code>: "table" (wajib)</li>
                                        <li><code>columns</code>: Array definisi kolom (wajib)</li>
                                        <li><code>rows</code>: Array definisi baris dengan label</li>
                                        <li><code>show_row_number</code>: true untuk nomor baris otomatis</li>
                                        <li><code>row_label_header</code>: Label header nomor (default: "No")</li>
                                        <li><code>dynamic_rows</code>: true untuk tambah/hapus baris</li>
                                        <li><code>min_rows</code>: Minimal jumlah baris</li>
                                        <li><code>max_rows</code>: Maksimal jumlah baris</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Properti Kolom:</h6>
                                    <ul class="small mb-0">
                                        <li><code>key</code>: Identifier unik kolom (wajib)</li>
                                        <li><code>label</code>: Label yang ditampilkan (wajib)</li>
                                        <li><code>type</code>: text, number, percentage</li>
                                        <li><code>width</code>: Lebar kolom (mis: "20%")</li>
                                        <li><code>read_only</code>: true untuk kolom hanya baca</li>
                                        <li><code>calculate</code>: Formula perhitungan otomatis</li>
                                        <li><code>placeholder</code>: Teks placeholder input</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="useStructureExample()">
                        <i class="bi bi-arrow-right-circle"></i> Gunakan Template Aktif
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Store aspect indicators data
            const aspectIndicators = @json($aspects);

            // Update indicators when aspect changes
            document.getElementById('aspect_id').addEventListener('change', function() {
                const aspectId = parseInt(this.value);
                const indicatorSelect = document.getElementById('indicator_id');

                indicatorSelect.innerHTML = '<option value="">Pilih Indikator</option>';

                if (aspectId) {
                    const aspect = aspectIndicators.find(a => a.id === aspectId);
                    if (aspect && aspect.indicators) {
                        aspect.indicators.forEach(indicator => {
                            const option = document.createElement('option');
                            option.value = indicator.id;
                            option.textContent = indicator.indicator_name;
                            indicatorSelect.appendChild(option);
                        });
                    }
                }
            });

            // Show/hide fields based on answer type
            document.getElementById('answer_type').addEventListener('change', function() {
                const scaleOptions = document.getElementById('scaleOptions');
                const choiceOptions = document.getElementById('choiceOptions');
                const structureOptions = document.getElementById('structureOptions');

                scaleOptions.style.display = 'none';
                choiceOptions.style.display = 'none';
                if (structureOptions) structureOptions.style.display = 'none';

                // Disable inputs in hidden sections to prevent submission conflicts
                document.getElementById('answer_options_choice').disabled = true;
                if (document.getElementById('answer_options_structure')) {
                    document.getElementById('answer_options_structure').disabled = true;
                }

                if (this.value === 'scale') {
                    scaleOptions.style.display = 'block';
                } else if (this.value === 'choice') {
                    choiceOptions.style.display = 'block';
                    document.getElementById('answer_options_choice').disabled = false;
                } else if (this.value === 'structure') {
                    if (structureOptions) {
                        structureOptions.style.display = 'block';
                        document.getElementById('answer_options_structure').disabled = false;
                    }
                }
            });

            // Trigger change on page load to show correct fields
            document.getElementById('answer_type').dispatchEvent(new Event('change'));

            // Update min/max scores when scale template changes
            document.getElementById('scale_template_id')?.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    document.getElementById('min_score').value = selectedOption.dataset.min;
                    document.getElementById('max_score').value = selectedOption.dataset.max;
                }
            });

            // Copy structure example to clipboard
            window.copyStructureExample = function(elementId) {
                const jsonText = document.getElementById(elementId).textContent;
                navigator.clipboard.writeText(jsonText).then(function() {
                    // Show success feedback
                    const btn = event.target.closest('button');
                    const originalHtml = btn.innerHTML;
                    btn.innerHTML = '<i class="bi bi-check"></i> Tersalin!';
                    btn.classList.remove('btn-outline-secondary');
                    btn.classList.add('btn-success');

                    setTimeout(function() {
                        btn.innerHTML = originalHtml;
                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-outline-secondary');
                    }, 2000);
                }).catch(function(err) {
                    alert('Gagal menyalin: ' + err);
                });
            };

            // Use structure example - populate the textarea with active tab's JSON
            window.useStructureExample = function() {
                // Find the active tab pane
                const activePane = document.querySelector('#structureExampleTabsContent .tab-pane.active');
                if (!activePane) return;

                // Find the JSON code element in the active pane
                const codeElement = activePane.querySelector('code[id^="structureExampleJson"]');
                if (!codeElement) return;

                const jsonText = codeElement.textContent;
                const textarea = document.getElementById('answer_options_structure');

                if (textarea) {
                    textarea.value = jsonText;

                    // Change answer type to structure if not already
                    const answerTypeSelect = document.getElementById('answer_type');
                    if (answerTypeSelect.value !== 'structure') {
                        answerTypeSelect.value = 'structure';
                        answerTypeSelect.dispatchEvent(new Event('change'));
                    }

                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('structureExampleModal'));
                    if (modal) {
                        modal.hide();
                    }

                    // Scroll to the structure options
                    textarea.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    // Highlight the textarea briefly
                    textarea.classList.add('border-success', 'border-3');
                    setTimeout(function() {
                        textarea.classList.remove('border-success', 'border-3');
                    }, 2000);
                }
            };
        </script>
    @endpush
@endsection
