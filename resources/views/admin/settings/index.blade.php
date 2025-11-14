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
                            <i class="fas fa-user-cog text-primary fs-2"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold text-dark mb-1">Pengaturan Administrator</h2>
                            <p class="text-muted mb-0">Kelola informasi akun dan keamanan sistem</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Main Content -->
            <div class="row g-4">
                <!-- Left Column - Navigation & Profile -->
                <div class="col-12 col-lg-4">
                    <!-- Profile Card -->
                    <div class="card modern-profile-card mb-4">
                        <div class="card-body text-center p-4">
                            <div class="profile-avatar-wrapper mb-3">
                                <div class="profile-avatar bg-primary bg-opacity-10">
                                    <i class="fas fa-user-shield text-primary fs-1"></i>
                                </div>
                                <div class="online-status online"></div>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">{{ auth()->user()->name }}</h4>
                            <div class="role-badge mb-3">
                                <span class="badge rounded-pill bg-primary px-3 py-2">
                                    <i class="fas fa-crown me-1"></i>
                                    Administrator
                                </span>
                            </div>
                            <p class="text-muted mb-0">
                                <i class="fas fa-envelope me-2"></i>
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>

                    <!-- Navigation Tabs -->
                    <div class="card modern-nav-card">
                        <div class="card-body p-3">
                            <div class="nav-tabs-vertical">
                                <button class="nav-tab-vertical active" data-tab="profile">
                                    <div class="nav-icon">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div class="nav-content">
                                        <div class="nav-title">Profil Admin</div>
                                        <div class="nav-subtitle">Informasi pribadi</div>
                                    </div>
                                    <i class="nav-arrow fas fa-chevron-right"></i>
                                </button>
                                <button class="nav-tab-vertical" data-tab="security">
                                    <div class="nav-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div class="nav-content">
                                        <div class="nav-title">Keamanan</div>
                                        <div class="nav-subtitle">Password & akses</div>
                                    </div>
                                    <i class="nav-arrow fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Content -->
                <div class="col-12 col-lg-8">
                    <!-- Profile Tab Content -->
                    <div class="tab-content active" id="profile-tab">
                        <div class="card modern-content-card">
                            <div class="card-header modern-card-header">
                                <h5 class="mb-0 text-white">
                                    <i class="fas fa-user-cog me-2"></i>
                                    Informasi Profil Administrator
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="content-section">
                                    <h6 class="section-title mb-4">
                                        <i class="fas fa-id-card me-2 text-primary"></i>
                                        Data Pribadi
                                    </h6>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-user text-primary me-2"></i>
                                                    Nama Lengkap
                                                </div>
                                                <div class="info-value">{{ auth()->user()->name }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-envelope text-danger me-2"></i>
                                                    Alamat Email
                                                </div>
                                                <div class="info-value">
                                                    {{ auth()->user()->email }}

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="content-section mt-4">
                                    <h6 class="section-title mb-4">
                                        <i class="fas fa-user-tie me-2 text-warning"></i>
                                        Informasi Akun
                                    </h6>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-user-tag text-warning me-2"></i>
                                                    Role Akun
                                                </div>
                                                <div class="info-value">
                                                    <span class="role-badge-sm bg-primary">Administrator</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-key text-success me-2"></i>
                                                    Status Akun
                                                </div>
                                                <div class="info-value">
                                                    <span class="status-badge active">
                                                        <i class="fas fa-circle me-1"></i> Aktif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="content-section mt-4">
                                    <h6 class="section-title mb-4">
                                        <i class="fas fa-history me-2 text-secondary"></i>
                                        Riwayat Sistem
                                    </h6>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-calendar-plus text-success me-2"></i>
                                                    Bergabung Sejak
                                                </div>
                                                <div class="info-value">
                                                    {{ auth()->user()->created_at->translatedFormat('d F Y') }}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab Content -->
                    <div class="tab-content" id="security-tab">
                        <div class="card modern-content-card">
                            <div class="card-header modern-card-header">
                                <h5 class="mb-0 text-white">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    Keamanan Akun
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Success/Error Messages -->
                                @if(session('success'))
                                    <div class="alert modern-alert-success mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle me-3"></i>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Berhasil!</h6>
                                                <p class="mb-0">{{ session('success') }}</p>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert modern-alert-error mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-triangle me-3"></i>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Terjadi Kesalahan</h6>
                                                <p class="mb-0">{{ session('error') }}</p>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    </div>
                                @endif

                                <form action="{{ route('admin.settings.updatePassword') }}" method="POST" class="modern-form">
                                    @csrf

                                    <div class="content-section">
                                        <h6 class="section-title mb-4">
                                            <i class="fas fa-lock me-2 text-warning"></i>
                                            Ubah Password
                                        </h6>

                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="form-group-modern">
                                                    <label class="form-label">
                                                        <i class="fas fa-key me-2"></i>
                                                        Password Lama
                                                        <span class="required-badge">*</span>
                                                    </label>
                                                    <div class="input-group-modern">
                                                        <input type="password"
                                                               name="current_password"
                                                               class="form-control modern-input"
                                                               placeholder="Masukkan password lama"
                                                               required>
                                                        <button type="button" class="password-toggle">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    @error('current_password')
                                                        <div class="form-error-message">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group-modern">
                                                    <label class="form-label">
                                                        <i class="fas fa-lock me-2"></i>
                                                        Password Baru
                                                        <span class="required-badge">*</span>
                                                    </label>
                                                    <div class="input-group-modern">
                                                        <input type="password"
                                                               name="new_password"
                                                               class="form-control modern-input"
                                                               placeholder="Password baru"
                                                               required>
                                                        <button type="button" class="password-toggle">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    @error('new_password')
                                                        <div class="form-error-message">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group-modern">
                                                    <label class="form-label">
                                                        <i class="fas fa-lock me-2"></i>
                                                        Konfirmasi Password
                                                        <span class="required-badge">*</span>
                                                    </label>
                                                    <div class="input-group-modern">
                                                        <input type="password"
                                                               name="new_password_confirmation"
                                                               class="form-control modern-input"
                                                               placeholder="Konfirmasi password"
                                                               required>
                                                        <button type="button" class="password-toggle">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="form-actions mt-4 pt-4 border-top">
                                        <button type="submit" class="btn btn-primary btn-modern">
                                            <i class="fas fa-save me-2"></i>
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
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
    .modern-nav-card,
    .modern-content-card {
        border: none;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
        background: white;
    }

    .modern-profile-card:hover,
    .modern-nav-card:hover,
    .modern-content-card:hover {
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

    .online-status {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .online-status.online {
        background: var(--success);
    }

    /* Navigation Tabs */
    .nav-tabs-vertical {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .nav-tab-vertical {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: none;
        border: none;
        border-radius: 8px;
        transition: var(--transition);
        cursor: pointer;
        width: 100%;
        text-align: left;
    }

    .nav-tab-vertical:hover {
        background: var(--primary-light);
    }

    .nav-tab-vertical.active {
        background: var(--primary);
        color: white;
    }

    .nav-tab-vertical.active .nav-subtitle {
        color: rgba(255, 255, 255, 0.8);
    }

    .nav-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-light);
        color: var(--primary);
        transition: var(--transition);
    }

    .nav-tab-vertical.active .nav-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .nav-content {
        flex: 1;
    }

    .nav-title {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .nav-subtitle {
        font-size: 0.8rem;
        color: var(--secondary);
        transition: var(--transition);
    }

    .nav-arrow {
        transition: var(--transition);
    }

    .nav-tab-vertical.active .nav-arrow {
        transform: translateX(3px);
    }

    /* Content Sections */
    .content-section {
        margin-bottom: 2rem;
    }

    .section-title {
        color: var(--dark);
        font-weight: 600;
        font-size: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-light);
        display: flex;
        align-items: center;
    }

    /* Info Items */
    .info-item {
        padding: 1rem;
        background: var(--light);
        border-radius: 8px;
        border: 1px solid var(--border);
        transition: var(--transition);
    }

    .info-item:hover {
        background: white;
        border-color: var(--primary);
        transform: translateX(5px);
    }

    .info-label {
        font-size: 0.875rem;
        color: var(--secondary);
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .info-value {
        color: var(--dark);
        font-size: 1rem;
        font-weight: 500;
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

    .role-badge-sm {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
    }

    .status-badge {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .status-badge.active {
        background: var(--primary-light);
        color: var(--primary);
    }

    /* Form Styles */
    .modern-form {
        margin-top: 1rem;
    }

    .form-group-modern {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
    }

    .form-label i {
        width: 20px;
        margin-right: 0.75rem;
        color: var(--primary);
    }

    .required-badge {
        color: var(--danger);
        margin-left: 0.25rem;
        font-weight: 700;
    }

    .input-group-modern {
        position: relative;
    }

    .modern-input {
        border: 2px solid var(--border);
        border-radius: 8px;
        padding: 1rem 3rem 1rem 1rem;
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        width: 100%;
    }

    .modern-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        outline: none;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--secondary);
        cursor: pointer;
        transition: var(--transition);
    }

    .password-toggle:hover {
        color: var(--primary);
    }

    .form-error-message {
        color: var(--danger);
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
    }

    /* Buttons */
    .btn-modern {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: var(--transition);
        border: 2px solid transparent;
        display: flex;
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
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
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

    /* Alert Styles */
    .modern-alert-success {
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border-left: 4px solid #10b981;
        box-shadow: var(--shadow);
    }

    .modern-alert-error {
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border-left: 4px solid var(--danger);
        box-shadow: var(--shadow);
    }

    /* Tab Content */
    .tab-content {
        display: none;
        animation: fadeIn 0.5s ease;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
            justify-content: center;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
        }

        .nav-tab-vertical {
            padding: 0.75rem;
        }

        .nav-icon {
            width: 35px;
            height: 35px;
        }

        .form-actions {
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .info-item {
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 0.9rem;
        }

        .modern-input {
            padding: 0.875rem 2.5rem 0.875rem 0.875rem;
        }

        .password-toggle {
            right: 0.75rem;
        }
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab Navigation
    const navTabs = document.querySelectorAll('.nav-tab-vertical');
    const tabContents = document.querySelectorAll('.tab-content');

    // Function to switch tabs
    function switchTab(tabName) {
        // Hide all tab contents
        tabContents.forEach(content => {
            content.classList.remove('active');
        });

        // Show selected tab content
        const targetTab = document.getElementById(`${tabName}-tab`);
        if (targetTab) {
            targetTab.classList.add('active');
        }

        // Update active tab button
        navTabs.forEach(tab => {
            tab.classList.remove('active');
            if (tab.dataset.tab === tabName) {
                tab.classList.add('active');
            }
        });
    }

    // Add click event listeners to tabs
    navTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            switchTab(targetTab);
        });
    });

    // Check if there's a hash in URL for direct tab access
    if (window.location.hash) {
        const hash = window.location.hash.replace('#', '');
        if (hash === 'security') {
            switchTab('security');
        }
    }

    // Password Toggle Visibility
    const passwordToggles = document.querySelectorAll('.password-toggle');

    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Form submission enhancement
    const forms = document.querySelectorAll('.modern-form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Add loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            submitBtn.disabled = true;

            // Re-enable after 5 seconds if still on page (fallback)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;

                    // Show error message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert modern-alert-error mt-3';
                    alertDiv.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Timeout</h6>
                                <p class="mb-0">Proses memakan waktu terlalu lama. Silakan coba lagi.</p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                    form.appendChild(alertDiv);
                }
            }, 5000);
        });
    });

    // Add smooth animations
    const cards = document.querySelectorAll('.modern-profile-card, .modern-nav-card, .modern-content-card');

    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Debug info
    console.log('Admin Settings JS loaded successfully');
    console.log('Tabs found:', navTabs.length);
    console.log('Tab contents found:', tabContents.length);
});
</script>
@endpush
@endsection
