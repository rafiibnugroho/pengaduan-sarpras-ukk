@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')
@section('content')
<div class="dashboard-admin">
    <!-- Welcome Header -->
    <div class="dashboard-header mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="welcome-content">
                    <div class="welcome-badge">
                        <i class="fas fa-star me-2"></i>Admin Dashboard
                    </div>
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

        </div>
    </div>

    <!-- Main Statistics Grid -->
    <div class="stats-grid-modern mb-5">
        <div class="row g-4">
            @php
                $cards = [
                    [
                        'icon' => 'fa-users',
                        'title' => 'Total Pengguna',
                        'value' => \App\Models\User::count(),
                        'color' => 'primary',
                        'description' => 'Pengguna aktif'
                    ],
                    [
                        'icon' => 'fa-box',
                        'title' => 'Total Item',
                        'value' => \App\Models\Item::count(),
                        'color' => 'success',
                        'description' => 'Item terdaftar'
                    ],
                    [
                        'icon' => 'fa-exclamation-triangle',
                        'title' => 'Total Pengaduan',
                        'value' => \App\Models\Pengaduan::count(),
                        'color' => 'warning',
                        'description' => 'Pengaduan bulan ini'
                    ],
                    [
                        'icon' => 'fa-map-marker-alt',
                        'title' => 'Total Lokasi',
                        'value' => \App\Models\Lokasi::count(),
                        'color' => 'info',
                        'description' => 'Lokasi terdaftar'
                    ],
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
                            </div>
                            <div class="stat-body">
                                <div class="stat-value">{{ $card['value'] }}</div>
                                <div class="stat-title">{{ $card['title'] }}</div>
                                <div class="stat-description">{{ $card['description'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Quick Actions Section - Lebih Simpel & Elegan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
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
                </div>
                <div class="card-body">
                    <div class="quick-actions-simple">
                        <a href="{{ route('admin.users.create') }}" class="quick-action-simple">
                            <div class="action-icon-simple bg-primary">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <span class="action-text">Tambah User</span>
                        </a>

                        <a href="{{ route('admin.lokasi.create') }}" class="quick-action-simple">
                            <div class="action-icon-simple bg-success">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span class="action-text">Tambah Lokasi</span>
                        </a>

                        <a href="{{ route('admin.items.create') }}" class="quick-action-simple">
                            <div class="action-icon-simple bg-warning">
                                <i class="fas fa-box"></i>
                            </div>
                            <span class="action-text">Tambah Item</span>
                        </a>

                        <a href="{{ route('admin.pengaduan.index') }}" class="quick-action-simple">
                            <div class="action-icon-simple bg-danger">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <span class="action-text">Kelola Pengaduan</span>
                        </a>

                        <a href="{{ route('admin.laporan.index') }}" class="quick-action-simple">
                           <div class="action-icon-simple" style="background-color: #6f42c1;">
                                        <i class="fa-solid fa-chart-bar text-white"></i>
                           </div>
                           <span class="action-text">Analisis Laporan</span>
                       </a>
                   </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Recent Activities Section -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
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
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn-view-all">
                        Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="modern-activity-container">
                        @forelse($pengaduan->take(8) as $p)
                        <div class="activity-item-modern">
                            <div class="activity-avatar">
                                <div class="avatar-circle">
                                    {{ substr($p->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="activity-indicator status-{{ strtolower($p->status) }}"></div>
                            </div>

                            <div class="activity-content">
                                <div class="activity-header">
                                    <h6 class="activity-title">{{ Str::limit($p->nama_pengaduan, 50) }}</h6>
                                    <span class="activity-time">{{ $p->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="activity-details">
                                    <div class="detail-item">
                                        <i class="fas fa-user detail-icon"></i>
                                        <span class="detail-text">{{ $p->user->name ?? 'Pengguna' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-map-marker-alt detail-icon"></i>
                                        <span class="detail-text">{{ $p->lokasi->nama_lokasi ?? 'N/A' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-box detail-icon"></i>
                                        <span class="detail-text">{{ $p->item->nama_item ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <div class="activity-footer">
                                    <div class="status-badge-modern status-{{ strtolower($p->status) }}">
                                        <i class="status-icon
                                            @if($p->status == 'Selesai') fas fa-check-circle
                                            @elseif($p->status == 'Diproses') fas fa-cogs
                                            @elseif($p->status == 'Ditolak') fas fa-times-circle
                                            @else fas fa-clock @endif me-1">
                                        </i>
                                        {{ $p->status }}
                                    </div>

                                    <div class="activity-actions">
                                        <a href="{{ route('admin.pengaduan.show', $p->id_pengaduan) }}"
                                           class="btn-action-modern btn-view-modern"
                                           title="Lihat Detail"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.pengaduan.edit', $p->id_pengaduan) }}"
                                           class="btn-action-modern btn-edit-modern"
                                           title="Edit Pengaduan"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="empty-activity-state">
                            <div class="empty-icon">
                                <i class="fas fa-inbox fa-3x"></i>
                            </div>
                            <h4 class="empty-title">Belum Ada Aktivitas</h4>
                            <p class="empty-description">Sistem akan menampilkan aktivitas terbaru di sini</p>
                            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-primary rounded-pill px-4 py-2">
                                <i class="fas fa-plus me-2"></i>Kelola Pengaduan
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Design System */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --purple-gradient: linear-gradient(135deg, #a8c0ff 0%, #3f2b96 100%);

    --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.08);
    --shadow-md: 0 8px 25px rgba(0, 0, 0, 0.12);
    --shadow-lg: 0 15px 35px rgba(0, 0, 0, 0.15);
    --radius-sm: 12px;
    --radius-md: 16px;
    --radius-lg: 20px;
}

.dashboard-admin {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #e9ecef 100%);
}

/* Enhanced Welcome Header */
.dashboard-header {
    padding: 2rem 0;
}

.welcome-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
    border: 1px solid rgba(102, 126, 234, 0.2);
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #2d3748;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.gradient-text {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.welcome-subtitle {
    font-size: 1.2rem;
    color: #718096;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.welcome-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    background: white;
    padding: 0.75rem 1.25rem;
    border-radius: var(--radius-sm);
    box-shadow: var(--shadow-sm);
    border: 1px solid #e2e8f0;
    color: #4a5568;
    font-weight: 500;
    transition: all 0.3s ease;
}

.meta-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.meta-item i {
    color: #667eea;
    margin-right: 0.5rem;
}

/* Performance Overview */
.performance-overview {
    background: white;
    border-radius: var(--radius-md);
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
    border: 1px solid #e2e8f0;
    height: 100%;
}

.performance-item {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.performance-icon {
    width: 70px;
    height: 70px;
    background: var(--primary-gradient);
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.75rem;
    box-shadow: var(--shadow-sm);
}

.performance-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: #2d3748;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.performance-label {
    color: #718096;
    font-size: 0.9rem;
}

/* Modern Stat Cards */
.stats-grid-modern {
    margin-bottom: 2rem;
}

.stat-card-modern {
    background: white;
    border-radius: var(--radius-md);
    padding: 1.5rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.stat-content {
    text-align: center;
}

.stat-header {
    margin-bottom: 1.5rem;
}

.stat-icon-wrapper {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    margin: 0 auto;
    box-shadow: var(--shadow-sm);
}

.stat-icon-wrapper.primary { background: var(--primary-gradient); }
.stat-icon-wrapper.success { background: var(--success-gradient); }
.stat-icon-wrapper.warning { background: var(--warning-gradient); }
.stat-icon-wrapper.info { background: var(--info-gradient); }

.stat-body {
    margin-bottom: 1rem;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: #2d3748;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.stat-description {
    color: #718096;
    font-size: 0.875rem;
}

/* Dashboard Cards */
.dashboard-card {
    background: white;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-md);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    margin-bottom: 2rem;
}

.card-header-modern {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
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
    background: var(--primary-gradient);
    border-radius: var(--radius-sm);
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
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.card-subtitle {
    color: #718096;
    margin: 0;
    font-size: 0.9rem;
}

.btn-view-all {
    display: inline-flex;
    align-items: center;
    background: var(--primary-gradient);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: var(--radius-sm);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.btn-view-all:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: white;
    text-decoration: none;
}

.card-body {
    padding: 1.5rem;
}

/* Quick Actions - Simple & Elegant */
.quick-actions-simple {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.quick-action-simple {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 1rem;
    background: #f8fafc;
    border-radius: var(--radius-sm);
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.quick-action-simple:hover {
    background: white;
    border-color: #667eea;
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    color: inherit;
    text-decoration: none;
}

.action-icon-simple {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: var(--shadow-sm);
}

.action-text {
    font-weight: 600;
    color: #2d3748;
    text-align: center;
    font-size: 0.9rem;
}

/* Modern Activity Container */
.modern-activity-container {
    padding: 0;
}

.activity-item-modern {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.3s ease;
    position: relative;
}

.activity-item-modern:last-child {
    border-bottom: none;
}

.activity-item-modern:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
    transform: translateX(4px);
}

.activity-avatar {
    position: relative;
    flex-shrink: 0;
}

.avatar-circle {
    width: 50px;
    height: 50px;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    box-shadow: var(--shadow-sm);
}

.activity-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.activity-indicator.status-selesai { background: #10B981; }
.activity-indicator.status-diproses { background: #F59E0B; }
.activity-indicator.status-diajukan { background: #3B82F6; }
.activity-indicator.status-ditolak { background: #EF4444; }

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.75rem;
}

.activity-title {
    font-weight: 600;
    color: #2d3748;
    margin: 0;
    line-height: 1.4;
    flex: 1;
    margin-right: 1rem;
}

.activity-time {
    font-size: 0.875rem;
    color: #718096;
    white-space: nowrap;
}

.activity-details {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-icon {
    width: 16px;
    color: #667eea;
    font-size: 0.875rem;
}

.detail-text {
    font-size: 0.875rem;
    color: #718096;
}

.activity-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.status-badge-modern {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge-modern.status-selesai {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.status-badge-modern.status-diproses {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.status-badge-modern.status-diajukan {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.status-badge-modern.status-ditolak {
    background: rgba(239, 68, 68, 0.1);
    color: #EF4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.activity-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-action-modern {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}

.btn-view-modern {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.btn-edit-modern {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.btn-action-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.btn-view-modern:hover {
    background: #3B82F6;
    color: white;
}

.btn-edit-modern:hover {
    background: #F59E0B;
    color: white;
}

/* Empty State */
.empty-activity-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(102, 126, 234, 0.05));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: #667eea;
}

.empty-title {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
    font-size: 1.25rem;
}

.empty-description {
    color: #718096;
    margin-bottom: 1.5rem;
}

/* Animations */
.activity-item-modern {
    animation: slideInUp 0.6s ease;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .quick-actions-simple {
        grid-template-columns: repeat(3, 1fr);
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
        gap: 0.5rem;
    }

    .performance-item {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .quick-actions-simple {
        grid-template-columns: repeat(2, 1fr);
    }

    .card-header-modern {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .btn-view-all {
        align-self: flex-start;
    }

    .activity-details {
        flex-direction: column;
        gap: 0.75rem;
    }

    .activity-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .activity-actions {
        align-self: flex-end;
    }
}

@media (max-width: 576px) {
    .welcome-title {
        font-size: 1.75rem;
    }

    .stat-card-modern {
        padding: 1.25rem;
    }

    .stat-value {
        font-size: 2rem;
    }

    .quick-actions-simple {
        grid-template-columns: 1fr;
    }

    .action-icon-simple {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .activity-item-modern {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .activity-header {
        flex-direction: column;
        gap: 0.5rem;
    }

    .activity-title {
        margin-right: 0;
        text-align: center;
    }

    .activity-footer {
        align-items: center;
    }

    .activity-actions {
        align-self: center;
    }
}
</style>

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

    // Simple hover animations
    const statCards = document.querySelectorAll('.stat-card-modern');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Quick action hover effects
    const quickActions = document.querySelectorAll('.quick-action-simple');
    quickActions.forEach(action => {
        action.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });

        action.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Activity item animations
    const activityItems = document.querySelectorAll('.activity-item-modern');
    activityItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;

        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px)';
        });

        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(4px)';
        });
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
@endsection
