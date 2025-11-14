@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card elegant-card">
                <div class="card-header elegant-card-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="header-text">
                            <h5 class="mb-1">Manajemen Pengguna</h5>
                            <p class="mb-0 opacity-75">Kelola semua akun pengguna sistem</p>
                        </div>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-elegant">
                            <i class="fas fa-plus me-2"></i> Tambah User
                        </a>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="card-body">
                    @php
                        $stats = [
                            ['count' => $users->where('role', 'admin')->count(), 'label' => 'Administrator', 'icon' => 'fas fa-user-shield', 'color' => 'danger'],
                            ['count' => $users->where('role', 'petugas')->count(), 'label' => 'Petugas', 'icon' => 'fas fa-user-cog', 'color' => 'warning'],
                            ['count' => \App\Models\User::where('role', 'pengguna')->count(), 'label' => 'Pengguna', 'icon' => 'fas fa-user', 'color' => 'secondary'],
                            ['count' => $users->count(), 'label' => 'Total Pengguna', 'icon' => 'fas fa-chart-line', 'color' => 'primary'],
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
                                    <div class=" bg-success bg-opacity-20 rounded-3 p-2 me-3">
                                        
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

                    @if($users->count() > 0)
                        <div class="table-elegant-container">
                            <table class="table table-elegant">
                                <thead class="table-elegant-header">
                                    <tr>
                                        <th class="ps-4">ID</th>
                                        <th>Informasi Pengguna</th>
                                        <th>Email</th>
                                        <th>Role</th>

                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr class="table-elegant-row">
                                        <!-- ID Column -->
                                        <td class="ps-4">
                                            <span class="id-badge">#{{ $user->id }}</span>
                                        </td>

                                        <!-- User Information -->
                                        <td>
                                            <div class="location-item">
                                                <div class="location-icon">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div class="location-content">
                                                    <h6 class="location-name">{{ $user->name }}</h6>
                                                    <div class="location-meta">
                                                        <span class="meta-item">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            Bergabung {{ $user->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Email -->
                                        <td>
                                            <div class="user-email-info">
                                                <i class="fas fa-envelope me-2 text-muted"></i>
                                                <span>{{ $user->email }}</span>
                                            </div>
                                        </td>

                                        <!-- Role -->
                                        <td>
                                            <div class="role-badge role-{{ $user->role }}">
                                                <i class="fas fa-{{ $user->role == 'admin' ? 'user-shield' : ($user->role == 'petugas' ? 'user-cog' : 'user') }} me-1"></i>
                                                {{ ucfirst($user->role) }}
                                            </div>
                                        </td>



                                        <!-- Actions -->
                                        <td class="text-center pe-4">
                                            <div class="action-buttons-modern">
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                   class="btn-action-edit-modern"
                                                   title="Edit User">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="action-text">Edit</span>
                                                </a>
                                                <a href="{{ route('admin.users.show', $user->id) }}"
                                                   class="btn-action-view-modern"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                    <span class="action-text">Lihat</span>
                                                </a>
                                                <button class="btn-action-delete-modern"
                                                        onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                                        title="Hapus User">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="action-text">Hapus</span>
                                                </button>
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
                                Menampilkan <strong>{{ $users->count() }}</strong> pengguna
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="empty-state-elegant text-center py-5">
                            <div class="empty-icon">
                                <i class="fas fa-users-slash"></i>
                            </div>
                            <h5>Belum Ada Pengguna</h5>
                            <p class="text-muted mb-4">
                                Mulai dengan menambahkan pengguna pertama.
                            </p>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-elegant">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Pengguna Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal border-0 rounded-4">
            <div class="modal-header bg-transparent border-0">
                <div class="modal-icon-danger bg-danger bg-opacity-10 rounded-3 p-2 me-3">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                </div>
                <div>
                    <h5 class="modal-title fw-bold text-dark">Konfirmasi Hapus</h5>
                    <p class="mb-0 text-muted small">Tindakan ini tidak dapat dibatalkan</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0" id="deleteMessage"></p>
            </div>
            <div class="modal-footer bg-transparent border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

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

/* ID Badge */
.id-badge {
    font-weight: 600;
    color: var(--primary);
    background: rgba(67, 97, 238, 0.08);
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8rem;
    display: inline-block;
}

/* Location Item (User Info) */
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
    font-weight: 600;
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

.meta-divider {
    color: #dee2e6;
}

/* User Email Info */
.user-email-info {
    display: flex;
    align-items: center;
    color: var(--secondary);
    font-size: 0.9rem;
}

/* Role Badges */
.role-badge {
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.role-admin {
    background: rgba(220, 53, 69, 0.1);
    color: var(--danger);
    border: 1px solid rgba(220, 53, 69, 0.2);
}

.role-petugas {
    background: rgba(255, 193, 7, 0.1);
    color: var(--warning);
    border: 1px solid rgba(255, 193, 7, 0.2);
}

.role-pengguna {
    background: rgba(108, 117, 125, 0.1);
    color: var(--secondary);
    border: 1px solid rgba(108, 117, 125, 0.2);
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

.status-active {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.status-inactive {
    background: rgba(108, 117, 125, 0.1);
    color: var(--secondary);
    border: 1px solid rgba(108, 117, 125, 0.2);
}

/* Action Buttons Modern */
.action-buttons-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
}

.btn-action-edit-modern,
.btn-action-delete-modern,
.btn-action-view-modern {
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
}

.btn-action-edit-modern {
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

.btn-action-delete-modern {
    background: rgba(239, 68, 68, 0.1);
    color: #EF4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.btn-action-delete-modern:hover {
    background: #EF4444;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-action-view-modern {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.btn-action-view-modern:hover {
    background: #10B981;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.action-text {
    font-size: 0.75rem;
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

.modal-icon-danger {
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

    .action-buttons-modern {
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

    .meta-divider {
        display: none;
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

    .action-buttons-modern {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-action-edit-modern,
    .btn-action-delete-modern,
    .btn-action-view-modern {
        width: 100%;
        height: auto;
        padding: 0.75rem;
        justify-content: center;
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
    const tableHeaders = ['ID', 'Informasi Pengguna', 'Email', 'Role', 'Status', 'Aksi'];
    document.querySelectorAll('.table-elegant-row').forEach(row => {
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, index) => {
            cell.setAttribute('data-label', tableHeaders[index]);
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
});

// Delete confirmation function
function confirmDelete(userId, userName) {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    const deleteMessage = document.getElementById('deleteMessage');

    deleteMessage.textContent = `Apakah Anda yakin ingin menghapus pengguna "${userName}"? Tindakan ini tidak dapat dibatalkan.`;
    deleteForm.action = `/admin/users/${userId}`;

    deleteModal.show();
}
</script>
@endpush
@endsection
