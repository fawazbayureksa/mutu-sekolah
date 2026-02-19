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
                                <select type="text"
                                    class="form-control form-control-sm table-input main-factor-select"
                                    data-key="main_factor" data-row="{{ $i }}"
                                    onchange="toggleOtherInput(this)">
                                    <option value="">-- Pilih Faktor Utama --</option>
                                    <option value="Ekonomi">Ekonomi</option>
                                    <option value="Bekerja/Menikah">Bekerja/Menikah</option>
                                    <option value="Pindah">Pindah</option>
                                    <option value="Lainnya">Lainnya (3 siswa berhenti untuk bekerja melaut)</option>
                                </select>
                                <input type="text"
                                    class="form-control form-control-sm table-input main-factor-other mt-2"
                                    data-key="main_factor_other" data-row="{{ $i }}"
                                    placeholder="Jelaskan faktor lainnya" style="display: none;"
                                    value="{{ $rowData['main_factor_other'] ?? '' }}">
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

<script>
    function toggleOtherInput(selectElement) {
        const row = selectElement.closest('tr');
        const otherInput = row.querySelector('.main-factor-other');

        if (selectElement.value === 'Lainnya') {
            otherInput.style.display = 'block';
        } else {
            otherInput.style.display = 'none';
            otherInput.value = '';
        }
    }

    // Initialize existing rows
    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll('.main-factor-select');
        selects.forEach(function(select) {
            if (select.value) {
                toggleOtherInput(select);
            }
        });
    });
</script>
