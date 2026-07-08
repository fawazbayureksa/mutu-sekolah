@extends('layouts.admin')

@section('title', 'Data Sekolah - Panel Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Data Sekolah</h2>
            <p class="text-muted mb-0">Kelola data sekolah dan informasi terkait</p>
        </div>
        {{-- <a href="{{ route('admin.schools.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Sekolah
        </a> --}}
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.schools.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama sekolah..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="npsn" class="form-control" placeholder="Cari NPSN..."
                        value="{{ request('npsn') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="address" class="form-control" placeholder="Cari alamat..."
                        value="{{ request('address') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span>Total: {{ $schools->total() }} sekolah</span>
        </div>
        <div class="table-responsive">
            <form id="bulkActionForm" action="{{ route('admin.schools.bulk') }}" method="POST">
                @csrf
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="40">
                                {{-- <input type="checkbox" class="form-check-input" id="selectAll"> --}}
                            </th>
                            <th>Nama Sekolah</th>
                            <th>NPSN</th>
                            {{-- <th>Provinsi</th>
                            <th>Kota/Kabupaten</th> --}}
                            {{-- <th>Jumlah Penilaian</th> --}}
                            <th>Tanggal Pengajuan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schools as $school)
                            <tr>
                                <td>
                                    {{-- <input type="checkbox" class="form-check-input school-checkbox" name="schools[]"
                                        value="{{ $school->id }}"> --}}
                                </td>
                                <td>
                                    <strong>{{ $school->school_name }}</strong>
                                </td>
                                <td>{{ $school->npsn }}</td>
                                {{-- <td>{{ $school->province }}</td> --}}
                                {{-- <td>{{ $school->city }}</td> --}}
                                {{-- <td>
                                    <span class="badge bg-primary">{{ $school->assessments()->count() }}</span>
                                </td> --}}
                                <td>
                                    @if ($school->created_at)
                                        <small class="text-muted">{{ $school->created_at->format('d/m/Y') }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.schools.show', $school) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        {{-- <a href="{{ route('admin.schools.edit', $school) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.schools.assessments', $school) }}" class="btn btn-sm btn-outline-info" title="Penilaian">
                                        <i class="bi bi-clipboard-check"></i>
                                    </a>
                                    <form action="{{ route('admin.schools.destroy', $school) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus sekolah ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form> --}}
                                        <a href="{{ route('admin.schools.generate-link', $school) }}"
                                            class="btn btn-sm btn-outline-success" title="Generate Link">
                                            <i class="bi bi-link-45deg"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-building fs-1 d-block mb-3"></i>
                                        <p class="mb-0">Tidak ada data sekolah ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <input type="hidden" name="action" id="bulkActionInput">
            </form>
        </div>
        @if ($schools->hasPages())
            <div class="card-footer">
                {{ $schools->appends(request()->all())->links() }}
            </div>
        @endif
    </div>

    <script>
        document.getElementById('selectAll')?.addEventListener('change', function() {
            document.querySelectorAll('.school-checkbox').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        function submitBulkAction(action) {
            const checked = document.querySelectorAll('.school-checkbox:checked');
            if (checked.length === 0) {
                alert('Silakan pilih setidaknya satu sekolah');
                return;
            }
            if (confirm(`Apakah Anda yakin ingin ${action} sekolah yang dipilih?`)) {
                document.getElementById('bulkActionInput').value = action;
                document.getElementById('bulkActionForm').submit();
            }
        }
    </script>
@endsection
