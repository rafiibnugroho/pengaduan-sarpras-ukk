<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard Petugas')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #3B82F6;
            --primary-dark: #1D4ED8;
            --primary-light: #EFF6FF;
            --secondary-color: #64748B;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --info-color: #06B6D4;
            --dark-color: #1E293B;
            --light-color: #F8FAFC;
            --border-color: #E2E8F0;
            --text-dark: #1E293B;
            --text-medium: #475569;
            --text-light: #94A3B8;
            --surface: #FFFFFF;
            --background: #F1F5F9;
            --sidebar-width: 280px;
            --border-radius: 16px;
            --border-radius-sm: 12px;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, var(--background) 0%, #E2E8F0 100%);
            color: var(--text-dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Modern Design */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--surface) 0%, #F8FAFC 100%);
            border-right: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            z-index: 1000;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--surface);
        }

        .brand-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: var(--shadow-sm);
        }

        .brand-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0;
            overflow-y: auto;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 1.5rem;
            margin-bottom: 0.75rem;
        }

        .nav-item {
            margin: 0.25rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            border-radius: var(--border-radius-sm);
            color: var(--text-medium);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--primary-color);
            transform: scaleY(0);
            transition: var(--transition);
            border-radius: 0 4px 4px 0;
        }

        .nav-link:hover {
            background: var(--primary-light);
            color: var(--primary-color);
            transform: translateX(4px);
        }

        .nav-link:hover::before {
            transform: scaleY(1);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .nav-link.active::before {
            transform: scaleY(1);
            background: white;
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: var(--transition);
            background: transparent;
        }

        /* Modern Header */
        .header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0 2rem;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        .page-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            background: linear-gradient(135deg, var(--text-dark) 0%, var(--text-medium) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-actions {
            margin-left: 950px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius-sm);
            background: var(--surface);
            border: 1px solid var(--border-color);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
        }

        .user-profile:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: var(--shadow-sm);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Modern Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            overflow: hidden;
            position: relative;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        /* Statistics Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            background: var(--primary-light);
            color: var(--primary-color);
            box-shadow: var(--shadow-sm);
        }

        .stat-icon.success { background: #ECFDF5; color: var(--success-color); }
        .stat-icon.warning { background: #FFFBEB; color: var(--warning-color); }
        .stat-icon.danger { background: #FEF2F2; color: var(--danger-color); }
        .stat-icon.info { background: #ECFEFF; color: var(--info-color); }
        .stat-icon.dark { background: #F1F5F9; color: var(--dark-color); }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0.5rem 0;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-medium);
            margin: 0;
        }

        /* Welcome Section */
        .welcome-card {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 3rem 2.5rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px); /* efek kaca */
}


        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .welcome-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .welcome-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.9;
            display: inline-block;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-modern {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.875rem 2rem;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }

        .btn-modern:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Activity Section */
        .activity-section {
            max-width: 1200px;
            margin: 2rem auto;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2.5rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            padding-left: 1rem;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 28px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .btn-modern {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: #1D4ED8;
            color: white;
            text-decoration: none;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            border: none;
            cursor: pointer;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            background: #06B6D4;
        }

        .activity-list {
            display: grid;
            gap: 1.5rem;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition);
            overflow: hidden;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            position: relative;
            transition: var(--transition);
        }

        .activity-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .activity-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            transition: var(--transition);
        }

        .activity-item.selesai::before { background: var(--success-color); }
        .activity-item.diproses::before { background: var(--warning-color); }
        .activity-item.ditolak::before { background: var(--danger-color); }
        .activity-item.diajukan::before { background: var(--primary-color); }

        .activity-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
            margin-right: 1.25rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .activity-item:hover .activity-icon {
            transform: scale(1.1);
        }

        .activity-icon.selesai {
            background: var(--success-color);
            box-shadow: 0 4px 15px rgba(6, 214, 160, 0.3);
        }
        .activity-icon.diproses {
            background: var(--warning-color);
            box-shadow: 0 4px 15px rgba(255, 209, 102, 0.3);
        }
        .activity-icon.ditolak {
            background: var(--danger-color);
            box-shadow: 0 4px 15px rgba(239, 71, 111, 0.3);
        }
        .activity-icon.diajukan {
            background: var(--primary-color);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .activity-meta {
            font-size: 0.9rem;
            color: var(--text-medium);
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .priority-tag {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .priority-tinggi { background: #FEF2F2; color: var(--danger-color); }
        .priority-sedang { background: #FFFBEB; color: var(--warning-color); }
        .priority-rendah { background: #ECFDF5; color: var(--success-color); }

        .activity-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
            margin-left: auto;
            box-shadow: var(--shadow-sm);
        }

        .badge-selesai { background: #ECFDF5; color: var(--success-color); border: 1px solid #D1FAE5; }
        .badge-diproses { background: #FFFBEB; color: var(--warning-color); border: 1px solid #FEF3C7; }
        .badge-ditolak { background: #FEF2F2; color: var(--danger-color); border: 1px solid #FECACA; }
        .badge-diajukan { background: #EFF6FF; color: var(--primary-color); border: 1px solid #DBEAFE; }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--text-light);
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--text-medium);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-light);
            max-width: 400px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-medium);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Mobile Responsive */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-dark);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
        }

        .mobile-menu-btn:hover {
            background: var(--primary-light);
            color: var(--primary-color);
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block;
            }

            .content-area {
                padding: 1.5rem;
            }

            .welcome-section {
                padding: 2rem 1.5rem;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
                height: 70px;
            }

            .content-area {
                padding: 1rem;
            }

            .welcome-section {
                padding: 1.5rem 1rem;
            }

            .welcome-title {
                font-size: 1.75rem;
            }

            .stat-value {
                font-size: 2rem;
            }

            .activity-item {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }

            .activity-icon {
                margin-right: 0;
                margin-bottom: 1rem;
            }

            .activity-badge {
                margin-left: 0;
                margin-top: 1rem;
                align-self: flex-end;
            }

            .activity-meta {
                flex-direction: column;
                gap: 0.5rem;
            }

            .user-info {
                display: none;
            }
        }

        /* Animation Classes */
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stagger-item {
            animation: stagger 0.5s ease-out;
        }

        @keyframes stagger {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a class="brand-container" href="{{ route('petugas.dashboard') }}">
                <div class="brand-logo">
                    <i class="fas fa-tools"></i>
                </div>
                <span class="brand-text">Petugas Sarpras</span>
            </a>
        </div>

        <div class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Menu Utama</div>
                <div class="nav-item">
                    <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('petugas.pengaduan.index') }}" class="nav-link {{ request()->routeIs('petugas.pengaduan.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        Kelola Pengaduan
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Akun</div>
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        Pengaturan
                    </a>
                </div>
                <div class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-left bg-transparent border-0">
                            <div class="nav-icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
            <div class="header-actions">
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Petugas Sarpras</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    sidebar.classList.remove('mobile-open');
                }
            }
        });

        // Add animation to stats cards
        document.addEventListener('DOMContentLoaded', function() {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('fade-in-up');
            });

            // Add hover effects
            const cards = document.querySelectorAll('.glass-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });

        // Real-time updates simulation (optional)
        function simulateRealTimeUpdates() {
            const statValues = document.querySelectorAll('.stat-value');
            setInterval(() => {
                statValues.forEach(stat => {
                    const currentValue = parseInt(stat.textContent);
                    const randomChange = Math.random() > 0.5 ? 1 : -1;
                    const newValue = Math.max(0, currentValue + randomChange);
                    if (newValue !== currentValue) {
                        stat.textContent = newValue;
                        stat.style.color = randomChange > 0 ? 'var(--success-color)' : 'var(--danger-color)';
                        setTimeout(() => {
                            stat.style.color = 'var(--text-dark)';
                        }, 1000);
                    }
                });
            }, 5000);
        }

        // Uncomment the line below if you want to enable real-time simulation
        // simulateRealTimeUpdates();
    </script>

    @stack('scripts')
</body>
</html>
