@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card elegant-card">
                <div class="card-header elegant-card-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="header-text">
                            <h5 class="mb-1">Manajemen Pengaduan</h5>
                            <p class="mb-0 opacity-75">Kelola dan pantau semua pengaduan yang masuk</p>
                        </div>
                    </div>
                   
                </div>

                <!-- Statistics Cards -->
                <div class="card-body">
                   @php
                        $stats = [
                            ['count' => $pengaduan->count(), 'label' => 'Total Pengaduan', 'icon' => 'fas fa-inbox', 'color' => 'primary'],
                            ['count' => $pengaduan->where('status', 'Diterima')->count(), 'label' => 'Diterima', 'icon' => 'fas fa-check-circle', 'color' => 'success'],
                            ['count' => $pengaduan->where('status', 'Ditolak')->count(), 'label' => 'Ditolak', 'icon' => 'fas fa-times-circle', 'color' => 'danger'],
                            ['count' => $pengaduan->where('status', 'Selesai')->count(), 'label' => 'Selesai', 'icon' => 'fas fa-flag-checkered', 'color' => 'info'],
                        ];
                    @endphp

                    <div class="row mb-4">
                        @foreach($stats as $stat)
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="stat-card-elegant">
                                <div class="stat-icon bg-{{ $stat['color'] }}">
                                    <i class="{{ $stat['icon'] }}"></i>
                                </div>
                                <div class="stat-content">
                                    <h3 class="stat-number">{{ $stat['count'] }}</h3>
                                    <p class="stat-label">{{ $stat['label'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if(session('success'))
                    <!-- Success Alert -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert-modern alert-success border-0 rounded-4 p-4">
                                <div class="d-flex align-items-center">
                                    <div class="alert-icon bg-success bg-opacity-20 rounded-3 p-2 me-3">
                                        <i class="fas fa-check-circle fa-lg text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1 text-success">Berhasil!</h6>
                                        <p class="mb-0 text-success">{{ session('success') }}</p>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($pengaduan->count() > 0)
                        <div class="table-elegant-container">
                            <table class="table table-elegant">
                                <thead class="table-elegant-header">
                                    <tr>
                                        <th class="ps-4">Ticket</th>
                                        <th>Judul & Deskripsi</th>
                                        <th>Pelapor</th>
                                        <th>Lokasi & Barang</th>
                                        <th>Status</th>
                                        <th>Rating</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduan as $l)
                                    <tr class="table-elegant-row">
                                        <!-- Ticket Column -->
                                        <td class="ps-4">
                                            <div class="ticket-info">
                                                <span class="ticket-badge">#{{ $l->ticket_number ?? 'SRP-GEN' }}</span>
                                                <small class="ticket-date d-block text-muted mt-1">
                                                    {{ \Carbon\Carbon::parse($l->created_at)->format('d/m/Y') }}
                                                </small>
                                            </div>
                                        </td>

                                        <!-- Complaint Information -->
                                        <td>
                                            <div class="location-item">
                                                <div class="location-icon">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                </div>
                                                <div class="location-content">
                                                    <h6 class="location-name">{{ $l->nama_pengaduan }}</h6>
                                                    <div class="location-meta">
                                                        <span class="meta-item">
                                                            <i class="fas fa-align-left me-1"></i>
                                                            {{ Str::limit($l->deskripsi, 50) }}
                                                            @if(strlen($l->deskripsi) > 50)
                                                            <span class="read-more" data-desc="{{ $l->deskripsi }}">Baca selengkapnya</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- User Information -->
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    {{ strtoupper(substr($l->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <div class="user-details">
                                                    <div class="user-name">{{ $l->user->name ?? '-' }}</div>
                                                    <div class="user-email">{{ $l->user->email ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Location & Item -->
                                        <td>
                                            <div class="items-container">
                                                <div class="items-list">
                                                    <div class="item-tag">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        <span>{{ $l->lokasi->nama_lokasi ?? '-' }}</span>
                                                    </div>
                                                    <div class="item-tag">
                                                        <i class="fas fa-cube me-1"></i>
                                                        <span>{{ $l->item->nama_item ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>


                                        <!-- Status -->
                                        <td>
                                            <div class="status-container">
                                                @if($l->status == 'Diajukan')
                                                <div class="approval-buttons">
                                                    <button type="button"
                                                            class="btn-approve"
                                                            title="Setujui Pengaduan"
                                                            onclick="updateStatus({{ $l->id_pengaduan }}, 'Diterima')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn-reject"
                                                            title="Tolak Pengaduan"
                                                            onclick="updateStatus({{ $l->id_pengaduan }}, 'Ditolak')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                @endif
                                                <div class="status-badge-elegant status-{{ strtolower($l->status) }}">
                                                    <i class="status-icon fas {{
                                                        $l->status == 'Diterima' ? 'fa-check-circle' :
                                                        ($l->status == 'Ditolak' ? 'fa-times-circle' :
                                                        ($l->status == 'Selesai' ? 'fa-flag-checkered' :
                                                        ($l->status == 'Diajukan' ? 'fa-paper-plane' : 'fa-clock')))
                                                    }}"></i>
                                                    <span>{{ $l->status }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Rating -->
                                        <td>
                                            <div class="rating-display-mini">
                                                @if($l->rating)
                                                    <div class="mini-rating">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $l->rating ? 'text-warning' : 'text-muted' }} fa-xs"></i>
                                                        @endfor
                                                        <small class="rating-score ms-1">{{ $l->rating }}/5</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">Belum dinilai</span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-center pe-4">
                                            <div class="action-container">
                                                <a href="{{ route('admin.pengaduan.show', $l->id_pengaduan) }}"
                                                   class="btn-action btn-view"
                                                   data-bs-toggle="tooltip" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.pengaduan.edit', $l->id_pengaduan) }}"
                                                   class="btn-action btn-edit"
                                                   data-bs-toggle="tooltip" title="Edit Pengaduan">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.pengaduan.destroy', $l->id_pengaduan) }}"
                                                      method="POST"
                                                      class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn-action btn-delete"
                                                            onclick="return confirm('Hapus pengaduan ini?')"
                                                            data-bs-toggle="tooltip" title="Hapus Pengaduan">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer -->
                        <div class="elegant-footer">
                            <div class="footer-text">
                                Menampilkan <strong>{{ $pengaduan->count() }}</strong> pengaduan
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="empty-state-elegant text-center py-5">
                            <div class="empty-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h5>Belum Ada Pengaduan</h5>
                            <p class="text-muted mb-4">
                                Mulai dengan menambahkan pengaduan pertama.
                            </p>
                            <a href="{{ route('admin.pengaduan.create') }}" class="btn btn-primary btn-elegant">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Pengaduan Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk deskripsi lengkap -->
<div class="modal fade" id="descModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal border-0 rounded-4">
            <div class="modal-header bg-transparent border-0">
                <div class="modal-icon-primary bg-primary bg-opacity-10 rounded-3 p-2 me-3">
                    <i class="fas fa-align-left text-primary"></i>
                </div>
                <div>
                    <h5 class="modal-title fw-bold text-dark">Deskripsi Lengkap</h5>
                    <p class="mb-0 text-muted small">Detail pengaduan</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0" id="fullDescription"></p>
            </div>
        </div>
    </div>
</div>



<!-- Section untuk menampilkan permintaan barang dan lokasi baru -->
@php
    $requests = $pengaduan->filter(function ($item) {
        return $item->status === 'Diajukan' && (!empty($item->lokasi_baru) || !empty($item->nama_barang_baru));
    });
@endphp

@if($requests->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <h5>Permintaan Barang dan Lokasi Baru</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Lokasi</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                <tr>
                    <td>{{ $request->nama_barang_baru ?? '-' }}</td>
                    <td>{{ $request->lokasi_baru ?? '-' }}</td>
                    <td>{{ $request->jumlah ?? '-' }}</td>
                    <td>
                        <form action="{{ route('admin.pengaduan.approveRequest', $request->id_pengaduan) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Setujui</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<style>
:root {
    --primary: #4361ee;
    --primary-dark: #3a56d4;
    --secondary: #6c757d;
    --success: #28a745;
    --warning: #ffc107;
    --danger: #dc3545;
    --info: #17a2b8;
    --light: #f8f9fa;
    --dark: #343a40;
    --border-radius: 12px;
    --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Ticket Info */
.ticket-info {
    text-align: center;
}

.ticket-badge {
    font-weight: 600;
    color: var(--primary);
    background: rgba(67, 97, 238, 0.08);
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8rem;
    display: inline-block;
}

.ticket-date {
    font-size: 0.75rem;
}



/* Rating Display Mini */
.rating-display-mini {
    text-align: center;
}

.mini-rating {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.1rem;
}

.rating-score {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--dark);
}

/* Priority Modal Styles */
.priority-options {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.priority-option {
    position: relative;
}

.priority-radio {
    display: none;
}

.priority-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    cursor: pointer;
    transition: var(--transition);
    background: white;
}

.priority-label:hover {
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.priority-radio:checked + .priority-label {
    border-color: var(--primary);
    background: rgba(67, 97, 238, 0.05);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.priority-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.priority-low .priority-icon {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

.priority-medium .priority-icon {
    background: rgba(255, 193, 7, 0.1);
    color: var(--warning);
}

.priority-high .priority-icon {
    background: rgba(253, 126, 20, 0.1);
    color: #fd7e14;
}

.priority-emergency .priority-icon {
    background: rgba(220, 53, 69, 0.1);
    color: var(--danger);
}

.priority-content {
    flex: 1;
}

.priority-content h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.priority-content p {
    font-size: 0.875rem;
    color: var(--secondary);
    margin-bottom: 0;
}

/* New Action Button for Priority */
.btn-priority {
    background: rgba(255, 193, 7, 0.1);
    color: var(--warning);
}

.btn-priority:hover {
    background: var(--warning);
    color: white;
    transform: scale(1.1);
}

/* Update existing styles for new columns */
.table-elegant-header th {
    padding: 1rem 0.75rem;
}

.table-elegant td {
    padding: 1rem 0.75rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .priority-badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.6rem;
    }

    .mini-rating {
        flex-direction: column;
        gap: 0.25rem;
    }

    .priority-label {
        padding: 0.75rem 1rem;
    }

    .priority-content h6 {
        font-size: 0.875rem;
    }

    .priority-content p {
        font-size: 0.8rem;
    }
}

/* Rest of your existing CSS remains the same */
/* Card Styles */
.elegant-card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    background: #ffffff;
    transition: var(--transition);
    overflow: hidden;
}

.elegant-card:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-2px);
}

/* Card Header */
.elegant-card-header {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-bottom: none;
    padding: 1.5rem 2rem;
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
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.header-text h5 {
    color: white;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.header-text p {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 0;
    font-size: 0.875rem;
}

.header-actions {
    display: flex;
    gap: 0.75rem;
}

/* Buttons */
.btn-elegant {
    border-radius: 8px;
    padding: 0.5rem 1.25rem;
    font-weight: 500;
    transition: var(--transition);
    border: none;
}

.btn-primary.btn-elegant {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
}

.btn-primary.btn-elegant:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-1px);
}

.btn-secondary.btn-elegant {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
}

.btn-secondary.btn-elegant:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-1px);
}

/* Statistics Cards */
.stat-card-elegant {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: var(--border-radius);
    padding: 1.75rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    transition: var(--transition);
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    height: 100%;
    min-height: 120px;
}

.stat-card-elegant:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
    flex-shrink: 0;
}

.stat-icon.bg-primary { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); }
.stat-icon.bg-success { background: linear-gradient(135deg, var(--success), #1e7e34); }
.stat-icon.bg-warning { background: linear-gradient(135deg, var(--warning), #e0a800); }
.stat-icon.bg-danger { background: linear-gradient(135deg, var(--danger), #c82333); }
.stat-icon.bg-info { background: linear-gradient(135deg, var(--info), #138496); }
.stat-icon.bg-secondary { background: linear-gradient(135deg, var(--secondary), #5a6268); }

.stat-content {
    flex: 1;
    min-width: 0;
}

.stat-number {
    font-size: 2.25rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 0.5rem;
    line-height: 1;
    letter-spacing: -0.5px;
}

.stat-label {
    color: var(--secondary);
    margin-bottom: 0;
    font-size: 0.95rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Table Styles */
.table-elegant-container {
    border-radius: var(--border-radius);
    overflow: hidden;
    border: 1px solid #e9ecef;
}

.table-elegant {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table-elegant-header th {
    background: var(--light);
    border-bottom: 1px solid #e9ecef;
    font-weight: 600;
    color: var(--dark);
    padding: 1.25rem 1rem;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-elegant-row {
    transition: var(--transition);
    border-bottom: 1px solid #f8f9fa;
}

.table-elegant-row:hover {
    background: rgba(67, 97, 238, 0.02);
    transform: translateX(4px);
}

.table-elegant td {
    padding: 1.25rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #f8f9fa;
}

/* Location Item (Complaint Info) */
.location-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.location-icon {
    width: 48px;
    height: 48px;
    background: rgba(67, 97, 238, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.25rem;
}

.location-content {
    flex: 1;
}

.location-name {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.location-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    color: var(--secondary);
}

.meta-item {
    display: flex;
    align-items: center;
}

.read-more {
    color: var(--primary);
    cursor: pointer;
    font-weight: 500;
    margin-left: 0.25rem;
}

.read-more:hover {
    text-decoration: underline;
}

/* User Info */
.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.user-details {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: 500;
    color: var(--dark);
    font-size: 0.875rem;
    line-height: 1.4;
}

.user-email {
    color: var(--secondary);
    font-size: 0.75rem;
}

/* Items Container */
.items-container {
    min-width: 0;
}

.items-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.item-tag {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
    border: 1px solid rgba(40, 167, 69, 0.2);
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    max-width: 100%;
}

.item-tag span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Status Container */
.status-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.approval-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-approve, .btn-reject {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    font-size: 0.875rem;
}

.btn-approve {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

.btn-approve:hover {
    background: var(--success);
    color: white;
    transform: scale(1.1);
}

.btn-reject {
    background: rgba(220, 53, 69, 0.1);
    color: var(--danger);
}

.btn-reject:hover {
    background: var(--danger);
    color: white;
    transform: scale(1.1);
}

/* Status Badge */
.status-badge-elegant {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-menunggu {
    background: rgba(255, 193, 7, 0.1);
    color: var(--warning);
    border: 1px solid rgba(255, 193, 7, 0.2);
}

.status-diajukan {
    background: rgba(13, 110, 253, 0.1);
    color: var(--primary);
    border: 1px solid rgba(13, 110, 253, 0.2);
}

.status-diterima {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.status-ditolak {
    background: rgba(220, 53, 69, 0.1);
    color: var(--danger);
    border: 1px solid rgba(220, 53, 69, 0.2);
}

.status-selesai {
    background: rgba(23, 162, 184, 0.1);
    color: var(--info);
    border: 1px solid rgba(23, 162, 184, 0.2);
}

/* Action Buttons (Icon Only) */
.action-container {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.btn-action {
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    border: none;
    transition: var(--transition);
    font-size: 0.875rem;
    text-decoration: none;
}

.btn-view {
    background: rgba(23, 162, 184, 0.1);
    color: var(--info);
}

.btn-view:hover {
    background: var(--info);
    color: white;
    transform: scale(1.1);
}

.btn-edit {
    background: rgba(255, 193, 7, 0.1);
    color: var(--warning);
}

.btn-edit:hover {
    background: var(--warning);
    color: white;
    transform: scale(1.1);
}

.btn-delete {
    background: rgba(220, 53, 69, 0.1);
    color: var(--danger);
}

.btn-delete:hover {
    background: var(--danger);
    color: white;
    transform: scale(1.1);
}

/* Alert Modern */
.alert-modern {
    border: none;
    box-shadow: var(--shadow);
}

.alert-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Modal Modern */
.modern-modal {
    border: none;
    box-shadow: var(--shadow-lg);
}

.modal-icon-primary {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Empty State */
.empty-state-elegant {
    padding: 3rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-state-elegant h5 {
    color: var(--secondary);
    margin-bottom: 1rem;
}

/* Footer */
.elegant-footer {
    background: var(--light);
    border-top: 1px solid #e9ecef;
    padding: 1rem 2rem;
    margin-top: 1rem;
    border-radius: 0 0 var(--border-radius) var(--border-radius);
}

.footer-text {
    color: var(--secondary);
    font-size: 0.875rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .elegant-card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem;
    }

    .header-actions {
        width: 100%;
        justify-content: flex-end;
    }

    .table-elegant-container {
        border: 1px solid #e9ecef;
        border-radius: var(--border-radius);
    }

    .table-elegant thead {
        display: none;
    }

    .table-elegant-row {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1.25rem;
        background: white;
    }

    .table-elegant td {
        display: block;
        text-align: left;
        border: none;
        padding: 0.75rem 0;
        position: relative;
    }

    .table-elegant td:before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--primary);
        display: block;
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
    }

    .action-container {
        justify-content: flex-start;
    }

    .location-item {
        justify-content: flex-start;
    }

    .location-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }

    .user-info {
        justify-content: flex-start;
    }

    .status-container {
        align-items: flex-start;
    }

    .approval-buttons {
        justify-content: flex-start;
    }

    .stat-card-elegant {
        text-align: center;
        flex-direction: column;
        padding: 1.5rem 1rem;
    }

    .stat-icon {
        margin: 0 auto;
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }

    .stat-number {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .header-actions {
        flex-direction: column;
        width: 100%;
    }

    .btn-elegant {
        width: 100%;
        justify-content: center;
    }

    .action-container {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-action {
        width: 100%;
        height: auto;
        padding: 0.75rem;
    }

    .stat-card-elegant {
        padding: 1.25rem 1rem;
    }

    .stat-number {
        font-size: 1.75rem;
    }

    .stat-label {
        font-size: 0.875rem;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Tambahkan data-label untuk responsive table
    const tableHeaders = ['Ticket', 'Judul & Deskripsi', 'Pelapor', 'Lokasi & Barang', 'Prioritas', 'Status', 'Rating', 'Aksi'];
    document.querySelectorAll('.table-elegant-row').forEach(row => {
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, index) => {
            cell.setAttribute('data-label', tableHeaders[index]);
        });
    });

    // Handle read more for descriptions
    document.querySelectorAll('.read-more').forEach(link => {
        link.addEventListener('click', function() {
            const fullDesc = this.getAttribute('data-desc');
            showDescriptionModal(fullDesc);
        });
    });

    // Animasi untuk stat cards
    const statCards = document.querySelectorAll('.stat-card-elegant');
    statCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('animate__animated', 'animate__fadeInUp');
    });

    // Animasi untuk table rows
    const tableRows = document.querySelectorAll('.table-elegant-row');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
        row.classList.add('animate__animated', 'animate__fadeIn');
    });

    // Handle priority form submission
    const priorityForm = document.getElementById('priorityForm');
    if (priorityForm) {
        priorityForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updatePriority();
        });
    }
});

function showDescriptionModal(description) {
    const modal = new bootstrap.Modal(document.getElementById('descModal'));
    const descElement = document.getElementById('fullDescription');

    descElement.textContent = description;
    modal.show();
}

function showPriorityModal(pengaduanId, currentPriority) {
    // Set pengaduan ID
    document.getElementById('priorityPengaduanId').value = pengaduanId;

    // Set current priority
    const radioButtons = document.querySelectorAll('.priority-radio');
    radioButtons.forEach(radio => {
        radio.checked = radio.value === currentPriority;
    });

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('priorityModal'));
    modal.show();
}

function updatePriority() {
    const pengaduanId = document.getElementById('priorityPengaduanId').value;
    const selectedPriority = document.querySelector('input[name="priority"]:checked');

    if (!selectedPriority) {
        showToast('Pilih prioritas terlebih dahulu!', 'error');
        return;
    }

    const priorityValue = selectedPriority.value;
    const formData = new FormData(document.getElementById('priorityForm'));

    // Show loading state
    const submitBtn = document.querySelector('#priorityForm button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div> Menyimpan...';
    submitBtn.disabled = true;

    fetch(`/admin/pengaduan/${pengaduanId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update UI
            updatePriorityUI(pengaduanId, priorityValue);
            showToast('Prioritas berhasil diupdate!', 'success');

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('priorityModal'));
            modal.hide();
        } else {
            throw new Error(data.message || 'Update failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Gagal mengupdate prioritas! Silakan coba lagi.', 'error');
    })
    .finally(() => {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function updatePriorityUI(pengaduanId, priority) {
    const row = document.querySelector(`button[onclick*="showPriorityModal(${pengaduanId},"]`)?.closest('.table-elegant-row');
    if (!row) return;

    const priorityCell = row.querySelector('.priority-badge');
    if (priorityCell) {
        // Update priority badge
        priorityCell.className = `priority-badge priority-${priority}`;

        // Update text
        let priorityText = 'Sedang';
        if (priority === 'low') priorityText = 'Rendah';
        else if (priority === 'medium') priorityText = 'Sedang';
        else if (priority === 'high') priorityText = 'Tinggi';
        else if (priority === 'emergency') priorityText = 'Emergency';

        priorityCell.innerHTML = `<i class="fas fa-flag me-1"></i>${priorityText}`;
    }
}

// Your existing functions (updateStatus, showToast, etc.) remain the same
function updateStatus(pengaduanId, status) {
    // Show loading state
    const row = document.querySelector(`button[onclick*="updateStatus(${pengaduanId},"]`)?.closest('.table-elegant-row');

    if (!row) {
        console.error('Row not found for pengaduan ID:', pengaduanId);
        showToast('Gagal menemukan data pengaduan!', 'error');
        return;
    }

    const statusCell = row.querySelector('.status-container');
    const originalContent = statusCell.innerHTML;

    // Show loading state
    statusCell.innerHTML = `
        <div class="status-badge-elegant status-menunggu">
            <i class="status-icon fas fa-spinner fa-spin"></i>
            <span>Memproses...</span>
        </div>
    `;

    // Prepare form data
    const formData = new FormData();
    formData.append('status', status);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');

    // Send AJAX request
    fetch(`/admin/pengaduan/${pengaduanId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update UI immediately
            updateStatusUI(pengaduanId, status, row);
            showToast('Status berhasil diupdate!', 'success');

            // Update statistics without page reload
            updateStatistics(status);

        } else {
            throw new Error(data.message || 'Update failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        statusCell.innerHTML = originalContent;
        showToast('Gagal mengupdate status! Silakan coba lagi.', 'error');
    });
}

function updateStatusUI(pengaduanId, status, row) {
    const statusCell = row.querySelector('.status-container');

    const statusClass = `status-${status.toLowerCase()}`;
    const statusIcon = status === 'Diterima' ? 'fa-check-circle' :
                    status === 'Ditolak' ? 'fa-times-circle' :
                    status === 'Selesai' ? 'fa-flag-checkered' :
                    status === 'Diajukan' ? 'fa-paper-plane' : 'fa-clock';

    // Remove approval buttons if status is changed from 'Diajukan'
    if (status !== 'Diajukan') {
        statusCell.innerHTML = `
            <div class="status-badge-elegant ${statusClass}">
                <i class="status-icon fas ${statusIcon}"></i>
                <span>${status}</span>
            </div>
        `;
    } else {
        // Keep approval buttons if status is still 'Diajukan'
        statusCell.innerHTML = `
            <div class="approval-buttons">
                <button type="button"
                        class="btn-approve"
                        title="Setujui Pengaduan"
                        onclick="updateStatus(${pengaduanId}, 'Diterima')">
                    <i class="fas fa-check"></i>
                </button>
                <button type="button"
                        class="btn-reject"
                        title="Tolak Pengaduan"
                        onclick="updateStatus(${pengaduanId}, 'Ditolak')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="status-badge-elegant ${statusClass}">
                <i class="status-icon fas ${statusIcon}"></i>
                <span>${status}</span>
            </div>
        `;
    }
}

function updateStatistics(updatedStatus) {
    // Update statistics counters without page reload
    const statCards = document.querySelectorAll('.stat-card-elegant');

    statCards.forEach(card => {
        const labelElement = card.querySelector('.stat-label');
        if (labelElement) {
            const label = labelElement.textContent.trim();

            if (label === 'Total Pengaduan') {
                // Total usually doesn't change when updating status
                return;
            }

            if (label === 'Diterima' && updatedStatus === 'Diterima') {
                incrementCounter(card.querySelector('.stat-number'));
            }
            else if (label === 'Ditolak' && updatedStatus === 'Ditolak') {
                incrementCounter(card.querySelector('.stat-number'));
            }
            else if (label === 'Selesai' && updatedStatus === 'Selesai') {
                incrementCounter(card.querySelector('.stat-number'));
            }
            // Handle decrementing 'Diajukan' counter when status changes
            else if (label === 'Diajukan' && (updatedStatus === 'Diterima' || updatedStatus === 'Ditolak')) {
                decrementCounter(card.querySelector('.stat-number'));
            }
        }
    });
}

function incrementCounter(element) {
    if (!element) return;

    const currentValue = parseInt(element.textContent);
    const newValue = currentValue + 1;

    // Simple animation for counter update
    element.style.transform = 'scale(1.2)';
    element.style.color = 'var(--success)';

    setTimeout(() => {
        element.textContent = newValue;
        element.style.transform = 'scale(1)';
        element.style.color = '';
    }, 300);
}

function decrementCounter(element) {
    if (!element) return;

    const currentValue = parseInt(element.textContent);
    const newValue = Math.max(0, currentValue - 1);

    // Simple animation for counter update
    element.style.transform = 'scale(0.8)';
    element.style.color = 'var(--danger)';

    setTimeout(() => {
        element.textContent = newValue;
        element.style.transform = 'scale(1)';
        element.style.color = '';
    }, 300);
}

function showToast(message, type = 'success') {
    // Remove existing toasts
    const existingToasts = document.querySelectorAll('.custom-toast');
    existingToasts.forEach(toast => toast.remove());

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `alert-modern alert-${type} border-0 rounded-4 p-4 custom-toast`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
        min-width: 300px;
        animation: slideInRight 0.5s ease;
    `;

    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    const bgColor = type === 'success' ? 'var(--success)' : 'var(--danger)';
    const textColor = type === 'success' ? 'var(--success)' : 'var(--danger)';

    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <div class="alert-icon rounded-3 p-2 me-3" style="background: ${bgColor}20;">
                <i class="fas ${icon} fa-lg" style="color: ${textColor};"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="fw-bold mb-1" style="color: ${textColor};">${type === 'success' ? 'Berhasil!' : 'Error!'}</h6>
                <p class="mb-0" style="color: ${textColor};">${message}</p>
            </div>
            <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;

    document.body.appendChild(toast);

    // Auto remove after 4 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 4000);
}

// Add CSS animation for toast
if (!document.querySelector('#toast-animations')) {
    const style = document.createElement('style');
    style.id = 'toast-animations';
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .custom-toast {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
    `;
    document.head.appendChild(style);
}
</script>
@endpush
@endsection
