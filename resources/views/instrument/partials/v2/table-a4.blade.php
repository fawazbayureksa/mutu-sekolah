@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
@endphp

{{-- Table A.4: Data Skor Rata-rata TKA Tahun 2025 --}}
<div class="card table-card">
    <div class="card-body p-0">
        @php
            $initialValue = old('answers.A.4');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData, true);
            }
        @endphp
        <input type="hidden" name="answers[A.4]" id="table-a4-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table mb-0" id="table-a4">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 30%; white-space: normal;">Mata Pelajaran</th>
                        <th style="width: 15%; white-space: normal;">Rata-rata Nasional 2025</th>
                        <th style="width: 15%; white-space: normal;">Rata-rata Sekolah 2025</th>
                        <th style="width: 15%; white-space: normal;">Selisih (+/-)</th>
                        <th style="width: 20%; white-space: normal;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subjects = [
                            ['type' => 'header', 'label' => 'Wajib'],
                            [
                                'type' => 'subject',
                                'key' => 'bahasa_indonesia_wajib',
                                'label' => 'Bahasa Indonesia',
                                'national_avg' => 55.38,
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'matematika_wajib',
                                'label' => 'Matematika',
                                'national_avg' => 36.1,
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'bahasa_inggris_wajib',
                                'label' => 'Bahasa Inggris',
                                'national_avg' => 24.93,
                            ],
                            ['type' => 'header', 'label' => 'Pilihan:'],
                            ['type' => 'subject', 'key' => 'ppkn', 'label' => 'PPKN', 'national_avg' => 60.91],
                            [
                                'type' => 'subject',
                                'key' => 'antropologi',
                                'label' => 'Antropologi',
                                'national_avg' => 70.43,
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'projek_kreatif',
                                'label' => 'Projek Kreatif & Kewirausahaan',
                                'national_avg' => 56.34,
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'bahasa_indonesia_lanjut',
                                'label' => 'Bahasa Indonesia Lanjut',
                                'national_avg' => 68.02,
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'matematika_lanjut',
                                'label' => 'Matematika Lanjut',
                                'national_avg' => 39.32,
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'bahasa_inggris_lanjut',
                                'label' => 'Bahasa Inggris Lanjut',
                                'national_avg' => 45.23,
                            ],
                            ['type' => 'subject', 'key' => 'biologi', 'label' => 'Biologi', 'national_avg' => 54.4],
                            [
                                'type' => 'subject',
                                'key' => 'sosiologi',
                                'label' => 'Sosiologi',
                                'national_avg' => 60.07,
                            ],
                            ['type' => 'subject', 'key' => 'ekonomi', 'label' => 'Ekonomi', 'national_avg' => 31.68],
                            ['type' => 'subject', 'key' => 'kimia', 'label' => 'Kimia', 'national_avg' => 34.92],
                            ['type' => 'subject', 'key' => 'sejarah', 'label' => 'Sejarah', 'national_avg' => 62.72],
                            ['type' => 'subject', 'key' => 'fisika', 'label' => 'Fisika', 'national_avg' => 37.65],
                            ['type' => 'subject', 'key' => 'geografi', 'label' => 'Geografi', 'national_avg' => 70.36],
                            [
                                'type' => 'subject',
                                'key' => 'bahasa_arab',
                                'label' => 'Bahasa Arab',
                                'national_avg' => 64.97,
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'bahasa_jepang',
                                'label' => 'Bahasa Jepang',
                                'national_avg' => 55.21,
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'bahasa_mandarin',
                                'label' => 'Bahasa Mandarin',
                                'national_avg' => 57.66,
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'bahasa_jerman',
                                'label' => 'Bahasa Jerman',
                                'national_avg' => 36.59,
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'bahasa_korea',
                                'label' => 'Bahasa Korea',
                                'national_avg' => 28.55,
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'bahasa_prancis',
                                'label' => 'Bahasa Prancis',
                                'national_avg' => 45.05,
                            ],
                        ];
                    @endphp
                    @php
                        $rowNumber = 0;
                    @endphp
                    @foreach ($subjects as $index => $subject)
                        @if ($subject['type'] === 'header')
                            <tr class="table-secondary">
                                <td colspan="6" class="fw-bold">{{ $subject['label'] }}</td>
                            </tr>
                        @else
                            @php
                                $rowData = $rows[$index] ?? [];
                                $rowNumber++;
                                $nationalAvgValue =
                                    $rowData["{$subject['key']}_national_avg"] ??
                                    number_format($subject['national_avg'], 2, '.', '');
                            @endphp
                            <tr data-row="{{ $index }}">
                                <td class="text-center">{{ $rowNumber }}</td>
                                <td>{{ $subject['label'] }}</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm table-input bg-light"
                                        data-key="{{ $subject['key'] }}_national_avg" data-row="{{ $index }}"
                                        placeholder="0.00" min="0" max="100" step="0.01"
                                        value="{{ $nationalAvgValue }}" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm table-input"
                                        data-key="{{ $subject['key'] }}_school_avg" data-row="{{ $index }}"
                                        placeholder="0.00" min="0" max="100" step="0.01"
                                        value="{{ $rowData["{$subject['key']}_school_avg"] ?? '' }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm table-input bg-light"
                                        data-key="{{ $subject['key'] }}_difference" data-row="{{ $index }}"
                                        placeholder="0.00" readonly
                                        value="{{ $rowData["{$subject['key']}_difference"] ?? '' }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm table-input"
                                        data-key="{{ $subject['key'] }}_remarks" data-row="{{ $index }}"
                                        placeholder="Keterangan"
                                        value="{{ $rowData["{$subject['key']}_remarks"] ?? '' }}">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Auto-calculate Selisih on page load for rows that already have school avg values --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tableA4 = document.getElementById('table-a4');
        if (tableA4) {
            tableA4.querySelectorAll('tbody tr[data-row]').forEach(function(row) {
                var inputs = row.querySelectorAll('.table-input');
                var schoolAvg = null;
                var nationalAvg = null;
                var differenceField = null;

                inputs.forEach(function(input) {
                    var key = input.dataset.key;
                    if (key && key.endsWith('_school_avg')) {
                        schoolAvg = input;
                    } else if (key && key.endsWith('_national_avg')) {
                        nationalAvg = input;
                    } else if (key && key.endsWith('_difference')) {
                        differenceField = input;
                    }
                });

                if (schoolAvg && nationalAvg && differenceField && schoolAvg.value) {
                    var school = parseFloat(schoolAvg.value) || 0;
                    var national = parseFloat(nationalAvg.value) || 0;
                    var diff = school - national;
                    differenceField.value = diff.toFixed(2);
                }
            });
        }
    });
</script>
