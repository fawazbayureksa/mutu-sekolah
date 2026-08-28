{{-- ROW 4: Prioritas Perhatian & Data Cakupan --}}
<div class="row g-4 mb-4">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm border-0 rounded-4 p-3 h-100 bg-white" style="border: 1px solid #e2e8f0 !important;">
            <div class="d-flex align-items-center gap-2 mb-3">
                <h6 class="fw-bold text-dark mb-0">Prioritas Perhatian</h6>
            </div>
            <div class="row g-2">
                @foreach ($attentionCoverage['priorities'] as $priority)
                    <div class="col-12 col-sm-6">
                        <div class="priority-item-card">
                            <strong class="text-dark small lh-1 d-block mb-1">{{ $priority['title'] }}</strong>
                            <p class="text-muted mb-0" style="font-size: 0.72rem; line-height: 1.35;">
                                {{ $priority['description'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Data & Cakupan --}}
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm border-0 rounded-4 p-3 h-100 bg-white" style="border: 1px solid #e2e8f0 !important;">
            <div class="d-flex align-items-center gap-2 mb-3">
                <h6 class="fw-bold text-dark mb-0">Data & Cakupan</h6>
            </div>
            <div class="row g-3 align-items-center my-auto">
                <div class="col-12 col-sm-4">
                    <div>
                        <span class="text-muted d-block" style="font-size: 0.7rem;">Total Pengajuan</span>
                        <strong class="text-dark small d-block">{{ number_format($attentionCoverage['total_submission']) }}</strong>
                        <small class="text-muted" style="font-size: 0.68rem;">instrumen masuk</small>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div>
                        <span class="text-muted d-block" style="font-size: 0.7rem;">Kelengkapan Data</span>
                        <strong class="text-dark small d-block">Rata-rata: {{ $attentionCoverage['avg_completion'] }}%</strong>
                        <small class="text-muted" style="font-size: 0.68rem;">isian instrumen</small>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div>
                        <span class="text-muted d-block" style="font-size: 0.7rem;">Update Terakhir</span>
                        <strong class="text-dark small d-block" style="font-size: 0.75rem;">{{ $attentionCoverage['last_update'] }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>