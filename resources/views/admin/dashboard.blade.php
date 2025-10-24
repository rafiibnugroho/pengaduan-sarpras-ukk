@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')
@section('content')
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="welcome-title">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}</h2>
                <p class="welcome-subtitle">Kelola sistem dengan mudah melalui dashboard yang telah disediakan</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="date-info">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid mb-5">
        <div class="row g-4">
            <!-- Total Pengguna -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-icon primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-card-title">Total Pengguna</div>
                    <div class="stat-card-value">{{ \App\Models\User::count() }}</div>
                    <div class="stat-card-change">
                    </div>
                </div>
            </div>

            <!-- Total Item -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-icon success">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-card-title">Total Item</div>
                    <div class="stat-card-value">{{ \App\Models\Item::count() }}</div>
                    <div class="stat-card-change">
                    </div>
                </div>
            </div>

            <!-- Total Pengaduan -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-icon warning">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-card-title">Total Pengaduan</div>
                    <div class="stat-card-value">{{ \App\Models\Pengaduan::count() }}</div>
                    <div class="stat-card-change">
                    </div>
                </div>
            </div>

            <!-- Pengaduan Aktif -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: #8b5cf6;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="stat-card-title">Total Lokasi</div>
                    <div class="stat-card-value">{{ \App\Models\Lokasi::count() }}</div>
                    <div class="stat-card-change">
                    </div>
                </div>
            </div>
        </div>
    </div>

   <div class="col-12">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 pb-0">
            <h5 class="card-title mb-3">
                <i class="fas fa-bolt text-primary me-2"></i>
                Aksi Cepat
            </h5>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-3">
                <!-- Tambah User -->
                <a href="{{ route('admin.users.create') }}" class="quick-action-card flex-fill">
                    <div class="quick-action-icon bg-primary">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="quick-action-text">
                        <div class="quick-action-title">Tambah User</div>
                        <div class="quick-action-desc">Daftarkan pengguna baru</div>
                    </div>
                </a>

                <!-- Tambah Lokasi -->
                <a href="{{ route('admin.lokasi.create') }}" class="quick-action-card flex-fill">
                    <div class="quick-action-icon bg-danger">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="quick-action-text">
                        <div class="quick-action-title">Tambah Lokasi</div>
                        <div class="quick-action-desc">Daftarkan lokasi baru</div>
                    </div>
                </a>

                <!-- Tambah Item -->
                <a href="{{ route('admin.items.create') }}" class="quick-action-card flex-fill">
                    <div class="quick-action-icon bg-success">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="quick-action-text">
                        <div class="quick-action-title">Tambah Item</div>
                        <div class="quick-action-desc">Input item baru</div>
                    </div>
                </a>

                <!-- Lihat Pengaduan -->
                <a href="{{ route('admin.pengaduan.index') }}" class="quick-action-card flex-fill">
                    <div class="quick-action-icon bg-warning text-dark">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="quick-action-text">
                        <div class="quick-action-title">Lihat Pengaduan</div>
                        <div class="quick-action-desc">Review pengaduan masuk</div>
                    </div>
                </a>

                <!-- Lihat Laporan -->
                <a href="{{ route('admin.laporan.index') }}" class="quick-action-card flex-fill">
                    <div class="quick-action-icon bg-purple text-white" style="background:#8b5cf6;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="quick-action-text">
                        <div class="quick-action-title">Lihat Laporan</div>
                        <div class="quick-action-desc">Analisa data sistem</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>


<style>
.quick-action-card {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #f9fafb;
    padding: 15px;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    height: 100%;
}
.quick-action-card:hover {
    background: #f0f4ff;
    transform: translateY(-4px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
}
.quick-action-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 20px;
}
.quick-action-text {
    flex: 1;
}
.quick-action-title {
    font-weight: 600;
    font-size: 14px;
}
.quick-action-desc {
    font-size: 12px;
    color: #6b7280;
}
</style>

  <!-- Recent Activities -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-gradient-primary text-white border-0 d-flex justify-content-between align-items-center py-3">
                <h5 class="card-title mb-0 d-flex align-items-center fw-bold">
                    <i class="fas fa-history me-2"></i>
                    Aktivitas Terbaru
                </h5>
            </div>
            <div class="card-body bg-light">
                <div class="activity-timeline">

                    @forelse($pengaduan as $p)
                        <div class="activity-item d-flex">
                            <div class="activity-icon
                                @if($p->status == 'Diajukan') bg-primary
                                @elseif($p->status == 'Disetujui') bg-success
                                @elseif($p->status == 'Ditolak') bg-danger
                                @elseif($p->status == 'Diproses') bg-warning
                                @elseif($p->status == 'Selesai') bg-info
                                @else bg-secondary @endif
                                text-white shadow">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="ms-3 p-3 bg-white rounded-3 shadow-sm flex-grow-1">
                                <div class="fw-semibold text-dark">
                                    {{ $p->user->name ?? 'Pengguna' }}
                                    <span class="text-muted"> • {{ $p->item->nama_item ?? 'Item' }}</span>
                                </div>
                                <div class="small mt-1">
                                    <span class="badge rounded-pill
                                        @if($p->status == 'Diajukan') bg-primary-subtle text-primary
                                        @elseif($p->status == 'Disetujui') bg-success-subtle text-success
                                        @elseif($p->status == 'Ditolak') bg-danger-subtle text-danger
                                        @elseif($p->status == 'Diproses') bg-warning-subtle text-warning
                                        @elseif($p->status == 'Selesai') bg-info-subtle text-info
                                        @else bg-secondary-subtle text-secondary @endif">
                                        {{ $p->status }}
                                    </span>
                                </div>
                                <div class="text-muted small mt-1">
                                    <i class="far fa-clock me-1"></i> {{ $p->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small">Belum ada aktivitas terbaru.</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .activity-timeline {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        position: relative;
        padding-left: 1.5rem;
    }

    .activity-item {
        position: relative;
        display: flex;
        align-items: flex-start;
    }

    .activity-item::before {
        content: '';
        position: absolute;
        left: 18px;
        top: 36px;
        width: 2px;
        height: calc(100% - 36px);
        background: #dee2e6;
    }

    .activity-item:last-child::before {
        display: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df, #224abe);
    }
.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
}

.welcome-section {
    padding: 0;
}

.welcome-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    color: var(--text-secondary);
    font-size: 1rem;
    margin-bottom: 0;
}

.date-info {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-weight: 500;
}

.stats-grid .stat-card {
    position: relative;
    overflow: hidden;
}

.stats-grid .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
}

.card {
    border-radius: 12px;
    border: 1px solid var(--medium-gray);
}

.card-header {
    padding: 1.5rem 1.5rem 0;
}

.card-body {
    padding: 1.5rem;
}

.quick-action-card {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: white;
    border: 1px solid var(--medium-gray);
    border-radius: 10px;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
    gap: 0.75rem;
}

.quick-action-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    color: inherit;
    border-color: var(--primary-color);
}

.quick-action-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.quick-action-text {
    flex: 1;
}

.quick-action-title {
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    color: var(--text-primary);
}

.quick-action-desc {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.system-status-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.system-status-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}

.status-indicator.status-online {
    background: var(--success-color);
}

.status-indicator.status-warning {
    background: var(--warning-color);
}

.status-indicator.status-offline {
    background: var(--danger-color);
}

.status-info {
    flex: 1;
}

.status-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.status-desc {
    font-size: 0.8rem;
    color: var(--text-secondary);
}

.status-value {
    font-weight: 600;
    font-size: 0.85rem;
}

.activity-timeline {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.activity-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.activity-desc {
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

.activity-time {
    font-size: 0.75rem;
    color: var(--text-secondary);
    font-weight: 500;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .welcome-section .row {
        text-align: center;
    }

    .welcome-section .col-md-4 {
        margin-top: 1rem;
    }

    .stats-grid .col-xl-3 {
        margin-bottom: 1rem;
    }

    .quick-action-card {
        padding: 0.75rem;
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .quick-action-text {
        text-align: center;
    }
}

@media (max-width: 576px) {
    .welcome-title {
        font-size: 1.5rem;
    }

    .stat-card-value {
        font-size: 1.75rem;
    }

    .card-body {
        padding: 1rem;
    }

    .quick-action-card .quick-action-icon {
        width: 32px;
        height: 32px;
    }

    .activity-icon {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
    }
}
</styl>
@endsection
