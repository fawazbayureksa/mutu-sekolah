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
                        <th style="width: 8%; white-space: normal;">Kategori TEFA</th>
                        <th style="width: 8%; white-space: normal;">Nama Produk</th>
                        <th style="width: 8%; white-space: normal;">Deskripsi Produk</th>
                        <th style="width: 7%; white-space: normal;">Mitra Industri</th>
                        <th style="width: 7%; white-space: normal;">Proses/Dokumen Tefa</th>
                        <th style="width: 7%; white-space: normal;">Sertifikasi Kompetensi (Siswa/Guru, BNSP/Industri)
                        </th>
                        <th style="width: 7%; white-space: normal;">Sinkronisasi Kurikulum</th>
                        <th style="width: 7%; white-space: normal;">Branding Produk/HAKI</th>
                        <th style="width: 7%; white-space: normal;">Evaluasi Mutu Produk</th>
                        <th style="width: 7%; white-space: normal;">Omzet (Rp/Bulan/Tahun)</th>
                        <th style="width: 7%; white-space: normal;">Keterlibatan Alumni/Industri dalam pengembangan
                            produk</th>
                        <th style="width: 7%; white-space: normal;">Kendala</th>
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

                            {{-- Kategori TEFA (select) --}}
                            <td>
                                <select class="form-select form-select-sm table-input" data-key="kategori_tefa"
                                    data-row="{{ $i }}">
                                    <option value="">-- Pilih --</option>
                                    <option value="Berbasis pemenuhan kompetensi peserta didik"
                                        {{ ($rowData['kategori_tefa'] ?? '') === 'Berbasis pemenuhan kompetensi peserta didik' ? 'selected' : '' }}>
                                        1. Berbasis pemenuhan kompetensi peserta didik
                                    </option>
                                    <option value="Berbasis kebutuhan masyarakat"
                                        {{ ($rowData['kategori_tefa'] ?? '') === 'Berbasis kebutuhan masyarakat' ? 'selected' : '' }}>
                                        2. Berbasis kebutuhan masyarakat
                                    </option>
                                    <option value="Berbasis kemitraan dengan dunia kerja"
                                        {{ ($rowData['kategori_tefa'] ?? '') === 'Berbasis kemitraan dengan dunia kerja' ? 'selected' : '' }}>
                                        3. Berbasis kemitraan dengan dunia kerja
                                    </option>
                                </select>
                            </td>

                            {{-- Nama Produk --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="product_name" data-row="{{ $i }}"
                                    placeholder="Nama produk/jasa" value="{{ $rowData['product_name'] ?? '' }}">
                            </td>

                            {{-- Deskripsi Produk --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="product_description" data-row="{{ $i }}"
                                    rows="2" placeholder="Deskripsi singkat produk/jasa">{{ $rowData['product_description'] ?? '' }}</textarea>
                            </td>

                            {{-- Mitra Industri --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="industry_partner" data-row="{{ $i }}"
                                    placeholder="Nama mitra industri (jika ada)"
                                    value="{{ $rowData['industry_partner'] ?? '' }}">
                            </td>

                            {{-- Proses/Dokumen Tefa --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="tefa_process" data-row="{{ $i }}"
                                    rows="2" placeholder="Contoh: SOP, modul, lembar kerja">{{ $rowData['tefa_process'] ?? '' }}</textarea>
                            </td>

                            {{-- Sertifikasi Kompetensi --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="certification" data-row="{{ $i }}"
                                    rows="2" placeholder="Siswa: __% BNSP&#10;Guru: __ sertifikat industri">{{ $rowData['certification'] ?? '' }}</textarea>
                            </td>

                            {{-- Sinkronisasi Kurikulum --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="curriculum_sync" data-row="{{ $i }}"
                                    rows="2" placeholder="Terintegrasi PjBL/Capaian Pembelajaran">{{ $rowData['curriculum_sync'] ?? '' }}</textarea>
                            </td>

                            {{-- Branding Produk/HAKI --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="branding_haki" data-row="{{ $i }}"
                                    rows="2" placeholder="Merek dagang, Halal, ISO, dll">{{ $rowData['branding_haki'] ?? '' }}</textarea>
                            </td>

                            {{-- Evaluasi Mutu Produk --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="quality_evaluation" data-row="{{ $i }}"
                                    rows="2" placeholder="Standar BPOM, Halal MUI, SKKNI, dll">{{ $rowData['quality_evaluation'] ?? '' }}</textarea>
                            </td>

                            {{-- Omzet --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="revenue_activity" data-row="{{ $i }}"
                                    placeholder="Rp ___/bulan atau ___/tahun"
                                    value="{{ $rowData['revenue_activity'] ?? '' }}">
                            </td>

                            {{-- Keterlibatan Alumni/Industri --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="industry_contribution"
                                    data-row="{{ $i }}" rows="2" placeholder="Alumni/industri yang terlibat">{{ $rowData['industry_contribution'] ?? '' }}</textarea>
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
