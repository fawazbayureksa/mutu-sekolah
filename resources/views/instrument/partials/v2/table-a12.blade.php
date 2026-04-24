@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
    $rowCount = max(3, count($rows));

    $samplePlaceholders = [
        0 => [
            'label' => 'Ahli Pengolahan Rumput Laut',
            'kkni_level' => 'Level II/III',
            'competency_units' => 10,
            'remarks' =>
                'Skema yang diakui BNSP dan LSP-KP. Mencakup kompetensi pengolahan hasil perikanan, termasuk rumput laut menjadi produk seperti dodol, selai, atau bakso.',
        ],
        1 => [
            'label' => 'Ahli Budidaya Rumput Laut',
            'kkni_level' => 'Level II/III',
            'competency_units' => 8,
            'remarks' =>
                'Mengacu pada Permen KKP No. 1 Tahun 2024 tentang Penerapan KKNI Bidang Budidaya Rumput Laut. Sertifikasi ini menjamin kemampuan pembudidaya mulai dari pembibitan hingga pemanenan sesuai standar.',
        ],
        2 => [
            'label' => 'IndoGAP – Cara Budidaya Ikan yang Baik (CBIB) Rumput Laut',
            'kkni_level' => 'Level III',
            'competency_units' => 6,
            'remarks' =>
                'Skema ini merupakan bagian dari Indonesian Good Aquaculture Practices (IndoGAP). Mengacu pada SNI 8228.2 tentang Cara Budidaya Ikan yang Baik untuk Rumput Laut.',
        ],
    ];
    $defaultPlaceholder = [
        'label' => 'Nama skema sertifikasi',
        'kkni_level' => 'Level II/III',
        'competency_units' => 0,
        'remarks' => 'Keterangan tambahan',
    ];
@endphp

{{-- Table A.1.2: Analisis Skema Sertifikasi dan Kesesuaian KKNI --}}
<div class="card table-card">
    <div class="card-body p-0">
        @php
            $initialValue = old('answers.A.1.2');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData, true);
            }
        @endphp
        <input type="hidden" name="answers[A.1.2]" id="table-a12-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table mb-0" id="table-a12">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 20%; white-space: normal;">Nama Skema Sertifikasi</th>
                        <th style="width: 15%; white-space: normal;">Jenis Kemasan Skema</th>
                        <th style="width: 10%; white-space: normal;">Jenjang KKNI</th>
                        <th style="width: 12%; white-space: normal;">Jumlah Unit Kompetensi</th>
                        <th style="width: 18%; white-space: normal;">Kesesuaian dengan SKKNI/Standar Industri</th>
                        <th style="width: 15%; white-space: normal;">Keterangan</th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $rowCount; $i++)
                        @php
                            $rowData = $rows[$i] ?? [];
                            $ph = $samplePlaceholders[$i] ?? $defaultPlaceholder;
                        @endphp
                        <tr data-row="{{ $i }}">
                            <td class="text-center row-number">{{ $i + 1 }}</td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input" data-key="label"
                                    data-row="{{ $i }}" placeholder="{{ $ph['label'] }}"
                                    value="{{ $rowData['label'] ?? '' }}">
                            </td>
                            <td>
                                <select class="form-select form-select-sm table-input scheme-type-select"
                                    data-key="scheme_type" data-row="{{ $i }}"
                                    onchange="toggleSchemeTypeInput(this)">
                                    <option value="">Pilih</option>
                                    <option value="Okupasi Nasional"
                                        {{ ($rowData['scheme_type'] ?? '') === 'Okupasi Nasional' ? 'selected' : '' }}>
                                        Okupasi Nasional</option>
                                    <option value="Klaster"
                                        {{ ($rowData['scheme_type'] ?? '') === 'Klaster' ? 'selected' : '' }}>Klaster
                                    </option>
                                    <option value="{{ config('constant.scheme_types.kkni') }}"
                                        {{ ($rowData['scheme_type'] ?? '') === config('constant.scheme_types.kkni') ? 'selected' : '' }}>
                                        {{ config('constant.scheme_types.kkni') }}</option>
                                    <option value="Lainnya"
                                        {{ ($rowData['scheme_type'] ?? '') === 'Lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                <input type="text"
                                    class="form-control form-control-sm table-input scheme-type-other mt-1"
                                    data-key="scheme_type_other" data-row="{{ $i }}"
                                    placeholder="Sebutkan jenis skema lainnya"
                                    style="display: {{ ($rowData['scheme_type'] ?? '') === 'Lainnya' ? 'block' : 'none' }};"
                                    value="{{ $rowData['scheme_type_other'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="kkni_level" data-row="{{ $i }}"
                                    placeholder="{{ $ph['kkni_level'] }}" value="{{ $rowData['kkni_level'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="competency_units" data-row="{{ $i }}"
                                    placeholder="{{ $ph['competency_units'] }}" min="0"
                                    value="{{ $rowData['competency_units'] ?? '' }}">
                            </td>
                            <td>
                                <select class="form-select form-select-sm table-input" data-key="compliance"
                                    data-row="{{ $i }}">
                                    <option value="">Pilih</option>
                                    <option value="Sesuai"
                                        {{ ($rowData['compliance'] ?? '') === 'Sesuai' ? 'selected' : '' }}>Sesuai
                                    </option>
                                    <option value="Sebagian"
                                        {{ ($rowData['compliance'] ?? '') === 'Sebagian' ? 'selected' : '' }}>Sebagian
                                    </option>
                                    <option value="Tidak Sesuai"
                                        {{ ($rowData['compliance'] ?? '') === 'Tidak Sesuai' ? 'selected' : '' }}>Tidak
                                        Sesuai</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="remarks" data-row="{{ $i }}"
                                    placeholder="{{ $ph['remarks'] }}" value="{{ $rowData['remarks'] ?? '' }}">
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
            <button type="button" class="btn btn-add-row" data-table-id="table-a12">
                <i class="bi bi-plus-circle me-2"></i>Tambah Item
            </button>
        </div>
    </div>
</div>

<script>
    function toggleSchemeTypeInput(selectElement) {
        const row = selectElement.closest('tr');
        const otherInput = row.querySelector('.scheme-type-other');
        if (selectElement.value === 'Lainnya') {
            otherInput.style.display = 'block';
        } else {
            otherInput.style.display = 'none';
            otherInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('#table-a12 .scheme-type-select').forEach(function(select) {
            if (select.value === 'Lainnya') {
                toggleSchemeTypeInput(select);
            }
        });
    });
</script>
