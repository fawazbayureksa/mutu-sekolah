@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
    $rowCount = max(3, count($rows));
@endphp

{{-- Table A.1.1: Data Kelulusan Uji Kompetensi dan Sertifikasi --}}
<div class="card table-card">
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
                        <th style="width: 15%; white-space: normal;">Tahun Ajaran</th>
                        <th style="width: 50%; white-space: normal;">Nama Ujian/Sertifikasi</th>
                        <th style="width: 10%; white-space: normal;">Jumlah Peserta</th>
                        <th style="width: 10%; white-space: normal;">Jumlah Lulus</th>
                        <th style="width: 10%; white-space: normal;">Tingkat Kelulusan (%)</th>
                        <th style="width: 10%; white-space: normal;">Lembaga Sertifikasi/Penyelenggara</th>
                        <th style="width: 10%; white-space: normal;">Keterangan</th>
                        <th style="width: 10%"></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $rowCount; $i++)
                        @php
                            $rowData = $rows[$i] ?? [];
                        @endphp
                        <tr data-row="{{ $i }}">
                            <td class="text-center row-number">{{ $i + 1 }}</td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input" data-key="year"
                                    data-row="{{ $i }}" placeholder="2024/2025"
                                    value="{{ $rowData['year'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input" data-key="label"
                                    data-row="{{ $i }}"
                                    placeholder="Nama Sertifikasi (Contoh: UKK, Sertifikasi Profesi, TOEIC, BNSP)"
                                    value="{{ $rowData['label'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="total_participants" data-row="{{ $i }}" placeholder="0"
                                    min="0" value="{{ $rowData['total_participants'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="total_passed" data-row="{{ $i }}" placeholder="0"
                                    min="0" value="{{ $rowData['total_passed'] ?? '' }}">
                            </td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control table-input bg-light" data-key="pass_rate"
                                        data-row="{{ $i }}" placeholder="0.00" readonly
                                        value="{{ $rowData['pass_rate'] ?? '' }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="organizer" data-row="{{ $i }}" placeholder="Masukkan lembaga"
                                    value="{{ $rowData['organizer'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="organizer" data-row="{{ $i }}"
                                    placeholder="Skema Level II KKNI, 8 unit kompetensi"
                                    value="{{ $rowData['description'] ?? '' }}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-remove-row" title="Hapus baris">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        {{-- Add Row Button --}}
        <div class="p-3 text-center border-top">
            <button type="button" class="btn btn-add-row" data-table-id="table-a11">
                <i class="bi bi-plus-circle me-2"></i>Tambah Item
            </button>
        </div>
    </div>
</div>
