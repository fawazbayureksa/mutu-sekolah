@auth
    @if (auth()->user()->isVerifier())
        <script>
            window.location.href = "{{ route('verifier.dashboard') }}";
        </script>
    @endif
@endauth

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Panel - Mutu Sekolah')</title>
    <link rel="icon" href="{{ asset('images/tut-wuri-handayani.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    @stack('styles')
</head>

<body>
    <!-- Mobile Sidebar Backdrop -->
    <div class="sidebar-backdrop d-lg-none" id="sidebarBackdrop"></div>

    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <img src="{{ asset('images/logo.png') }}" class="logo-sidebar" alt="Logo Mutu Sekolah">
            </a>
        </div>

        <ul class="sidebar-menu">
            <!-- Navigasi Utama -->
            <li class="sidebar-heading">Navigasi Utama</li>
            <li class="sidebar-menu-item">
                <a href="{{ route('dashboard') }}"
                    class="sidebar-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Home</span>
                </a>
            </li>

            @if (auth()->check() && auth()->user()->isAdmin())
                <!-- Manajemen Data -->
                <li class="sidebar-divider"></li>
                <li class="sidebar-heading">Manajemen Data</li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.schools.index') }}"
                        class="sidebar-menu-link {{ request()->is('admin/schools*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i>
                        <span>Data Sekolah</span>
                    </a>
                </li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="sidebar-menu-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                </li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.submissions-v2.index') }}"
                        class="sidebar-menu-link {{ request()->is('admin/submissions-v2*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-check-fill"></i>
                        <span>Pengajuan</span>
                    </a>
                </li>

                <!-- Laporan -->
                <li class="sidebar-divider"></li>
                <li class="sidebar-heading">Laporan & Analisis</li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.laporan.index') }}"
                        class="sidebar-menu-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart-line-fill"></i>
                        <span>Laporan</span>
                    </a>
                </li>

                <!-- Dashboard Mutu SMK -->
                <li class="sidebar-divider"></li>
                <li class="sidebar-heading">Dashboard Mutu SMK</li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.dashboard.overview') }}"
                        class="sidebar-menu-link {{ request()->is('admin/dashboard-mutu/overview*') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard Overview</span>
                    </a>
                </li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.dashboard.kelembagaan.index') }}"
                        class="sidebar-menu-link {{ request()->is('admin/dashboard-mutu/kelembagaan*') ? 'active' : '' }}">
                        <i class="bi bi-buildings-fill"></i>
                        <span>Kelembagaan</span>
                    </a>
                </li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.dashboard.sarana-prasarana.index') }}"
                        class="sidebar-menu-link {{ request()->is('admin/dashboard-mutu/sarana-prasarana*') || request()->is('admin/dashboard-mutu/sarpras*') ? 'active' : '' }}">
                        <i class="bi bi-tools"></i>
                        <span>Sarana Prasarana</span>
                    </a>
                </li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.dashboard.peserta-didik.index') }}"
                        class="sidebar-menu-link {{ request()->is('admin/dashboard-mutu/peserta-didik*') ? 'active' : '' }}">
                        <i class="bi bi-mortarboard-fill"></i>
                        <span>Mutu Peserta Didik</span>
                    </a>
                </li>
            @endif
        </ul>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"
                class="sidebar-menu-link text-white-50">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <nav class="top-navbar">
            <button class="btn btn-link text-decoration-none d-lg-none" id="sidebarToggle" aria-label="Toggle Sidebar">
                <i class="bi bi-list fs-4 text-dark"></i>
            </button>

            <div class="d-flex align-items-center gap-3 ms-auto">
                <span class="text-muted small">
                    Selamat datang, <strong class="text-dark">{{ Auth::user()->name }}</strong>
                </span>
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle p-1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4 text-primary"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('admin.users.show', Auth::id()) }}">
                                <i class="bi bi-person me-2 text-muted"></i>Profil Saya
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-1">
                        </li>
                        <li>
                            <a class="dropdown-item py-2 text-danger" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');
            const sidebar = document.querySelector('.sidebar');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                sidebarBackdrop?.classList.toggle('show');
            }

            sidebarToggle?.addEventListener('click', toggleSidebar);
            sidebarBackdrop?.addEventListener('click', toggleSidebar);
        });
    </script>

    @stack('scripts')
</body>

</html>
