<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - ' . config('app.name'))</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.4/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            z-index: 1000;
            padding-top: 70px;
        }

        .sidebar-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .sidebar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #6366f1;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link {
            color: #475569;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            background: #f1f5f9;
            color: #6366f1;
        }

        .nav-link.active {
            background: #6366f1;
            color: white;
        }

        /* Top Navbar */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            height: 70px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            z-index: 999;
        }

        .profile-dropdown {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #6366f1;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 2rem;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        .card-icon {
            font-size: 2rem;
            padding: 0.75rem;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .bg-primary-light {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
        }

        .text-primary {
            color: #6366f1 !important;
        }

        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin: 0.5rem 0 0.25rem;
        }

        .card-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
        }

        .card-subtitle {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0.5rem 0 0;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.2);
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 1.5rem;
        }

        .btn-action {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('petugas.dashboard') }}" class="sidebar-brand">
                <i class="fas fa-bullhorn"></i>
                <span>{{ config('app.name') }}</span>
            </a>
        </div>
        <ul class="nav flex-column px-2">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('petugas.pengaduan.index') ? 'active' : '' }}" href="{{ route('petugas.pengaduan.index') }}">
                    <i class="fas fa-tasks"></i> Kelola Pengaduan
                </a>
            </li>
            <li class="nav-item mt-auto">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link text-danger">Logout</button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Top Navbar -->
    <nav class="top-navbar">
        <div class="profile-dropdown">
            <div class="avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div>
                <div class="fw-medium">{{ Auth::user()->name }}</div>
                <div class="text-muted" style="font-size: 0.8rem;">Petugas</div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
