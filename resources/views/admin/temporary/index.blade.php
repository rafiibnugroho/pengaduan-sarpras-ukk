@extends('layouts.admin')

@section('title', 'Request Barang/Lokasi Baru - ' . config('app.name'))

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
                            <h5 class="mb-1">Request Barang/Lokasi Baru</h5>
                            <p class="mb-0 opacity-75">Kelola permintaan barang dan lokasi baru dari pengguna</p>
                        </div>
                    </div>
                    <div class="header-actions">
                        <button class="btn btn-primary btn-elegant" id="refreshBtn">
                            <i class="fas fa-sync-alt me-2"></i> Refresh
                        </button>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="card-body">
                    @php
                        $stats = [
                            ['count' => $requests->count(), 'label' => 'Total Request', 'icon' => 'fas fa-inbox', 'color' => 'primary'],
                            ['count' => $requests->where('status', 'pending')->count(), 'label' => 'Pending', 'icon' => 'fas fa-clock', 'color' => 'warning'],
                        ];
                    @endphp

                    <div class="row mb-4">
                        @foreach($stats as $stat)
                        <div class="col-xl-6 col-md-6 mb-3">
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

    @if($requests->count() > 0)
    <!-- Modern Table Section -->
    <div class="row">
        <div class="col-12">
            <div class="card modern-card border-0 rounded-4">
                <div class="card-header-modern bg-transparent border-0 d-flex justify-content-between align-items-center pb-3">
                    <div>
                        <h5 class="card-title fw-bold mb-1 fs-5">
                            <i class="fas fa-list text-primary me-2"></i>
                            Daftar Request
                        </h5>
                        <p class="text-muted mb-0">Total {{ $requests->count() }} permintaan barang dan lokasi</p>
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
                                            <span>User</span>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="d-flex align-items-center">
                                            <span>Jenis Request</span>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="d-flex align-items-center">
                                            <span>Status</span>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="d-flex align-items-center">
                                            <span>Tanggal</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="modern-table-body">
                                @foreach($requests as $r)
                                <tr class="modern-table-row">
                                    <td class="ps-4">
                                        <div class="id-badge-modern">
                                            <span class="id-prefix">#</span>
                                            <span class="id-number">{{ $r->id_temp }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item-info-modern">
                                            <div class="item-icon-modern bg-primary bg-opacity-10 rounded-3 p-2 me-3">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div class="item-details-modern">
                                                <div class="item-name-modern fw-semibold">{{ $r->user->name }}</div>
                                                <div class="item-meta-modern text-muted small">
                                                    <i class="fas fa-envelope me-1"></i>
                                                    ID: {{ $r->user->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="request-details-modern">
                                            @if($r->nama_barang_baru)
                                            <div class="request-item-modern mb-2">
                                                <div class="request-type-badge bg-info bg-opacity-10 rounded-2 px-2 py-1 d-inline-flex align-items-center">
                                                    <i class="fas fa-box text-info me-1" style="font-size: 0.7rem;"></i>
                                                    <span class="text-info fw-semibold" style="font-size: 0.75rem;">ITEM BARU</span>
                                                </div>
                                                <div class="request-content mt-1">
                                                    {{ $r->nama_barang_baru }}
                                                </div>
                                            </div>
                                            @endif
                                            @if($r->lokasi_baru)
                                            <div class="request-item-modern">
                                                <div class="request-type-badge bg-warning bg-opacity-10 rounded-2 px-2 py-1 d-inline-flex align-items-center">
                                                    <i class="fas fa-map-marker-alt text-warning me-1" style="font-size: 0.7rem;"></i>
                                                    <span class="text-warning fw-semibold" style="font-size: 0.75rem;">LOKASI BARU</span>
                                                </div>
                                                <div class="request-content mt-1">
                                                    {{ $r->lokasi_baru }}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = 'status-pending';
                                            $statusIcon = 'fas fa-clock';
                                            if($r->status == 'approved') {
                                                $statusClass = 'status-approved';
                                                $statusIcon = 'fas fa-check-circle';
                                            } elseif($r->status == 'rejected') {
                                                $statusClass = 'status-rejected';
                                                $statusIcon = 'fas fa-times-circle';
                                            }
                                        @endphp
                                        <div class="status-badge-modern {{ $statusClass }} rounded-3 px-3 py-2 d-inline-flex align-items-center">
                                            <i class="{{ $statusIcon }} me-2" style="font-size: 0.8rem;"></i>
                                            <span class="fw-semibold" style="font-size: 0.8rem;">{{ ucfirst($r->status) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-info-modern">
                                            <div class="date-main fw-semibold">{{ $r->created_at->format('d M Y') }}</div>
                                            <div class="date-time text-muted small">{{ $r->created_at->format('H:i') }}</div>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer-modern bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan <strong>{{ $requests->count() }}</strong> dari <strong>{{ $requests->count() }}</strong> request
                        </div>
                        <div class="text-muted small">
                            Terakhir diperbarui: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="empty-state-elegant text-center py-5">
        <div class="empty-icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <h5>Belum Ada Request</h5>
        <p class="text-muted mb-4">
            Belum ada permintaan barang atau lokasi baru dari pengguna.
        </p>
    </div>
    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Design System - Same as your items table */
:root {
    --primary-color: #3B82F6;
    --success-color: #10B981;
    --warning-color: #F59E0B;
    --danger-color: #EF4444;
    --dark-color: #374151;
    --border-radius: 16px;
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
    --shadow-md: 0 8px 25px rgba(0, 0, 0, 0.12);
    --shadow-lg: 0 12px 35px rgba(0, 0, 0, 0.15);
}

/* Elegant Card Styles (same as your items) */
.elegant-card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-sm);
    background: #ffffff;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.elegant-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

/* Card Header */
.elegant-card-header {
    background: linear-gradient(135deg, var(--primary-color), #1D4ED8);
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
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

/* Statistics Cards */
.stat-card-elegant {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: var(--border-radius);
    padding: 1.75rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

.stat-icon.bg-primary {
    background: linear-gradient(135deg, var(--primary-color), #1D4ED8);
}

.stat-icon.bg-warning {
    background: linear-gradient(135deg, var(--warning-color), #D97706);
}

.stat-content {
    flex: 1;
    min-width: 0;
}

.stat-number {
    font-size: 2.25rem;
    font-weight: 800;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
    line-height: 1;
    letter-spacing: -0.5px;
}

.stat-label {
    color: #6c757d;
    margin-bottom: 0;
    font-size: 0.95rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Empty State Elegant */
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
    color: #6c757d;
    margin-bottom: 1rem;
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

/* Card Header Modern */
.card-header-modern {
    padding: 1.5rem 1.5rem 1rem;
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

/* Item Info Modern */
.item-info-modern {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.item-icon-modern {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.modern-table-row:hover .item-icon-modern {
    transform: scale(1.1);
}

.item-details-modern {
    flex: 1;
    min-width: 0;
}

.item-name-modern {
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
    color: var(--dark-color);
}

.item-meta-modern {
    font-size: 0.75rem;
}

/* Request Details Modern */
.request-details-modern {
    max-width: 250px;
}

.request-item-modern:not(:last-child) {
    margin-bottom: 1rem;
}

.request-type-badge {
    font-size: 0.7rem;
    font-weight: 600;
}

.request-content {
    font-size: 0.85rem;
    color: var(--dark-color);
    line-height: 1.4;
}

/* Status Badge Modern */
.status-badge-modern {
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.status-pending {
    background: rgba(245, 158, 11, 0.1);
    color: #D97706;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.status-approved {
    background: rgba(16, 185, 129, 0.1);
    color: #047857;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.status-rejected {
    background: rgba(239, 68, 68, 0.1);
    color: #DC2626;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

/* Date Info Modern */
.date-info-modern {
    text-align: left;
}

.date-main {
    font-size: 0.9rem;
    color: var(--dark-color);
}

.date-time {
    font-size: 0.75rem;
}

/* Action Buttons Modern */
.action-buttons-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
}

.btn-action-edit-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.btn-action-edit-modern:hover {
    background: #3B82F6;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.action-text {
    font-size: 0.75rem;
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
    color: var(--dark-color);
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-action:hover {
    background: #3B82F6;
    color: white;
    transform: translateY(-1px);
}

/* Card Footer Modern */
.card-footer-modern {
    padding: 1rem 1.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

/* Alert Modern */
.alert-modern {
    border: none;
    box-shadow: var(--shadow-sm);
}

.alert-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }

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

    .card-header-modern {
        padding: 1.5rem 1rem 1rem;
    }

    .card-header-modern .d-flex {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .table-actions {
        width: 100%;
        justify-content: center;
    }

    .modern-table-header {
        display: none;
    }

    .modern-table-row {
        display: block;
        margin-bottom: 1rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        padding: 1rem;
    }

    .modern-table-row td {
        display: block;
        text-align: left;
        border: none;
        padding: 0.75rem 0;
        position: relative;
    }

    .modern-table-row td::before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--dark-color);
        margin-right: 0.5rem;
        text-transform: uppercase;
        font-size: 0.75rem;
        display: block;
        margin-bottom: 0.25rem;
    }

    .action-buttons-modern {
        justify-content: flex-start;
        margin-top: 0.5rem;
    }

    /* Responsive data labels */
    .modern-table-row td:nth-child(1)::before { content: "ID: "; }
    .modern-table-row td:nth-child(2)::before { content: "USER: "; }
    .modern-table-row td:nth-child(3)::before { content: "JENIS REQUEST: "; }
    .modern-table-row td:nth-child(4)::before { content: "STATUS: "; }
    .modern-table-row td:nth-child(5)::before { content: "TANGGAL: "; }

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

    .action-buttons-modern {
        flex-direction: column;
        align-items: flex-start;
    }

    .btn-action-edit-modern {
        width: 100%;
        justify-content: center;
    }

    .item-info-modern {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .item-details-modern {
        text-align: center;
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

/* Animation for table rows */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modern-table-row {
    animation: slideIn 0.5s ease;
}

.modern-table-row:nth-child(1) { animation-delay: 0.1s; }
.modern-table-row:nth-child(2) { animation-delay: 0.2s; }
.modern-table-row:nth-child(3) { animation-delay: 0.3s; }
.modern-table-row:nth-child(4) { animation-delay: 0.4s; }
.modern-table-row:nth-child(5) { animation-delay: 0.5s; }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Refresh button functionality
    const refreshBtn = document.getElementById('refreshBtn');
    refreshBtn.addEventListener('click', function() {
        this.querySelector('i').className = 'fas fa-spinner fa-spin';
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.modern-table-row');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Add smooth animations to table rows
    const tableRows = document.querySelectorAll('.modern-table-row');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        row.style.transition = 'all 0.5s ease';

        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Add responsive data labels
    tableRows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const labels = ['ID', 'User', 'Jenis Request', 'Status', 'Tanggal', 'Aksi'];
        cells.forEach((cell, index) => {
            cell.setAttribute('data-label', labels[index]);
        });
    });
});
</script>
@endpush
@endsection
