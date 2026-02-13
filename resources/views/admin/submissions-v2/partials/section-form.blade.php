{{--
    Section Form Partial (C.3.2)
    Variables:
    - $code: Section code
    - $title: Section title
    - $data: Form questionnaire data from collectFormData()
--}}
@php
    $formSections = [
        'competency_gap' => [
            'label' => '1. Kesenjangan Kompetensi untuk Siswa',
            'description' =>
                'Dari seluruh kompetensi teknis dalam kurikulum, satu keterampilan atau teknologi baru apa yang paling penting dikuasai siswa, tetapi Bapak/Ibu merasa butuh pembaruan/pengetahuan lebih untuk mengajarkannya?',
            'fields' => [
                'answer' => 'Jawaban',
                'reason' => 'Alasan/Akibat jika tidak dikuasai',
            ],
        ],
        'industry_alignment' => [
            'label' => '2. Kesesuaian dengan Kebutuhan Industri',
            'description' =>
                'Menurut penilaian atau masukan dari mitra industri, peningkatan keterampilan teknis apa pada guru yang paling berdampak langsung pada kesiapan kerja dan produktivitas lulusan?',
            'fields' => [
                'answer' => 'Jawaban',
                'source' => 'Sumber masukan (jika ada)',
            ],
        ],
        'training_priority' => [
            'label' => '3. Prioritas Pelatihan',
            'description' =>
                'Berdasarkan analisis di atas, pelatihan apa yang paling mendesak untuk diikuti oleh guru produktif di sekolah ini?',
            'fields' => [
                'answer' => 'Jawaban',
            ],
        ],
    ];
@endphp

<div class="section-block mb-4">
    <h6 class="fw-bold mb-3">{{ $code }} - {{ $title }}</h6>

    @php
        $formData = is_string($data) ? json_decode($data, true) : $data;
    @endphp

    @if (!empty($formData))
        @foreach ($formSections as $sectionKey => $section)
            <div class="mb-4 pb-3 border-bottom">
                <h6 class="text-secondary mb-2">{{ $section['label'] }}</h6>
                <p class="small text-muted fst-italic mb-3">{{ $section['description'] }}</p>

                @foreach ($section['fields'] as $fieldKey => $fieldLabel)
                    @php
                        $value = $formData[$sectionKey][$fieldKey] ?? null;
                    @endphp
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">{{ $fieldLabel }}:</label>
                        <div class="border rounded p-2 bg-light">
                            @if (!empty($value))
                                <p class="mb-0 small">{!! nl2br(e($value)) !!}</p>
                            @else
                                <p class="mb-0 small text-muted fst-italic">Belum diisi</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <div class="alert alert-secondary small mb-0">
            <i class="bi bi-info-circle me-1"></i> Belum ada data untuk bagian ini.
        </div>
    @endif
</div>
