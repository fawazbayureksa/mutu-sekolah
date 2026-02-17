@extends('layouts.admin')

@section('title', 'Manajemen Pengguna - Panel Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Manajemen Pengguna</h2>
            <p class="text-muted mb-0">Kelola pengguna sistem dan izin</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Pengguna
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari pengguna..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">Semua Peran</option>
                        @foreach (config('constant.user_role') as $key => $role)
                            <option value="{{ $key }}" {{ request('role') === $key ? 'selected' : '' }}>
                                {{ $role }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
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
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Total: {{ $users->total() }} pengguna</span>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-gear me-1"></i>Aksi Massal
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#" class="dropdown-item" onclick="submitBulkAction('activate')">Aktifkan Terpilih</a>
                    </li>
                    <li><a href="#" class="dropdown-item" onclick="submitBulkAction('deactivate')">Nonaktifkan
                            Terpilih</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="#" class="dropdown-item text-danger" onclick="submitBulkAction('delete')">Hapus
                            Terpilih</a></li>
                </ul>
            </div>
        </div>
        <div class="table-responsive">
            <form id="bulkActionForm" action="{{ route('admin.users.bulk') }}" method="POST">
                @csrf
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Peran</th>
                            <th>Status</th>
                            <th>Masuk Terakhir</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input user-checkbox" name="users[]"
                                        value="{{ $user->id }}">
                                </td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td>
                                    @if ($user->is_active)
                                        <span class="badge badge-active">Aktif</span>
                                    @else
                                        <span class="badge badge-inactive">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum Pernah' }}
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if ($user->is_active)
                                            <form action="{{ route('admin.users.deactivate', $user) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning"
                                                    title="Nonaktifkan">
                                                    <i class="bi bi-dash-circle"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.users.activate', $user) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success"
                                                    title="Aktifkan">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-3"></i>
                                        <p class="mb-0">Tidak ada pengguna ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <input type="hidden" name="action" id="bulkActionInput">
            </form>
        </div>
        @if ($users->hasPages())
            <div class="card-footer">
                {{ $users->appends(request()->all())->links() }}
            </div>
        @endif
    </div>

    <script>
        document.getElementById('selectAll')?.addEventListener('change', function() {
            document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        function submitBulkAction(action) {
            const checked = document.querySelectorAll('.user-checkbox:checked');
            if (checked.length === 0) {
                alert('Silakan pilih setidaknya satu pengguna');
                return;
            }
            if (confirm(`Apakah Anda yakin ingin ${action} pengguna yang dipilih?`)) {
                document.getElementById('bulkActionInput').value = action;
                document.getElementById('bulkActionForm').submit();
            }
        }
    </script>
@endsection
