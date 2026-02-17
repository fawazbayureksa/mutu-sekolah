@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
@endphp

{{-- Table A.4: Data Skor Rata-rata TKA Tahun 2025 --}}
<div class="card table-card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="icon-box me-3"
                style="width: 40px; height: 40px; background: #e7f1ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-table text-primary"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-primary">Data Skor Rata-rata TKA Tahun 2025</h6>
                <small class="text-muted">Silahkan lengkapi data skor rata-rata TKA</small>
            </div>
        </div>
    </div>
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
                        <th style="width: 35%; white-space: normal;">Mata Pelajaran</th>
                        <th style="width: 15%; white-space: normal;">Rata-rata Sekolah</th>
                        <th style="width: 15%; white-space: normal;">Rata-rata Nasional 2025</th>
                        <th style="width: 10%; white-space: normal;">Selisih (+/-)</th>
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
                                'label' => 'Bahasa Indonesia Wajib',
                            ],
                            ['type' => 'subject', 'key' => 'matematika_wajib', 'label' => 'Matematika Wajib'],
                            ['type' => 'subject', 'key' => 'bahasa_inggris_wajib', 'label' => 'Bahasa Inggris Wajib'],
                            ['type' => 'header', 'label' => 'Pilihan:'],
                            ['type' => 'subject', 'key' => 'ppkn', 'label' => 'PPKN'],
                            ['type' => 'subject', 'key' => 'antropologi', 'label' => 'Antropologi'],
                            [
                                'type' => 'subject',
                                'key' => 'projek_kreatif',
                                'label' => 'Projek Kreatif & Kewirausahaan',
                            ],
                            [
                                'type' => 'subject',
                                'key' => 'bahasa_indonesia_lanjut',
                                'label' => 'Bahasa Indonesia Lanjut',
                            ],
                            ['type' => 'subject', 'key' => 'matematika_lanjut', 'label' => 'Matematika Lanjut'],
                            ['type' => 'subject', 'key' => 'bahasa_inggris_lanjut', 'label' => 'Bahasa Inggris Lanjut'],
                            ['type' => 'subject', 'key' => 'biologi', 'label' => 'Biologi'],
                            ['type' => 'subject', 'key' => 'sosiologi', 'label' => 'Sosiologi'],
                            ['type' => 'subject', 'key' => 'ekonomi', 'label' => 'Ekonomi'],
                            ['type' => 'subject', 'key' => 'kimia', 'label' => 'Kimia'],
                            ['type' => 'subject', 'key' => 'sejarah', 'label' => 'Sejarah'],
                            ['type' => 'subject', 'key' => 'fisika', 'label' => 'Fisika'],
                            ['type' => 'subject', 'key' => 'geografi', 'label' => 'Geografi'],
                            ['type' => 'subject', 'key' => 'bahasa_arab', 'label' => 'Bahasa Arab'],
                            ['type' => 'subject', 'key' => 'bahasa_jepang', 'label' => 'Bahasa Jepang'],
                            ['type' => 'subject', 'key' => 'bahasa_mandarin', 'label' => 'Bahasa Mandarin'],
                            ['type' => 'subject', 'key' => 'bahasa_jerman', 'label' => 'Bahasa Jerman'],
                            ['type' => 'subject', 'key' => 'bahasa_korea', 'label' => 'Bahasa Korea'],
                            ['type' => 'subject', 'key' => 'bahasa_prancis', 'label' => 'Bahasa Prancis'],
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
                            @endphp
                            <tr data-row="{{ $index }}">
                                <td class="text-center">{{ $rowNumber }}</td>
                                <td>{{ $subject['label'] }}</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm table-input"
                                        data-key="{{ $subject['key'] }}_school_avg" data-row="{{ $index }}"
                                        placeholder="0.00" min="0" max="100" step="0.01"
                                        value="{{ $rowData["{$subject['key']}_school_avg"] ?? '' }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm table-input"
                                        data-key="{{ $subject['key'] }}_national_avg" data-row="{{ $index }}"
                                        placeholder="0.00" min="0" max="100" step="0.01"
                                        value="{{ $rowData["{$subject['key']}_national_avg"] ?? '' }}">
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
