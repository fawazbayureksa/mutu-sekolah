@php
    $existingData = $existingData ?? [];
    $competencyGap = $existingData['competency_gap'] ?? [];
    $industryAlignment = $existingData['industry_alignment'] ?? [];
    $trainingPriority = $existingData['training_priority'] ?? [];
@endphp

{{-- Form C.3.2: Analisis Kebutuhan Pelatihan Guru ke Depan --}}
<div class="card table-card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="icon-box me-3"
                style="width: 40px; height: 40px; background: #e7f1ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-clipboard-data text-primary"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-primary">Analisis Kebutuhan Pelatihan Guru ke Depan</h6>
                <small class="text-muted">Diisi oleh Guru/Koordinator Program</small>
            </div>
        </div>
    </div>

    <div class="card-body" id="form-c32">
        @php
            $initialValue = old('answers.C.3.2');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData);
            }
        @endphp
        <input type="hidden" name="answers[C.3.2]" id="form-c32-input" value="{{ $initialValue ?? '{}' }}">

        {{-- Section 1: Kesenjangan Kompetensi untuk Siswa --}}
        <div class="form-section mb-4 pb-4 border-bottom">
            <div class="d-flex mb-3">
                <div class="section-number me-3">1</div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 text-dark">Kesenjangan Kompetensi untuk Siswa</h6>
                    <p class="text-muted mb-0 fst-italic" style="font-size: 0.9rem;">
                        Dari seluruh kompetensi teknis dalam kurikulum, satu keterampilan atau teknologi baru apa yang
                        paling penting dikuasai siswa, tetapi Bapak/Ibu merasa butuh pembaruan/pengetahuan lebih untuk
                        mengajarkannya?
                    </p>
                </div>
            </div>

            <div class="ps-5">
                <div class="mb-3">
                    <label class="form-label fw-medium text-dark">Jawaban:</label>
                    <textarea class="form-control border-light bg-light-subtle" rows="3" data-section="competency_gap"
                        data-field="answer" placeholder="Masukkan jawaban Anda">{{ $competencyGap['answer'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium text-dark">Alasan/Akibat jika tidak dikuasai:</label>
                    <textarea class="form-control border-light bg-light-subtle" rows="3" data-section="competency_gap"
                        data-field="reason" placeholder="Jelaskan alasan atau akibatnya">{{ $competencyGap['reason'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        {{-- Section 2: Kesesuaian dengan Kebutuhan Industri --}}
        <div class="form-section mb-4 pb-4 border-bottom">
            <div class="d-flex mb-3">
                <div class="section-number me-3">2</div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 text-dark">Kesesuaian dengan Kebutuhan Industri</h6>
                    <p class="text-muted mb-0 fst-italic" style="font-size: 0.9rem;">
                        Menurut penilaian atau masukan dari mitra industri, peningkatan keterampilan teknis apa pada
                        guru yang paling berdampak langsung pada kesiapan kerja dan produktivitas lulusan?
                    </p>
                </div>
            </div>

            <div class="ps-5">
                <div class="mb-3">
                    <label class="form-label fw-medium text-dark">Jawaban:</label>
                    <textarea class="form-control border-light bg-light-subtle" rows="3" data-section="industry_alignment"
                        data-field="answer" placeholder="Masukkan jawaban Anda">{{ $industryAlignment['answer'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium text-dark">Sumber masukan (jika ada):</label>
                    <textarea class="form-control border-light bg-light-subtle" rows="2" data-section="industry_alignment"
                        data-field="source" placeholder="Sebutkan sumber masukan">{{ $industryAlignment['source'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        {{-- Section 3: Prioritas Pelatihan --}}
        <div class="form-section">
            <div class="d-flex mb-3">
                <div class="section-number me-3">3</div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 text-dark">Prioritas Pelatihan</h6>
                    <p class="text-muted mb-0 fst-italic" style="font-size: 0.9rem;">
                        Berdasarkan analisis di atas, pelatihan apa yang paling mendesak untuk diikuti oleh guru
                        produktif di sekolah ini?
                    </p>
                </div>
            </div>

            <div class="ps-5">
                <div class="mb-3">
                    <label class="form-label fw-medium text-dark">Jawaban:</label>
                    <textarea class="form-control border-light bg-light-subtle" rows="3" data-section="training_priority"
                        data-field="answer" placeholder="Masukkan prioritas pelatihan">{{ $trainingPriority['answer'] ?? '' }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
