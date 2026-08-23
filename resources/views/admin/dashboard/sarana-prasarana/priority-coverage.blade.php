{{-- ROW 4: Prioritas Perhatian Aspek Sarana & Prasarana (col-12) --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card chart-container-card shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark">Prioritas Perhatian Aspek Sarana & Prasarana</h6>
                <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.75rem;">
                    Identifikasi Gap Instrumen
                </span>
            </div>

            <div class="row g-3">
                @foreach ($priorities as $pri)
                    <div class="col-12 col-md-4">
                        <div class="priority-item-card">
                            <strong class="text-dark small lh-1 d-block mb-2">{{ $pri['title'] }}</strong>
                            <p class="text-muted mb-0" style="font-size: 0.75rem; line-height: 1.45;">
                                {{ $pri['description'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
