@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
    $rowCount = max(3, count($rows));
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
                        @endphp
                        <tr data-row="{{ $i }}">
                            <td class="text-center row-number">{{ $i + 1 }}</td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input" data-key="label"
                                    data-row="{{ $i }}" placeholder="Nama skema sertifikasi"
                                    value="{{ $rowData['label'] ?? '' }}">
                            </td>
                            <td>
                                <select class="form-select form-select-sm table-input" data-key="scheme_type"
                                    data-row="{{ $i }}">
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
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="kkni_level" data-row="{{ $i }}" placeholder="Level II/III"
                                    value="{{ $rowData['kkni_level'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="competency_units" data-row="{{ $i }}" placeholder="0"
                                    min="0" value="{{ $rowData['competency_units'] ?? '' }}">
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
                                    data-key="remarks" data-row="{{ $i }}" placeholder="Keterangan"
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
            <button type="button" class="btn btn-add-row" data-table-id="table-a12">
                <i class="bi bi-plus-circle me-2"></i>Tambah Item
            </button>
        </div>
    </div>
</div>
