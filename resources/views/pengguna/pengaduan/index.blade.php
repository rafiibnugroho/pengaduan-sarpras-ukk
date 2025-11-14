@extends('layouts.user')

@section('content')
<div class="container-fluid py-4">
    <!-- Modern Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="mb-4 mb-md-0">
                <div class="d-flex align-items-center mb-2">
                    <div class="icon-wrapper me-3">
                        <i class="fas fa-clipboard-list fa-lg text-white"></i>
                    </div>
                    <div>
                        <h1 class="fw-bold fs-3 text-dark mb-1">Daftar Pengaduan</h1>
                        <p class="text-secondary fs-6 mb-0">Kelola dan pantau progress laporan Anda</p>
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Pengaduan Baru
                </a>
            </div>
        </div>
    </div>

    @if($pengaduan->count() > 0)
        <!-- Enhanced Filter Section -->
        <div class="filter-section mb-4">
            <div class="filter-container">
                <div class="filter-header">
                    <i class="fas fa-filter me-2"></i>
                    <span class="filter-title">Filter Pengaduan</span>
                    <div class="filter-stats">
                        <span class="total-count">{{ $pengaduan->count() }} Total Pengaduan</span>
                    </div>
                </div>
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all">
                        <div class="tab-content">
                            <i class="fas fa-layer-group tab-icon"></i>
                            <span class="tab-text">Semua</span>
                            <small class="count-badge">{{ $pengaduan->count() }}</small>
                        </div>
                    </button>
                    <button class="filter-tab" data-filter="diajukan">
                        <div class="tab-content">
                            <i class="fas fa-clock tab-icon"></i>
                            <span class="tab-text">Diajukan</span>
                            <small class="count-badge">{{ $pengaduan->where('status', 'Diajukan')->count() }}</small>
                        </div>
                    </button>
                    <button class="filter-tab" data-filter="diterima">
                        <div class="tab-content">
                            <i class="fas fa-check-circle tab-icon"></i>
                            <span class="tab-text">Diterima</span>
                            <small class="count-badge">{{ $pengaduan->where('status', 'Diterima')->count() }}</small>
                        </div>
                    </button>
                    <button class="filter-tab" data-filter="selesai">
                        <div class="tab-content">
                            <i class="fas fa-check-double tab-icon"></i>
                            <span class="tab-text">Selesai</span>
                            <small class="count-badge">{{ $pengaduan->where('status', 'Selesai')->count() }}</small>
                        </div>
                    </button>
                    <button class="filter-tab" data-filter="ditolak">
                        <div class="tab-content">
                            <i class="fas fa-times-circle tab-icon"></i>
                            <span class="tab-text">Ditolak</span>
                            <small class="count-badge">{{ $pengaduan->where('status', 'Ditolak')->count() }}</small>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Search and Sort Section -->
        <div class="search-sort-section mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="search-input" placeholder="Cari pengaduan...">
                        <div class="search-actions">
                            <button class="btn-clear-search" id="clearSearch">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="sort-container">
                        <select class="sort-select" id="sortSelect">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="priority">Prioritas Tinggi</option>
                            <option value="name">Nama A-Z</option>
                        </select>
                        <i class="fas fa-sort sort-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Cards Grid -->
        <div class="row g-4" id="pengaduan-container">
            @foreach($pengaduan as $p)
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4 pengaduan-card"
                     data-status="{{ strtolower($p->status) }}"
                     data-priority="{{ strtolower($p->prioritas) }}"
                     data-name="{{ strtolower($p->nama_pengaduan) }}"
                     data-date="{{ $p->tgl_pengajuan }}">
                    <div class="card modern-card h-100">
                        <!-- Priority Badge -->
                        @if($p->prioritas)
                            <div class="priority-badge priority-{{ strtolower($p->prioritas) }}">
                                <i class="fas fa-flag me-1"></i>
                                {{ ucfirst($p->prioritas) }}
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="status-badge {{ strtolower($p->status) }}">
                            <span>{{ ucfirst($p->status) }}</span>
                        </div>

                        <!-- Card Header -->
                        <div class="card-header bg-transparent border-0 pt-4 pb-3">
                            <div class="d-flex align-items-start mb-3">
                                <div class="category-icon me-3 status-{{ strtolower($p->status) }}">
                                    @php
                                        $statusIcons = [
                                            'diajukan' => 'fas fa-clock',
                                            'diproses' => 'fas fa-sync-alt',
                                            'selesai' => 'fas fa-check-circle',
                                            'diterima' => 'fas fa-check-circle',
                                            'ditolak' => 'fas fa-times-circle'
                                        ];
                                        $icon = $statusIcons[strtolower($p->status)] ?? 'fas fa-exclamation-circle';
                                    @endphp
                                    <i class="{{ $icon }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title fw-semibold text-dark mb-1 line-clamp-2">{{ $p->nama_pengaduan }}</h5>
                                    <div class="meta-info">
                                        <span class="meta-item">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d M Y') }}
                                        </span>
                                        <span class="meta-divider">•</span>
                                        <span class="meta-item">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $p->item->nama_item ?? 'Tidak ada kategori' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body pt-0 pb-3">
                            <p class="card-text text-muted mb-4 line-clamp-3">{{ $p->deskripsi }}</p>

                            <!-- Progress Bar for Diproses Status -->
                            @if(strtolower($p->status) === 'diproses')
                                <div class="progress-section mb-3">
                                    <div class="progress-label d-flex justify-content-between mb-2">
                                        <span class="small fw-semibold">Progress Penanganan</span>
                                        <span class="small text-muted">65%</span>
                                    </div>
                                    <div class="progress modern-progress">
                                        <div class="progress-bar progress-diproses" role="progressbar" style="width: 65%"></div>
                                    </div>
                                </div>
                            @endif

                            <!-- Enhanced Photo Preview -->
                            <div class="photo-preview-container">
                                @if($p->foto)
                                    <div class="modern-photo-wrapper">
                                        <img src="{{ asset('storage/'.$p->foto) }}"
                                            alt="Bukti Foto"
                                            class="modern-photo"
                                            data-foto-src="{{ asset('storage/'.$p->foto) }}"
                                            data-foto-title="{{ $p->nama_pengaduan }}">

                                    </div>
                                @else
                                    <div class="no-photo-placeholder">
                                        <i class="fas fa-camera fa-2x mb-2"></i>
                                        <p class="small mb-0">Tidak ada foto</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-transparent border-0 pt-0 pb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="id-badge">
                                    <i class="fas fa-hashtag me-1"></i>
                                    #{{ $p->id_pengaduan }}
                                </div>
                                <div class="action-buttons">
                                    <a href="{{ route('pengaduan.show', $p->id_pengaduan) }}"
                                       class="btn btn-action detail-btn">
                                        <i class="fas fa-eye me-1"></i>
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- No Results State -->
        <div class="no-results-state text-center py-5 d-none" id="noResults">
            <div class="no-results-illustration mb-4">
                <i class="fas fa-search fa-4x text-muted"></i>
            </div>
            <h4 class="text-muted mb-3">Tidak ada hasil ditemukan</h4>
            <p class="text-muted mb-4">Coba ubah filter atau kata kunci pencarian Anda</p>
            <button class="btn btn-outline-primary" id="resetFilters">
                <i class="fas fa-refresh me-2"></i>Reset Filter
            </button>
        </div>
    @else
        <!-- Enhanced Empty State -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 text-center py-5">
                <div class="empty-state-illustration mb-4">
                    <div class="illustration-wrapper">
                        <i class="fas fa-inbox illustration-icon"></i>
                    </div>
                </div>
                <h3 class="fw-light text-dark mb-3">Belum Ada Pengaduan</h3>
                <p class="text-muted mb-4">Mulai buat pengaduan pertama Anda untuk melaporkan masalah yang ditemui.</p>
                <a href="{{ route('pengaduan.create') }}" class="btn btn-primary btn-lg rounded-3 px-4 py-3 modern-shadow">
                    <i class="fas fa-plus-circle me-2"></i>Buat Pengaduan Pertama
                </a>
            </div>
        </div>
    @endif

    <!-- Floating Action Button -->
    <a href="{{ route('pengaduan.create') }}" class="floating-action-btn">
        <i class="fas fa-plus fa-lg"></i>
    </a>
</div>

<!-- Modern Foto Modal -->
<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="fotoModalTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img src="" alt="Foto Pengaduan" class="img-fluid" id="fotoModalImage">
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary: #6366f1;
    --primary-light: #818cf8;
    --primary-dark: #4f46e5;
    --secondary: #8b5cf6;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #06b6d4;
    --dark: #1f2937;
    --light: #f8fafc;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --border: #e2e8f0;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --gradient-primary: linear-gradient(135deg, var(--primary), var(--secondary));
    --gradient-success: linear-gradient(135deg, var(--success), #34d399);
    --gradient-warning: linear-gradient(135deg, var(--warning), #fbbf24);
    --gradient-danger: linear-gradient(135deg, var(--danger), #f87171);
    --gradient-info: linear-gradient(135deg, var(--info), #22d3ee);
}

/* Enhanced Filter Section */
.filter-section {
    margin-bottom: 2rem;
}

.filter-container {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
}

.filter-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--gray-100);
}

.filter-title {
    font-weight: 600;
    color: var(--dark);
    font-size: 1.1rem;
    flex: 1;
}

.filter-stats {
    font-size: 0.875rem;
    color: var(--gray-500);
}

.filter-tabs {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
}

.filter-tab {
    background: white;
    border: 2px solid var(--gray-200);
    border-radius: 16px;
    padding: 1.25rem 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.filter-tab::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--gradient-primary);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.filter-tab:hover {
    border-color: var(--primary-light);
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.filter-tab.active {
    border-color: var(--primary);
    background: var(--gradient-primary);
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.filter-tab.active::before {
    opacity: 1;
}

.tab-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    position: relative;
    z-index: 2;
}

.tab-icon {
    font-size: 1.5rem;
    margin-bottom: 0.25rem;
}

.filter-tab:not(.active) .tab-icon {
    color: var(--gray-500);
}

.filter-tab.active .tab-icon {
    color: white;
}

.tab-text {
    font-weight: 600;
    font-size: 0.9rem;
}

.filter-tab:not(.active) .tab-text {
    color: var(--gray-600);
}

.filter-tab.active .tab-text {
    color: white;
}

.count-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.filter-tab:not(.active) .count-badge {
    background: var(--gray-100);
    color: var(--gray-500);
}

/* Search and Sort Section */
.search-sort-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
}

.search-box {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 1rem;
    color: var(--gray-400);
    z-index: 2;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: var(--gray-50);
}

.search-input:focus {
    outline: none;
    border-color: var(--primary);
    background: white;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.search-actions {
    position: absolute;
    right: 0.5rem;
}

.btn-clear-search {
    background: none;
    border: none;
    color: var(--gray-400);
    padding: 0.25rem;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.btn-clear-search:hover {
    background: var(--gray-200);
    color: var(--gray-600);
}

.sort-container {
    position: relative;
}

.sort-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 0.9rem;
    background: var(--gray-50);
    appearance: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.sort-select:focus {
    outline: none;
    border-color: var(--primary);
    background: white;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.sort-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    pointer-events: none;
}

/* Enhanced Modern Cards */
.modern-card {
    background: white;
    border: none;
    box-shadow: var(--shadow);
    border-radius: 20px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    position: relative;
}

.modern-card:hover {
    box-shadow: var(--shadow-xl);
    transform: translateY(-8px);
}

/* Priority Badge */
.priority-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 2;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.priority-tinggi {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.9), rgba(248, 113, 113, 0.9));
    color: white;
}

.priority-sedang {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.9), rgba(251, 191, 36, 0.9));
    color: white;
}

.priority-rendah {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.9), rgba(52, 211, 153, 0.9));
    color: white;
}

/* 🎀 Modern Status Badge */
.status-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    padding: 0.5rem 1rem;
    color: white;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 5;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 0.4rem;
    min-width: auto;
    line-height: 1;
}

/* Efek hover yang smooth */
.status-badge:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

/* Warna sesuai status dengan gradien modern */
.status-badge.diajukan {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.status-badge.diproses {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.status-badge.selesai {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.status-badge.diterima {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}


.status-badge.ditolak {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

/* Icon dalam status badge */
.status-badge::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.8);
    animation: pulse 2s infinite;
}

/* Animasi pulse untuk icon */
@keyframes pulse {
    0% {
        transform: scale(0.8);
        opacity: 1;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.7;
    }
    100% {
        transform: scale(0.8);
        opacity: 1;
    }
}

/* Efek glow pada hover */
.status-badge::after {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    border-radius: 14px;
    background: inherit;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.status-badge:hover::after {
    opacity: 0.3;
    filter: blur(8px);
}

/* Pastikan teks tetap terbaca */
.status-badge span {
    display: block;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    font-size: 0.7rem;
}

/* Category Icon with Status Colors */
.category-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.category-icon.status-diajukan {
    background: var(--gradient-info);
}

.category-icon.status-diproses {
    background: var(--gradient-warning);
}

.category-icon.status-selesai {
    background: var(--gradient-success);
}

.category-icon.status-ditolak {
    background: var(--gradient-danger);
}

/* Progress Bar */
.progress-section {
    margin: 1rem 0;
}

.modern-progress {
    height: 8px;
    border-radius: 10px;
    background: var(--gray-200);
    overflow: hidden;
}

.progress-bar {
    border-radius: 10px;
    transition: width 0.6s ease;
}

.progress-diproses {
    background: var(--gradient-warning);
}

/* Enhanced Photo Preview */
.photo-preview-container {
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1rem;
    background: var(--gray-50);
}

.modern-photo-wrapper {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    height: 200px;
    transition: all 0.3s ease;
}

.modern-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.overlay-content {
    text-align: center;
    color: white;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.modern-photo-wrapper:hover .photo-overlay {
    opacity: 1;
}

.modern-photo-wrapper:hover .overlay-content {
    transform: translateY(0);
}

.modern-photo-wrapper:hover .modern-photo {
    transform: scale(1.1);
}

.no-photo-placeholder {
    height: 200px;
    background: var(--light);
    border: 2px dashed var(--border);
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
    transition: all 0.3s ease;
}

.no-photo-placeholder:hover {
    border-color: var(--primary-light);
    color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
}

/* Card Footer */
.id-badge {
    background: var(--gray-100);
    padding: 0.5rem 1rem;
    border-radius: 12px;
    color: var(--gray-600);
    font-size: 0.875rem;
    font-weight: 500;
}

.btn-action {
    background: var(--gradient-primary);
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    box-shadow: var(--shadow);
}

.btn-action:hover {
    background: var(--gradient-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: white;
}

.secondary-btn {
    background: var(--gray-100);
    color: var(--gray-600);
    padding: 0.75rem;
}

.secondary-btn:hover {
    background: var(--gray-200);
    color: var(--gray-700);
}

/* Meta Information */
.meta-info {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--gray-500);
}

.meta-item {
    display: flex;
    align-items: center;
}

.meta-divider {
    color: var(--gray-300);
}

/* Enhanced Empty State */
.empty-state-illustration {
    position: relative;
    margin-bottom: 2rem;
}

.illustration-wrapper {
    width: 160px;
    height: 160px;
    margin: 0 auto;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    box-shadow: var(--shadow-xl);
}

.illustration-wrapper::before {
    content: '';
    position: absolute;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: rgba(99, 102, 241, 0.1);
    animation: pulse 2s infinite;
}

.illustration-icon {
    font-size: 4.5rem;
    color: white;
    position: relative;
    z-index: 2;
}

@keyframes pulse {
    0% { transform: scale(0.8); opacity: 1; }
    100% { transform: scale(1.2); opacity: 0; }
}

/* No Results State */
.no-results-state {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: var(--shadow);
    border: 2px dashed var(--border);
}

.no-results-illustration {
    opacity: 0.5;
}

/* Buttons */
.btn-primary {
    background: var(--gradient-primary);
    border: none;
    border-radius: 16px;
    padding: 1rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-lg);
}

.btn-primary:hover {
    background: var(--gradient-primary);
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

/* Modal Styles */
.modern-modal {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    border-radius: 20px;
    overflow: hidden;
}

.modal-header {
    background: var(--gradient-primary);
    color: white;
    border: none;
    padding: 1.5rem;
}

/* Utility Classes */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Animation for cards */
.pengaduan-card {
    animation: slideUp 0.6s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Floating Action Button */
.floating-action-btn {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: var(--gradient-primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-xl);
    z-index: 1000;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 1.25rem;
}

.floating-action-btn:hover {
    transform: scale(1.1) rotate(90deg);
    color: white;
    box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
}

/* Header Styles */
.page-header {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--shadow);
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: var(--gradient-primary);
    opacity: 0.05;
    border-radius: 50%;
    transform: translate(60px, -60px);
}

.icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-primary);
    box-shadow: var(--shadow-lg);
}

/* Responsive Design */
@media (max-width: 768px) {
    .filter-tabs {
        grid-template-columns: 1fr;
    }

    .filter-tab {
        padding: 1rem;
    }

    .meta-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }

    .meta-divider {
        display: none;
    }

    .page-header {
        padding: 1.5rem;
    }

    .card-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .id-badge {
        text-align: center;
    }

    .floating-action-btn {
        bottom: 1.5rem;
        right: 1.5rem;
        width: 60px;
        height: 60px;
    }

    .status-badge {
        top: 12px;
        right: 12px;
        padding: 0.4rem 0.8rem;
        font-size: 0.7rem;
    }

    .status-badge span {
        font-size: 0.65rem;
    }

    .priority-badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.6rem;
    }
}

@media (max-width: 576px) {
    .illustration-wrapper {
        width: 120px;
        height: 120px;
    }

    .illustration-icon {
        font-size: 3.5rem;
    }

    .illustration-wrapper::before {
        width: 140px;
        height: 140px;
    }

    .search-sort-section .row {
        flex-direction: column;
    }

    .search-sort-section .col-md-6 {
        width: 100%;
    }

    .status-badge {
        top: 10px;
        right: 10px;
        padding: 0.3rem 0.7rem;
        font-size: 0.65rem;
    }

    .status-badge span {
        font-size: 0.6rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Foto Modal
    document.querySelectorAll('.modern-photo').forEach(img => {
        img.addEventListener('click', function() {
            document.getElementById('fotoModalImage').src = this.dataset.fotoSrc;
            document.getElementById('fotoModalTitle').textContent = this.dataset.fotoTitle;
            new bootstrap.Modal(document.getElementById('fotoModal')).show();
        });
    });

    // Enhanced Filter functionality
    const filterTabs = document.querySelectorAll('.filter-tab');
    const pengaduanCards = document.querySelectorAll('.pengaduan-card');
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const sortSelect = document.getElementById('sortSelect');
    const noResults = document.getElementById('noResults');
    const resetFilters = document.getElementById('resetFilters');

    let currentFilter = 'all';
    let currentSearch = '';
    let currentSort = 'newest';

    function filterAndSortPengaduan() {
        let visibleCount = 0;

        pengaduanCards.forEach(card => {
            const status = card.getAttribute('data-status');
            const name = card.getAttribute('data-name');
            const priority = card.getAttribute('data-priority');
            const date = card.getAttribute('data-date');

            // Filter by status
            const statusMatch = currentFilter === 'all' || status === currentFilter;

            // Filter by search
            const searchMatch = !currentSearch || name.includes(currentSearch.toLowerCase());

            // Combine filters
            const shouldShow = statusMatch && searchMatch;

            if (shouldShow) {
                card.style.display = 'block';
                visibleCount++;

                // Add animation
                card.style.animation = 'slideUp 0.5s ease';
            } else {
                card.style.display = 'none';
            }
        });

        // Sort cards
        sortPengaduanCards();

        // Show/hide no results state
        if (visibleCount === 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }
    }

    function sortPengaduanCards() {
        const container = document.getElementById('pengaduan-container');
        const cards = Array.from(pengaduanCards).filter(card => card.style.display !== 'none');

        cards.sort((a, b) => {
            switch (currentSort) {
                case 'newest':
                    return new Date(b.getAttribute('data-date')) - new Date(a.getAttribute('data-date'));
                case 'oldest':
                    return new Date(a.getAttribute('data-date')) - new Date(b.getAttribute('data-date'));
                case 'priority':
                    const priorityOrder = { 'tinggi': 3, 'sedang': 2, 'rendah': 1 };
                    return priorityOrder[b.getAttribute('data-priority')] - priorityOrder[a.getAttribute('data-priority')];
                case 'name':
                    return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                default:
                    return 0;
            }
        });

        // Reorder cards in container
        cards.forEach(card => {
            container.appendChild(card);
        });
    }

    // Filter tabs event listeners
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            filterTabs.forEach(t => {
                t.classList.remove('active');
                t.style.transform = 'translateY(0)';
            });

            // Add active class to clicked tab
            this.classList.add('active');
            this.style.transform = 'translateY(-3px)';

            currentFilter = this.getAttribute('data-filter');
            filterAndSortPengaduan();
        });
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        currentSearch = this.value.toLowerCase().trim();
        filterAndSortPengaduan();

        // Show/hide clear button
        if (currentSearch) {
            clearSearch.style.display = 'block';
        } else {
            clearSearch.style.display = 'none';
        }
    });

    // Clear search
    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        currentSearch = '';
        filterAndSortPengaduan();
        this.style.display = 'none';
    });

    // Sort functionality
    sortSelect.addEventListener('change', function() {
        currentSort = this.value;
        filterAndSortPengaduan();
    });

    // Reset filters
    if (resetFilters) {
        resetFilters.addEventListener('click', function() {
            // Reset filter tabs
            filterTabs.forEach(tab => {
                tab.classList.remove('active');
                tab.style.transform = 'translateY(0)';
            });
            filterTabs[0].classList.add('active');
            filterTabs[0].style.transform = 'translateY(-3px)';

            // Reset search
            searchInput.value = '';
            currentSearch = '';
            clearSearch.style.display = 'none';

            // Reset sort
            sortSelect.value = 'newest';

            currentFilter = 'all';
            currentSort = 'newest';

            filterAndSortPengaduan();
        });
    }

    // Enhanced hover effects to cards
    document.querySelectorAll('.modern-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Add loading animation
    const container = document.getElementById('pengaduan-container');
    if (container) {
        container.style.opacity = '0';
        setTimeout(() => {
            container.style.transition = 'opacity 0.6s ease';
            container.style.opacity = '1';
        }, 100);
    }

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
