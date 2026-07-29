@php
    $secCode = $code ?? '';
    $secStatus = isset($submission) ? $submission->getSectionStatus($secCode) : null;
    $secNotes = isset($submission) ? $submission->getSectionNotes($secCode) : null;
    $isReviewer = isset($canReview) && $canReview;
@endphp

<div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
    <h6 class="fw-bold text-primary mb-0">
        <i class="bi bi-journal-text me-1"></i>{{ $secCode }} - {{ $title }}
    </h6>
    <div>
        @if ($secStatus === 'approved')
            <span class="badge bg-success px-2 py-1"><i class="bi bi-check-circle me-1"></i>Disetujui</span>
        @elseif ($secStatus === 'rejected')
            <span class="badge bg-danger px-2 py-1"><i class="bi bi-exclamation-triangle me-1"></i>Perlu Perbaikan</span>
        @endif
    </div>
</div>

{{-- Section Notes Callout (Visible to School, Verifier, Admin) --}}
@if ($secNotes)
    <div class="alert {{ $secStatus === 'rejected' ? 'alert-danger' : 'alert-info' }} alert-dismissible fade show p-2 mb-3 small" role="alert">
        <div class="d-flex align-items-start gap-2">
            <i class="bi {{ $secStatus === 'rejected' ? 'bi-exclamation-circle-fill text-danger' : 'bi-info-circle-fill text-info' }} fs-6 mt-1 flex-shrink-0"></i>
            <div class="flex-grow-1">
                <strong>Catatan Perbaikan ({{ $secCode }}):</strong>
                <p class="mb-0 text-break">{{ $secNotes }}</p>
            </div>
        </div>
    </div>
@endif

{{-- Inline Review Form for Admin / Verifier --}}
@if ($isReviewer && isset($submission) && in_array($submission->status, ['submitted', 'verified']))
    <div class="card border border-warning-subtle bg-light-subtle mb-3 section-review-input-box d-none">
        <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <small class="fw-semibold text-dark"><i class="bi bi-pencil-square me-1"></i>Catatan Review Bagian {{ $secCode }}</small>
                <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none small text-muted" data-bs-toggle="collapse" data-bs-target="#collapseReview{{ Str::slug($secCode) }}">
                    Toggle Form
                </button>
            </div>
            <div class="collapse show" id="collapseReview{{ Str::slug($secCode) }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4 col-12">
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="section_notes[{{ $secCode }}][status]" id="status_approved_{{ Str::slug($secCode) }}" value="approved" {{ $secStatus === 'approved' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success btn-sm" for="status_approved_{{ Str::slug($secCode) }}">
                                <i class="bi bi-check-lg me-1"></i> Sesuai
                            </label>

                            <input type="radio" class="btn-check" name="section_notes[{{ $secCode }}][status]" id="status_rejected_{{ Str::slug($secCode) }}" value="rejected" {{ $secStatus === 'rejected' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger btn-sm" for="status_rejected_{{ Str::slug($secCode) }}">
                                <i class="bi bi-x-lg me-1"></i> Revisi
                            </label>
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <input type="text" name="section_notes[{{ $secCode }}][notes]" class="form-control form-control-sm" placeholder="Catatan perbaikan khusus bagian {{ $secCode }}..." value="{{ $secNotes }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
