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
                                <li><strong>Struktur:</strong> Konfigurasi tabel dengan kolom dan baris</li>
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
        </script>
    @endpush
@endsection
