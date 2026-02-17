@extends('layouts.app')

@section('title', 'Isi Instrumen V2 - Penjaminan Mutu SMK Bidang KPTK')

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

        .table-card {
            border: 0;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table-card .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.25rem;
        }

        .table-responsive {
            border-radius: 0 0 0.75rem 0.75rem;
        }

        .instrument-table {
            margin-bottom: 0;
        }

        .instrument-table thead th {
            background: #f1f5f9;
            border: none;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            padding: 0.75rem 1rem;
            white-space: nowrap;
        }

        .instrument-table tbody td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            border-color: #f1f5f9;
        }

        .instrument-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .table-input {
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .table-input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
            outline: none;
        }

        .btn-add-row {
            border: 2px dashed #dee2e6;
            color: #6c757d;
            background: transparent;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-add-row:hover {
            border-color: #0d6efd;
            color: #0d6efd;
            background: rgba(13, 110, 253, 0.05);
        }

        .btn-remove-row {
            color: #dc3545;
            background: transparent;
            border: none;
            padding: 0.25rem 0.5rem;
            font-size: 1.1rem;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .btn-remove-row:hover {
            opacity: 1;
        }

        .checklist-item {
            display: flex;
            align-items: flex-start;
            padding: 1rem;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .checklist-item:hover {
            border-color: #dee2e6;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .form-section {
            margin-bottom: 1.5rem;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .section-number {
            width: 32px;
            height: 32px;
            min-width: 32px;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .header-input-group {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .note-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            font-size: 0.875rem;
        }

        .note-box i {
            color: #856404;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-5" style="max-width: 1400px;">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-2 text-primary">Instrumen Penjaminan Mutu V2</h2>
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

                <form action="{{ route('instrument.v2.submit') }}" method="POST" id="instrumentForm">
                    @csrf

                    {{-- Section 1: Identitas Sekolah --}}
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-building"></i>
                            <strong>Identitas Sekolah</strong>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                                <input type="text" name="school_name"
                                    class="form-control @error('school_name') is-invalid @enderror" required
                                    value="{{ old('school_name') }}" placeholder="Masukkan nama sekolah">
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NPSN</label>
                                <input type="text" name="npsn" class="form-control" value="{{ old('npsn') }}"
                                    placeholder="Masukkan NPSN (opsional)">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required
                                    placeholder="Masukkan alamat lengkap sekolah (termasuk provinsi dan kota/kabupaten)">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Data Responden --}}
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-person-badge"></i>
                            <strong>Data Responden</strong>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Responden <span class="text-danger">*</span></label>
                                <input type="text" name="respondent_name"
                                    class="form-control @error('respondent_name') is-invalid @enderror" required
                                    value="{{ old('respondent_name') }}" placeholder="Masukkan nama responden">
                                @error('respondent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan Responden <span class="text-danger">*</span></label>
                                <input type="text" name="respondent_position"
                                    class="form-control @error('respondent_position') is-invalid @enderror" required
                                    value="{{ old('respondent_position') }}" placeholder="Masukkan jabatan responden">
                                @error('respondent_position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ASPECT A: Standar Peserta Didik --}}
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-journal-text"></i>
                            <strong>A - Standar Peserta Didik (Kompetensi & Kesiapan Kerja)</strong>
                        </div>

                        {{-- A.1: Data Kompetensi (UKK & Sertifikasi) --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">A.1</span>
                                Data Kompetensi (UKK & Sertifikasi)
                            </h5>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">A.1.1</span>
                                </div>
                                <p class="indicator-text mb-2">Data Kelulusan Uji Kompetensi dan Sertifikasi</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data kelulusan UKK dan sertifikasi profesi
                                    untuk tahun terakhir
                                </small>

                                @include('instrument.partials.v2.table-a11')
                            </div>
                        </div>

                        {{-- A.2: Penelusuran Alumni (Tracer Study) --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">A.2</span>
                                Penelusuran Alumni (Tracer Study)
                            </h5>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">A.2.1</span>
                                </div>
                                <p class="indicator-text mb-2">Penelusuran Alumni (Tracer Study)</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data penelusuran alumni berdasarkan tracer
                                    study untuk kelas lulusan tertentu
                                </small>

                                @include('instrument.partials.v2.table-a21')
                            </div>
                        </div>
                    </div>

                    {{-- ASPECT B: Data Sarana Prasarana --}}
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-journal-text"></i>
                            <strong>B - Data Sarana Prasarana (Sapras)</strong>
                        </div>

                        {{-- B.1: Inventarisasi dan Kesesuaian dengan Standar Industri --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">B.1</span>
                                Inventarisasi dan Kesesuaian dengan Standar Industri
                            </h5>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">B.1.1</span>
                                    <span class="badge bg-info ms-2">Dynamic Rows</span>
                                </div>
                                <p class="indicator-text mb-2">Inventarisasi dan Kesesuaian dengan Standar Industri</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data inventaris perangkat bengkel/lab dan
                                    bandingkan dengan standar industri
                                </small>

                                @include('instrument.partials.v2.table-b11')
                            </div>
                        </div>

                        {{-- B.2: Penilaian Kesiapan Fasilitas (Checklist) --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">B.2</span>
                                Penilaian Kesiapan Fasilitas (Checklist)
                            </h5>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">B.2.1</span>
                                </div>
                                <p class="indicator-text mb-2">Penilaian Kesiapan Fasilitas (Checklist)</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi checklist penilaian kesiapan fasilitas
                                    bengkel/lab
                                </small>

                                @include('instrument.partials.v2.checklist-b21')
                            </div>
                        </div>
                    </div>

                    {{-- ASPECT C: Data Tata Kelola --}}
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-journal-text"></i>
                            <strong>C - Data Tata Kelola</strong>
                        </div>

                        {{-- C.1: Kerjasama Industri --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">C.1</span>
                                Kerjasama Industri
                            </h5>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">C.1.1</span>
                                    <span class="badge bg-info ms-2">Dynamic Rows</span>
                                </div>
                                <p class="indicator-text mb-2">Kerjasama Industri</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data kerjasama dengan industri mitra
                                </small>

                                @include('instrument.partials.v2.table-c11')
                            </div>
                        </div>

                        {{-- C.2: Teaching Factory (TEFA) --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">C.2</span>
                                Teaching Factory (TEFA) / Unit Produksi Sekolah
                            </h5>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">C.2.1</span>
                                    <span class="badge bg-info ms-2">Dynamic Rows</span>
                                </div>
                                <p class="indicator-text mb-2">Teaching Factory (TEFA) / Unit Produksi Sekolah</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data program Teaching Factory atau Unit
                                    Produksi Sekolah
                                </small>

                                @include('instrument.partials.v2.table-c21')
                            </div>
                        </div>

                        {{-- C.3: Data Pelatihan dan Sertifikasi Guru --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">C.3</span>
                                Data Pelatihan dan Sertifikasi Guru/Guru Produktif
                            </h5>

                            <div class="indicator-item mb-3">
                                <div class="mb-2">
                                    <span class="indicator-code">C.3.1</span>
                                    <span class="badge bg-info ms-2">Dynamic Rows</span>
                                </div>
                                <p class="indicator-text mb-2">Data Pelatihan dan Sertifikasi Guru yang Telah Diikuti</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data pelatihan dan sertifikasi yang telah
                                    diikuti oleh guru
                                </small>

                                @include('instrument.partials.v2.table-c31')
                            </div>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">C.3.2</span>
                                </div>
                                <p class="indicator-text mb-2">Analisis Kebutuhan Pelatihan Guru ke Depan</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Diisi oleh Guru/Koordinator Program untuk
                                    menganalisis kebutuhan pelatihan
                                </small>

                                @include('instrument.partials.v2.form-c32')
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all tables
            initializeDynamicTables();

            // Form submission handler
            document.getElementById('instrumentForm').addEventListener('submit', function(e) {
                // Collect all table data before submit
                collectAllTableData();

                if (!confirm('Apakah Anda yakin data yang diisi sudah benar?')) {
                    e.preventDefault();
                }
            });
        });

        function initializeDynamicTables() {
            // Add row buttons
            document.querySelectorAll('.btn-add-row').forEach(btn => {
                btn.addEventListener('click', function() {
                    const tableId = this.dataset.tableId;
                    addTableRow(tableId);
                });
            });

            // Remove row buttons (event delegation)
            document.addEventListener('click', function(e) {
                if (e.target.closest('.btn-remove-row')) {
                    const btn = e.target.closest('.btn-remove-row');
                    const row = btn.closest('tr');
                    const tbody = row.closest('tbody');

                    // Don't remove if it's the last row
                    if (tbody.querySelectorAll('tr').length > 1) {
                        row.remove();
                        // Re-number rows
                        renumberRows(tbody);
                    } else {
                        alert('Minimal harus ada 1 baris data');
                    }
                }
            });

            // Auto-calculate fields
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('table-input')) {
                    const row = e.target.closest('tr');
                    if (row) {
                        calculateRowFields(row);
                    }
                }
            });
        }

        function addTableRow(tableId) {
            const table = document.getElementById(tableId);
            const tbody = table.querySelector('tbody');
            const templateRow = tbody.querySelector('tr:last-child');
            const newRow = templateRow.cloneNode(true);
            const rowIndex = tbody.querySelectorAll('tr').length;

            // Clear input values and update row index
            newRow.querySelectorAll('input, select, textarea').forEach(input => {
                if (input.type === 'radio' || input.type === 'checkbox') {
                    input.checked = false;
                } else {
                    input.value = '';
                }

                // Update name attributes
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${rowIndex}]`));
                }

                // Update data-row attribute
                input.dataset.row = rowIndex;
            });

            // Update row number
            const rowNumCell = newRow.querySelector('.row-number');
            if (rowNumCell) {
                rowNumCell.textContent = rowIndex + 1;
            }

            tbody.appendChild(newRow);
        }

        function renumberRows(tbody) {
            tbody.querySelectorAll('tr').forEach((row, index) => {
                const rowNumCell = row.querySelector('.row-number');
                if (rowNumCell) {
                    rowNumCell.textContent = index + 1;
                }

                // Update data-row attributes
                row.querySelectorAll('input, select, textarea').forEach(input => {
                    input.dataset.row = index;

                    // Update name attributes
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                    }
                });
            });
        }

        function calculateRowFields(row) {
            // Auto-calculate pass rate for A.1.1
            const totalParticipants = row.querySelector('[data-key="total_participants"]');
            const totalPassed = row.querySelector('[data-key="total_passed"]');
            const passRate = row.querySelector('[data-key="pass_rate"]');

            if (totalParticipants && totalPassed && passRate) {
                const participants = parseFloat(totalParticipants.value) || 0;
                const passed = parseFloat(totalPassed.value) || 0;

                if (participants > 0) {
                    passRate.value = ((passed / participants) * 100).toFixed(2);
                } else {
                    passRate.value = '0.00';
                }
            }
        }

        function collectAllTableData() {
            // Collect data from all dynamic tables
            const tables = ['table-a11', 'table-a21', 'table-b11', 'table-b21', 'table-c11', 'table-c21', 'table-c31'];

            tables.forEach(tableId => {
                const table = document.getElementById(tableId);
                if (table) {
                    const hiddenInput = document.getElementById(tableId + '-input');
                    if (hiddenInput) {
                        const data = collectTableData(table);
                        hiddenInput.value = JSON.stringify(data);
                    }
                }
            });

            // Collect form data for C.3.2
            const formC32 = document.getElementById('form-c32');
            if (formC32) {
                const hiddenInput = document.getElementById('form-c32-input');
                if (hiddenInput) {
                    const data = collectFormData('form-c32');
                    hiddenInput.value = JSON.stringify(data);
                }
            }
        }

        function collectTableData(table) {
            const data = {
                header: {},
                rows: []
            };

            // Collect header inputs
            const headerInputs = table.closest('.table-card, .card')?.querySelectorAll('.header-input');
            if (headerInputs) {
                headerInputs.forEach(input => {
                    const key = input.dataset.key;
                    if (key) {
                        data.header[key] = input.value;
                    }
                });
            }

            // Collect rows
            table.querySelectorAll('tbody tr').forEach(row => {
                const rowData = {};

                row.querySelectorAll('input, select, textarea').forEach(input => {
                    const key = input.dataset.key;
                    if (key) {
                        if (input.type === 'radio') {
                            if (input.checked) {
                                rowData[key] = input.value;
                            }
                        } else if (input.type === 'checkbox') {
                            rowData[key] = input.checked;
                        } else {
                            rowData[key] = input.value;
                        }
                    }
                });

                // Only add row if it has data
                if (Object.keys(rowData).length > 0) {
                    data.rows.push(rowData);
                }
            });

            return data;
        }

        function collectFormData(formId) {
            const form = document.getElementById(formId);
            const data = {};

            if (form) {
                form.querySelectorAll('input, select, textarea').forEach(input => {
                    const section = input.dataset.section;
                    const field = input.dataset.field;

                    if (section && field) {
                        if (!data[section]) {
                            data[section] = {};
                        }
                        data[section][field] = input.value;
                    }
                });
            }

            return data;
        }
    </script>
@endpush
