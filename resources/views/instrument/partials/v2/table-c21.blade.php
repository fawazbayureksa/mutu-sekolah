@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
    $rowCount = max(2, count($rows));
@endphp

{{-- Table C.2.1: Teaching Factory (TEFA) / Unit Produksi Sekolah (Dynamic Rows) --}}
<div class="card table-card">
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
                        <th style="width: 3%; white-space: normal;">No</th>
                        <th style="width: 8%; white-space: normal;">Nama Program TEFA/Produk</th>
                        <th style="width: 7%; white-space: normal;">Mitra Industri (jika ada)</th>
                        <th style="width: 7%; white-space: normal;">Skala Operasi (Siswa/Guru/Tim Khusus)</th>
                        <th style="width: 7%; white-space: normal;">Nama Toko (Reguler/Kolaborasi/ Penjualan)</th>
                        <th style="width: 10%; white-space: normal;">Pencapaian & Manfaat (Output, penjualan,
                            pengalaman)</th>
                        <th style="width: 9%; white-space: normal;">Sertifikasi Kompetensi (Siswa/Guru, BNSP/Industri)
                        </th>
                        <th style="width: 9%; white-space: normal;">Integrasi Kurikulum (PjBL/Capaian Pembelajaran)</th>
                        <th style="width: 7%; white-space: normal;">Pengembangan HaKI/Branding Produk</th>
                        <th style="width: 8%; white-space: normal;">Evaluasi Mutu Produk (Standar/Mutu/ Sertifikasi)
                        </th>
                        <th style="width: 6%; white-space: normal;">Omzet/Surat Aktivitas (Tahunan/Bulanan)</th>
                        <th style="width: 7%; white-space: normal;">Dampak/Tracer (alumni)</th>
                        <th style="width: 7%; white-space: normal;">Kontribusi dari Industri</th>
                        <th style="width: 5%; white-space: normal;">Kendala</th>
                        <th style="width: 3%"></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $rowCount; $i++)
                        @php
                            $rowData = $rows[$i] ?? [];
                        @endphp
                        <tr data-row="{{ $i }}">
                            <td class="text-center row-number">{{ $i + 1 }}</td>
                            {{-- Nama Program TEFA/Produk --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="program_name" data-row="{{ $i }}"
                                    placeholder="Nama program TEFA/Produk" value="{{ $rowData['program_name'] ?? '' }}">
                            </td>
                            {{-- Mitra Industri --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="industry_partner" data-row="{{ $i }}"
                                    placeholder="Nama mitra industri" value="{{ $rowData['industry_partner'] ?? '' }}">
                            </td>
                            {{-- Skala Operasi --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="operation_scale" data-row="{{ $i }}"
                                    rows="2" placeholder="Contoh: Siswa Kelas XI (18 orang) + Guru Pembimbing (2 orang)">{{ $rowData['operation_scale'] ?? '' }}</textarea>
                            </td>
                            {{-- Nama Toko --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="store_name" data-row="{{ $i }}" placeholder="Nama toko/outlet"
                                    value="{{ $rowData['store_name'] ?? '' }}">
                            </td>
                            {{-- Pencapaian & Manfaat --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="achievement" data-row="{{ $i }}"
                                    rows="3" placeholder="Output: ___ kg produk/bulan&#10;Penjualan: Rp ___/bulan&#10;Pengalaman siswa: ...">{{ $rowData['achievement'] ?? '' }}</textarea>
                            </td>
                            {{-- Sertifikasi Kompetensi --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="certification" data-row="{{ $i }}"
                                    rows="3" placeholder="Siswa: __% tersertifikasi BNSP&#10;Guru: __ orang sertifikat industri">{{ $rowData['certification'] ?? '' }}</textarea>
                            </td>
                            {{-- Integrasi Kurikulum --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="curriculum_integration"
                                    data-row="{{ $i }}" rows="3"
                                    placeholder="Terintegrasi PjBL: modul ...&#10;Persentase: __% produksi sesuai standar">{{ $rowData['curriculum_integration'] ?? '' }}</textarea>
                            </td>
                            {{-- Pengembangan HaKI/Branding --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="branding_haki" data-row="{{ $i }}"
                                    rows="3" placeholder="Merek dagang, Halal MUI, Sustainable, Branding via sosmed, dll">{{ $rowData['branding_haki'] ?? '' }}</textarea>
                            </td>
                            {{-- Evaluasi Mutu Produk --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="quality_evaluation" data-row="{{ $i }}"
                                    rows="3" placeholder="Standar BPOM & Sertifikat&#10;Mutu sesuai SKKNI&#10;Pengolahan: __% ke pesantren">{{ $rowData['quality_evaluation'] ?? '' }}</textarea>
                            </td>
                            {{-- Omzet/Surat Aktivitas --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="revenue_activity" data-row="{{ $i }}"
                                    rows="3" placeholder="Omzet Rp ___/tahun&#10;Sustainable (memenuhi)&#10;Aktivitas: ...">{{ $rowData['revenue_activity'] ?? '' }}</textarea>
                            </td>
                            {{-- Dampak/Tracer --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="tracer_impact" data-row="{{ $i }}"
                                    rows="3" placeholder="Alumni __ orang&#10;Diversi ke industri pengolahan&#10;Tracer study: ...">{{ $rowData['tracer_impact'] ?? '' }}</textarea>
                            </td>
                            {{-- Kontribusi dari Industri --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="industry_contribution"
                                    data-row="{{ $i }}" rows="3" placeholder="Kontribusi bahan, cold storage, pelatihan, dll">{{ $rowData['industry_contribution'] ?? '' }}</textarea>
                            </td>
                            {{-- Kendala --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="constraints" data-row="{{ $i }}"
                                    rows="2" placeholder="Kendala yang dihadapi">{{ $rowData['constraints'] ?? '' }}</textarea>
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
