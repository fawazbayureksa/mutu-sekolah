@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $headerData = $existingData['header'] ?? [];
    $rows = $existingData['rows'] ?? [];
@endphp

{{-- Table A.2.1: Penelusuran Alumni (Tracer Study) --}}
<div class="card table-card">
    {{-- Header Input for Graduation Class --}}
    <div class="card-body border-bottom">
        <div class="header-input-group">
            <label class="form-label fw-semibold">Kelas Lulusan</label>
            <input type="text" class="form-control header-input" data-key="graduation_class"
                placeholder="Contoh: 2024/2025" style="max-width: 300px;"
                value="{{ $headerData['graduation_class'] ?? '' }}">
        </div>
    </div>

    <div class="card-body p-0">
        @php
            $initialValue = old('answers.A.2.1');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData);
            }
        @endphp
        <input type="hidden" name="answers[A.2.1]" id="table-a21-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table mb-0" id="table-a21">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 40%">Pertanyaan</th>
                        <th class="col-smk-pk-std" style="width: 10%; display: none;">Standar Minimal SMK PK (60%
                            lulusan terserap)</th>
                        <th style="width: 25%">Jawaban (Kuantitatif)</th>
                        <th style="width: 30%">Kualitatif (Jika Ada)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $tracerRows = [
                            [
                                'key' => 'total_graduates',
                                'label' => 'Jumlah total lulusan',
                                'quantitative_type' => 'number',
                                'quantitative_placeholder' => 'Masukkan jumlah',
                                'has_qualitative' => false,
                            ],
                            [
                                'key' => 'employment_rate',
                                'label' => 'Persentase bekerja (karyawan)',
                                'quantitative_type' => 'percentage',
                                'quantitative_placeholder' => '%',
                                'has_qualitative' => true,
                                'qualitative_placeholder' => 'Sebutkan sektor industri utama:',
                            ],
                            [
                                'key' => 'waiting_time',
                                'label' => 'Rata-rata waktu tunggu mendapatkan pekerjaan pertama',
                                'quantitative_type' => 'number',
                                'quantitative_placeholder' => 'bulan',
                                'quantitative_unit' => 'bulan',
                                'has_qualitative' => false,
                            ],
                            [
                                'key' => 'job_relevance',
                                'label' => 'Kesesuaian bidang kerja dengan kompetensi keahlian',
                                'quantitative_type' => 'percentage',
                                'quantitative_placeholder' => '%',
                                'has_qualitative' => false,
                            ],
                            [
                                'key' => 'user_satisfaction',
                                'label' => 'Tingkat kepuasan pengguna (dalam skala 1-5)',
                                'quantitative_type' => 'scale',
                                'quantitative_placeholder' => '1-5',
                                'has_qualitative' => true,
                                'qualitative_placeholder' => 'Testimoni/ulasan dari alumni/industri:',
                            ],
                            [
                                'key' => 'entrepreneurship_rate',
                                'label' => 'Persentase berwirausaha/membuka usaha',
                                'quantitative_type' => 'percentage',
                                'quantitative_placeholder' => '%',
                                'has_qualitative' => true,
                                'qualitative_placeholder' => 'Jenis usaha yang dikembangkan:',
                            ],
                            [
                                'key' => 'entrepreneurship_relevance',
                                'label' =>
                                    'Dari yang berwirausaha, persentase yang usahanya terkait dengan kompetensi keahlian SMK',
                                'quantitative_type' => 'percentage',
                                'quantitative_placeholder' => '%',
                                'has_qualitative' => false,
                            ],
                            [
                                'key' => 'continuing_education',
                                'label' => 'Persentase yang melanjutkan kuliah',
                                'quantitative_type' => 'percentage',
                                'quantitative_placeholder' => '%',
                                'has_qualitative' => false,
                            ],
                        ];
                    @endphp
                    @foreach ($tracerRows as $index => $row)
                        @php
                            $rowData = $rows[$index] ?? [];
                        @endphp
                        <tr data-row="{{ $index }}">
                            <td class="text-center row-number">{{ $index + 1 }}</td>
                            <td>{{ $row['label'] }}</td>
                            <td class="col-smk-pk-std" style="display: none;">
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="standard_minimal" data-row="{{ $index }}"
                                    value="{{ $rowData['standard_minimal'] ?? '' }}">
                            </td>
                            <td>
                                @if ($row['quantitative_type'] === 'percentage')
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control table-input"
                                            data-key="{{ $row['key'] }}_quantitative" data-row="{{ $index }}"
                                            placeholder="{{ $row['quantitative_placeholder'] }}" min="0"
                                            max="100" step="0.01"
                                            value="{{ $rowData["{$row['key']}_quantitative"] ?? '' }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                @elseif($row['quantitative_type'] === 'scale')
                                    <input type="number" class="form-control form-control-sm table-input"
                                        data-key="{{ $row['key'] }}_quantitative" data-row="{{ $index }}"
                                        placeholder="{{ $row['quantitative_placeholder'] }}" min="1"
                                        max="5" value="{{ $rowData["{$row['key']}_quantitative"] ?? '' }}">
                                @elseif(isset($row['quantitative_unit']))
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control table-input"
                                            data-key="{{ $row['key'] }}_quantitative" data-row="{{ $index }}"
                                            placeholder="{{ $row['quantitative_placeholder'] }}" min="0"
                                            value="{{ $rowData["{$row['key']}_quantitative"] ?? '' }}">
                                        <span class="input-group-text">{{ $row['quantitative_unit'] }}</span>
                                    </div>
                                @else
                                    <input type="number" class="form-control form-control-sm table-input"
                                        data-key="{{ $row['key'] }}_quantitative" data-row="{{ $index }}"
                                        placeholder="{{ $row['quantitative_placeholder'] }}" min="0"
                                        value="{{ $rowData["{$row['key']}_quantitative"] ?? '' }}">
                                @endif
                            </td>
                            <td>
                                @if ($row['has_qualitative'])
                                    <input type="text" class="form-control form-control-sm table-input"
                                        data-key="{{ $row['key'] }}_qualitative" data-row="{{ $index }}"
                                        placeholder="{{ $row['qualitative_placeholder'] ?? '' }}"
                                        value="{{ $rowData["{$row['key']}_qualitative"] ?? '' }}">
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
