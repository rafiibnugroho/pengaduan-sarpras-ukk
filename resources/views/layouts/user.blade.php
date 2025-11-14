<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard User')</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    {{-- Tambahan CSS dari child view --}}
    @stack('styles')

    <!-- Brave Performance Fix -->
    <script>
        // Force disable heavy effects for Brave
        if (navigator.brave || /Brave/i.test(navigator.userAgent)) {
            document.addEventListener('DOMContentLoaded', function() {
                // Remove all heavy elements immediately
                const floatingContainer = document.querySelector('.floating-elements');
                if (floatingContainer) floatingContainer.remove();

                // Disable all backdrop filters
                document.querySelectorAll('*').forEach(el => {
                    el.style.backdropFilter = 'none';
                    el.style.transform = 'none';
                });

                // Add lightweight styles
                const lightStyle = document.createElement('style');
                lightStyle.textContent = `
                    .glass-card, .navbar, .user-dropdown, .modern-table {
                        backdrop-filter: none !important;
                        background: rgba(255, 255, 255, 0.95) !important;
                    }
                    .glass-card:hover {
                        transform: translateY(-2px) !important;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
                    }
                    .modern-table tbody tr:hover {
                        transform: none !important;
                        background: #f8f9fa !important;
                    }
                    .floating-elements {
                        display: none !important;
                    }
                    * {
                        transition: all 0.2s ease !important;
                    }
                `;
                document.head.appendChild(lightStyle);
            });
        }
    </script>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --dark-gradient: linear-gradient(135deg, #4c669f 0%, #3b5998 100%);

            --primary-color: #6366f1;
            --primary-light: #eef2ff;
            --primary-dark: #4f46e5;
            --success: #10b981;
            --success-light: #ecfdf5;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --text-dark: #1f2937;
            --text-medium: #6b7280;
            --text-light: #9ca3af;
            --border-color: #e5e7eb;
            --surface: #ffffff;
            --background: #f8fafc;
            --gradient-bg: linear-gradient(135deg, #f8faff 0%, #f1f5f9 100%);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1);
            --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.25);
            --border-radius: 24px;
            --border-radius-md: 20px;
            --border-radius-sm: 16px;
            --border-radius-xs: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gradient-bg);
            color: var(--text-dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* SIMPLIFIED Navigation - No heavy effects */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }

        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: var(--shadow-md);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 1.35rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-brand img {
            height: 40px;
            width: auto;
            transition: transform 0.2s ease;
        }

        .navbar-brand:hover img {
            transform: rotate(-5deg) scale(1.05);
        }

        .nav-link {
            position: relative;
            padding: 0.75rem 1.25rem !important;
            margin: 0 0.5rem;
            border-radius: var(--border-radius-sm);
            transition: all 0.2s ease;
            font-weight: 500;
            color: var(--text-medium) !important;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.2s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
            background: rgba(99, 102, 241, 0.08);
        }

        .nav-link.active::before {
            width: 60%;
        }

        /* SIMPLIFIED User Dropdown */
        .user-dropdown {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 0.5rem 0.75rem;
            transition: all 0.2s ease;
        }

        .user-dropdown:hover {
            background: rgba(99, 102, 241, 0.05);
            border-color: var(--primary-color);
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.2s ease;
        }

        /* User Info in Mobile Menu */
        .mobile-user-info {
            display: none;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .mobile-user-info .user-avatar {
            width: 50px;
            height: 50px;
            margin-right: 1rem;
        }

        .mobile-user-info .user-details {
            flex: 1;
        }

        .mobile-user-info .user-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .mobile-user-info .user-role {
            font-size: 0.875rem;
            color: var(--text-light);
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* SIMPLIFIED Cards - No glass effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
            overflow: hidden;
        }

        .glass-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-color);
        }

        /* SIMPLIFIED Button Styles */
        .btn-modern {
            padding: 0.875rem 2rem;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
            border: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--border-color);
            color: var(--text-dark);
        }

        .btn-secondary:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* SIMPLIFIED Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            padding: 2rem 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius-md);
            background: white;
            box-shadow: var(--shadow-sm);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 2px 2px 0 0;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-label {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-medium);
            margin-bottom: 1rem;
        }

        /* SIMPLIFIED Table */
        .modern-table {
            background: white;
            border-radius: var(--border-radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .modern-table th {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            font-weight: 700;
            padding: 1.25rem;
            border: none;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modern-table td {
            padding: 1rem 1.25rem;
            border-color: var(--border-color);
            transition: all 0.2s ease;
            vertical-align: middle;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background: rgba(99, 102, 241, 0.03);
        }

        /* SIMPLIFIED Badge */
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Progress Bars */
        .progress {
            height: 6px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 10px;
            transition: width 0.8s ease-in-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .glass-card {
                margin-bottom: 1rem;
            }

            .btn-modern {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
            }

            /* Show mobile user info in collapsed menu */
            .mobile-user-info {
                display: flex;
                align-items: center;
            }

            /* Hide desktop user dropdown in mobile */
            .navbar .dropdown:not(.mobile-dropdown) {
                display: none;
            }

            /* Disable all transforms on mobile */
            .glass-card:hover {
                transform: none;
            }
        }

        @media (min-width: 769px) {
            /* Hide mobile user info on desktop */
            .mobile-user-info {
                display: none !important;
            }
        }

        /* Custom Scrollbar - Simplified */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--background);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }

        /* Floating Background Elements - REMOVED in Brave */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-element {
            position: absolute;
            background: var(--primary-gradient);
            opacity: 0.1;
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        /* Brave-specific optimizations - DISABLE EVERYTHING */
        @media all and (-webkit-brave: true) {
            .floating-elements {
                display: none !important;
            }

            .glass-card, .navbar, .user-dropdown, .modern-table {
                backdrop-filter: none !important;
                background: white !important;
            }

            .glass-card:hover {
                transform: translateY(-2px) !important;
            }

            .modern-table tbody tr:hover {
                transform: none !important;
            }

            * {
                transition: all 0.1s ease !important;
                animation: none !important;
            }
        }

        /* Low performance device detection */
        .lightweight-mode .floating-elements {
            display: none !important;
        }

        .lightweight-mode .glass-card {
            transition: none;
        }

        .lightweight-mode .glass-card:hover {
            transform: none;
        }
    </style>
</head>
<body>
    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.webp') }}" alt="Logo">
                <span>Pengaduan Sarpras</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i data-lucide="menu"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Mobile User Info (Visible only in hamburger menu) -->
                <div class="mobile-user-info d-lg-none">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Pengguna Terdaftar</div>
                    </div>
                </div>

                <ul class="navbar-nav ms-auto me-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i data-lucide="home"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengaduan.create') ? 'active' : '' }}" href="{{ route('pengaduan.create') }}">
                            <i data-lucide="plus-circle"></i>
                            Buat Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengaduan.index') ? 'active' : '' }}" href="{{ route('pengaduan.index') }}">
                            <i data-lucide="file-text"></i>
                            Riwayat
                        </a>
                    </li>
                </ul>

                <!-- Desktop User Dropdown (Hidden on mobile) -->
                <div class="dropdown d-none d-lg-block">
                    <div class="user-dropdown d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight: 600;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 0.875rem; color: var(--text-light);">Pengguna Terdaftar</div>
                        </div>
                        <i data-lucide="chevron-down" style="width: 16px; height: 16px;"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="border-radius: var(--border-radius-sm); border: 1px solid var(--border-color); background: white;">
                        <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i data-lucide="user"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    <i data-lucide="log-out"></i>Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <!-- Mobile Menu Items (Visible only in hamburger menu) -->
                <div class="d-lg-none mt-3">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                                <i data-lucide="user"></i>
                                Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="nav-link text-danger w-100 text-start border-0 bg-transparent" type="submit" style="font-weight: 500;">
                                    <i data-lucide="log-out"></i>
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // SIMPLIFIED Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // DISABLE complex animations for Brave
        const isBrave = navigator.brave || /Brave/i.test(navigator.userAgent);

        if (!isBrave) {
            // Simple fade in for cards
            document.querySelectorAll('.glass-card').forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        } else {
            // Skip all animations for Brave
            document.querySelectorAll('.glass-card').forEach(card => {
                card.style.opacity = '1';
                card.style.transform = 'none';
            });

            // Remove floating elements completely
            document.querySelector('.floating-elements')?.remove();
        }

        // Simple hover effects (disabled for Brave)
        if (!isBrave) {
            document.querySelectorAll('.btn-modern').forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        }

        // Force lightweight mode if still laggy
        setTimeout(() => {
            if (isBrave) {
                document.documentElement.classList.add('lightweight-mode');
                console.log('Lightweight mode activated for Brave');
            }
        }, 1000);
    </script>

    @stack('scripts')
</body>
</html>
