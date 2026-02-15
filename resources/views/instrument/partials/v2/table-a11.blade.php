@php
    $existingData = $existingData ?? [];
    $rows = $existingData['rows'] ?? [];
@endphp

{{-- Table A.1.1: Data Kelulusan Uji Kompetensi dan Sertifikasi --}}
<div class="card table-card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="icon-box me-3"
                style="width: 40px; height: 40px; background: #e7f1ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-table text-primary"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-primary">Input Data Tabel</h6>
                <small class="text-muted">Silahkan lengkapi data pada tabel di bawah ini</small>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @php
            $initialValue = old('answers.A.1.1');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData, true);
            }
        @endphp
        <input type="hidden" name="answers[A.1.1]" id="table-a11-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table mb-0" id="table-a11">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 25%">Nama Ujian/Sertifikasi</th>
                        <th style="width: 10%">Tahun</th>
                        <th style="width: 12%">Jumlah Peserta</th>
                        <th style="width: 12%">Jumlah Lulus</th>
                        <th style="width: 12%">Tingkat Kelulusan (%)</th>
                        <th style="width: 24%">Lembaga Sertifikasi/Penyelenggara</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $defaultRows = [
                            ['label' => 'Uji Kompetensi Keahlian (UKK) Mandiri'],
                            ['label' => 'Uji Kompetensi Keahlian (UKK) LSP'],
                            ['label' => 'Sertifikasi Profesi (Contoh: BNSP, TOEIC, dll)'],
                        ];
                    @endphp
                    @foreach ($defaultRows as $index => $row)
                        @php
                            $rowData = $rows[$index] ?? [];
                        @endphp
                        <tr data-row="{{ $index }}">
                            <td class="text-center row-number">{{ $index + 1 }}</td>
                            <td>{{ $row['label'] }}</td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input" data-key="year"
                                    data-row="{{ $index }}" placeholder="Tahun" min="2000" max="2100"
                                    value="{{ $rowData['year'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="total_participants" data-row="{{ $index }}" placeholder="0"
                                    min="0" value="{{ $rowData['total_participants'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="total_passed" data-row="{{ $index }}" placeholder="0"
                                    min="0" value="{{ $rowData['total_passed'] ?? '' }}">
                            </td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control table-input bg-light" data-key="pass_rate"
                                        data-row="{{ $index }}" placeholder="0.00" readonly
                                        value="{{ $rowData['pass_rate'] ?? '' }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="organizer" data-row="{{ $index }}" placeholder="Masukkan lembaga"
                                    value="{{ $rowData['organizer'] ?? '' }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
