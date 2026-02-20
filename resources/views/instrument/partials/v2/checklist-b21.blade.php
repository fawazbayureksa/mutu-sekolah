@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
@endphp

{{-- Checklist B.2.1: Penilaian Kesiapan Fasilitas --}}
<div class="card table-card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="icon-box me-3"
                style="width: 40px; height: 40px; background: #e7f1ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-check2-square text-primary"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-primary">Checklist Kesiapan Fasilitas</h6>
                <small class="text-muted">Isi checklist penilaian kesiapan fasilitas bengkel/lab</small>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        @php
            $initialValue = old('answers.B.2.1');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData);
            }
        @endphp
        <input type="hidden" name="answers[B.2.1]" id="table-b21-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table mb-0" id="table-b21">
                <thead>
                    <tr>
                        <th style="width: 50%">Aspek</th>
                        <th style="width: 10%" class="text-center">Ya</th>
                        <th style="width: 10%" class="text-center">Tidak</th>
                        <th style="width: 30%">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $checklistItems = [
                            [
                                'key' => 'layout_industry',
                                'label' => 'Apakah tata letak bengkel/lab meniru lingkungan kerja industri?',
                            ],
                            [
                                'key' => 'calibration',
                                'label' => 'Apakah peralatan telah melalui kalibrasi/pemeliharaan berkala?',
                            ],
                            [
                                'key' => 'sop_available',
                                'label' => 'Apakah tersedia prosedur operasi standar (SOP) untuk setiap alat utama?',
                            ],
                            [
                                'key' => 'k3_implementation',
                                'label' => 'Apakah K3 (Keselamatan dan Kesehatan Kerja) diterapkan dengan baik?',
                            ],
                        ];
                    @endphp
                    @foreach ($checklistItems as $index => $item)
                        @php
                            $rowData = $rows[$index] ?? [];
                        @endphp
                        <tr data-row="{{ $index }}">
                            <td>{{ $item['label'] }}</td>
                            <td class="text-center">
                                <div class="form-check d-flex justify-content-center">
                                    <input type="radio" class="form-check-input table-input"
                                        name="checklist_{{ $item['key'] }}" id="checklist_{{ $item['key'] }}_yes"
                                        data-key="{{ $item['key'] }}" data-row="{{ $index }}" value="yes"
                                        {{ ($rowData[$item['key']] ?? '') === 'yes' ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check d-flex justify-content-center">
                                    <input type="radio" class="form-check-input table-input"
                                        name="checklist_{{ $item['key'] }}" id="checklist_{{ $item['key'] }}_no"
                                        data-key="{{ $item['key'] }}" data-row="{{ $index }}" value="no"
                                        {{ ($rowData[$item['key']] ?? '') === 'no' ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="{{ $item['key'] }}_notes" data-row="{{ $index }}"
                                    placeholder="Catatan (opsional)"
                                    value="{{ $rowData["{$item['key']}_notes"] ?? '' }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
