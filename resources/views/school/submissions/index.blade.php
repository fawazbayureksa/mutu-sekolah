@extends('school.layouts.school')

@section('title', 'Pengajuan Saya - Portal Sekolah')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">Pengajuan Saya</h1>
                <p class="text-muted small mb-0">{{ $school->school_name }}</p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tanggal Pengisian</th>
                                <th>Konsentrasi Keahlian</th>
                                <th>Kurikulum</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($submissions as $submission)
                                <tr>
                                    <td>{{ $submissions->firstItem() + $loop->index }}</td>
                                    <td>{{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}</td>
                                    <td>{{ $submission->expertise_concentration ?? '-' }}</td>
                                    <td>{{ $submission->curriculum ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $submission->getStatusBadgeClass() }}">
                                            {{ $submission->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td class="d-flex gap-1">
                                        <a href="{{ route('school.submissions.show', $submission) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                        @if ($submission->isEditable())
                                            <a href="{{ route('school.submissions.edit', $submission) }}"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada pengajuan.
                                        <div class="mt-2">
                                            <a href="{{ route('instrument.v2.form') }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-plus-circle me-1"></i>Isi Instrumen Sekarang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($submissions->hasPages())
                <div class="card-footer">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
