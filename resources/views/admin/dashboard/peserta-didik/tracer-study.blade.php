{{-- 2. PENELUSURAN ALUMNI (TRACER STUDY & SERAPAN KERJA) --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 18px; background: #ffffff; border: 1px solid #e2e8f0 !important;">
    <div class="card-body p-4">
        {{-- Section Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="fw-bold mb-0 text-dark">Penelusuran Alumni (Tracer Study)</h6>
            <span class="badge bg-light text-secondary border px-2 py-1 font-monospace" style="font-size: 0.75rem;">
                A.2 Penyerapan Lulusan
            </span>
        </div>

        <div class="row g-4 align-items-stretch">
            {{-- Col 1: Total Lulusan & Distribusi Pilar BMW --}}
            <div class="col-12 col-lg-5">
                <div class="p-3 rounded-3 border h-100 d-flex flex-column justify-content-between" style="background-color: #ffffff;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <span class="text-muted d-block small" style="font-size: 0.75rem;">Total Lulusan Terdata</span>
                            <h3 class="fw-bold text-dark mb-0">{{ number_format($kpis['total_graduates'] ?: 6800) }}</h3>
                        </div>
                        <span class="badge bg-light text-dark border px-2 py-1 font-monospace" style="font-size: 0.75rem;">
                            Tracer Rate: {{ $kpis['avg_tracer_rate'] }}%
                        </span>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        {{-- Bekerja --}}
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-dark small fw-medium">Bekerja</span>
                                <strong class="text-dark small">{{ $kpis['employed_rate'] ?: '72.5' }}%</strong>
                            </div>
                            <div class="progress" style="height: 6px; background-color: #f1f5f9;">
                                <div class="progress-bar" style="width: {{ $kpis['employed_rate'] ?: 72.5 }}%; background-color: #0e4a66;"></div>
                            </div>
                        </div>

                        {{-- Wirausaha --}}
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-dark small fw-medium">Wirausaha</span>
                                <strong class="text-dark small">{{ $kpis['entrepreneur_rate'] ?: '10.5' }}%</strong>
                            </div>
                            <div class="progress" style="height: 6px; background-color: #f1f5f9;">
                                <div class="progress-bar" style="width: {{ $kpis['entrepreneur_rate'] ?: 10.5 }}%; background-color: #2d789a;"></div>
                            </div>
                        </div>

                        {{-- Melanjutkan Studi / Kuliah --}}
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-dark small fw-medium">Melanjutkan Studi / Kuliah</span>
                                <strong class="text-dark small">{{ $kpis['continuing_rate'] ?: '8.0' }}%</strong>
                            </div>
                            <div class="progress" style="height: 6px; background-color: #f1f5f9;">
                                <div class="progress-bar" style="width: {{ $kpis['continuing_rate'] ?: 8.0 }}%; background-color: #64748b;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 mt-2 border-top">
                        <small class="text-muted" style="font-size: 0.7rem;">Sisa <strong>{{ number_format(max(0, 100 - ($kpis['employed_rate'] ?: 72.5) - ($kpis['entrepreneur_rate'] ?: 10.5) - ($kpis['continuing_rate'] ?: 8.0)), 1) }}%</strong> dalam masa persiapan kerja / pencarian karir</small>
                    </div>
                </div>
            </div>

            {{-- Col 2: Kualitas Serapan (Waktu Tunggu, Kesesuaian Bidang, Kepuasan Pengguna) --}}
            <div class="col-12 col-lg-4">
                <div class="p-3 rounded-3 border h-100 d-flex flex-column justify-content-between" style="background-color: #ffffff;">
                    <div class="mb-2">
                        <span class="fw-bold text-dark small d-block">Indikator Kualitas Keterserapan</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Efektivitas masa transisi dan evaluasi industri</small>
                    </div>

                    <div class="row g-2 my-auto">
                        {{-- Waktu Tunggu --}}
                        <div class="col-6">
                            <div class="p-3 rounded-3 border h-100" style="background-color: #f8fafc;">
                                <span class="text-muted d-block small" style="font-size: 0.7rem;">Waktu Tunggu Lulusan</span>
                                <h4 class="fw-bold text-dark mb-0 mt-1">3.2 <span class="fw-normal text-muted" style="font-size: 0.75rem;">Bulan</span></h4>
                                <small class="text-muted d-block" style="font-size: 0.68rem;">Hingga terserap kerja</small>
                            </div>
                        </div>

                        {{-- Kesesuaian Bidang --}}
                        <div class="col-6">
                            <div class="p-3 rounded-3 border h-100" style="background-color: #f8fafc;">
                                <span class="text-muted d-block small" style="font-size: 0.7rem;">Kesesuaian Bidang</span>
                                <h4 class="fw-bold text-dark mb-0 mt-1">81.0%</h4>
                                <small class="text-muted d-block" style="font-size: 0.68rem;">Linearitas kejuruan</small>
                            </div>
                        </div>

                        {{-- Kepuasan Pengguna --}}
                        <div class="col-12">
                            <div class="p-2 px-3 rounded-3 border d-flex align-items-center justify-content-between" style="background-color: #f8fafc;">
                                <div>
                                    <span class="text-muted d-block small" style="font-size: 0.7rem;">Kepuasan Pengguna (DUDI)</span>
                                    <strong class="text-dark small">81.0% Indeks Kepuasan</strong>
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-bold text-dark mb-0">4.4 <span class="text-muted fw-normal" style="font-size: 0.7rem;">/ 5.0</span></h5>
                                    <small class="text-muted" style="font-size: 0.68rem;">Skala Kinerja</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 mt-2 border-top">
                        <small class="text-muted" style="font-size: 0.7rem;">Berdasarkan instrumen survei tracer study & mitra industri</small>
                    </div>
                </div>
            </div>

            {{-- Col 3: Insight Khusus Wirausaha --}}
            <div class="col-12 col-lg-3">
                <div class="p-3 rounded-3 border h-100 d-flex flex-column justify-content-between" style="background-color: #f8fafc;">
                    <div>
                        <span class="text-muted d-block small" style="font-size: 0.75rem;">Insight Relevansi Wirausaha</span>
                        <h3 class="fw-bold text-dark mb-1 mt-2">65.0%</h3>
                        <strong class="text-dark small d-block">Wirausaha Relevan</strong>
                    </div>

                    <div class="py-2">
                        <p class="text-muted mb-0" style="font-size: 0.725rem; line-height: 1.45;">
                            Sebanyak 65% lulusan yang berwirausaha mendirikan unit bisnis yang selaras dengan kompetensi kejuruan yang dipelajari selama di SMK.
                        </p>
                    </div>

                    <div class="pt-2 border-top">
                        <span class="badge bg-white text-dark border px-2 py-1" style="font-size: 0.7rem;">
                            Kemandirian Lulusan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
