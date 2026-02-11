@extends('verifier.layouts.verifier')

@section('title', 'Submissions')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0 text-gray-800">Submissions</h1>
            </div>
            <div class="col-md-6 text-end">
                <div class="btn-group">
                    <a href="{{ route('verifier.submissions.index', ['status' => 'pending']) }}"
                        class="btn btn-{{ $status === 'pending' ? 'primary' : 'outline-primary' }}">
                        Menunggu Verifikasi
                    </a>
                    <a href="{{ route('verifier.submissions.index', ['status' => 'verified']) }}"
                        class="btn btn-{{ $status === 'verified' ? 'success' : 'outline-success' }}">
                        Diverifikasi
                    </a>
                    <a href="{{ route('verifier.submissions.index', ['status' => 'rejected']) }}"
                        class="btn btn-{{ $status === 'rejected' ? 'danger' : 'outline-danger' }}">
                        Ditolak
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Submissions</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sekolah</th>
                                <th>Instrumen</th>
                                <th>Responden</th>
                                <th>Tanggal Isi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->school->school_name ?? '-' }}</td>
                                    <td>{{ $submission->instrument->name ?? '-' }}</td>
                                    <td>
                                        <div>{{ $submission->respondent_name }}</div>
                                        <small class="text-muted">{{ $submission->respondent_position }}</small>
                                    </td>
                                    <td>{{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('verifier.submissions.show', $submission) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        @if ($submission->isRejected())
                                            <button type="button" class="btn btn-warning btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#generateTokenModal{{ $submission->id }}">
                                                <i class="bi bi-link-45deg"></i> Generate Link
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada submission</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $submissions->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modals for generating update tokens --}}
    @foreach ($submissions as $submission)
        @if ($submission->isRejected())
            <div class="modal fade" id="generateTokenModal{{ $submission->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Generate Update Link</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('verifier.submissions.generate-token', $submission) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <p>Generate link akses satu kali untuk responden agar dapat memperbarui data submission mereka?</p>
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> Link akan berlaku selama 7 hari dan hanya dapat digunakan 1 kali.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-warning">Generate Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    {{-- Update URL Display Modal --}}
    @if (session('update_url'))
        <div class="modal fade show" id="updateUrlModal" tabindex="-1" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-check-circle"></i> Link Berhasil Dibuat</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Link akses untuk update data submission:</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="updateUrl" value="{{ session('update_url') }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard()">
                                <i class="bi bi-clipboard"></i> Copy
                            </button>
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Kirimkan link ini kepada responden. Link berlaku 7 hari dan hanya dapat digunakan 1 kali.
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
        <script>
            function copyToClipboard() {
                const input = document.getElementById('updateUrl');
                
                // Use modern Clipboard API if available, fallback to execCommand
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(input.value).then(() => {
                        alert('Link berhasil disalin!');
                    }).catch(err => {
                        console.error('Failed to copy: ', err);
                        alert('Gagal menyalin link.');
                    });
                } else {
                    // Fallback for older browsers
                    input.select();
                    try {
                        document.execCommand('copy');
                        alert('Link berhasil disalin!');
                    } catch (err) {
                        alert('Gagal menyalin link.');
                    }
                }
            }
            
            document.getElementById('updateUrlModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
            
            // Attach close handlers to both buttons
            const closeButtons = document.querySelectorAll('#updateUrlModal .btn-close, #updateUrlModal .btn-primary');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('updateUrlModal').style.display = 'none';
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                });
            });
        </script>
    @endif
@endsection
