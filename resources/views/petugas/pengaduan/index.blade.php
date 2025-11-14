@extends('layouts.petugas')

@section('title', 'Kelola Pengaduan - ' . config('app.name'))

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="dashboard-header-card bg-gradient-primary text-white rounded-4 p-5 position-relative overflow-hidden">
                <div class="row align-items-center">
                    <div class="col-md-12 text-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <div>
                                <h1 class="fw-bold mb-2 display-6">Kelola Aduan</h1>
                                <p class="mb-0 opacity-90 fs-5">Kelola semua laporan pengguna dengan antarmuka yang modern dan intuitif</p>
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

    <!-- Filter & Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card modern-card border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <div class="search-box-modern">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchInput" class="search-input" placeholder="Cari pengaduan...">
                                <div class="search-loader">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="filter-group-modern">
                                <button class="filter-btn active" data-filter="all">
                                    <i class="fas fa-layer-group me-2"></i>Semua
                                </button>
                                <button class="filter-btn" data-filter="diproses">
                                    <i class="fas fa-cogs me-2"></i>Diproses
                                </button>
                                <button class="filter-btn" data-filter="selesai">
                                    <i class="fas fa-check-circle me-2"></i>Selesai
                                </button>
                                <button class="filter-btn" data-filter="berrating">
                                    <i class="fas fa-star me-2"></i>Ber-Rating
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card-modern bg-info bg-opacity-10 border-0 rounded-4">
                <div class="stat-content">
                    <div class="stat-icon bg-info">
                        <i class="fas fa-cogs text-white"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $pengaduan->where('status', 'Diproses')->count() }}</div>
                        <div class="stat-label">Diproses</div>
                    </div>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar bg-info" style="width: {{ ($pengaduan->where('status', 'Diproses')->count() / max($pengaduan->count(), 1)) * 100 }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card-modern bg-success bg-opacity-10 border-0 rounded-4">
                <div class="stat-content">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $pengaduan->where('status', 'Selesai')->count() }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar bg-success" style="width: {{ ($pengaduan->where('status', 'Selesai')->count() / max($pengaduan->count(), 1)) * 100 }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card-modern bg-warning bg-opacity-10 border-0 rounded-4">
                <div class="stat-content">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-star text-white"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $pengaduan->where('status', 'Selesai')->whereNotNull('rating')->count() }}</div>
                        <div class="stat-label">Ber-Rating</div>
                    </div>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar bg-warning" style="width: {{ ($pengaduan->where('status', 'Selesai')->whereNotNull('rating')->count() / max($pengaduan->where('status', 'Selesai')->count(), 1)) * 100 }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card-modern bg-primary bg-opacity-10 border-0 rounded-4">
                <div class="stat-content">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-list-alt text-white"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $pengaduan->count() }}</div>
                        <div class="stat-label">Total</div>
                    </div>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content - Modern Table -->
    <div class="row">
        <div class="col-12">
            <div class="card modern-card border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="table-actions">
                            <button class="btn-action" id="refreshBtn" title="Refresh">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button class="btn-action" id="exportBtn" title="Export Data">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="modern-table-container">
                        <table class="table modern-table mb-0">
                            <thead class="modern-table-header">
                                <tr>
                                    <th class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <span>ID</span>
                                        </div>
                                    </th>
                                    <th>
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
                                    <th class="text-center">Rating</th>
                                    <th class="text-center">Bukti</th>
                                    <th class="text-center pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="modern-table-body">
                                @forelse($pengaduan as $p)
                                <tr class="modern-table-row" data-status="{{ strtolower($p->status) }}" data-rating="{{ $p->rating ? 'yes' : 'no' }}">
                                    <td class="ps-4">
                                        <div class="id-badge-modern">
                                            <span class="id-prefix">#</span>
                                            <span class="id-number">{{ $p->id_pengaduan }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-info-modern">
                                            <div class="user-avatar-modern bg-primary bg-opacity-10 rounded-circle">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div class="user-details-modern">
                                                <div class="user-name-modern">{{ $p->user->name ?? '-' }}</div>
                                                <div class="user-email-modern text-muted">{{ $p->user->email ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="complaint-info-modern">
                                            <div class="complaint-title-modern fw-semibold">{{ $p->nama_pengaduan ?? 'Judul Pengaduan' }}</div>
                                            <div class="complaint-desc-modern text-muted small">{{ Str::limit($p->deskripsi, 80) }}</div>
                                            <div class="complaint-meta-modern">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="location-info-modern">
                                            <div class="location-text-modern">
                                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                {{ $p->lokasi->nama_lokasi ?? 'Lokasi tidak tersedia' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item-info-modern">
                                            <div class="item-name-modern fw-semibold">{{ $p->item->nama_item ?? '-' }}</div>
                                            <div class="item-category-modern text-muted small">{{ $p->item->kategori ?? 'Umum' }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="status-badge-modern status-{{ strtolower($p->status) }}">
                                            <i class="status-icon
                                                @if($p->status == 'Selesai') fas fa-check-circle
                                                @elseif($p->status == 'Diproses') fas fa-cogs
                                                @elseif($p->status == 'Ditolak') fas fa-times-circle
                                                @elseif($p->status == 'Disetujui') fas fa-thumbs-up
                                                @else fas fa-clock @endif me-1">
                                            </i>
                                            {{ $p->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($p->status == 'Selesai' && $p->rating)
                                        <div class="rating-display-modern">
                                            <div class="stars-small">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $p->rating ? 'active' : '' }}"></i>
                                                @endfor
                                            </div>
                                            <small class="rating-value">{{ $p->rating }}/5</small>
                                        </div>
                                        @elseif($p->status == 'Selesai')
                                        <span class="no-rating-badge">
                                            <i class="fas fa-star text-muted"></i>
                                            <span class="text-muted small">Belum</span>
                                        </span>
                                        @else
                                        <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($p->foto)
                                        <div class="evidence-container-modern">
                                            <a href="{{ asset('storage/'.$p->foto) }}" class="evidence-thumbnail-modern" data-fancybox="gallery">
                                                <img src="{{ asset('storage/'.$p->foto) }}" alt="Bukti" class="evidence-image-modern">
                                                <div class="evidence-overlay-modern">
                                                    <i class="fas fa-search-plus"></i>
                                                </div>
                                            </a>
                                        </div>
                                        @else
                                        <div class="no-evidence-modern">
                                            <i class="fas fa-image text-muted"></i>
                                            <span class="text-muted small">Tidak ada</span>
                                        </div>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="action-buttons-modern-simple">
                                            <a href="{{ route('petugas.pengaduan.show', $p->id_pengaduan) }}"
                                               class="btn-action-view-modern"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="empty-state-modern">
                                            <div class="empty-icon-modern">
                                                <i class="fas fa-inbox fa-4x"></i>
                                            </div>
                                            <h4 class="empty-title-modern">Belum ada pengaduan</h4>
                                            <p class="empty-description-modern">Tidak ada data pengaduan yang ditemukan</p>
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
    </div>
</div>

<!-- Modal for Full Description -->
<div class="modal fade" id="descriptionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Deskripsi Lengkap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="fullDescription" class="mb-0"></p>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true
});
</script>
@endif

<style>
/* Rating Display Styles */
.rating-display-modern {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
}

.stars-small {
    display: flex;
    gap: 0.1rem;
}

.stars-small .fa-star {
    font-size: 0.8rem;
    color: var(--gray-300);
}

.stars-small .fa-star.active {
    color: var(--warning);
}

.rating-value {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.75rem;
}

.no-rating-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    opacity: 0.6;
}

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

/* Header Section */
.dashboard-header-card {
    background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    position: relative;
    overflow: hidden;
}

.header-icon-container {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.dashboard-header-card:hover .header-icon-container {
    transform: scale(1.1) rotate(5deg);
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

/* Search & Filter */
.search-box-modern {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 3rem;
    border: 2px solid rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    background: #fff;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.search-input:focus {
    outline: none;
    border-color: #3B82F6;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.15);
}

.search-icon {
    position: absolute;
    left: 1rem;
    color: var(--text-light);
    z-index: 2;
}

.search-loader {
    position: absolute;
    right: 1rem;
    color: var(--text-light);
    display: none;
}

.filter-group-modern {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 0.75rem 1.25rem;
    border: 2px solid rgba(0, 0, 0, 0.1);
    background: white;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-medium);
    transition: all 0.3s ease;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.filter-btn.active,
.filter-btn:hover {
    background: #3B82F6;
    border-color: #3B82F6;
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    transform: translateY(-1px);
}

/* Statistics Cards */
.stat-card-modern {
    padding: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.stat-content {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stat-info {
    flex: 1;
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.25rem;
    color: var(--text-dark);
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-medium);
    font-weight: 500;
}

.stat-progress {
    height: 4px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 2px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    border-radius: 2px;
    transition: width 0.6s ease;
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

/* Table Elements */
.id-badge-modern {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-family: 'Courier New', monospace;
    font-weight: 700;
    color: var(--text-dark);
}

.id-prefix {
    color: var(--text-light);
    font-weight: 600;
}

.id-number {
    color: var(--text-dark);
    font-weight: 700;
}

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

/* Complaint Info Modern */
.complaint-info-modern {
    min-width: 0;
    max-width: 280px;
}

.complaint-title-modern {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
    line-height: 1.4;
}

.complaint-desc-modern {
    font-size: 0.8rem;
    line-height: 1.4;
    margin-bottom: 0.5rem;
}

.complaint-meta-modern {
    font-size: 0.75rem;
}

/* Location Info Modern */
.location-info-modern {
    min-width: 0;
}

.location-text-modern {
    font-size: 0.85rem;
    color: var(--text-medium);
    display: flex;
    align-items: center;
}

/* Item Info Modern */
.item-info-modern {
    min-width: 0;
}

.item-name-modern {
    font-size: 0.9rem;
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

/* Evidence Images Modern */
.evidence-container-modern {
    position: relative;
    display: inline-block;
}

.evidence-thumbnail-modern {
    display: block;
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.evidence-image-modern {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.evidence-overlay-modern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    border-radius: 8px;
}

.evidence-thumbnail-modern:hover .evidence-overlay-modern {
    opacity: 1;
}

.evidence-thumbnail-modern:hover .evidence-image-modern {
    transform: scale(1.1);
}

.evidence-overlay-modern i {
    color: white;
    font-size: 1.25rem;
}

.no-evidence-modern {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    opacity: 0.5;
}

/* Action Buttons Modern Simple */
.action-buttons-modern-simple {
    display: flex;
    align-items: center;
    gap: 0.5rem;
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

/* Table Actions */
.table-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    padding: 0.5rem;
    background: rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    color: var(--text-medium);
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-action:hover {
    background: #3B82F6;
    color: white;
    transform: translateY(-1px);
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
}

.empty-description-modern {
    color: var(--text-medium);
    margin-bottom: 0;
}

/* Modal */
.modern-modal {
    border: none;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.modern-modal .modal-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
}

.modern-modal .modal-body {
    padding: 1.5rem;
    line-height: 1.6;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }

    .dashboard-header-card {
        padding: 2rem 1.5rem;
        text-align: center;
    }

    .dashboard-header-card .d-flex {
        flex-direction: column;
    }

    .header-icon-container {
        margin: 0 auto 1rem;
    }

    .filter-group-modern {
        justify-content: center;
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

    .action-buttons-modern-simple {
        justify-content: flex-start;
    }

    .card-header .d-flex {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    /* Responsive data labels */
    .modern-table-row td:nth-child(1)::before { content: "ID: "; }
    .modern-table-row td:nth-child(2)::before { content: "Pengguna: "; }
    .modern-table-row td:nth-child(3)::before { content: "Pengaduan: "; }
    .modern-table-row td:nth-child(4)::before { content: "Lokasi: "; }
    .modern-table-row td:nth-child(5)::before { content: "Item: "; }
    .modern-table-row td:nth-child(6)::before { content: "Status: "; }
    .modern-table-row td:nth-child(7)::before { content: "Rating: "; }
    .modern-table-row td:nth-child(8)::before { content: "Bukti: "; }
    .modern-table-row td:nth-child(9)::before { content: "Aksi: "; }
}

@media (max-width: 576px) {
    .stat-card-modern {
        text-align: center;
    }

    .stat-content {
        flex-direction: column;
        text-align: center;
    }

    .search-box-modern,
    .filter-group-modern {
        width: 100%;
    }

    .filter-btn {
        flex: 1;
        justify-content: center;
    }

    .action-buttons-modern-simple {
        flex-direction: column;
        gap: 0.25rem;
    }

    .btn-action-view-modern {
        width: 35px;
        height: 35px;
        font-size: 0.8rem;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const tableRows = document.querySelectorAll('.modern-table-row');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');

            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Filter rows
            tableRows.forEach(row => {
                if (filter === 'all') {
                    row.style.display = '';
                } else if (filter === 'berrating') {
                    const hasRating = row.getAttribute('data-rating') === 'yes';
                    row.style.display = hasRating ? '' : 'none';
                } else {
                    const status = row.getAttribute('data-status');
                    row.style.display = status === filter ? '' : 'none';
                }
            });
        });
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const searchLoader = document.querySelector('.search-loader');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        // Show loader
        searchLoader.style.display = 'block';

        setTimeout(() => {
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });

            // Hide loader
            searchLoader.style.display = 'none';
        }, 300);
    });

    // Refresh button
    const refreshBtn = document.getElementById('refreshBtn');
    refreshBtn.addEventListener('click', function() {
        this.querySelector('i').className = 'fas fa-spinner fa-spin';
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    });

    // Export button
    const exportBtn = document.getElementById('exportBtn');
    exportBtn.addEventListener('click', function() {
        // Simulate export functionality
        this.querySelector('i').className = 'fas fa-check';
        setTimeout(() => {
            this.querySelector('i').className = 'fas fa-download';
        }, 2000);
    });

    // Add smooth animations
    const cards = document.querySelectorAll('.modern-card');
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
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        row.style.transition = 'all 0.5s ease';

        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 100);
    });
});

</script>

<!-- Add Fancybox for image lightbox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>
// Initialize Fancybox
$(document).ready(function() {
    $('[data-fancybox="gallery"]').fancybox({
        buttons: [
            "zoom",
            "share",
            "slideShow",
            "fullScreen",
            "download",
            "thumbs",
            "close"
        ],
        animationEffect: "zoom-in-out",
        transitionEffect: "circular",
    });
});
</script>
@endpush

@endsection
