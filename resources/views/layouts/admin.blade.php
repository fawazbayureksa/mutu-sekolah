<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Panel - Mutu Sekolah')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
            --dark-sidebar: #1e293b;
            --light-sidebar: #334155;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
        }

        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, var(--dark-sidebar) 0%, var(--light-sidebar) 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .sidebar-menu {
            padding: 1rem 0;
            list-style: none;
            margin: 0;
        }

        .sidebar-menu-item {
            padding: 0.5rem 1.5rem;
        }

        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .sidebar-menu-link:hover,
        .sidebar-menu-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-menu-link i {
            font-size: 1.25rem;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .top-navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-content {
            padding: 2rem;
        }

        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem;
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .table th {
            font-weight: 600;
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .badge-active {
            background-color: #10b981;
        }

        .badge-inactive {
            background-color: #ef4444;
        }

        .badge-draft {
            background-color: #6b7280;
        }

        .badge-submitted {
            background-color: #3b82f6;
        }

        .badge-verified {
            background-color: #8b5cf6;
        }

        .badge-approved {
            background-color: #10b981;
        }

        .badge-rejected {
            background-color: #ef4444;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <i class="bi bi-grid-fill me-2"></i>
                Admin Panel
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
