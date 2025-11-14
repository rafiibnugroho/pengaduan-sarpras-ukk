@extends('layouts.admin')
@section('page-title', 'Dashboard Admin')
@section('content')
<div class="dashboard-admin">
    <!-- Background Elements -->
    <div class="position-fixed w-100 h-100 top-0 start-0" style="z-index: -1;">
        <div class="admin-bg-shape shape-1"></div>
        <div class="admin-bg-shape shape-2"></div>
        <div class="admin-bg-shape shape-3"></div>
    </div>

    <!-- Welcome Header -->
    <div class="dashboard-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="welcome-content">
                    <h1 class="welcome-title">
                        Selamat Datang, <span class="gradient-text">{{ Auth::user()->name ?? 'Admin' }}</span> 👋
                    </h1>
                    <p class="welcome-subtitle">Kelola sistem dengan mudah melalui dashboard yang telah disediakan</p>
                    <div class="welcome-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt me-2"></i>
                            {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock me-2"></i>
                            <span id="liveClock">{{ \Carbon\Carbon::now()->format('H:i') }}</span> WIB
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="performance-overview">
                    <div class="performance-item">
                        <div class="performance-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="performance-info">
                            <div class="performance-value">{{ \App\Models\Pengaduan::count() }}</div>
                            <div class="performance-label">Total Aktivitas</div>
                            <div class="performance-trend positive">
                                <i class="fas fa-arrow-up"></i>
                                <span>12% dari kemarin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Statistics Grid -->
    <div class="stats-grid-modern mb-5">
        <div class="row g-4">
            @php
                $cards = [
                    ['icon' => 'fa-users', 'title' => 'Total Pengguna', 'value' => \App\Models\User::count(), 'trend' => '+2.5%', 'color' => 'primary', 'progress' => '75%', 'note' => '75% target tercapai'],
                    ['icon' => 'fa-box', 'title' => 'Total Item', 'value' => \App\Models\Item::count(), 'trend' => '+5.2%', 'color' => 'success', 'progress' => '60%', 'note' => '60% pertumbuhan'],
                    ['icon' => 'fa-exclamation-triangle', 'title' => 'Total Pengaduan', 'value' => \App\Models\Pengaduan::count(), 'trend' => '-1.8%', 'color' => 'warning', 'progress' => '45%', 'note' => 'Respon cepat diperlukan'],
                    ['icon' => 'fa-map-marker-alt', 'title' => 'Total Lokasi', 'value' => \App\Models\Lokasi::count(), 'trend' => 'Stabil', 'color' => 'purple', 'progress' => '90%', 'note' => '90% coverage area'],
                ];
            @endphp

            @foreach($cards as $card)
                <div class="col-xl-3 col-lg-6">
                    <div class="stat-card-modern">
                        <div class="stat-content">
                            <div class="stat-header">
                                <div class="stat-icon-wrapper {{ $card['color'] }}">
                                    <i class="fas {{ $card['icon'] }}"></i>
                                </div>
                                <div class="stat-trend positive">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>{{ $card['trend'] }}</span>
                                </div>
                            </div>
                            <div class="stat-body">
                                <div class="stat-value">{{ $card['value'] }}</div>
                                <div class="stat-title">{{ $card['title'] }}</div>
                            </div>
                            <div class="stat-footer">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $card['progress'] }}"></div>
                                </div>
                                <span class="progress-text">{{ $card['note'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row g-4">
        <div class="col-12">
            <div class="dashboard-card-atas">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="header-text">
                            <h3 class="card-title">Aksi Cepat</h3>
                            <p class="card-subtitle">Akses fitur penting dengan satu klik</p>
                        </div>
                    </div>
                    <div class="header-badge">
                        <span class="badge-count">{{ \App\Models\Pengaduan::where('status', 'Diajukan')->count() }}</span>
                        <span>Pengaduan Baru</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="quick-actions-grid">
                        <a href="{{ route('admin.users.create') }}" class="quick-action-modern">
                            <div class="action-icon primary"><i class="fas fa-user-plus"></i></div>
                            <div class="action-content">
                                <h4>Tambah User</h4><p>Daftarkan pengguna baru ke sistem</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.lokasi.create') }}" class="quick-action-modern">
                            <div class="action-icon danger"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="action-content">
                                <h4>Tambah Lokasi</h4><p>Daftarkan lokasi baru untuk monitoring</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.items.create') }}" class="quick-action-modern">
                            <div class="action-icon success"><i class="fas fa-box"></i></div>
                            <div class="action-content">
                                <h4>Tambah Item</h4><p>Input item sarana prasarana baru</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.pengaduan.index') }}" class="quick-action-modern highlight">
                            <div class="action-icon warning"><i class="fas fa-exclamation-circle"></i></div>
                            <div class="action-content">
                                <h4>Kelola Pengaduan</h4><p>Review dan proses pengaduan masuk</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.laporan.index') }}" class="quick-action-modern">
                            <div class="action-icon purple"><i class="fas fa-chart-line"></i></div>
                            <div class="action-content">
                                <h4>Analisis Laporan</h4><p>Lihat analisis data dan statistik</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="quick-action-modern">
                            <div class="action-icon info"><i class="fas fa-cog"></i></div>
                            <div class="action-content">
                                <h4>Kelola Sistem</h4><p>Pengaturan dan konfigurasi sistem</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card-aktivitas">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="header-text">
                            <h3 class="card-title">Aktivitas Terbaru</h3>
                            <p class="card-subtitle">Monitor aktivitas sistem terkini</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="activity-timeline-modern">
                        @forelse($pengaduan as $p)
                            <div class="activity-item-modern">
                                <div class="activity-indicator indicator-{{ strtolower($p->status) }}"></div>
                                <div class="activity-content">
                                    <div class="activity-header">
                                        <div class="activity-user">
                                            <div class="user-avatar">{{ substr($p->user->name ?? 'U', 0, 1) }}</div>
                                            <div class="user-info">
                                                <h5 class="activity-title">{{ $p->user->name ?? 'Pengguna' }}</h5>
                                                <span class="activity-item">{{ $p->item->nama_item ?? 'Item' }}</span>
                                            </div>
                                        </div>
                                        <span class="activity-badge badge-{{ strtolower($p->status) }}">
                                            {{ $p->status }}
                                        </span>
                                    </div>
                                    <p class="activity-desc">{{ $p->nama_pengaduan }}</p>
                                    <div class="activity-meta">
                                        <span class="meta-item"><i class="fas fa-clock"></i> {{ $p->created_at->diffForHumans() }}</span>
                                        <span class="meta-item"><i class="fas fa-map-marker-alt"></i> {{ $p->lokasi->nama_lokasi ?? 'N/A' }}</span>
                                        <span class="meta-item"><i class="fas fa-calendar"></i> {{ $p->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h4>Belum ada aktivitas</h4>
                                <p>Tidak ada aktivitas terbaru untuk ditampilkan</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('styles')
<style>
/* Enhanced Dashboard Design System */
:root {
    --admin-primary: #4f46e5;
    --admin-primary-light: #6366f1;
    --admin-primary-dark: #4338ca;
    --admin-secondary: #10b981;
    --admin-accent: #f59e0b;
    --admin-danger: #ef4444;
    --admin-warning: #f59e0b;
    --admin-success: #10b981;
    --admin-purple: #8b5cf6;
    --admin-info: #06b6d4;
    --admin-dark: #1e293b;
    --admin-light: #f8fafc;
    --admin-gray-50: #f9fafb;
    --admin-gray-100: #f1f5f9;
    --admin-gray-200: #e2e8f0;
    --admin-gray-300: #cbd5e1;
    --admin-gray-400: #94a3b8;
    --admin-gray-500: #64748b;
    --admin-gray-600: #475569;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --radius: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
}

/* Enhanced Background Elements */
.admin-bg-shape {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--admin-primary-light), var(--admin-primary));
    opacity: 0.03;
    animation: adminFloat 25s ease-in-out infinite;
}

.shape-1 {
    width: 300px;
    height: 300px;
    top: 5%;
    right: 5%;
    animation-delay: 0s;
}

.shape-2 {
    width: 200px;
    height: 200px;
    top: 60%;
    left: 8%;
    animation-delay: 8s;
}

.shape-3 {
    width: 150px;
    height: 150px;
    bottom: 10%;
    right: 15%;
    animation-delay: 16s;
}

@keyframes adminFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
    33% { transform: translateY(-20px) rotate(120deg) scale(1.05); }
    66% { transform: translateY(10px) rotate(240deg) scale(0.95); }
}

/* Enhanced Welcome Header */
.dashboard-header {
    padding: 2rem 0;
}

.welcome-content {
    max-width: 600px;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--admin-dark);
    margin-bottom: 1rem;
    line-height: 1.2;
}

.gradient-text {
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-purple));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.welcome-subtitle {
    font-size: 1.2rem;
    color: var(--admin-gray-500);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.welcome-meta {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    color: var(--admin-gray-500);
    font-weight: 500;
    background: white;
    padding: 0.75rem 1rem;
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--admin-gray-200);
}

.meta-item i {
    color: var(--admin-primary);
    margin-right: 0.5rem;
}

.performance-overview {
    background: white;
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--admin-gray-200);
}

.performance-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.performance-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-dark));
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.performance-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--admin-dark);
    line-height: 1;
}

.performance-label {
    color: var(--admin-gray-500);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.performance-trend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
}

.performance-trend.positive {
    color: var(--admin-success);
}

/* Enhanced Stat Cards */
.stat-card-modern {
    position: relative;
    background: white;
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--admin-gray-200);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.stat-background {
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, transparent, rgba(99, 102, 241, 0.05));
    border-radius: 0 0 0 100px;
}

.stat-content {
    position: relative;
    z-index: 2;
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.stat-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: var(--shadow);
}

.stat-icon-wrapper.primary {
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-dark));
}

.stat-icon-wrapper.success {
    background: linear-gradient(135deg, var(--admin-success), #059669);
}

.stat-icon-wrapper.warning {
    background: linear-gradient(135deg, var(--admin-warning), #d97706);
}

.stat-icon-wrapper.purple {
    background: linear-gradient(135deg, var(--admin-purple), #7c3aed);
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 20px;
}

.stat-trend.positive {
    background: rgba(16, 185, 129, 0.1);
    color: var(--admin-success);
}

.stat-trend.negative {
    background: rgba(239, 68, 68, 0.1);
    color: var(--admin-danger);
}

.stat-trend.neutral {
    background: rgba(100, 116, 139, 0.1);
    color: var(--admin-gray-500);
}

.stat-body {
    margin-bottom: 1rem;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--admin-dark);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-title {
    color: var(--admin-gray-500);
    font-weight: 500;
    font-size: 0.95rem;
}

.stat-footer {
    border-top: 1px solid var(--admin-gray-200);
    padding-top: 1rem;
}

.stat-progress {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.progress-bar {
    height: 6px;
    background: var(--admin-gray-200);
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--admin-primary), var(--admin-primary-light));
    border-radius: 3px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 0.75rem;
    color: var(--admin-gray-500);
}

/* Enhanced Dashboard Cards */
.dashboard-card {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    border: 1px solid var(--admin-gray-200);
    overflow: hidden;
    height: 100%;
    transition: all 0.3s ease;
}
.dashboard-card-aktivitas {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    border: 1px solid var(--admin-gray-200);
    overflow: hidden;
    height: 100%;
    transition: all 0.3s ease;
}

.dashboard-card-atas {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    border: 1px solid var(--admin-gray-200);
    overflow: hidden;
    height: 100%;
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    box-shadow: var(--shadow-lg);
}

.card-header-modern {
    background: linear-gradient(135deg, var(--admin-gray-50), white);
    border-bottom: 1px solid var(--admin-gray-200);
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-dark));
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.header-text {
    flex: 1;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--admin-dark);
    margin: 0;
}

.card-subtitle {
    color: var(--admin-gray-500);
    margin: 0;
    font-size: 0.9rem;
}

.header-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(239, 68, 68, 0.1);
    color: var(--admin-danger);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
}

.badge-count {
    background: var(--admin-danger);
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
}

.header-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-refresh, .btn-filter {
    width: 40px;
    height: 40px;
    border: 1px solid var(--admin-gray-300);
    background: white;
    border-radius: var(--radius);
    color: var(--admin-gray-500);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-refresh:hover, .btn-filter:hover {
    background: var(--admin-primary);
    color: white;
    border-color: var(--admin-primary);
}

.card-body {
    padding: 1.5rem;
}

/* Enhanced Quick Actions */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1rem;
}

.quick-action-modern {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--admin-gray-50);
    border-radius: var(--radius);
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    border: 1px solid transparent;
    position: relative;
}

.quick-action-modern:hover {
    background: white;
    border-color: var(--admin-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
    color: inherit;
}

.quick-action-modern.highlight {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.05), rgba(245, 158, 11, 0.02));
    border-color: rgba(245, 158, 11, 0.2);
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.action-icon.primary { background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-dark)); }
.action-icon.success { background: linear-gradient(135deg, var(--admin-success), #059669); }
.action-icon.warning { background: linear-gradient(135deg, var(--admin-warning), #d97706); }
.action-icon.danger { background: linear-gradient(135deg, var(--admin-danger), #dc2626); }
.action-icon.purple { background: linear-gradient(135deg, var(--admin-purple), #7c3aed); }
.action-icon.info { background: linear-gradient(135deg, var(--admin-info), #0891b2); }

.action-content {
    flex: 1;
}

.action-content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--admin-dark);
    margin: 0 0 0.25rem 0;
}

.action-content p {
    font-size: 0.875rem;
    color: var(--admin-gray-500);
    margin: 0;
}

.action-badge {
    display: flex;
    gap: 0.5rem;
}

.badge-new {
    background: var(--admin-success);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-urgent {
    background: var(--admin-danger);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.action-arrow {
    color: var(--admin-gray-400);
    transition: all 0.3s ease;
}

.quick-action-modern:hover .action-arrow {
    color: var(--admin-primary);
    transform: translateX(3px);
}

/* Enhanced Quick Stats */
.enhanced-stats {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.enhanced-stat-item.featured {
    background: linear-gradient(135deg, var(--admin-gray-50), white);
    border: 1px solid var(--admin-gray-200);
    border-radius: var(--radius);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.stat-visual {
    flex-shrink: 0;
}

.stat-chart {
    display: flex;
    align-items: end;
    gap: 4px;
    height: 40px;
}

.chart-bar {
    width: 8px;
    background: linear-gradient(to top, var(--admin-primary), var(--admin-primary-light));
    border-radius: 2px;
    animation: chartGrow 1s ease-out;
}

@keyframes chartGrow {
    from { height: 0%; }
}

.stat-content .stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--admin-dark);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-content .stat-label {
    color: var(--admin-gray-500);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.stat-change {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
}

.stat-change.positive {
    color: var(--admin-success);
}

.stats-grid-mini {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.mini-stat {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--admin-gray-50);
    border-radius: var(--radius);
    border: 1px solid var(--admin-gray-200);
}

.mini-stat-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
}

.mini-stat-icon.primary { background: var(--admin-primary); }
.mini-stat-icon.success { background: var(--admin-success); }
.mini-stat-icon.warning { background: var(--admin-warning); }
.mini-stat-icon.danger { background: var(--admin-danger); }

.mini-stat-content .value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--admin-dark);
    line-height: 1;
}

.mini-stat-content .label {
    font-size: 0.75rem;
    color: var(--admin-gray-500);
    margin-top: 0.25rem;
}

/* Performance Summary */
.performance-summary {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.performance-metric {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.metric-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.metric-label {
    color: var(--admin-gray-600);
    font-size: 0.9rem;
    font-weight: 500;
}

.metric-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--admin-dark);
}

.metric-progress {
    width: 100%;
}

.progress-track {
    height: 6px;
    background: var(--admin-gray-200);
    border-radius: 3px;
    overflow: hidden;
}

.progress-value {
    height: 100%;
    background: linear-gradient(90deg, var(--admin-success), #22c55e);
    border-radius: 3px;
    transition: width 0.3s ease;
}

.performance-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--admin-gray-200);
}

.performance-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(16, 185, 129, 0.1);
    color: var(--admin-success);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
}

.performance-tip {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--admin-gray-500);
    font-size: 0.875rem;
}

/* Enhanced Activity Timeline */
.activity-timeline-modern {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item-modern {
    display: flex;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--admin-gray-50);
    border-radius: var(--radius);
    transition: all 0.3s ease;
    position: relative;
    border: 1px solid transparent;
}

.activity-item-modern:hover {
    background: white;
    box-shadow: var(--shadow);
    border-color: var(--admin-gray-200);
}

.activity-indicator {
    width: 4px;
    border-radius: 2px;
    flex-shrink: 0;
}

.indicator-primary { background: var(--admin-primary); }
.indicator-success { background: var(--admin-success); }
.indicator-warning { background: var(--admin-warning); }
.indicator-danger { background: var(--admin-danger); }
.indicator-info { background: var(--admin-info); }
.indicator-secondary { background: var(--admin-gray-400); }

.activity-content {
    flex: 1;
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.75rem;
    gap: 1rem;
}

.activity-user {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
}

.user-info {
    display: flex;
    flex-direction: column;
}

.activity-title {
    font-weight: 600;
    color: var(--admin-dark);
    margin: 0;
    font-size: 0.95rem;
    line-height: 1.4;
}

.activity-item {
    color: var(--admin-gray-500);
    font-size: 0.875rem;
}

.activity-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}

.badge-primary { background: rgba(79, 70, 229, 0.1); color: var(--admin-primary); }
.badge-success { background: rgba(16, 185, 129, 0.1); color: var(--admin-success); }
.badge-warning { background: rgba(245, 158, 11, 0.1); color: var(--admin-warning); }
.badge-danger { background: rgba(239, 68, 68, 0.1); color: var(--admin-danger); }
.badge-info { background: rgba(6, 182, 212, 0.1); color: var(--admin-info); }
.badge-secondary { background: rgba(100, 116, 139, 0.1); color: var(--admin-gray-500); }

.activity-badge i {
    font-size: 0.5rem;
}

.activity-desc {
    color: var(--admin-gray-600);
    font-size: 0.875rem;
    margin-bottom: 0.75rem;
    line-height: 1.5;
}

.activity-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--admin-gray-500);
    font-size: 0.8rem;
}

.meta-item i {
    font-size: 0.7rem;
}

.activity-actions {
    display: flex;
    gap: 0.5rem;
    align-items: flex-start;
}

.btn-action {
    width: 32px;
    height: 32px;
    border: 1px solid var(--admin-gray-300);
    background: white;
    border-radius: var(--radius);
    color: var(--admin-gray-500);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.btn-action:hover {
    background: var(--admin-primary);
    color: white;
    border-color: var(--admin-primary);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--admin-gray-400);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h4 {
    color: var(--admin-gray-500);
    margin-bottom: 0.5rem;
}

.empty-state p {
    margin: 0;
    font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .quick-actions-grid {
        grid-template-columns: 1fr 1fr;
    }

    .stats-grid-mini {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .dashboard-header {
        padding: 1rem 0;
    }

    .welcome-title {
        font-size: 2rem;
    }

    .welcome-meta {
        flex-direction: column;
        gap: 1rem;
    }

    .stat-card-modern {
        padding: 1.25rem;
    }

    .stat-value {
        font-size: 2rem;
    }

    .quick-actions-grid {
        grid-template-columns: 1fr;
    }

    .activity-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .card-header-modern {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .header-content {
        width: 100%;
    }

    .header-actions {
        width: 100%;
        justify-content: flex-end;
    }

    .enhanced-stat-item.featured {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .performance-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}

@media (max-width: 576px) {
    .welcome-title {
        font-size: 1.75rem;
    }

    .stat-header {
        flex-direction: column;
        gap: 1rem;
    }

    .stat-trend {
        align-self: flex-end;
    }

    .activity-meta {
        flex-direction: column;
        gap: 0.5rem;
    }

    .quick-action-modern {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }

    .action-content {
        text-align: center;
    }

    .activity-user {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .user-info {
        align-items: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live Clock Update
    function updateLiveClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        const clockElement = document.getElementById('liveClock');
        if (clockElement) {
            clockElement.textContent = timeString;
        }
    }

    // Update clock every second
    setInterval(updateLiveClock, 1000);
    updateLiveClock(); // Initial call

    // Refresh button functionality
    const refreshBtn = document.querySelector('.btn-refresh');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            icon.style.animation = 'spin 1s linear infinite';

            setTimeout(() => {
                icon.style.animation = '';
                // Add your refresh logic here
                location.reload();
            }, 1000);
        });
    }

    // Filter button functionality
    const filterBtn = document.querySelector('.btn-filter');
    if (filterBtn) {
        filterBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            // Add filter functionality here
            console.log('Filter button clicked');
        });
    }

    // Add spin animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .btn-filter.active {
            background: var(--admin-primary) !important;
            color: white !important;
            border-color: var(--admin-primary) !important;
        }
    `;
    document.head.appendChild(style);

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe stat cards and other elements
    document.querySelectorAll('.stat-card-modern, .dashboard-card').forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'all 0.6s ease';
        observer.observe(element);
    });

    // Enhanced hover effects
    const quickActions = document.querySelectorAll('.quick-action-modern');
    quickActions.forEach(action => {
        action.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.02)';
        });

        action.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add loading animation to cards
    const cards = document.querySelectorAll('.dashboard-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in-up');
    });

    // Add fade-in-up animation
    const fadeStyle = document.createElement('style');
    fadeStyle.textContent = `
        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
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
    `;
    document.head.appendChild(fadeStyle);

    // Chart bar animations
    const chartBars = document.querySelectorAll('.chart-bar');
    chartBars.forEach((bar, index) => {
        bar.style.animationDelay = `${index * 0.1}s`;
    });

    // Progress bar animations
    const progressBars = document.querySelectorAll('.progress-value, .progress-fill');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 500);
    });
});
</script>
@endpush
