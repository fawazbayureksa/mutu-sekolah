@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
    $rowCount = max(2, count($rows));
@endphp

{{-- Table C.3.1: Data Pelatihan dan Sertifikasi Guru yang Telah Diikuti (Dynamic Rows) --}}
<div class="card table-card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="icon-box me-3"
                style="width: 40px; height: 40px; background: #e7f1ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-person-badge text-primary"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-primary">Data Pelatihan dan Sertifikasi Guru</h6>
                <small class="text-muted">Silahkan lengkapi data pelatihan dan sertifikasi yang telah diikuti oleh
                    guru</small>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        @php
            $initialValue = old('answers[C.3.1]');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData);
            }
        @endphp
        <input type="hidden" name="answers[C.3.1]" id="table-c31-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table mb-0" id="table-c31">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 18%">Nama Guru</th>
                        <th style="width: 15%">Mata Pelajaran/Keahlian</th>
                        <th style="width: 20%">Jenis Pelatihan/Sertifikasi</th>
                        <th style="width: 8%">Tahun</th>
                        <th style="width: 15%">Penyedia (Industri/Lembaga)</th>
                        <th style="width: 14%">Bukti/Dokumen</th>
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
                                    data-row="{{ $i }}" placeholder="Nama guru"
                                    value="{{ $rowData['label'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="subject" data-row="{{ $i }}" placeholder="Mata pelajaran"
                                    value="{{ $rowData['subject'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="training_type" data-row="{{ $i }}"
                                    placeholder="Contoh: Pelatihan CNC, Sertifikat Asesor BNSP"
                                    value="{{ $rowData['training_type'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input" data-key="year"
                                    data-row="{{ $i }}" placeholder="Tahun" min="2000" max="2100"
                                    value="{{ $rowData['year'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="provider" data-row="{{ $i }}" placeholder="Nama penyedia"
                                    value="{{ $rowData['provider'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="evidence" data-row="{{ $i }}" placeholder="Keterangan bukti"
                                    value="{{ $rowData['evidence'] ?? '' }}">
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
            <button type="button" class="btn btn-add-row" data-table-id="table-c31">
                <i class="bi bi-plus-circle me-2"></i>Tambah Data Guru
            </button>
        </div>
    </div>
</div>
