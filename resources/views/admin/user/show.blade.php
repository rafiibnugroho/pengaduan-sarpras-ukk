@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div class="header-content">
                    <div class="d-flex align-items-center">
                        <div class="header-icon-wrapper bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-user-circle text-primary fs-2"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold text-dark mb-1">Detail Pengguna</h2>
                            <p class="text-muted mb-0">Informasi lengkap tentang pengguna sistem</p>
                        </div>
                    </div>
                </div>
               
            </div>

            <!-- Main Content -->
            <div class="row g-4">
                <!-- Left Column - User Profile -->
                <div class="col-12 col-lg-4">
                    <!-- Profile Card -->
                    <div class="card modern-profile-card mb-4">
                        <div class="card-body text-center p-4">
                            <div class="profile-avatar-wrapper mb-3">
                                <div class="profile-avatar bg-primary bg-opacity-10">
                                    <i class="fas fa-user text-primary fs-1"></i>
                                </div>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">{{ $user->name }}</h4>
                            <div class="role-badge mb-3">
                                <span class="badge rounded-pill bg-{{ $user->role == 'admin' ? 'primary' : ($user->role == 'petugas' ? 'info' : 'secondary') }} px-3 py-2">
                                    <i class="fas fa-user-tag me-1"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            <p class="text-muted mb-0">
                                <i class="fas fa-envelope me-2"></i>
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card modern-actions-card">
                        <div class="card-header bg-transparent border-bottom">
                            <h6 class="mb-0 fw-semibold">
                                <i class="fas fa-bolt me-2 text-warning"></i>
                                Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary btn-modern">
                                    <i class="fas fa-edit me-2"></i> Edit Pengguna
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - User Details -->
                <div class="col-12 col-lg-8">
                    <!-- User Information Card -->
                    <div class="card modern-detail-card">
                        <div class="card-header modern-card-header">
                            <h5 class="mb-0 text-white">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Detail
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Personal Information -->
                                <div class="col-12">
                                    <h6 class="section-title mb-3">
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        Informasi Pribadi
                                    </h6>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <div class="detail-label">
                                            <i class="fas fa-id-card text-primary me-2"></i>
                                            Nama Lengkap
                                        </div>
                                        <div class="detail-value fw-semibold">{{ $user->name }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <div class="detail-label">
                                            <i class="fas fa-envelope text-danger me-2"></i>
                                            Alamat Email
                                        </div>
                                        <div class="detail-value">
                                            {{ $user->email }}
                                            <span class="verification-badge verified ms-2">
                                                <i class="fas fa-check-circle"></i> Terverifikasi
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Information -->
                                <div class="col-12 mt-4">
                                    <h6 class="section-title mb-3">
                                        <i class="fas fa-shield-alt me-2 text-warning"></i>
                                        Informasi Akun
                                    </h6>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <div class="detail-label">
                                            <i class="fas fa-user-tag text-warning me-2"></i>
                                            Role Akun
                                        </div>
                                        <div class="detail-value">
                                            <span class="role-display badge bg-{{ $user->role == 'admin' ? 'primary' : ($user->role == 'petugas' ? 'info' : 'secondary') }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Timestamps -->
                                <div class="col-12 mt-4">
                                    <h6 class="section-title mb-3">
                                        <i class="fas fa-history me-2 text-secondary"></i>
                                        Riwayat Sistem
                                    </h6>
                                </div>

                                <div class="col-12">
                                    <div class="detail-item">
                                        <div class="detail-label">
                                            <i class="fas fa-calendar-plus text-success me-2"></i>
                                            Akun Dibuat
                                        </div>
                                        <div class="detail-value">
                                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}</div>
                                        </div>
                                    </div>
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

    /* Header Styles */
    .header-icon-wrapper {
        transition: var(--transition);
    }

    .header-icon-wrapper:hover {
        transform: scale(1.05);
        background: rgba(67, 97, 238, 0.15) !important;
    }

    /* Modern Cards */
    .modern-profile-card,
    .modern-detail-card,
    .modern-actions-card {
        border: none;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
        background: white;
        height: fit-content;
    }

    .modern-profile-card:hover,
    .modern-detail-card:hover,
    .modern-actions-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .modern-card-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-bottom: none;
        padding: 1.25rem 1.5rem;
        border-radius: var(--radius) var(--radius) 0 0 !important;
    }

    /* Profile Avatar */
    .profile-avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid white;
        box-shadow: var(--shadow);
    }

    /* Detail Items */
    .detail-item {
        padding: 1rem;
        background: var(--light);
        border-radius: 8px;
        border: 1px solid var(--border);
        transition: var(--transition);
    }

    .detail-item:hover {
        background: white;
        border-color: var(--primary);
        transform: translateX(5px);
    }

    .detail-label {
        font-size: 0.875rem;
        color: var(--secondary);
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .detail-value {
        color: var(--dark);
        font-size: 1rem;
    }

    /* Section Titles */
    .section-title {
        color: var(--dark);
        font-weight: 600;
        font-size: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-light);
        display: flex;
        align-items: center;
    }

    /* Badges */
    .verification-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .verification-badge.verified {
        background: var(--primary-light);
        color: var(--primary);
    }

    .role-display {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }

    /* Buttons */
    .btn-modern {
        border-radius: 8px;
        padding: 0.75rem 1.25rem;
        font-weight: 500;
        transition: var(--transition);
        border: 2px solid transparent;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-outline-secondary.btn-modern {
        border-color: var(--border);
        color: var(--secondary);
    }

    .btn-outline-secondary.btn-modern:hover {
        background: var(--light);
        border-color: var(--secondary);
        transform: translateY(-2px);
    }

    .btn-outline-primary.btn-modern {
        border-color: var(--primary);
        color: var(--primary);
    }

    .btn-outline-primary.btn-modern:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .header-content {
            text-align: center;
            margin-bottom: 1rem;
        }

        .header-actions {
            width: 100%;
        }

        .btn-modern {
            width: 100%;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
        }

        .profile-avatar i {
            font-size: 1.5rem !important;
        }
    }

    @media (max-width: 576px) {
        .detail-item {
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 0.9rem;
        }
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations
    const cards = document.querySelectorAll('.modern-profile-card, .modern-detail-card, .modern-actions-card');

    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Add click effects to detail items
    const detailItems = document.querySelectorAll('.detail-item');
    detailItems.forEach(item => {
        item.addEventListener('click', function() {
            this.style.transform = 'translateX(10px)';
            setTimeout(() => {
                this.style.transform = 'translateX(5px)';
            }, 150);
        });
    });
});
</script>
@endpush
@endsection
