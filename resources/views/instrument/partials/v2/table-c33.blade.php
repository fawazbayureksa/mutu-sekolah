@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
    $rowCount = max(1, count($rows));
@endphp

{{-- Table C.3.3: Data Ketenagaan dan Beban Mengajar (Rasio Guru-Murid) --}}
<div class="card table-card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="icon-box me-3"
                style="width: 40px; height: 40px; background: #e7f1ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-people text-primary"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-primary">C3.3 Data Ketenagaan dan Beban Mengajar (Rasio Guru-Murid)</h6>
                <small class="text-muted">Isikan untuk setiap Kompetensi Keahlian (Konsentrasi) yang aktif</small>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        @php
            $initialValue = old('answers[C.3.3]');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData);
            }
        @endphp
        <input type="hidden" name="answers[C.3.3]" id="table-c33-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table table-sm-header mb-0" id="table-c33">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kompetensi Keahlian (Konsentrasi)</th>
                        <th>Jumlah Guru Produktif</th>
                        <th>Jumlah Total Murid (Kelas X, XI, XII)</th>
                        <th>Rasio Guru:Siswa</th>
                        <th>Keterangan</th>
                        <th></th>
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
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="concentration" data-row="{{ $i }}"
                                    placeholder="Nama konsentrasi keahlian"
                                    value="{{ $rowData['concentration'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="teacher_count" data-row="{{ $i }}" placeholder="Jumlah"
                                    min="0" value="{{ $rowData['teacher_count'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="student_count" data-row="{{ $i }}" placeholder="Jumlah"
                                    min="0" value="{{ $rowData['student_count'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input bg-light"
                                    data-key="ratio" data-row="{{ $i }}" placeholder="Otomatis" readonly
                                    value="{{ $rowData['ratio'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="remarks" data-row="{{ $i }}"
                                    placeholder="Misal: kurang/cukup/ideal" value="{{ $rowData['remarks'] ?? '' }}">
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
            <button type="button" class="btn btn-add-row" data-table-id="table-c33">
                <i class="bi bi-plus-circle me-2"></i>Tambah Data Konsentrasi
            </button>
        </div>
    </div>
</div>
