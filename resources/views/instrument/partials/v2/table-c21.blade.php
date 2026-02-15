@php
    $existingData = $existingData ?? [];
    $rows = $existingData['rows'] ?? [];
    $rowCount = max(2, count($rows));
@endphp

{{-- Table C.2.1: Teaching Factory (TEFA) / Unit Produksi Sekolah (Dynamic Rows) --}}
<div class="card table-card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="icon-box me-3"
                style="width: 40px; height: 40px; background: #e7f1ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-gear text-primary"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-primary">Data Teaching Factory (TEFA)</h6>
                <small class="text-muted">Silahkan lengkapi data program Teaching Factory atau Unit Produksi
                    Sekolah</small>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        @php
            $initialValue = old('answers.C.2.1');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData);
            }
        @endphp
        <input type="hidden" name="answers[C.2.1]" id="table-c21-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table mb-0" id="table-c21">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 20%">Nama Program TEFA/Produk</th>
                        <th style="width: 15%">Mitra Industri (Jika ada)</th>
                        <th style="width: 15%">Skala Operasi</th>
                        <th style="width: 25%">Pencapaian & Manfaat</th>
                        <th style="width: 15%">Kendala</th>
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
                                    data-row="{{ $i }}" placeholder="Nama program/produk"
                                    value="{{ $rowData['label'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="industry_partner" data-row="{{ $i }}"
                                    placeholder="Nama mitra industri"
                                    value="{{ $rowData['industry_partner'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="operation_scale" data-row="{{ $i }}"
                                    placeholder="Siswa/Guru/Tim Khusus"
                                    value="{{ $rowData['operation_scale'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="achievement" data-row="{{ $i }}"
                                    placeholder="Output, penjualan, pengalaman"
                                    value="{{ $rowData['achievement'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="constraints" data-row="{{ $i }}"
                                    placeholder="Kendala yang dihadapi"
                                    value="{{ $rowData['constraints'] ?? '' }}">
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
            <button type="button" class="btn btn-add-row" data-table-id="table-c21">
                <i class="bi bi-plus-circle me-2"></i>Tambah Program TEFA
            </button>
        </div>
    </div>
</div>
