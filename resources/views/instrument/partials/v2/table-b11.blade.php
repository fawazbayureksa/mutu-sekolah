{{-- Table B.1.1: Inventarisasi dan Kesesuaian dengan Standar Industri (Dynamic Rows) --}}
<div class="card table-card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="icon-box me-3"
                style="width: 40px; height: 40px; background: #e7f1ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-table text-primary"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-primary">Input Data Inventaris</h6>
                <small class="text-muted">Silahkan lengkapi data inventaris perangkat bengkel/lab</small>
            </div>
        </div>
    </div>

    {{-- Header Inputs --}}
    <div class="card-body border-bottom">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="header-input-group mb-0">
                    <label class="form-label fw-semibold">Nama Bengkel/Lab</label>
                    <input type="text" class="form-control header-input" data-key="workshop_name"
                        placeholder="Masukkan nama bengkel/lab">
                </div>
            </div>
            <div class="col-md-6">
                <div class="header-input-group mb-0">
                    <label class="form-label fw-semibold">Bidang Keahlian</label>
                    <input type="text" class="form-control header-input" data-key="expertise_field"
                        placeholder="Masukkan bidang keahlian">
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <input type="hidden" name="answers[B.1.1]" id="table-b11-input" value="{{ old('answers.B.1.1', '{}') }}">

        <div class="table-responsive">
            <table class="table instrument-table mb-0" id="table-b11">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 18%">Item/Perangkat</th>
                        <th style="width: 15%">Spesifikasi</th>
                        <th style="width: 10%">Jumlah Unit</th>
                        <th style="width: 12%">Kondisi</th>
                        <th style="width: 15%">Kesesuaian Standar Industri</th>
                        <th style="width: 20%">Keterangan</th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 3; $i++)
                        <tr data-row="{{ $i }}">
                            <td class="text-center row-number">{{ $i + 1 }}</td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input" data-key="label"
                                    data-row="{{ $i }}" placeholder="Nama item/perangkat">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="specification" data-row="{{ $i }}" placeholder="Spesifikasi">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="quantity" data-row="{{ $i }}" placeholder="0" min="0">
                            </td>
                            <td>
                                <select class="form-select form-select-sm table-input" data-key="condition"
                                    data-row="{{ $i }}">
                                    <option value="">Pilih</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak">Rusak</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-select form-select-sm table-input" data-key="industry_standard"
                                    data-row="{{ $i }}">
                                    <option value="">Pilih</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="remarks" data-row="{{ $i }}" placeholder="Merek, Tahun, dll">
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
            <button type="button" class="btn btn-add-row" data-table-id="table-b11">
                <i class="bi bi-plus-circle me-2"></i>Tambah Item
            </button>
        </div>
    </div>

    {{-- Note --}}
    <div class="card-footer bg-transparent border-0 pt-0">
        <div class="note-box">
            <i class="bi bi-lightbulb me-2"></i>
            <strong>Catatan untuk Pengisi:</strong> Bandingkan spesifikasi alat dengan standar yang digunakan di Dunia
            Usaha/Dunia Industri (DUDI) mitra atau standar kompetensi nasional.
        </div>
    </div>
</div>
