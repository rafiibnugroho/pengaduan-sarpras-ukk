<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Petugas')</title>

    <!-- Gunakan hanya SATU link Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Tambahan CSS dari child view --}}
    @stack('styles')

    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --light-gray: #f8fafc;
            --medium-gray: #e2e8f0;
            --dark-gray: #475569;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --sidebar-width: 280px;
            --sidebar-width-collapsed: 80px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            overflow-x: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-gray);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid var(--medium-gray);
            overflow-y: auto;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }

        .sidebar.collapsed {
            width: var(--sidebar-width-collapsed);
        }

        /* Header Sidebar */
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--medium-gray);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: var(--header-height);
        }

        .sidebar.collapsed .sidebar-header {
            padding: 1.5rem 0.75rem;
            justify-content: center;
        }

        .sidebar-header .logo {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .sidebar-header .brand {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 1;
            transform: translateX(0);
        }

        .sidebar.collapsed .brand {
            opacity: 0;
            transform: translateX(-10px);
            width: 0;
            overflow: hidden;
        }

        /* Hamburger Menu */
        .sidebar-hamburger {
            padding: 0 1.5rem 1rem;
            border-bottom: 1px solid var(--medium-gray);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed .sidebar-hamburger {
            padding: 0 0.75rem 1rem;
        }

        .hamburger-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 0.75rem;
            width: 100%;
        }

        .sidebar.collapsed .hamburger-btn {
            justify-content: center;
            padding: 0.75rem;
        }

        .hamburger-btn:hover {
            background-color: var(--light-gray);
            color: var(--primary-color);
            transform: translateX(3px);
        }

        .hamburger-icon {
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .hamburger-btn:hover .hamburger-icon {
            transform: scale(1.1);
        }

        .hamburger-text {
            font-weight: 500;
            color: var(--text-primary);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 1;
            transform: translateX(0);
        }

        .sidebar.collapsed .hamburger-text {
            opacity: 0;
            transform: translateX(-10px);
            width: 0;
            overflow: hidden;
        }

        /* Navigation */
        .sidebar-nav {
            padding: 1rem 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-item {
            margin: 0 1rem 0.25rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed .nav-item {
            margin: 0 0.5rem 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            gap: 0.75rem;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-link {
            padding: 0.75rem;
            justify-content: center;
        }

        .nav-link:hover {
            background-color: var(--light-gray);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .nav-link.active {
            background-color: var(--primary-color);
            color: white;
            transform: translateX(0);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .nav-link.active:hover {
            background-color: var(--primary-dark);
            transform: translateX(5px);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .nav-link span {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 1;
            transform: translateX(0);
        }

        .sidebar.collapsed .nav-link span {
            opacity: 0;
            transform: translateX(-10px);
            width: 0;
            overflow: hidden;
        }

        /* Tooltip untuk sidebar collapsed */
        .nav-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%) translateX(-10px);
            background: var(--text-primary);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1001;
            pointer-events: none;
        }

        .sidebar.collapsed .nav-link:hover::after {
            opacity: 1;
            visibility: visible;
            transform: translateY(-50%) translateX(10px);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: var(--light-gray);
        }

        .sidebar.collapsed + .main-content {
            margin-left: var(--sidebar-width-collapsed);
            width: calc(100% - var(--sidebar-width-collapsed));
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Mobile Header */
        .mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: var(--header-height);
            background: white;
            border-bottom: 1px solid var(--medium-gray);
            padding: 0 1rem;
            z-index: 999;
            align-items: center;
            justify-content: space-between;
        }

        .mobile-header .brand {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .mobile-hamburger {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .mobile-hamburger:hover {
            background-color: var(--light-gray);
            color: var(--primary-color);
        }

        /* Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--medium-gray);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        /* Mobile Overlay dengan animasi smooth */
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            opacity: 0;
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Loading indicator */
        .loading-indicator {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            z-index: 10000;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .sidebar {
                width: var(--sidebar-width-collapsed);
            }

            .sidebar .brand,
            .sidebar .hamburger-text,
            .sidebar .nav-link span {
                opacity: 0;
                transform: translateX(-10px);
                width: 0;
                overflow: hidden;
            }

            .main-content {
                margin-left: var(--sidebar-width-collapsed);
                width: calc(100% - var(--sidebar-width-collapsed));
            }

            .sidebar-header {
                padding: 1.5rem 0.75rem;
                justify-content: center;
            }

            .sidebar-hamburger {
                padding: 0 0.75rem 1rem;
            }

            .hamburger-btn {
                justify-content: center;
            }

            .nav-item {
                margin: 0 0.5rem 0.25rem;
            }

            .nav-link {
                padding: 0.75rem;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .mobile-header {
                display: flex;
            }

            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
                top: var(--header-height);
                height: calc(100vh - var(--header-height));
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar .brand,
            .sidebar .hamburger-text,
            .sidebar .nav-link span {
                opacity: 1;
                transform: translateX(0);
                width: auto;
                overflow: visible;
            }

            .sidebar-header {
                padding: 1.5rem;
                justify-content: flex-start;
                display: none; /* Sembunyikan header di sidebar pada mobile */
            }

            .sidebar-hamburger {
                padding: 0 1.5rem 1rem;
            }

            .hamburger-btn {
                justify-content: flex-start;
            }

            .nav-item {
                margin: 0 1rem 0.25rem;
            }

            .nav-link {
                padding: 0.75rem 1rem;
                justify-content: flex-start;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding-top: var(--header-height);
            }

            .content-area {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .content-area {
                padding: 0.75rem;
            }

            .mobile-header {
                padding: 0 0.75rem;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light-gray);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--medium-gray);
            border-radius: 3px;
            transition: background 0.3s ease;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }

        /* Logout Button */
        .logout-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            gap: 0.75rem;
            white-space: nowrap;
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #fef2f2;
            color: var(--danger-color);
            transform: translateX(5px);
        }

        .sidebar.collapsed .logout-btn {
            justify-content: center;
            padding: 0.75rem;
        }

        .sidebar.collapsed .logout-btn span {
            opacity: 0;
            transform: translateX(-10px);
            width: 0;
            overflow: hidden;
        }

        /* Smooth transitions untuk semua elemen */
        .sidebar * {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Loading state */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <!-- Loading Indicator -->
    <div class="loading-indicator" id="loadingIndicator"></div>

    <!-- Mobile Header -->
    <div class="mobile-header">
        <div class="brand">Petugas Sarpras</div>
        <button class="mobile-hamburger" id="mobileHamburger">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar collapsed" id="sidebar">
        <!-- Header -->
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-user-cog"></i>
            </div>
            <span class="brand">Petugas Sarpras</span>
        </div>

        <!-- Hamburger Menu -->
        <div class="sidebar-hamburger">
            <button class="hamburger-btn" id="sidebarToggle">
                <i class="fas fa-bars hamburger-icon"></i>
                <span class="hamburger-text">Menu</span>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard" data-route="petugas.dashboard">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('petugas.pengaduan.index') }}" class="nav-link {{ request()->routeIs('petugas.pengaduan.*') ? 'active' : '' }}" data-tooltip="Pengaduan" data-route="petugas.pengaduan">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Kelola Pengaduan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('petugas.pengaturan.index') }}" class="nav-link {{ request()->routeIs('petugas.pengaturan.*') ? 'active' : '' }}" data-tooltip="Pengaturan" data-route="petugas.pengaturan">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
            </div>

            <!-- Logout -->
            <div class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="w-100" id="logoutForm">
                    @csrf
                    <button type="submit" class="logout-btn" data-tooltip="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Content Area -->
        <main class="content-area" id="mainContent">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar functionality dengan smooth animations
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileHamburger = document.getElementById('mobileHamburger');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const mainContent = document.getElementById('mainContent');

        // State management
        let currentPage = '{{ request()->route()->getName() }}';
        let isNavigating = false;

        // Fungsi untuk toggle sidebar state
        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                // Mobile behavior
                if (sidebar.classList.contains('show')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            } else {
                // Desktop behavior - toggle collapsed state
                sidebar.classList.toggle('collapsed');
                // Simpan state sidebar di localStorage
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        }

        // Open sidebar pada mobile
        function openSidebar() {
            sidebar.classList.add('show');
            setTimeout(() => {
                sidebar.style.transform = 'translateX(0)';
                mobileOverlay.classList.add('active');
                setTimeout(() => {
                    mobileOverlay.style.opacity = '1';
                }, 50);
            }, 50);
            document.body.style.overflow = 'hidden';
        }

        // Close sidebar pada mobile
        function closeSidebar() {
            sidebar.style.transform = 'translateX(-100%)';
            mobileOverlay.style.opacity = '0';
            setTimeout(() => {
                sidebar.classList.remove('show');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            }, 400);
        }

        // Update active menu item
        function updateActiveMenu(routeName) {
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
                const linkRoute = link.getAttribute('data-route');
                if (routeName.startsWith(linkRoute)) {
                    link.classList.add('active');
                }
            });
        }

        // Navigasi dengan AJAX
        async function navigateTo(url, routeName) {
            if (isNavigating) return;

            isNavigating = true;
            loadingIndicator.style.display = 'block';

            try {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const html = await response.text();

                // Parse HTML response
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.content-area').innerHTML;
                const newTitle = doc.querySelector('title').textContent;

                // Update content dan title
                mainContent.innerHTML = newContent;
                document.title = newTitle;

                // Update URL tanpa refresh
                window.history.pushState({}, '', url);

                // Update active menu
                currentPage = routeName;
                updateActiveMenu(routeName);

                // Trigger event untuk scripts yang perlu dijalankan ulang
                window.dispatchEvent(new Event('content-loaded'));

            } catch (error) {
                console.error('Navigation error:', error);
                // Fallback ke navigasi normal
                window.location.href = url;
            } finally {
                loadingIndicator.style.display = 'none';
                isNavigating = false;

                // Tutup sidebar di mobile setelah navigasi
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            }
        }

        // Event listeners
        sidebarToggle.addEventListener('click', toggleSidebar);
        mobileHamburger.addEventListener('click', toggleSidebar);
        mobileOverlay.addEventListener('click', closeSidebar);

        // Handle navigation clicks
        document.addEventListener('click', function(e) {
            const link = e.target.closest('.nav-link');
            if (link && !link.classList.contains('logout-btn')) {
                e.preventDefault();

                const url = link.href;
                const routeName = link.getAttribute('data-route');

                navigateTo(url, routeName);
            }
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function() {
            // Reload page untuk simplicity
            window.location.reload();
        });

        // Handle window resize
        function handleResize() {
            if (window.innerWidth <= 768) {
                // Mobile behavior
                sidebar.classList.remove('collapsed');
                if (!sidebar.classList.contains('show')) {
                    closeSidebar();
                }
            } else {
                // Desktop behavior
                sidebar.classList.remove('show');
                mobileOverlay.classList.remove('active');
                mobileOverlay.style.opacity = '0';
                document.body.style.overflow = 'auto';

                // Restore sidebar state dari localStorage untuk desktop
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                } else {
                    sidebar.classList.remove('collapsed');
                }
            }

            // Auto-collapse on medium screens (1200px - 768px)
            if (window.innerWidth <= 1200 && window.innerWidth > 768) {
                sidebar.classList.add('collapsed');
            } else if (window.innerWidth > 1200) {
                // Di desktop besar, gunakan state yang disimpan user
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                } else {
                    sidebar.classList.remove('collapsed');
                }
            }
        }

        // Initialize
        window.addEventListener('resize', handleResize);

        // Load saved sidebar state
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                handleResize();

                // Load saved state untuk desktop
                if (window.innerWidth > 768) {
                    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                    if (isCollapsed) {
                        sidebar.classList.add('collapsed');
                    } else {
                        sidebar.classList.remove('collapsed');
                    }
                }

                // Set current page
                updateActiveMenu(currentPage);
            }, 100);
        });

        // Enhanced hover effects
        document.querySelectorAll('.nav-link, .logout-btn, .hamburger-btn').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            });

            link.addEventListener('mouseleave', function() {
                this.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            });
        });

        // Event untuk child scripts
        window.addEventListener('content-loaded', function() {
            // Re-initialize scripts yang perlu dijalankan ulang
            if (typeof initializePageScripts === 'function') {
                initializePageScripts();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
