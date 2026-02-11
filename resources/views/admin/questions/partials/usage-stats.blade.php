    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-exclamation-triangle"></i> Peringatan
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-2">
                <strong>Pertanyaan ini tidak dapat dihapus</strong> karena sedang digunakan.
            </p>
            <p class="small text-muted mb-0">
                Untuk menghapus pertanyaan ini, Anda harus terlebih dahulu menghapusnya dari semua instrumen yang mereferensikannya.
            </p>
        </div>
    </div>
    <div class="card-body">
        @if ($usageCount > 0)
            <div class="alert alert-info mb-3">
                <i class="bi bi-info-circle"></i>
                Pertanyaan ini digunakan dalam <strong>{{ $usageCount }}</strong> instrumen.
                <br>
                <small class="text-muted">Anda tidak dapat menghapus pertanyaan yang sedang digunakan.</small>
            </div>

            @if ($instruments->count() > 0)
                <h6 class="mb-3">Instrumen yang menggunakan pertanyaan ini:</h6>
                <div class="list-group list-group-flush">
                    @foreach ($instruments as $instrument)
                        <a href="{{ route('admin.instruments.show', $instrument) }}"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $instrument->name }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-tag"></i>
                                    {{ $instrument->code ?? ($instrument->instrument_code ?? 'N/A') }}
                                    @if ($instrument->category)
                                        | <i class="bi bi-folder"></i> {{ ucfirst($instrument->category) }}
                                    @endif
                                </small>
                            </div>
                            <div>
                                @if ($instrument->is_published)
                                    <span class="badge bg-success">Diterbitkan</span>
                                @else
                                    <span class="badge bg-secondary">Draf</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        @else
            <div class="alert alert-success mb-0">
                <i class="bi bi-check-circle"></i>
                Pertanyaan ini belum digunakan dalam instrumen apa pun.
                <br>
                <small class="text-muted">Anda dapat menghapus pertanyaan ini dengan aman jika diperlukan.</small>
            </div>
        @endif
    </div>

    @if ($usageCount > 0)
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="bi bi-clock"></i> Terakhir diperbarui: {{ $question->updated_at->diffForHumans() }}
                </small>
                <a href="{{ route('admin.instruments.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-list"></i> Lihat Semua Instrumen
                </a>
            </div>
        </div>
    @endif
</div>

@if ($usageCount > 0)
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-exclamation-triangle"></i> Warning
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-2">
                <strong>This question cannot be deleted</strong> because it is currently in use.
            </p>
            <p class="small text-muted mb-0">
                To delete this question, you must first remove it from all instruments that reference it.
            </p>
        </div>
    </div>
@endif
