@extends('layouts.admin')

@section('title', 'Laporan Pengaduan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Main Card -->
            <div class="card modern-report-card">
                <!-- Card Header -->
                <div class="card-header modern-report-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="header-content">
                            <h4 class="mb-1 text-white">
                                <i class="fas fa-chart-line me-2"></i>Laporan Pengaduan
                            </h4>
                            <p class="mb-0 text-white opacity-85">Analisis dan monitoring data pengaduan sistem</p>
                        </div>
                        <div class="header-actions">
                            <a href="{{ route('admin.laporan.exportPdf', request()->query()) }}"
                               class="btn btn-light btn-modern export-btn">
                                <i class="fas fa-file-pdf me-2 text-danger"></i> Export PDF
                            </a>
                        </div>
                    </div>
                </div>



                    <!-- Filter & Search Section -->
                    <div class="modern-filter-section mb-4">
                        <div class="row g-3">
                            <!-- Quick Filter Tabs -->
                            <div class="col-12">
                                <div class="quick-filter-tabs">
                                    <button class="filter-tab active" data-status="">
                                        <i class="fas fa-layer-group me-2"></i>Semua
                                    </button>
                                    <button class="filter-tab" data-status="Selesai">
                                        <i class="fas fa-check-circle me-2"></i>Selesai
                                    </button>
                                    <button class="filter-tab" data-status="Diproses">
                                        <i class="fas fa-spinner me-2"></i>Diproses
                                    </button>
                                    <button class="filter-tab" data-status="Diajukan">
                                        <i class="fas fa-clock me-2"></i>Diajukan
                                    </button>
                                    <button class="filter-tab" data-status="Ditolak">
                                        <i class="fas fa-times-circle me-2"></i>Ditolak
                                    </button>
                                </div>
                            </div>

                            <!-- Advanced Filters -->
                            <div class="col-12">
                                <div class="advanced-filters">
                                    <div class="filter-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-sliders-h me-2"></i>Filter Lanjutan
                                        </h6>
                                        
                                    </div>
                                    <div class="filter-content" id="filterContent">
                                        <form method="GET" class="row g-3 mt-2">
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">Status</label>
                                                <select name="status" class="form-select modern-select">
                                                    <option value="">Semua Status</option>
                                                    <option value="Diajukan" {{ request('status') == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                                                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">Dari Tanggal</label>
                                                <input type="date" name="from" class="form-control modern-input" value="{{ request('from') }}">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">Sampai Tanggal</label>
                                                <input type="date" name="to" class="form-control modern-input" value="{{ request('to') }}">
                                            </div>

                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary w-100 btn-modern">
                                                    <i class="fas fa-filter me-2"></i> Terapkan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Bar -->
                            <div class="col-12">
                                <div class="modern-search-container">
                                    <div class="search-wrapper">
                                        <i class="fas fa-search search-icon"></i>
                                        <input type="text"
                                               id="globalSearch"
                                               class="form-control modern-search-input"
                                               placeholder="Cari berdasarkan judul, pelapor, lokasi, atau item..."
                                               value="{{ request('search') }}">
                                        <div class="search-actions">
                                            <button type="button" class="btn btn-clear-search" id="clearSearch">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table modern-table" id="reportTable">
                                <thead class="modern-thead">
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Pengaduan</th>
                                        <th>Pelapor</th>
                                        <th>Lokasi</th>
                                        <th>Item</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tanggal Pengajuan</th>
                                        <th class="text-center">Tanggal Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($laporan as $l)
                                        <tr class="modern-table-row">
                                            <td class="text-center">
                                                <span class="id-badge">#{{ $l->id_pengaduan }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="complaint-icon bg-primary bg-opacity-10 rounded p-2 me-3">
                                                        <i class="fas fa-exclamation-triangle text-primary"></i>
                                                    </div>
                                                    <div class="complaint-info">
                                                        <h6 class="mb-0 complaint-title">{{ $l->nama_pengaduan }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                                        <i class="fas fa-user text-info"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 small">{{ $l->user->name ?? '-' }}</h6>
                                                        <small class="text-muted">Pelapor</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="location-info">
                                                    <i class="fas fa-map-marker-alt text-danger me-2 small"></i>
                                                    <span class="small">{{ $l->lokasi->nama_lokasi ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="item-info">
                                                    <i class="fas fa-box text-success me-2 small"></i>
                                                    <span class="small">{{ $l->item->nama_item ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="status-badge modern-badge status-{{ strtolower($l->status) }}">
                                                    <i class="status-icon fas
                                                        @if($l->status == 'Selesai') fa-check-circle
                                                        @elseif($l->status == 'Ditolak') fa-times-circle
                                                        @elseif($l->status == 'Diproses') fa-spinner
                                                        @elseif($l->status == 'Disetujui') fa-check
                                                        @else fa-clock @endif
                                                    me-1"></i>
                                                    {{ ucfirst($l->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="date-info">
                                                    <div class="fw-semibold small">{{ \Carbon\Carbon::parse($l->tgl_pengajuan)->format('d M Y') }}</div>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($l->tgl_pengajuan)->format('H:i') }}</small>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($l->tgl_selesai)
                                                    <div class="date-info">
                                                        <div class="fw-semibold small">{{ \Carbon\Carbon::parse($l->tgl_selesai)->format('d M Y') }}</div>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($l->tgl_selesai)->format('H:i') }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="empty-state modern-empty">
                                                    <i class="fas fa-search fa-3x mb-3"></i>
                                                    <h5 class="mb-2">Tidak ada data ditemukan</h5>
                                                    <p class="mb-3">Coba ubah filter atau kata kunci pencarian</p>
                                                    <button class="btn btn-primary btn-modern" id="resetFilters">
                                                        <i class="fas fa-refresh me-2"></i> Reset Filter
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Table Footer -->
                        @if($laporan->count() > 0)
                        <div class="table-footer">
                            <div class="d-flex justify-content-between align-items-center">

                                <div class="export-actions">
                                    <a href="{{ route('admin.laporan.exportPdf', request()->query()) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download me-2"></i> Unduh Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
:root {
    --primary: #4361ee;
    --primary-dark: #3a56d4;
    --primary-light: #eef2ff;
    --secondary: #6c757d;
    --success: #28a745;
    --danger: #dc3545;
    --warning: #ffc107;
    --info: #17a2b8;
    --light: #f8f9fa;
    --dark: #343a40;
    --border: #e2e8f0;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Modern Card */
.modern-report-card {
    border: none;
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
    background: white;
    overflow: hidden;
}

.modern-report-header {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-bottom: none;
    padding: 1.5rem 2rem;
}

/* Stats Overview */
.stat-card {
    background: white;
    border-radius: var(--radius);
    padding: 1.5rem;
    box-shadow: var(--shadow);
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 1rem;
    border-left: 4px solid var(--primary);
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.stat-card.total { border-left-color: var(--primary); }
.stat-card.completed { border-left-color: var(--success); }
.stat-card.process { border-left-color: var(--warning); }
.stat-card.pending { border-left-color: var(--secondary); }

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-card.total .stat-icon { background: var(--primary-light); color: var(--primary); }
.stat-card.completed .stat-icon { background: #d1fae5; color: var(--success); }
.stat-card.process .stat-icon { background: #fef3c7; color: var(--warning); }
.stat-card.pending .stat-icon { background: #f1f5f9; color: var(--secondary); }

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--secondary);
    margin-top: 0.25rem;
}

/* Filter Section */
.modern-filter-section {
    background: var(--light);
    border-radius: var(--radius);
    padding: 1.5rem;
    border: 1px solid var(--border);
}

.quick-filter-tabs {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-tab {
    padding: 0.75rem 1.25rem;
    border: 1px solid var(--border);
    background: white;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--secondary);
    transition: var(--transition);
    cursor: pointer;
    display: flex;
    align-items: center;
}

.filter-tab:hover {
    border-color: var(--primary);
    color: var(--primary);
}

.filter-tab.active {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}

.advanced-filters {
    background: white;
    border-radius: var(--radius);
    padding: 1rem;
    border: 1px solid var(--border);
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.filter-content {
    margin-top: 1rem;
}

/* Search Container */
.modern-search-container {
    position: relative;
}

.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 1rem;
    color: var(--secondary);
    z-index: 2;
}

.modern-search-input {
    padding-left: 3rem;
    padding-right: 3rem;
    border: 2px solid var(--border);
    border-radius: 10px;
    height: 50px;
    font-size: 1rem;
    transition: var(--transition);
}

.modern-search-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
}

.search-actions {
    position: absolute;
    right: 0.5rem;
}

.btn-clear-search {
    background: none;
    border: none;
    color: var(--secondary);
    padding: 0.5rem;
    border-radius: 6px;
    transition: var(--transition);
}

.btn-clear-search:hover {
    background: var(--light);
    color: var(--dark);
}

/* Table Styles */
.table-container {
    border-radius: var(--radius);
    overflow: hidden;
    border: 1px solid var(--border);
}

.modern-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.modern-thead th {
    background-color: var(--primary-light);
    border-bottom: 2px solid var(--border);
    font-weight: 600;
    color: var(--dark);
    padding: 1rem 0.75rem;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modern-table-row {
    transition: var(--transition);
    border-bottom: 1px solid var(--border);
}

.modern-table-row:hover {
    background-color: rgba(67, 97, 238, 0.03);
}

.modern-table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

/* ID Badge */
.id-badge {
    font-weight: 600;
    color: var(--primary);
    background-color: rgba(67, 97, 238, 0.1);
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    display: inline-block;
    font-size: 0.85rem;
}

/* Status Badges */
.status-badge.modern-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.status-selesai {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    border: 1px solid #10b981;
}

.status-ditolak {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
    border: 1px solid #ef4444;
}

.status-diproses {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    border: 1px solid #f59e0b;
}

.status-diajukan {
    background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
    color: #3730a3;
    border: 1px solid #6366f1;
}

.status-disetujui {
    background: linear-gradient(135deg, #dbeafe, #93c5fd);
    color: #1e40af;
    border: 1px solid #3b82f6;
}

/* Empty State */
.modern-empty {
    padding: 3rem 1rem;
    text-align: center;
    color: var(--secondary);
}

.modern-empty i {
    opacity: 0.5;
}

/* Buttons */
.btn-modern {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: var(--transition);
    border: 2px solid transparent;
    display: inline-flex;
    align-items: center;
}

.btn-primary.btn-modern {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border: none;
    color: white;
    box-shadow: var(--shadow);
}

.btn-primary.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.export-btn {
    background: white;
    color: var(--primary);
    border: none;
}

.export-btn:hover {
    background: var(--light);
    transform: translateY(-2px);
}

/* Table Footer */
.table-footer {
    padding: 1rem 1.5rem;
    background: var(--light);
    border-top: 1px solid var(--border);
}

/* Form Elements */
.modern-select, .modern-input {
    border: 2px solid var(--border);
    border-radius: 8px;
    transition: var(--transition);
}

.modern-select:focus, .modern-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }

    .modern-report-header {
        padding: 1.25rem 1.5rem;
    }

    .quick-filter-tabs {
        flex-direction: column;
    }

    .filter-tab {
        justify-content: center;
    }

    .stat-card {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }

    .table-footer {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .modern-table {
        font-size: 0.875rem;
    }

    .modern-table td, .modern-table th {
        padding: 0.75rem 0.5rem;
    }
}

@media (max-width: 576px) {
    .modern-filter-section {
        padding: 1rem;
    }

    .advanced-filters .row {
        flex-direction: column;
    }

    .search-wrapper {
        flex-direction: column;
        gap: 0.5rem;
    }

    .modern-search-input {
        padding-left: 1rem;
    }

    .search-icon {
        position: static;
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Global Search Functionality
    const globalSearch = document.getElementById('globalSearch');
    const clearSearch = document.getElementById('clearSearch');
    const rows = document.querySelectorAll('#reportTable tbody tr');
    const filterTabs = document.querySelectorAll('.filter-tab');
    const resetFilters = document.getElementById('resetFilters');

    // Quick Filter Tabs
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const status = this.dataset.status;

            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // Filter rows by status
            filterRows(globalSearch.value, status);
        });
    });

    // Global Search with Debouncing
    let searchTimeout;
    globalSearch.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const activeTab = document.querySelector('.filter-tab.active');
            const status = activeTab ? activeTab.dataset.status : '';
            filterRows(this.value, status);
        }, 300);
    });

    // Clear Search
    clearSearch.addEventListener('click', function() {
        globalSearch.value = '';
        const activeTab = document.querySelector('.filter-tab.active');
        const status = activeTab ? activeTab.dataset.status : '';
        filterRows('', status);
    });

    // Reset All Filters
    if (resetFilters) {
        resetFilters.addEventListener('click', function() {
            globalSearch.value = '';
            filterTabs.forEach(tab => tab.classList.remove('active'));
            filterTabs[0].classList.add('active'); // Reset to "All" tab
            filterRows('', '');
        });
    }

    // Toggle Advanced Filters
    const toggleFilters = document.getElementById('toggleFilters');
    const filterContent = document.getElementById('filterContent');

    if (toggleFilters && filterContent) {
        toggleFilters.addEventListener('click', function() {
            const isHidden = filterContent.style.display === 'none';
            filterContent.style.display = isHidden ? 'block' : 'none';
            this.innerHTML = isHidden ?
                '<i class="fas fa-chevron-up"></i>' :
                '<i class="fas fa-chevron-down"></i>';
        });
    }

    // Filter Rows Function
    function filterRows(searchTerm, status) {
        const searchLower = searchTerm.toLowerCase().trim();
        let visibleCount = 0;

        rows.forEach(row => {
            if (row.querySelector('.empty-state')) return;

            const pengaduan = row.querySelector('.complaint-title')?.textContent.toLowerCase() || '';
            const pelapor = row.querySelector('.user-avatar + div h6')?.textContent.toLowerCase() || '';
            const lokasi = row.querySelector('.location-info span')?.textContent.toLowerCase() || '';
            const item = row.querySelector('.item-info span')?.textContent.toLowerCase() || '';
            const rowStatus = row.querySelector('.status-badge')?.textContent.toLowerCase().trim() || '';

            // Check search term match
            const searchMatch = !searchLower ||
                pengaduan.includes(searchLower) ||
                pelapor.includes(searchLower) ||
                lokasi.includes(searchLower) ||
                item.includes(searchLower);

            // Check status match
            const statusMatch = !status ||
                rowStatus.includes(status.toLowerCase());

            // Show/hide row
            const shouldShow = searchMatch && statusMatch;
            row.style.display = shouldShow ? '' : 'none';

            if (shouldShow) visibleCount++;
        });

        // Show empty state if no results
        const emptyState = document.querySelector('.empty-state');
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    // Initialize table with current filters
    const currentStatus = new URLSearchParams(window.location.search).get('status') || '';
    if (currentStatus) {
        const correspondingTab = document.querySelector(`.filter-tab[data-status="${currentStatus}"]`);
        if (correspondingTab) {
            filterTabs.forEach(tab => tab.classList.remove('active'));
            correspondingTab.classList.add('active');
        }
    }

    // Add smooth animations
    const cards = document.querySelectorAll('.stat-card, .modern-report-card');

    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });
});
</script>
@endpush
