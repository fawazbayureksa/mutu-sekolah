@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];

    $aspectRows = [
        [
            'aspect' => 'Persentase guru produktif bersertifikat kompetensi (BNSP/Industri)',
            'placeholder' => '___% (Contoh: pengisian 12 dari 30 guru = 40%)',
            'target' => '80% guru produktif tersertifikasi',
        ],
        [
            'aspect' => 'Rata-rata jam pelatihan per guru per tahun',
            'placeholder' => '___ jam/tahun',
            'target' => 'Minimal 64 poin/tahun (setara 32 poin/semester))',
        ],
        [
            'aspect' => 'Keterlibatan dalam magang industri',
            'placeholder' => '___ orang/guru',
            'target' => 'Seluruh guru produktif pernah magang di industri',
        ],
        [
            'aspect' => 'Frekuensi update teknologi/kompetensi',
            'placeholder' => '___ kali dalam 3 tahun',
            'target' => 'Minimal 2 kali dalam 3 tahun',
        ],
        [
            'aspect' => 'Ketersediaan guru dengan sertifikat asesor BNSP',
            'placeholder' => '___ orang',
            'target' => 'Minimal 2 orang per kompetensi keahlian',
        ],
    ];
@endphp

{{-- Form C.3.2: Analisis Kebutuhan Pelatihan Guru ke Depan --}}
<div class="card table-card">
    <div class="card-body p-0">
        @php
            $initialValue = old('answers.C.3.2');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData);
            }
        @endphp
        <input type="hidden" name="answers[C.3.2]" id="table-c32-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table table-sm-header mb-0" id="table-c32">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aspek</th>
                        <th>Kondisi Saat Ini</th>
                        <th>Target Ideal</th>
                        <th>Kesenjangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aspectRows as $index => $row)
                        @php
                            $rowData = $rows[$index] ?? [];
                        @endphp
                        <tr data-row="{{ $index }}">
                            <td class="text-center row-number">{{ $index + 1 }}</td>
                            <td>
                                <span class="small">{{ $row['aspect'] }}</span>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="current_condition" data-row="{{ $index }}"
                                    placeholder="{{ $row['placeholder'] }}"
                                    value="{{ $rowData['current_condition'] ?? '' }}">
                            </td>
                            <td>
                                <span class="small text-muted">{{ $row['target'] }}</span>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input" data-key="gap"
                                    data-row="{{ $index }}" placeholder="Kesenjangan"
                                    value="{{ $rowData['gap'] ?? '' }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
