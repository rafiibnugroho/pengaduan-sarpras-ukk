@extends('layouts.user')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="container-fluid py-4">
    <!-- Modern Welcome Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="modern-welcome-card rounded-4 p-5 position-relative overflow-hidden">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-start">
                           
                            <div class="flex-grow-1">
                                <h1 class="display-6 fw-bold text-dark mb-2">
                                    Selamat Datang, <span class="text-primary">{{ Auth::user()->name }}</span>
                                </h1>
                                <p class="lead text-muted mb-4">
                                    Sistem Pengaduan Sarana & Prasarana SMKN 1 BANTUL.
                                    Laporkan masalah infrastruktur dengan mudah dan pantau progress secara real-time.
                                </p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ route('pengaduan.create') }}"
                                       class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                                        <i class="fas fa-plus-circle me-2"></i>
                                        Buat Laporan Baru
                                    </a>
                                    <a href="{{ route('pengaduan.index') }}"
                                       class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold">
                                        <i class="fas fa-history me-2"></i>
                                        Lihat Riwayat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block">
                        <div class="text-center">
                            <div class="floating-graphic">
                                <i class="fas fa-clipboard-check fa-5x text-primary opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="welcome-decoration">
                    <div class="decoration-shape shape-1"></div>
                    <div class="decoration-shape shape-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Minimal Statistics Cards -->
    <div class="row mb-4">
        @php
            $statsData = [
                ['label' => 'Selesai', 'value' => $stats['selesai'] ?? 0, 'icon' => 'fas fa-check-circle', 'color' => 'success', 'progress' => ($stats['selesai'] ?? 0) / max(($stats['total'] ?? 1), 1) * 100],
                ['label' => 'Diproses', 'value' => $stats['proses'] ?? 0, 'icon' => 'fas fa-cogs', 'color' => 'warning', 'progress' => ($stats['proses'] ?? 0) / max(($stats['total'] ?? 1), 1) * 100],
                ['label' => 'Diajukan', 'value' => $stats['diajukan'] ?? 0, 'icon' => 'fas fa-clock', 'color' => 'primary', 'progress' => ($stats['diajukan'] ?? 0) / max(($stats['total'] ?? 1), 1) * 100],
                ['label' => 'Total', 'value' => $stats['total'] ?? 0, 'icon' => 'fas fa-file-alt', 'color' => 'dark', 'progress' => 100],
            ];
        @endphp

        @foreach($statsData as $stat)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card-modern bg-white border-0 rounded-3 p-4 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center mb-3">
                    <div class="stat-icon-modern bg-{{ $stat['color'] }}-subtle rounded-3 p-3 me-3">
                        <i class="{{ $stat['icon'] }} fs-4 text-{{ $stat['color'] }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="fw-bold mb-1 display-6">{{ $stat['value'] }}</h3>
                        <p class="text-muted mb-0 fw-semibold">{{ $stat['label'] }}</p>
                    </div>
                </div>
                <div class="stat-progress-modern mb-2">
                    <div class="progress-bar-modern bg-{{ $stat['color'] }}" style="width: {{ $stat['progress'] }}%"></div>
                </div>
                <small class="text-muted">{{ $stat['progress'] }}% dari total</small>
                <div class="stat-decoration bg-{{ $stat['color'] }}-subtle"></div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Content Area -->
    <div class="row">
        <!-- Recent Reports - Modern Table -->
        <div class="col-lg-8 mb-4">
            <div class="card modern-card border-0 rounded-4">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pb-3">
                    <div>
                        <h5 class="card-title fw-bold mb-1 fs-5">
                            <i class="fas fa-history text-primary me-2"></i>
                            Laporan Terbaru
                        </h5>
                        <p class="text-muted mb-0">Pantau status laporan Anda terkini</p>
                    </div>
                    <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-primary rounded-pill px-3 py-2">
                        Lihat Semua
                        <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="modern-table-container">
                        <table class="table modern-table mb-0">
                            <thead class="modern-table-header">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Pengaduan</th>
                                    <th>Lokasi</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="modern-table-body">
                                @forelse($recentReports as $report)
                                <tr class="modern-table-row">
                                    <td class="ps-4">
                                        <div class="id-badge-modern">
                                            <span class="id-prefix">#</span>
                                            <span class="id-number">{{ str_pad($report->id_pengaduan, 4, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="complaint-info-modern">
                                            <div class="complaint-title-modern fw-semibold">{{ Str::limit($report->nama_pengaduan, 40) }}</div>
                                            <div class="complaint-desc-modern text-muted small">{{ Str::limit($report->deskripsi, 60) }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="location-info-modern">
                                            <div class="location-text-modern small">
                                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                {{ Str::limit($report->lokasi->nama_lokasi ?? '-', 25) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="status-badge-modern status-{{ strtolower($report->status) }}">
                                            <i class="status-icon
                                                @if($report->status == 'Selesai') fas fa-check-circle
                                                @elseif($report->status == 'Diproses') fas fa-cogs
                                                @elseif($report->status == 'Ditolak') fas fa-times-circle
                                                @else fas fa-clock @endif me-1">
                                            </i>
                                            {{ $report->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="date-info-modern">
                                            <div class="date-day fw-semibold">{{ $report->created_at->format('d M') }}</div>
                                            <div class="date-time text-muted small">{{ $report->created_at->format('H:i') }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="action-buttons-modern">
                                            <a href="{{ route('pengaduan.show', $report->id_pengaduan) }}"
                                               class="btn-action-view-modern"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state-modern">
                                            <div class="empty-icon-modern">
                                                <i class="fas fa-inbox fa-4x"></i>
                                            </div>
                                            <h4 class="empty-title-modern">Belum ada laporan</h4>
                                            <p class="empty-description-modern">Buat laporan pertama Anda untuk memulai</p>
                                            <a href="{{ route('pengaduan.create') }}" class="btn btn-primary rounded-pill px-4 py-2">
                                                <i class="fas fa-plus me-2"></i>Buat Laporan
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Quick Actions -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card modern-card border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="quick-action-icon bg-primary bg-opacity-10 rounded-3 p-2 me-3">
                            <i class="fas fa-bolt text-primary"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Akses Cepat</h6>
                            <p class="text-muted mb-0 small">Fitur utama yang sering digunakan</p>
                        </div>
                    </div>

                    <div class="quick-actions-list">
                        <a href="{{ route('pengaduan.create') }}" class="quick-action-item">
                            <div class="action-icon bg-success bg-opacity-10 rounded-2 p-2">
                                <i class="fas fa-plus-circle text-success"></i>
                            </div>
                            <div class="action-content">
                                <div class="action-title fw-semibold">Buat Laporan Baru</div>
                                <div class="action-desc text-muted small">Laporkan masalah infrastruktur</div>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>

                        <a href="{{ route('pengaduan.index') }}" class="quick-action-item">
                            <div class="action-icon bg-primary bg-opacity-10 rounded-2 p-2">
                                <i class="fas fa-file-alt text-primary"></i>
                            </div>
                            <div class="action-content">
                                <div class="action-title fw-semibold">Riwayat Laporan</div>
                                <div class="action-desc text-muted small">Lihat semua laporan Anda</div>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>

                        <a href="{{ route('profile.index') }}" class="quick-action-item">
                            <div class="action-icon bg-info bg-opacity-10 rounded-2 p-2">
                                <i class="fas fa-user-cog text-info"></i>
                            </div>
                            <div class="action-content">
                                <div class="action-title fw-semibold">Profile</div>
                                <div class="action-desc text-muted small">Atur akun Anda</div>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips Section - Modern -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card modern-card border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h5 class="fw-bold mb-4 text-dark">
                                <i class="fas fa-lightbulb text-warning me-2"></i>
                                Tips Untuk Anda
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="tips-icon bg-success bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="fas fa-camera text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2">Foto yang Jelas</h6>
                                            <p class="text-muted small mb-0">Pastikan foto menunjukkan kerusakan dengan jelas dan terang</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="tips-icon bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2">Lokasi Spesifik</h6>
                                            <p class="text-muted small mb-0">Tentukan lokasi kerusakan dengan tepat</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="tips-icon bg-info bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="fas fa-file-alt text-info"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2">Deskripsi Detail</h6>
                                            <p class="text-muted small mb-0">Jelaskan kronologi dan dampak kerusakan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="tips-icon bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="fas fa-sync-alt text-warning"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-2">Pantau Berkala</h6>
                                            <p class="text-muted small mb-0">Cek status laporan secara rutin</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <div class="operational-info">
                                <div class="operational-icon bg-primary bg-opacity-10 rounded-3 p-3 d-inline-block mb-3">
                                    <i class="fas fa-clock fa-2x text-primary"></i>
                                </div>
                                <h6 class="fw-semibold mb-2">Waktu Operasional</h6>
                                <p class="text-muted small mb-3">Tim kami siap membantu Anda</p>
                                <div class="operational-time bg-light rounded-3 p-3">
                                    <div class="fw-semibold text-primary">Senin - Jumat</div>
                                    <div class="text-muted small">08:00 - 16:00 WIB</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Variables */
:root {
    --primary-color: #3B82F6;
    --success-color: #10B981;
    --warning-color: #F59E0B;
    --danger-color: #EF4444;
    --dark-color: #374151;
    --border-radius: 12px;
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
    --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.12);
    --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.15);
}

/* Modern Welcome Card */
.modern-welcome-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
}

.welcome-avatar {
    transition: all 0.3s ease;
}

.modern-welcome-card:hover .welcome-avatar {
    transform: scale(1.1) rotate(5deg);
}

.welcome-decoration {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.decoration-shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(59, 130, 246, 0.05);
}

.shape-1 {
    width: 120px;
    height: 120px;
    top: -40px;
    right: -40px;
}

.shape-2 {
    width: 80px;
    height: 80px;
    top: 50%;
    right: 20%;
}

.floating-graphic {
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* Modern Cards */
.modern-card {
    background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: var(--shadow-sm);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.modern-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

/* Modern Stat Cards */
.stat-card-modern {
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.stat-icon-modern {
    transition: all 0.3s ease;
}

.stat-card-modern:hover .stat-icon-modern {
    transform: scale(1.1);
}

.stat-progress-modern {
    height: 6px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 3px;
    overflow: hidden;
}

.progress-bar-modern {
    height: 100%;
    border-radius: 3px;
    transition: width 0.6s ease;
}

.stat-decoration {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    opacity: 0.1;
}

/* Modern Table */
.modern-table-container {
    overflow: hidden;
    border-radius: var(--border-radius);
}

.modern-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.modern-table-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.modern-table-header th {
    border: none;
    padding: 1.25rem 0.75rem;
    font-weight: 700;
    font-size: 0.875rem;
    color: var(--dark-color);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid rgba(0, 0, 0, 0.1);
}

.modern-table-body td {
    border: none;
    padding: 1.25rem 0.75rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.modern-table-row {
    transition: all 0.3s ease;
    background: white;
}

.modern-table-row:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
    transform: translateX(4px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Table Elements */
.id-badge-modern {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-family: 'Courier New', monospace;
    font-weight: 700;
}

.id-prefix {
    color: #6B7280;
    font-weight: 600;
}

.id-number {
    color: var(--dark-color);
}

.complaint-info-modern {
    min-width: 0;
    max-width: 280px;
}

.complaint-title-modern {
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    color: var(--dark-color);
    line-height: 1.4;
}

.complaint-desc-modern {
    font-size: 0.8rem;
    line-height: 1.4;
}

.location-info-modern {
    min-width: 0;
}

.location-text-modern {
    font-size: 0.8rem;
    color: #6B7280;
}

.date-info-modern {
    text-align: center;
}

.date-day {
    font-size: 0.9rem;
    color: var(--dark-color);
}

.date-time {
    font-size: 0.75rem;
}

/* Status Badges */
.status-badge-modern {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    min-width: 100px;
    justify-content: center;
}

.status-selesai {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.status-diproses {
    background: rgba(245, 158, 11, 0.1);
    color: #D97706;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.status-diajukan {
    background: rgba(59, 130, 246, 0.1);
    color: #2563EB;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.status-ditolak {
    background: rgba(239, 68, 68, 0.1);
    color: #DC2626;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

/* Action Buttons */
.action-buttons-modern {
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-action-view-modern {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 8px;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-action-view-modern:hover {
    background: #3B82F6;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

/* Quick Actions */
.quick-actions-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.quick-action-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    text-decoration: none;
    color: inherit;
    border-radius: var(--border-radius);
    border: 1px solid transparent;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.5);
}

.quick-action-item:hover {
    background: rgba(255, 255, 255, 0.8);
    border-color: rgba(59, 130, 246, 0.2);
    transform: translateX(5px);
    text-decoration: none;
    color: inherit;
}

.action-icon {
    transition: all 0.3s ease;
}

.quick-action-item:hover .action-icon {
    transform: scale(1.1);
}

.action-content {
    flex: 1;
    margin: 0 1rem;
}

.action-title {
    font-size: 0.9rem;
    margin-bottom: 0.125rem;
}

.action-desc {
    font-size: 0.75rem;
}

.action-arrow {
    opacity: 0;
    transform: translateX(-5px);
    transition: all 0.3s ease;
}

.quick-action-item:hover .action-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Empty State */
.empty-state-modern {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-icon-modern {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: #3B82F6;
}

.empty-title-modern {
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
    font-size: 1.25rem;
}

.empty-description-modern {
    color: #6B7280;
    margin-bottom: 1.5rem;
}

/* Tips Section */
.tips-icon {
    transition: all 0.3s ease;
}

.d-flex:hover .tips-icon {
    transform: scale(1.1) rotate(5deg);
}

.operational-info {
    padding: 1rem;
}

.operational-time {
    border: 1px solid rgba(0, 0, 0, 0.05);
}

/* Background Colors */
.bg-primary-subtle { background-color: rgba(59, 130, 246, 0.1) !important; }
.bg-success-subtle { background-color: rgba(16, 185, 129, 0.1) !important; }
.bg-warning-subtle { background-color: rgba(245, 158, 11, 0.1) !important; }
.bg-info-subtle { background-color: rgba(33, 150, 243, 0.1) !important; }
.bg-dark-subtle { background-color: rgba(55, 65, 81, 0.1) !important; }

/* Responsive Design */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }

    .modern-welcome-card {
        padding: 2rem 1.5rem;
        text-align: center;
    }

    .modern-welcome-card .d-flex {
        flex-direction: column;
    }

    .welcome-avatar {
        margin: 0 auto 1rem;
    }

    .modern-table-header {
        display: none;
    }

    .modern-table-row {
        display: block;
        margin-bottom: 1rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
    }

    .modern-table-row td {
        display: block;
        text-align: left;
        border: none;
        padding: 0.75rem 1rem;
        position: relative;
    }

    .modern-table-row td::before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--dark-color);
        margin-right: 0.5rem;
        text-transform: uppercase;
        font-size: 0.75rem;
    }

    .action-buttons-modern {
        justify-content: flex-start;
    }

    .card-header .d-flex {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    /* Responsive data labels */
    .modern-table-row td:nth-child(1)::before { content: "ID: "; }
    .modern-table-row td:nth-child(2)::before { content: "Pengaduan: "; }
    .modern-table-row td:nth-child(3)::before { content: "Lokasi: "; }
    .modern-table-row td:nth-child(4)::before { content: "Status: "; }
    .modern-table-row td:nth-child(5)::before { content: "Tanggal: "; }
    .modern-table-row td:nth-child(6)::before { content: "Aksi: "; }
}

@media (max-width: 576px) {
    .stat-card-modern {
        text-align: center;
    }

    .stat-card-modern .d-flex {
        flex-direction: column;
        text-align: center;
    }

    .stat-card-modern .me-3 {
        margin-right: 0 !important;
        margin-bottom: 1rem;
    }

    .quick-action-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .action-content {
        margin: 0.5rem 0;
    }

    .action-arrow {
        display: none;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress bars
    const progressBars = document.querySelectorAll('.progress-bar-modern');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
            bar.style.transition = 'width 1.5s cubic-bezier(0.4, 0, 0.2, 1)';
        }, 300);
    });

    // Add smooth animations to cards
    const cards = document.querySelectorAll('.modern-card, .stat-card-modern');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';

        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });

    // Table row animations
    const tableRows = document.querySelectorAll('.modern-table-row');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        row.style.transition = 'all 0.5s ease';

        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 100);
    });

    // Hover effects for stat cards
    const statCards = document.querySelectorAll('.stat-card-modern');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-5px)';
        });
    });

    // Auto-refresh stats (optional)
    setInterval(() => {
        // You can implement auto-refresh here if needed
    }, 30000);
});
</script>
@endpush

@endsection
