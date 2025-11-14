@extends('layouts.petugas')

@section('title', 'Dashboard Petugas - ' . config('app.name'))

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="welcome-card bg-gradient-primary text-white rounded-4 p-5 position-relative overflow-hidden">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="welcome-icon me-4">
                                <i class="fas fa-user-shield fa-3x opacity-75"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-2 display-6">Selamat datang, {{ Auth::user()->name }} 👋</h2>
                                <p class="mb-0 opacity-90 fs-5" id="liveDateTime"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-decoration">
                    <div class="decoration-circle circle-1"></div>
                    <div class="decoration-circle circle-2"></div>
                    <div class="decoration-circle circle-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Overview - DIREVISI: Hanya 3 statistik -->
    <div class="row mb-4">
        @php
            $statsData = [
                ['label' => 'Diproses', 'value' => $stats['proses'] ?? 0, 'icon' => 'fas fa-cogs', 'color' => 'info', 'progress' => 50, 'description' => 'Sedang dalam penanganan'],
                ['label' => 'Selesai', 'value' => $stats['selesai'] ?? 0, 'icon' => 'fas fa-check-circle', 'color' => 'success', 'progress' => 75, 'description' => 'Telah diselesaikan'],
                ['label' => 'Total', 'value' => $stats['total'] ?? 0, 'icon' => 'fas fa-clipboard-list', 'color' => 'primary', 'progress' => 100, 'description' => 'Total semua pengaduan'],
            ];
        @endphp

        @foreach($statsData as $stat)
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="stat-card-modern bg-{{ $stat['color'] }}-subtle border-0 rounded-4 p-4 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center mb-3">
                    <div class="stat-icon-modern bg-{{ $stat['color'] }} bg-opacity-10 rounded-3 p-3 me-3">
                        <i class="{{ $stat['icon'] }} fs-2 text-{{ $stat['color'] }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="fw-bold mb-1 display-6">{{ $stat['value'] }}</h3>
                        <p class="text-muted mb-0 fw-semibold fs-6">{{ $stat['label'] }}</p>
                    </div>
                </div>
                <div class="stat-progress-modern mb-2">
                    <div class="progress-bar-modern bg-{{ $stat['color'] }}" style="width: {{ $stat['progress'] }}%"></div>
                </div>
                <small class="text-muted">{{ $stat['description'] }}</small>
                <div class="stat-decoration"></div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Recent Activities - DIREVISI: Tabel modern dan elegant -->
    <div class="row">
        <div class="col-12">
            <div class="card modern-card border-0 rounded-4">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pb-3">
                    <div>
                        <h5 class="card-title fw-bold mb-1 fs-4">
                            <i class="fas fa-history text-primary me-2"></i>
                            Aktivitas Terkini
                        </h5>
                        <p class="text-muted mb-0">Daftar pengaduan terbaru yang perlu perhatian</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('petugas.pengaduan.index') }}" class="btn btn-primary rounded-pill px-4 py-2">
                            <i class="fas fa-list me-2"></i>Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="modern-table-container">
                        <table class="table modern-table mb-0">
                            <thead class="modern-table-header">
                                <tr>
                                    <th class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <span>Pengguna</span>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="d-flex align-items-center">
                                            <span>Pengaduan</span>
                                        </div>
                                    </th>
                                    <th>Lokasi</th>
                                    <th>Item</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="modern-table-body">
                                @forelse($recentActivities as $report)
                                <tr class="modern-table-row" data-status="{{ strtolower($report->status) }}">
                                    <td class="ps-4">
                                        <div class="user-info-modern">
                                            <div class="user-avatar-modern bg-primary bg-opacity-10 rounded-circle">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div class="user-details-modern">
                                                <div class="user-name-modern">{{ $report->user->name ?? 'Unknown' }}</div>
                                                <div class="user-email-modern text-muted">{{ $report->user->email ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="complaint-info">
                                            <div class="complaint-title fw-semibold">{{ Str::limit($report->nama_pengaduan, 50) }}</div>
                                            <div class="complaint-desc text-muted small">{{ Str::limit($report->deskripsi ?? 'Tidak ada deskripsi', 70) }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="location-info">
                                            <div class="location-text small">
                                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                {{ $report->lokasi->nama_lokasi ?? 'Lokasi tidak tersedia' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item-info-modern">
                                            <div class="item-name-modern">{{ $report->item->nama_item ?? 'Item tidak tersedia' }}</div>
                                            <div class="item-category-modern text-muted small">{{ $report->item->kategori ?? 'Umum' }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="status-badge-modern status-{{ strtolower($report->status) }}">
                                            <i class="status-icon
                                                @if($report->status == 'Selesai') fas fa-check-circle
                                                @elseif($report->status == 'Diproses') fas fa-cogs
                                                @elseif($report->status == 'Ditolak') fas fa-times-circle
                                                @elseif($report->status == 'Disetujui') fas fa-thumbs-up
                                                @else fas fa-clock @endif me-1">
                                            </i>
                                            {{ $report->status }}
                                        </span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="action-buttons-modern">
                                            <a href="{{ route('petugas.pengaduan.show', $report->id_pengaduan) }}"
                                               class="btn-action-primary-modern"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                                <span class="action-text">Detail</span>
                                            </a>
                                            <div class="action-dropdown-modern">

                                                <div class="dropdown-menu-modern">
                                                    <a href="{{ route('petugas.pengaduan.show', $report->id_pengaduan) }}" class="dropdown-item-modern">
                                                        <i class="fas fa-eye me-2"></i>Lihat Detail
                                                    </a>
                                                    
                                                </div>
                                            </div>
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
                                            <h4 class="empty-title-modern">Belum ada aktivitas</h4>
                                            <p class="empty-description-modern">Tidak ada pengaduan yang perlu ditangani saat ini</p>
                                            <a href="{{ route('petugas.pengaduan.index') }}" class="btn btn-primary rounded-pill px-4 py-2">
                                                <i class="fas fa-plus me-2"></i>Mulai Kerja
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($recentActivities->count() > 0)
                <div class="card-footer bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan <strong>{{ $recentActivities->count() }}</strong> dari <strong>{{ $stats['total'] ?? 0 }}</strong> pengaduan
                        </div>
                        <div class="text-muted small">
                            Terakhir diperbarui: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Card Styles */
.modern-card {
    background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.modern-card:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

/* Welcome Card */
.welcome-card {
    background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    position: relative;
    overflow: hidden;
}

.header-decoration {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.decoration-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
}

.circle-1 {
    width: 120px;
    height: 120px;
    top: -40px;
    right: -40px;
}

.circle-2 {
    width: 80px;
    height: 80px;
    top: 50%;
    right: 20%;
}

.circle-3 {
    width: 60px;
    height: 60px;
    bottom: -20px;
    right: 30%;
}

/* Modern Stat Cards */
.stat-card-modern {
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.stat-icon-modern {
    transition: all 0.3s ease;
}

.stat-card-modern:hover .stat-icon-modern {
    transform: scale(1.1) rotate(5deg);
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
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

/* Modern Table */
.modern-table-container {
    overflow: hidden;
    border-radius: 12px;
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
    color: var(--text-dark);
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

/* User Info Modern */
.user-info-modern {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar-modern {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.user-details-modern {
    flex: 1;
    min-width: 0;
}

.user-name-modern {
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.125rem;
}

.user-email-modern {
    font-size: 0.75rem;
}

/* Complaint Info */
.complaint-info {
    min-width: 0;
}

.complaint-title {
    font-size: 0.9rem;
    margin-bottom: 0.125rem;
    color: var(--text-dark);
}

.complaint-desc {
    font-size: 0.75rem;
    line-height: 1.4;
}

/* Location Info */
.location-info {
    min-width: 0;
}

.location-text {
    font-size: 0.8rem;
    color: var(--text-medium);
}

/* Item Info Modern */
.item-info-modern {
    min-width: 0;
}

.item-name-modern {
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 0.125rem;
}

.item-category-modern {
    font-size: 0.75rem;
}

/* Status Badges Modern */
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

.status-diajukan {
    background: rgba(245, 158, 11, 0.1);
    color: #D97706;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.status-diproses {
    background: rgba(59, 130, 246, 0.1);
    color: #2563EB;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.status-selesai {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.status-ditolak {
    background: rgba(239, 68, 68, 0.1);
    color: #DC2626;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.status-disetujui {
    background: rgba(139, 92, 246, 0.1);
    color: #7C3AED;
    border: 1px solid rgba(139, 92, 246, 0.3);
}

/* Action Buttons Modern */
.action-buttons-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
}

.btn-action-primary-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-action-primary-modern:hover {
    background: #3B82F6;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.action-dropdown-modern {
    position: relative;
}

.btn-action-more-modern {
    padding: 0.5rem;
    background: rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 6px;
    color: var(--text-medium);
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-action-more-modern:hover {
    background: rgba(0, 0, 0, 0.1);
    color: var(--text-dark);
}

.dropdown-menu-modern {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    padding: 0.5rem;
    min-width: 140px;
    z-index: 1000;
    display: none;
}

.action-dropdown-modern:hover .dropdown-menu-modern {
    display: block;
}

.dropdown-item-modern {
    display: flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    color: var(--text-dark);
    text-decoration: none;
    border-radius: 6px;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.dropdown-item-modern:hover {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
}

/* Empty State Modern */
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
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    font-size: 1.25rem;
}

.empty-description-modern {
    color: var(--text-medium);
    margin-bottom: 1.5rem;
}

/* Background Colors */
.bg-warning-subtle { background-color: rgba(255, 193, 7, 0.1) !important; }
.bg-info-subtle { background-color: rgba(33, 150, 243, 0.1) !important; }
.bg-success-subtle { background-color: rgba(76, 175, 80, 0.1) !important; }
.bg-primary-subtle { background-color: rgba(59, 130, 246, 0.1) !important; }

/* Responsive Design */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }

    .welcome-card {
        padding: 2rem 1.5rem;
        text-align: center;
    }

    .welcome-card .d-flex {
        flex-direction: column;
    }

    .welcome-icon {
        margin: 0 auto 1rem;
    }

    .modern-table-header {
        display: none;
    }

    .modern-table-row {
        display: block;
        margin-bottom: 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        color: var(--text-dark);
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

    .search-box-modern,
    .filter-group-modern {
        width: 100%;
    }

    .filter-btn {
        flex: 1;
        justify-content: center;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ✅ Live Tanggal + Waktu
    function updateDateTime() {
        const now = new Date();
        const hari = now.toLocaleDateString('id-ID', { weekday: 'long' });
        const tanggal = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        const waktu = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

        document.getElementById('liveDateTime').textContent = `${hari}, ${tanggal} • ${waktu}`;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // ✅ Animasi Fade-in Card
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

    // ✅ Table row animations
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

    // ✅ Hover effects for stat cards
    const statCards = document.querySelectorAll('.stat-card-modern');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-5px) scale(1)';
        });
    });

    // ✅ Click row to detail
    tableRows.forEach(row => {
        row.addEventListener('click', function(e) {
            // Prevent clicking if user clicked on action buttons
            if (!e.target.closest('.action-buttons-modern')) {
                const detailLink = this.querySelector('a[title="Lihat Detail"]');
                if (detailLink) detailLink.click();
            }
        });
    });
});

function confirmAction(id) {
    if (confirm('Apakah Anda yakin ingin memproses pengaduan ini?')) {
        // Implement process functionality here
        console.log('Process pengaduan:', id);
        // You can redirect to process page or show modal
        // window.location.href = `/petugas/pengaduan/${id}/process`;
    }
}
</script>
@endpush

@endsection
