@extends('layouts.app')

@section('title', 'Update Data Submission - Penjaminan Mutu SMK Bidang KPTK')

@push('styles')
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

        .verification-notes {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1.5rem;
            border-radius: 0.5rem;
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

        .indicator-group {
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .indicator-header {
            color: #495057;
            font-size: 1rem;
            font-weight: 600;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e9ecef;
        }

        .indicator-header .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35em 0.75em;
        }

        .indicator-item .text-muted {
            font-size: 0.85rem;
        }

        .indicator-item .text-muted i {
            color: #0d6efd;
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-2 text-primary">Update Data Submission</h2>
                    <p class="text-secondary small">Silakan perbarui data sesuai catatan verifikasi di bawah ini</p>
                </div>

                @if ($submission->verification_notes)
                    <div class="verification-notes">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-triangle-fill text-warning me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h5 class="fw-bold mb-2">Catatan Verifikasi</h5>
                                <p class="mb-0">{{ $submission->verification_notes }}</p>
                            </div>
                        </div>
                    </div>
                @endif

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

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-exclamation-triangle me-2"></i>Terdapat kesalahan pada form:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('submission.update.store', $token) }}" method="POST">
                    @csrf

                    <!-- Section 1: Identitas Sekolah (Read-only) -->
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-building"></i>
                            <strong>Identitas Sekolah</strong>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Sekolah</label>
                                <input type="text" class="form-control" value="{{ $submission->school->school_name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NPSN</label>
                                <input type="text" class="form-control" value="{{ $submission->school->npsn ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Alamat</label>
                                <textarea rows="3" class="form-control" readonly>{{ $submission->school->address }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Data Responden (Read-only) -->
                    <div class="form-card mt-3">
                        <div class="section-title mb-3">
                            <i class="bi bi-person-badge"></i>
                            <strong>Data Responden</strong>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Responden</label>
                                <input type="text" class="form-control" value="{{ $submission->respondent_name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan Responden</label>
                                <input type="text" class="form-control" value="{{ $submission->respondent_position }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Instrument Sections -->
                    @if ($useHierarchy && $aspects->count() > 0)
                        {{-- Hierarchical display: Aspect → Indicator → Question --}}
                        @foreach ($aspects as $aspect)
                            <div class="form-card mt-3">
                                <div class="section-title">
                                    <i class="bi bi-journal-text"></i>
                                    <strong>{{ $aspect->code }} - {{ $aspect->name }}</strong>
                                </div>

                                @foreach ($aspect->indicators as $indicator)
                                    <div class="indicator-group mb-4">
                                        <h5 class="indicator-header mb-3">
                                            <span class="badge bg-secondary me-2">{{ $indicator->code }}</span>
                                            {{ $indicator->description }}
                                        </h5>

                                        @foreach ($indicator->questions as $question)
                                            <div class="indicator-item mb-3">
                                                <div class="mb-2">
                                                    <span class="indicator-code">{{ $question->question_code }}</span>
                                                    <span class="ms-2 required-badge">
                                                        @if ($question->is_required)
                                                            <span class="text-danger">*</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <p class="mb-1 indicator-text">{{ $question->question_text }}</p>

                                                @if ($question->help_text)
                                                    <small class="text-muted d-block mb-2">
                                                        <i class="bi bi-info-circle me-1"></i>{{ $question->help_text }}
                                                    </small>
                                                @endif

                                                @php
                                                    $item = $instrument->items->firstWhere(
                                                        'assessment_question_id',
                                                        $question->id,
                                                    );
                                                    // Pre-fill with old values
                                                    $oldValue = old("answers.{$item->id}") ?? ($oldAnswers[$item->id] ?? null);
                                                @endphp

                                                @if ($item)
                                                    @include('instrument.partials.answer-input', [
                                                        'question' => $question,
                                                        'item' => $item,
                                                    ])
                                                    @error("answers.{$item->id}")
                                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                                    @enderror
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        {{-- Legacy display: flat items by section --}}
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
                                            @php
                                                $oldValue = old("answers.{$item->id}") ?? ($oldAnswers[$item->id] ?? null);
                                            @endphp

                                            @if ($item->answer_type === 'boolean')
                                                <div class="btn-group" role="group" aria-label="Yes/No">
                                                    <input type="radio" class="btn-check"
                                                        name="answers[{{ $item->id }}]" id="yes_{{ $item->id }}"
                                                        value="Yes" @if ($oldValue === 'Yes') checked @endif
                                                        required>
                                                    <label class="btn btn-outline-primary"
                                                        for="yes_{{ $item->id }}">Ya</label>

                                                    <input type="radio" class="btn-check"
                                                        name="answers[{{ $item->id }}]" id="no_{{ $item->id }}"
                                                        value="No" @if ($oldValue === 'No') checked @endif>
                                                    <label class="btn btn-outline-primary"
                                                        for="no_{{ $item->id }}">Tidak</label>
                                                </div>
                                            @elseif($item->answer_type === 'scale' || $item->answer_type === 'number')
                                                <input type="number" name="answers[{{ $item->id }}]"
                                                    class="form-control" required
                                                    value="{{ $oldValue }}"
                                                    placeholder="Masukkan nilai">
                                            @elseif($item->answer_type === 'option')
                                                <select name="answers[{{ $item->id }}]" class="form-select" required>
                                                    <option value="">Pilih opsi</option>
                                                    <option value="Sangat Baik"
                                                        @if ($oldValue === 'Sangat Baik') selected @endif>Sangat Baik
                                                    </option>
                                                    <option value="Baik"
                                                        @if ($oldValue === 'Baik') selected @endif>
                                                        Baik</option>
                                                    <option value="Cukup"
                                                        @if ($oldValue === 'Cukup') selected @endif>
                                                        Cukup</option>
                                                    <option value="Kurang"
                                                        @if ($oldValue === 'Kurang') selected @endif>
                                                        Kurang</option>
                                                    <option value="Sangat Kurang"
                                                        @if ($oldValue === 'Sangat Kurang') selected @endif>Sangat Kurang
                                                    </option>
                                                </select>
                                            @else
                                                <input type="text" name="answers[{{ $item->id }}]"
                                                    class="form-control" required
                                                    value="{{ $oldValue }}" placeholder="Jawaban Anda">
                                            @endif
                                        </div>

                                        @error("answers.{$item->id}")
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif

                    <!-- Submit Button -->
                    <div class="d-grid gap-3 col-lg-6 mx-auto mt-5 mb-5">
                        <button type="submit" class="btn btn-primary btn-lg shadow rounded-pill py-3 fw-bold"
                            style="font-size: 1rem;">
                            <i class="bi bi-send-fill me-2"></i> Perbarui Data Instrumen
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

@push('scripts')
    <script>
        // Optional: Add confirmation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            // Ensure all tables are updated before submit
            document.querySelectorAll('.instrument-table').forEach(table => {
                console.log('Updating table before submit:', table.id);
                updateTableValue(table.id);
            });

            if (!confirm('Apakah Anda yakin data yang diisi sudah benar?')) {
                e.preventDefault();
            }
        });

        // Initialize calculations on load - with fallback
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing tables...');
            initializeTables();

            setTimeout(initializeTables, 500);

            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('table-input') && !e.target.hasAttribute('readonly')) {
                    const tableId = e.target.dataset.tableId;
                    if (tableId) {
                        console.log('Input changed in table:', tableId);
                        updateTableValue(tableId);
                    }
                }
            });

            document.addEventListener('focusin', function(e) {
                if (e.target.classList.contains('table-input')) {
                    e.target.classList.add('shadow-sm', 'bg-white');
                    e.target.classList.remove('bg-light-subtle');
                }
            });
            document.addEventListener('focusout', function(e) {
                if (e.target.classList.contains('table-input')) {
                    e.target.classList.remove('shadow-sm', 'bg-white');
                    e.target.classList.add('bg-light-subtle');
                }
            });
        });

        function initializeTables() {
            const tables = document.querySelectorAll('.instrument-table');
            console.log('Found tables:', tables.length);
            tables.forEach(table => {
                console.log('Initializing table:', table.id);
                updateTableValue(table.id);
            });
        }

        function updateTableValue(tableId) {
            try {
                const table = document.getElementById(tableId);
                const hiddenInput = document.getElementById(tableId + '-input');

                if (!table || !hiddenInput) {
                    console.warn('Table or hidden input not found:', tableId);
                    return;
                }

                const rows = table.querySelectorAll('tbody tr');
                const data = [];

                rows.forEach(row => {
                    const rowData = {};
                    rowData['label'] = row.cells[0].innerText.trim();

                    const inputs = row.querySelectorAll('.table-input');
                    inputs.forEach(input => {
                        const key = input.dataset.key;
                        const type = input.dataset.type;
                        let value = input.value;

                        if (type === 'number' || type === 'percentage') {
                            value = parseFloat(value);
                            if (isNaN(value)) value = 0;
                            value = Math.round(value * 100) / 100;
                        }

                        rowData[key] = value;
                    });

                    inputs.forEach(input => {
                        if (input.dataset.calculate) {
                            try {
                                const expression = input.dataset.calculate;
                                const calculated = evaluateExpression(expression, rowData);
                                const finalValue = isNaN(calculated) || !isFinite(calculated) ? 0 :
                                    Math.round(calculated * 100) / 100;

                                input.value = finalValue.toFixed(2);
                                rowData[input.dataset.key] = finalValue;

                                console.log(`Calculated ${input.dataset.key}:`, expression, '=',
                                    finalValue);
                            } catch (e) {
                                console.error('Calculation error for', input.dataset.key, ':', e);
                                input.value = '0';
                                rowData[input.dataset.key] = 0;
                            }
                        }
                    });

                    data.push(rowData);
                });

                hiddenInput.value = JSON.stringify(data);
                console.log('Table', tableId, 'updated with data:', data.length, 'rows, value:', hiddenInput.value
                    .substring(0, 100));
            } catch (error) {
                console.error('Error updating table value:', error);
            }
        }

        function evaluateExpression(expression, rowData) {
            let evalString = expression;

            console.log('Evaluating expression:', expression, 'with data:', rowData);

            const keys = Object.keys(rowData).sort((a, b) => b.length - a.length);

            keys.forEach(key => {
                const val = parseFloat(rowData[key]) || 0;
                evalString = evalString.replaceAll('row.' + key, val);
            });

            console.log('After replacement:', evalString);

            try {
                if (/[^0-9+\-*/().\s]/.test(evalString)) {
                    console.warn('Expression contains non-numeric characters after replacement:', evalString);
                }

                const result = Function('"use strict";return (' + evalString + ')')();
                console.log('Calculation result:', result);
                return result;
            } catch (err) {
                console.error('Expression evaluation failed:', err, 'Expression:', evalString);
                return 0;
            }
        }
    </script>
@endpush
