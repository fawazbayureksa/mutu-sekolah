@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
    $rowCount = max(2, count($rows));
@endphp

{{-- Table C.1.1: Kerjasama Industri (Dynamic Rows) --}}
<div class="card table-card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="icon-box me-3"
                style="width: 40px; height: 40px; background: #e7f1ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-building text-primary"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-primary">Data Kerjasama Industri</h6>
                <small class="text-muted">Silahkan lengkapi data kerjasama dengan industri mitra</small>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        @php
            $initialValue = old('answers.C.1.1');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData);
            }
        @endphp
        <input type="hidden" name="answers[C.1.1]" id="table-c11-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table mb-0" id="table-c11">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 20%">Nama Industri Mitra</th>
                        <th style="width: 20%">Bentuk Kerjasama</th>
                        <th style="width: 12%">Durasi Kerjasama</th>
                        <th style="width: 23%">Output/Kontribusi Nyata</th>
                        <th style="width: 15%">Status MoU/MoA</th>
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
                                    data-row="{{ $i }}" placeholder="Nama industri"
                                    value="{{ $rowData['label'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="cooperation_type" data-row="{{ $i }}"
                                    placeholder="Magang, Rekrutmen, Donasi Alat, dll"
                                    value="{{ $rowData['cooperation_type'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="duration" data-row="{{ $i }}" placeholder="Contoh: 1 tahun"
                                    value="{{ $rowData['duration'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input" data-key="output"
                                    data-row="{{ $i }}" placeholder="Jumlah siswa magang, nilai bantuan, dll"
                                    value="{{ $rowData['output'] ?? '' }}">
                            </td>
                            <td>
                                <select class="form-select form-select-sm table-input" data-key="mou_status"
                                    data-row="{{ $i }}">
                                    <option value="">Pilih</option>
                                    <option value="Aktif"
                                        {{ ($rowData['mou_status'] ?? '') === 'Aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="Tidak"
                                        {{ ($rowData['mou_status'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
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
            <button type="button" class="btn btn-add-row" data-table-id="table-c11">
                <i class="bi bi-plus-circle me-2"></i>Tambah Mitra Industri
            </button>
        </div>
    </div>
</div>
