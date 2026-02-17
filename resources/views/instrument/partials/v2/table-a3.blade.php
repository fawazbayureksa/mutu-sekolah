@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
    $rowCount = max(2, count($rows));
@endphp

{{-- Table A.3: Data Putus Sekolah dan Ketidaklulusan Kelas --}}
<div class="card table-card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="icon-box me-3"
                style="width: 40px; height: 40px; background: #e7f1ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-table text-primary"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-primary">Data Putus Sekolah dan Ketidaklulusan Kelas</h6>
                <small class="text-muted">Silahkan lengkapi data putus sekolah</small>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @php
            $initialValue = old('answers.A.3');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData, true);
            }
        @endphp
        <input type="hidden" name="answers[A.3]" id="table-a3-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table mb-0" id="table-a3">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 10%; white-space: normal;">Tahun Ajaran</th>
                        <th style="width: 13%; white-space: normal;">Jumlah Murid Awal (Kelas X/XI/XII)</th>
                        <th style="width: 13%; white-space: normal;">Jumlah Murid Akhir</th>
                        <th style="width: 13%; white-space: normal;">Jumlah Putus Sekolah</th>
                        <th style="width: 13%; white-space: normal;">Jumlah Tidak Naik Kelas</th>
                        <th style="width: 10%; white-space: normal;">% Putus Sekolah</th>
                        <th style="width: 18%; white-space: normal;">Faktor Utama Penyebab Putus Sekolah</th>
                        <th style="width: 5%"></th>
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
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="initial_students" data-row="{{ $i }}" placeholder="0"
                                    min="0" value="{{ $rowData['initial_students'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="final_students" data-row="{{ $i }}" placeholder="0"
                                    min="0" value="{{ $rowData['final_students'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="dropouts" data-row="{{ $i }}" placeholder="0" min="0"
                                    value="{{ $rowData['dropouts'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="failed_students" data-row="{{ $i }}" placeholder="0"
                                    min="0" value="{{ $rowData['failed_students'] ?? '' }}">
                            </td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control table-input bg-light"
                                        data-key="dropout_percentage" data-row="{{ $i }}" placeholder="0.00"
                                        readonly value="{{ $rowData['dropout_percentage'] ?? '' }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="main_factor" data-row="{{ $i }}"
                                    placeholder="Masukkan faktor utama" value="{{ $rowData['main_factor'] ?? '' }}">
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
            <button type="button" class="btn btn-add-row" data-table-id="table-a3">
                <i class="bi bi-plus-circle me-2"></i>Tambah Item
            </button>
        </div>
    </div>
</div>
