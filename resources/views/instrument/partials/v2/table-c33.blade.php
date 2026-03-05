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
                        <th style="min-width: 40px; white-space:normal;">No</th>
                        <th style="min-width: 160px; white-space:normal;">Konsentrasi Keahlian</th>
                        <th style="min-width: 140px; white-space:normal;">Jumlah Guru (Produktif, Normatif, Adaptif)
                        </th>
                        <th style="min-width: 120px; white-space:normal;">Jumlah Total Murid (Kelas X, XI, XII)</th>
                        <th style="min-width: 180px; white-space:normal;">Rasio Ideal (Guru PNA : Murid)</th>
                        <th style="min-width: 130px; white-space:normal;">Rasio Guru:Murid (G:M)</th>
                        <th style="min-width: 160px; white-space:normal;">Jumlah Konsentrasi Keahlian per Bidang
                            Keahlian (Kemaritiman/Perikanan/Teknologi Informasi)</th>
                        <th style="min-width: 140px; white-space:normal;">Jumlah Guru Produktif : Konsentrasi Keahlian
                        </th>
                        <th style="min-width: 200px; white-space:normal;">Rasio Ideal (Guru Produktif : Konsentrasi
                            Keahlian)</th>
                        <th style="min-width: 160px; white-space:normal;">Rasio Guru Produktif : Konsentrasi Keahlian
                        </th>
                        <th style="min-width: 140px; white-space:normal;">Keterangan</th>
                        <th style="min-width: 45px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $rowCount; $i++)
                        @php
                            $rowData = $rows[$i] ?? [];
                        @endphp
                        <tr data-row="{{ $i }}">
                            <td class="text-center row-number">{{ $i + 1 }}</td>

                            {{-- Konsentrasi Keahlian (auto-filled from dropdown) --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input bg-light"
                                    data-key="concentration" data-row="{{ $i }}"
                                    id="c33-concentration-{{ $i }}"
                                    placeholder="Otomatis dari pilihan Konsentrasi"
                                    value="{{ $rowData['concentration'] ?? '' }}" readonly>
                            </td>

                            {{-- Jumlah Guru PNA (Produktif, Normatif, Adaptif) --}}
                            <td>
                                <input type="number" class="form-control form-control-sm table-input c33-total-teacher"
                                    data-key="total_teacher_count" data-row="{{ $i }}" placeholder="Jumlah"
                                    min="0" value="{{ $rowData['total_teacher_count'] ?? '' }}">
                            </td>

                            {{-- Jumlah Total Murid --}}
                            <td>
                                <input type="number" class="form-control form-control-sm table-input c33-student"
                                    data-key="student_count" data-row="{{ $i }}" placeholder="Jumlah"
                                    min="0" value="{{ $rowData['student_count'] ?? '' }}">
                            </td>

                            {{-- Rasio Ideal Guru PNA : Murid (readonly) --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input bg-light"
                                    data-key="ideal_ratio" data-row="{{ $i }}"
                                    value="{{ $rowData['ideal_ratio'] ?? '1 : 15 (satu guru untuk 15 siswa)' }}"
                                    readonly>
                            </td>

                            {{-- Rasio Guru:Murid G:M (auto-calculated) --}}
                            <td>
                                <input type="text"
                                    class="form-control form-control-sm table-input bg-light c33-ratio-gm"
                                    data-key="ratio_gm" data-row="{{ $i }}" placeholder="Otomatis" readonly
                                    value="{{ $rowData['ratio_gm'] ?? '' }}">
                            </td>

                            {{-- Jumlah Konsentrasi per Bidang --}}
                            <td>
                                <input type="number"
                                    class="form-control form-control-sm table-input c33-concentration-count"
                                    data-key="concentration_count" data-row="{{ $i }}" placeholder="Jumlah"
                                    min="1" value="{{ $rowData['concentration_count'] ?? '' }}">
                            </td>

                            {{-- Jumlah Guru Produktif --}}
                            <td>
                                <input type="number"
                                    class="form-control form-control-sm table-input c33-productive-teacher"
                                    data-key="productive_teacher_count" data-row="{{ $i }}"
                                    placeholder="Jumlah" min="0"
                                    value="{{ $rowData['productive_teacher_count'] ?? '' }}">
                            </td>

                            {{-- Rasio Ideal Guru Produktif : Konsentrasi (readonly) --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input bg-light"
                                    data-key="ideal_productive_ratio" data-row="{{ $i }}"
                                    value="{{ $rowData['ideal_productive_ratio'] ?? '1 : 5 (5 guru produktif untuk 1 konsentrasi keahlian)' }}"
                                    readonly>
                            </td>

                            {{-- Rasio Guru Produktif : Konsentrasi (auto-calculated) --}}
                            <td>
                                <input type="text"
                                    class="form-control form-control-sm table-input bg-light c33-ratio-pc"
                                    data-key="ratio_productive_concentration" data-row="{{ $i }}"
                                    placeholder="Otomatis" readonly
                                    value="{{ $rowData['ratio_productive_concentration'] ?? '' }}">
                            </td>

                            {{-- Keterangan --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="remarks" data-row="{{ $i }}" placeholder="Misal: Guru rangkap"
                                    value="{{ $rowData['remarks'] ?? '' }}">
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

<script>
    (function() {
        // Ratio map sourced from config/constant.php
        const idealProductiveRatioMap = @json(config('constant.ideal_productive_ratio_by_bidang'));
        const defaultRatio = idealProductiveRatioMap['_default'] ??
            '1 : 5 (minimal 5 guru produktif per konsentrasi keahlian)';

        function getRatioForBidang(bidang) {
            return idealProductiveRatioMap[bidang] ?? defaultRatio;
        }

        function syncC33Concentration(value) {
            document.querySelectorAll('#table-c33 input[data-key="concentration"]').forEach(function(input) {
                input.value = value;
            });
        }

        function syncC33IdealProductiveRatio(bidang) {
            const ratio = getRatioForBidang(bidang);
            document.querySelectorAll('#table-c33 input[data-key="ideal_productive_ratio"]').forEach(function(
                input) {
                input.value = ratio;
            });
        }

        function calcC33Ratios(row) {
            const totalTeacherInput = row.querySelector('.c33-total-teacher');
            const studentInput = row.querySelector('.c33-student');
            const productiveInput = row.querySelector('.c33-productive-teacher');
            const concCountInput = row.querySelector('.c33-concentration-count');
            const ratioGmInput = row.querySelector('.c33-ratio-gm');
            const ratioPcInput = row.querySelector('.c33-ratio-pc');

            const totalTeachers = parseFloat(totalTeacherInput?.value) || 0;
            const students = parseFloat(studentInput?.value) || 0;
            const productive = parseFloat(productiveInput?.value) || 0;
            const concCount = parseFloat(concCountInput?.value) || 0;

            // Rasio Guru PNA : Murid — uses total PNA teacher count
            if (ratioGmInput) {
                if (totalTeachers > 0 && students > 0) {
                    const r = (students / totalTeachers).toFixed(1);
                    ratioGmInput.value = `1 : ${r}`;
                } else {
                    ratioGmInput.value = '';
                }
            }

            // Rasio Guru Produktif : Konsentrasi
            if (ratioPcInput) {
                if (productive > 0 && concCount > 0) {
                    const r = (productive / concCount).toFixed(1);
                    ratioPcInput.value = `${r} : 1`;
                } else {
                    ratioPcInput.value = '';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const concentrationSelect = document.getElementById('expertiseConcentrationSelect');
            const expertiseSelect = document.getElementById('expertiseSelect');
            const table = document.getElementById('table-c33');
            if (!table) return;

            // Initialize ideal productive ratio from current Bidang Keahlian selection
            if (expertiseSelect && expertiseSelect.value) {
                syncC33IdealProductiveRatio(expertiseSelect.value);
            }

            // Sync ideal productive ratio whenever Bidang Keahlian changes
            if (expertiseSelect) {
                expertiseSelect.addEventListener('change', function() {
                    syncC33IdealProductiveRatio(this.value);
                });
            }

            // Sync concentration dropdown → table
            if (concentrationSelect) {
                if (concentrationSelect.value) syncC33Concentration(concentrationSelect.value);
                concentrationSelect.addEventListener('change', function() {
                    syncC33Concentration(this.value);
                });
            }

            // Auto-calculate ratios on input change
            table.addEventListener('input', function(e) {
                const row = e.target.closest('tr');
                if (row) calcC33Ratios(row);
            });

            // Run calculations for pre-filled rows
            table.querySelectorAll('tbody tr').forEach(calcC33Ratios);

            // Sync on new row added
            const addBtn = document.querySelector('[data-table-id="table-c33"].btn-add-row');
            if (addBtn) {
                addBtn.addEventListener('click', function() {
                    setTimeout(function() {
                        if (concentrationSelect) syncC33Concentration(concentrationSelect
                            .value);
                        if (expertiseSelect) syncC33IdealProductiveRatio(expertiseSelect
                            .value);
                    }, 50);
                });
            }
        });
    })();
</script>
