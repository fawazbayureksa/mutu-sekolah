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
                        <th style="width: 3%; white-space: normal;">No</th>
                        <th style="width: 15%; white-space: normal;">Nama Industri Mitra</th>
                        <th style="width: 10%; white-space: normal;">Status MoU/MoA</th>
                        <th style="width: 8%; white-space: normal;">Durasi Kerjasama (Tahun)</th>
                        <th style="width: 34%; white-space: normal;">Cakupan Program Kerjasama (Beri √ pada semua yang
                            berlaku)</th>
                        <th style="width: 27%; white-space: normal;">Bentuk Kontribusi Nyata (Deskripsikan)</th>
                        <th style="width: 3%;"></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $rowCount; $i++)
                        @php
                            $rowData = $rows[$i] ?? [];
                        @endphp
                        <tr data-row="{{ $i }}">
                            <td class="text-center row-number">{{ $i + 1 }}</td>

                            {{-- Nama Industri Mitra --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="partner_name" data-row="{{ $i }}"
                                    placeholder="Nama industri mitra" value="{{ $rowData['partner_name'] ?? '' }}">
                            </td>

                            {{-- Status MoU/MoA — radio buttons --}}
                            <td>
                                <div class="form-check form-check-sm">
                                    <input class="form-check-input table-input" type="radio"
                                        id="mou_aktif_{{ $i }}" name="mou_status_row_{{ $i }}"
                                        data-key="mou_status" data-row="{{ $i }}" value="Aktif"
                                        {{ ($rowData['mou_status'] ?? '') === 'Aktif' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mou_aktif_{{ $i }}">Aktif</label>
                                </div>
                                <div class="form-check form-check-sm">
                                    <input class="form-check-input table-input" type="radio"
                                        id="mou_tidak_aktif_{{ $i }}"
                                        name="mou_status_row_{{ $i }}" data-key="mou_status"
                                        data-row="{{ $i }}" value="Tidak Aktif"
                                        {{ ($rowData['mou_status'] ?? '') === 'Tidak Aktif' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mou_tidak_aktif_{{ $i }}">Tidak
                                        Aktif</label>
                                </div>
                            </td>

                            {{-- Durasi Kerjasama --}}
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="duration" data-row="{{ $i }}" placeholder="0" min="0"
                                    step="0.5" value="{{ $rowData['duration'] ?? '' }}">
                            </td>

                            {{-- Cakupan Program Kerjasama --}}
                            <td>
                                <div class="small">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input table-input" type="checkbox"
                                            id="program_kurikulum_{{ $i }}" data-key="program_kurikulum"
                                            data-row="{{ $i }}"
                                            {{ !empty($rowData['program_kurikulum']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="program_kurikulum_{{ $i }}">
                                            1. Penyelarasan Kurikulum
                                        </label>
                                    </div>
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input table-input" type="checkbox"
                                            id="program_guru_{{ $i }}" data-key="program_guru"
                                            data-row="{{ $i }}"
                                            {{ !empty($rowData['program_guru']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="program_guru_{{ $i }}">
                                            2. Guru Tamu
                                        </label>
                                    </div>
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input table-input" type="checkbox"
                                            id="program_magang_{{ $i }}" data-key="program_magang"
                                            data-row="{{ $i }}"
                                            {{ !empty($rowData['program_magang']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="program_magang_{{ $i }}">
                                            3. Magang/PKL Siswa (≥ 6 bulan)
                                        </label>
                                    </div>
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input table-input" type="checkbox"
                                            id="program_sertifikasi_{{ $i }}" data-key="program_sertifikasi"
                                            data-row="{{ $i }}"
                                            {{ !empty($rowData['program_sertifikasi']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="program_sertifikasi_{{ $i }}">
                                            4. Sertifikasi Kompetensi (BNSP/LSP)
                                        </label>
                                    </div>
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input table-input" type="checkbox"
                                            id="program_pelatihan_{{ $i }}" data-key="program_pelatihan"
                                            data-row="{{ $i }}"
                                            {{ !empty($rowData['program_pelatihan']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="program_pelatihan_{{ $i }}">
                                            5. Pelatihan Guru
                                        </label>
                                    </div>
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input table-input" type="checkbox"
                                            id="program_rekrutmen_{{ $i }}" data-key="program_rekrutmen"
                                            data-row="{{ $i }}"
                                            {{ !empty($rowData['program_rekrutmen']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="program_rekrutmen_{{ $i }}">
                                            6. Penyerapan Lulusan
                                        </label>
                                    </div>
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input table-input" type="checkbox"
                                            id="program_tefa_{{ $i }}" data-key="program_tefa"
                                            data-row="{{ $i }}"
                                            {{ !empty($rowData['program_tefa']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="program_tefa_{{ $i }}">
                                            7. Teaching Factory (TEFA)
                                        </label>
                                    </div>
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input table-input" type="checkbox"
                                            id="program_kelas_{{ $i }}" data-key="program_kelas"
                                            data-row="{{ $i }}"
                                            {{ !empty($rowData['program_kelas']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="program_kelas_{{ $i }}">
                                            8. Kelas Industri
                                        </label>
                                    </div>
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input table-input" type="checkbox"
                                            id="program_csr_{{ $i }}" data-key="program_csr"
                                            data-row="{{ $i }}"
                                            {{ !empty($rowData['program_csr'] ?? ($rowData['program_donasi'] ?? '')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="program_csr_{{ $i }}">
                                            9. CSR/Alat/Bahan/Beasiswa
                                        </label>
                                    </div>
                                    <div class="form-check form-check-sm mb-1">
                                        <input class="form-check-input table-input" type="checkbox"
                                            id="program_lainnya_{{ $i }}" data-key="program_lainnya"
                                            data-row="{{ $i }}"
                                            {{ !empty($rowData['program_lainnya']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="program_lainnya_{{ $i }}">
                                            10. Lainnya:
                                        </label>
                                    </div>
                                    <input type="text" class="form-control form-control-sm table-input"
                                        data-key="program_lainnya_text" data-row="{{ $i }}"
                                        placeholder="Sebutkan program lainnya..."
                                        value="{{ $rowData['program_lainnya_text'] ?? '' }}">
                                </div>
                            </td>

                            {{-- Bentuk Kontribusi Nyata --}}
                            <td>
                                <div class="small mb-2">
                                    <strong>Kontribusi Kuantitatif:</strong>
                                    <textarea class="form-control form-control-sm table-input mt-1" data-key="contribution_quantitative"
                                        data-row="{{ $i }}" rows="4"
                                        placeholder="• Jumlah siswa magang/tahun: ___ orang&#10;• Jumlah guru magang/pelatihan: ___ orang&#10;• Jumlah lulusan direkrut (2 th terakhir): ___ orang&#10;• Nilai bantuan (alat/beasiswa): Rp ___">{{ $rowData['contribution_quantitative'] ?? '' }}</textarea>
                                </div>
                                <div class="small">
                                    <strong>Kontribusi Kualitatif:</strong>
                                    <textarea class="form-control form-control-sm table-input mt-1" data-key="contribution_qualitative"
                                        data-row="{{ $i }}" rows="2" placeholder="• ...">{{ $rowData['contribution_qualitative'] ?? '' }}</textarea>
                                </div>
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
