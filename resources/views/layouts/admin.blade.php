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

    @stack('styles')
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <img src="{{ asset('images/logo.png') }}" class="logo-sidebar" alt="Logo Mutu Sekolah">
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="{{ route('dashboard') }}"
                    class="sidebar-menu-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.users.index') }}"
                    class="sidebar-menu-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>User Management</span>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.questions.index') }}"
                    class="sidebar-menu-link {{ request()->is('admin/questions*') ? 'active' : '' }}">
                    <i class="bi bi-question-circle"></i>
                    <span>Question Library</span>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.instruments.index') }}"
                    class="sidebar-menu-link {{ request()->is('admin/instruments*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Instruments</span>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.assessments.index') }}"
                    class="sidebar-menu-link {{ request()->is('admin/assessments*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Assessments</span>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.submissions.index') }}"
                    class="sidebar-menu-link {{ request()->is('admin/submissions*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Submissions</span>
                </a>
            </li>

            <li class="sidebar-menu-item mt-4">
                <a href="#"
                    onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"
                    class="sidebar-menu-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <nav class="top-navbar">
            <button class="btn btn-link text-decoration-none d-lg-none" id="sidebarToggle">
                <i class="bi bi-list fs-4"></i>
            </button>

            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">
                    Welcome, {{ Auth::user()->name }}
                </span>
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-4"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.users.show', Auth::id()) }}">
                                <i class="bi bi-person me-2"></i>My Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

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
            const sidebar = document.querySelector('.sidebar');

            sidebarToggle?.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
