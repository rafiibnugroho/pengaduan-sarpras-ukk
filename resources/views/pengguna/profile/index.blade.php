@extends('layouts.user')

@section('content')
<div class="min-vh-100 bg-gradient-light">
    <!-- Background Elements -->
    <div class="position-fixed w-100 h-100 top-0 start-0" style="z-index: -1;">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <div class="header-avatar mb-4">
                        <div class="avatar-wrapper">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <h1 class="display-5 fw-bold text-dark mb-2">Pengaturan Profil</h1>
                    <p class="lead text-muted">Kelola informasi akun dan keamanan Anda</p>
                </div>

                <!-- Main Profile Card -->
                <div class="modern-profile-card">
                    <!-- Navigation Tabs -->
                    <div class="profile-tabs">
                        <button class="profile-tab active" data-tab="profile">
                            <i class="fas fa-user-circle me-2"></i>
                            Informasi Profil
                        </button>
                        <button class="profile-tab" data-tab="security">
                            <i class="fas fa-shield-alt me-2"></i>
                            Keamanan
                        </button>
                    </div>

                    <div class="profile-content">
                        <!-- Profile Information Tab -->
                        <div class="tab-content active" id="profile-tab">
                            <div class="tab-header">
                                <h3 class="tab-title">
                                    <i class="fas fa-id-card me-3"></i>
                                    Informasi Dasar
                                </h3>
                                <p class="tab-subtitle">Kelola informasi profil dan kontak Anda</p>
                            </div>

                            @if(session('success'))
                                <div class="alert-modern success">
                                    <div class="alert-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="alert-content">
                                        <h6>Berhasil!</h6>
                                        <p>{{ session('success') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert-modern error">
                                    <div class="alert-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="alert-content">
                                        <h6>Terjadi Kesalahan</h6>
                                        <p>{{ session('error') }}</p>
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                                @csrf
                                <div class="form-grid">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <span class="label-text">Nama Lengkap</span>
                                            <span class="label-required">*</span>
                                        </label>
                                        <div class="input-group-modern">
                                            <i class="input-icon fas fa-user"></i>
                                            <input type="text"
                                                   id="name"
                                                   name="name"
                                                   class="form-input-modern"
                                                   placeholder="Masukkan nama lengkap Anda"
                                                   value="{{ old('name', $user->name) }}"
                                                   required>
                                        </div>
                                        @error('name')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <span class="label-text">Alamat Email</span>
                                            <span class="label-required">*</span>
                                        </label>
                                        <div class="input-group-modern">
                                            <i class="input-icon fas fa-envelope"></i>
                                            <input type="email"
                                                   id="email"
                                                   name="email"
                                                   class="form-input-modern"
                                                   placeholder="contoh@domain.com"
                                                   value="{{ old('email', $user->email) }}"
                                                   required>
                                        </div>
                                        @error('email')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <a href="{{ route('home') }}" class="btn-back">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Kembali
                                    </a>
                                    <button type="submit" class="btn-primary">
                                        <i class="fas fa-save me-2"></i>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Security Tab -->
                        <div class="tab-content" id="security-tab">
                            <div class="tab-header">
                                <h3 class="tab-title">
                                    <i class="fas fa-lock me-3"></i>
                                    Keamanan Akun
                                </h3>
                                <p class="tab-subtitle">Perbarui kata sandi untuk menjaga keamanan akun</p>
                            </div>

                            <form action="{{ route('profile.password') }}" method="POST" class="profile-form">
                                @csrf
                                <div class="form-grid">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <span class="label-text">Kata Sandi Lama</span>
                                            <span class="label-required">*</span>
                                        </label>
                                        <div class="input-group-modern">
                                            <i class="input-icon fas fa-key"></i>
                                            <input type="password"
                                                   id="old_password"
                                                   name="old_password"
                                                   class="form-input-modern"
                                                   placeholder="Masukkan kata sandi lama"
                                                   required>
                                            <button type="button" class="password-toggle" data-target="old_password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('old_password')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <span class="label-text">Kata Sandi Baru</span>
                                            <span class="label-required">*</span>
                                        </label>
                                        <div class="input-group-modern">
                                            <i class="input-icon fas fa-lock"></i>
                                            <input type="password"
                                                   id="new_password"
                                                   name="new_password"
                                                   class="form-input-modern"
                                                   placeholder="Masukkan kata sandi baru"
                                                   required>
                                            <button type="button" class="password-toggle" data-target="new_password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('new_password')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <span class="label-text">Konfirmasi Kata Sandi</span>
                                            <span class="label-required">*</span>
                                        </label>
                                        <div class="input-group-modern">
                                            <i class="input-icon fas fa-lock"></i>
                                            <input type="password"
                                                   id="new_password_confirmation"
                                                   name="new_password_confirmation"
                                                   class="form-input-modern"
                                                   placeholder="Konfirmasi kata sandi baru"
                                                   required>
                                            <button type="button" class="password-toggle" data-target="new_password_confirmation">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Strength Indicator -->
                                <div class="password-strength">
                                    <div class="strength-header">
                                        <span class="strength-label">Kekuatan Kata Sandi</span>
                                        <span class="strength-value" id="strengthValue">Lemah</span>
                                    </div>
                                    <div class="strength-bar">
                                        <div class="strength-progress" id="strengthProgress"></div>
                                    </div>
                                    <div class="strength-requirements">
                                        <div class="requirement" data-requirement="length">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Minimal 8 karakter</span>
                                        </div>
                                        <div class="requirement" data-requirement="uppercase">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Mengandung huruf besar</span>
                                        </div>
                                        <div class="requirement" data-requirement="lowercase">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Mengandung huruf kecil</span>
                                        </div>
                                        <div class="requirement" data-requirement="number">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Mengandung angka</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <a href="{{ route('home') }}" class="btn-back">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Kembali
                                    </a>
                                    <button type="submit" class="btn-secondary">
                                        <i class="fas fa-key me-2"></i>
                                        Perbarui Kata Sandi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
@endsection

@push('styles')
<style>
/* Modern Design System */
:root {
    --primary: #6366f1;
    --primary-light: #818cf8;
    --primary-dark: #4f46e5;
    --secondary: #10b981;
    --accent: #f59e0b;
    --danger: #ef4444;
    --dark: #1e293b;
    --light: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --radius: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
}

/* Background Elements */
.bg-gradient-light {
    background: linear-gradient(135deg, #f0f4ff 0%, #f8faff 50%, #f0f9ff 100%);
}

.floating-shape {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-light), var(--primary));
    opacity: 0.03;
    animation: float 25s ease-in-out infinite;
}

.shape-1 {
    width: 250px;
    height: 250px;
    top: 10%;
    left: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 180px;
    height: 180px;
    top: 60%;
    right: 15%;
    animation-delay: 8s;
}

.shape-3 {
    width: 120px;
    height: 120px;
    bottom: 20%;
    left: 20%;
    animation-delay: 16s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
    33% { transform: translateY(-20px) rotate(120deg) scale(1.05); }
    66% { transform: translateY(10px) rotate(240deg) scale(0.95); }
}

/* Header Section */
.header-avatar {
    display: flex;
    justify-content: center;
}

.avatar-wrapper {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-xl);
    position: relative;
    border: 4px solid white;
}

.avatar-wrapper::before {
    content: '';
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(99, 102, 241, 0.1);
    animation: pulse 3s ease-in-out infinite;
}

.avatar-wrapper i {
    font-size: 2.5rem;
    color: white;
    position: relative;
    z-index: 2;
}

@keyframes pulse {
    0%, 100% { transform: scale(0.8); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.5; }
}

/* Main Profile Card */
.modern-profile-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    margin-bottom: 2rem;
}

/* Profile Tabs */
.profile-tabs {
    display: flex;
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-200);
    padding: 0 2rem;
}

.profile-tab {
    flex: 1;
    padding: 1.5rem 2rem;
    background: none;
    border: none;
    color: var(--gray-500);
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    border-bottom: 3px solid transparent;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-tab:hover {
    color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
}

.profile-tab.active {
    color: var(--primary);
    border-bottom-color: var(--primary);
    background: white;
}

/* Profile Content */
.profile-content {
    padding: 3rem;
}

.tab-content {
    display: none;
    animation: slideIn 0.5s ease;
}

.tab-content.active {
    display: block;
}

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

/* Tab Header */
.tab-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--gray-200);
}

.tab-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tab-title i {
    color: var(--primary);
}

.tab-subtitle {
    color: var(--gray-500);
    font-size: 1.1rem;
    margin: 0;
}

/* Modern Alerts */
.alert-modern {
    display: flex;
    align-items: flex-start;
    padding: 1.5rem;
    border-radius: var(--radius-lg);
    margin-bottom: 2rem;
    animation: slideIn 0.5s ease;
}

.alert-modern.success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border-left: 4px solid var(--secondary);
}

.alert-modern.error {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    border-left: 4px solid var(--danger);
}

.alert-icon {
    margin-right: 1rem;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.alert-modern.success .alert-icon {
    color: var(--secondary);
}

.alert-modern.error .alert-icon {
    color: var(--danger);
}

.alert-content h6 {
    margin: 0 0 0.25rem 0;
    font-weight: 700;
    color: var(--dark);
}

.alert-content p {
    margin: 0;
    color: var(--gray-600);
    font-size: 0.95rem;
}

/* Form Elements */
.profile-form {
    margin-top: 2rem;
}

.form-grid {
    display: grid;
    gap: 2rem;
    margin-bottom: 3rem;
}

.form-group-modern {
    position: relative;
}

.form-label-modern {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: var(--dark);
}

.label-text {
    font-size: 1rem;
}

.label-required {
    color: var(--danger);
    margin-left: 4px;
}

.input-group-modern {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    z-index: 2;
    transition: all 0.3s ease;
}

.form-input-modern {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius);
    background: white;
    font-size: 1rem;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.form-input-modern:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.form-input-modern:focus + .input-icon {
    color: var(--primary);
}

.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--gray-400);
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 2;
}

.password-toggle:hover {
    color: var(--primary);
}

.form-error {
    color: var(--danger);
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-error::before {
    content: '⚠';
    font-size: 0.75rem;
}

/* Password Strength Indicator */
.password-strength {
    background: var(--gray-50);
    padding: 1.5rem;
    border-radius: var(--radius);
    margin-bottom: 2rem;
    border: 1px solid var(--gray-200);
}

.strength-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.strength-label {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.95rem;
}

.strength-value {
    font-weight: 700;
    font-size: 0.875rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    background: var(--danger);
    color: white;
}

.strength-bar {
    height: 6px;
    background: var(--gray-200);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.strength-progress {
    height: 100%;
    width: 0%;
    background: var(--danger);
    border-radius: 3px;
    transition: all 0.3s ease;
}

.strength-requirements {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}

.requirement {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--gray-500);
}

.requirement i {
    font-size: 0.75rem;
    transition: all 0.3s ease;
}

.requirement.valid {
    color: var(--secondary);
}

.requirement.valid i {
    color: var(--secondary);
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.btn-back, .btn-primary, .btn-secondary {
    padding: 1rem 2rem;
    border: none;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.btn-back {
    background: var(--gray-100);
    color: var(--gray-600);
}

.btn-back:hover {
    background: var(--gray-200);
    transform: translateX(-2px);
}

.btn-primary {
    background: var(--primary);
    color: white;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
}

.btn-secondary {
    background: linear-gradient(135deg, var(--secondary), #059669);
    color: white;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

/* Quick Stats */
.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.stat-icon.primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
}

.stat-icon.success {
    background: linear-gradient(135deg, var(--secondary), #059669);
}

.stat-icon.warning {
    background: linear-gradient(135deg, var(--accent), #d97706);
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--gray-500);
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    .modern-profile-card {
        margin: 0 -1rem;
        border-radius: 0;
    }

    .profile-content {
        padding: 2rem 1.5rem;
    }

    .profile-tabs {
        padding: 0 1rem;
    }

    .profile-tab {
        padding: 1rem 1.5rem;
        font-size: 0.9rem;
    }

    .tab-title {
        font-size: 1.5rem;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-grid {
        gap: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-back, .btn-primary, .btn-secondary {
        width: 100%;
        justify-content: center;
    }

    .strength-requirements {
        grid-template-columns: 1fr;
    }

    .stat-card {
        padding: 1.25rem;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
}

@media (max-width: 576px) {
    .profile-tabs {
        flex-direction: column;
    }

    .profile-tab {
        padding: 1rem;
    }

    .form-input-modern {
        padding-left: 2.5rem;
    }

    .input-icon {
        left: 0.75rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab Navigation
    const profileTabs = document.querySelectorAll('.profile-tab');
    const tabContents = document.querySelectorAll('.tab-content');

    profileTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.dataset.tab;

            // Update active tab
            profileTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // Show target content
            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === `${targetTab}-tab`) {
                    content.classList.add('active');
                }
            });
        });
    });

    // Password Toggle Visibility
    const passwordToggles = document.querySelectorAll('.password-toggle');

    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Password Strength Checker
    const newPasswordInput = document.getElementById('new_password');
    const strengthProgress = document.getElementById('strengthProgress');
    const strengthValue = document.getElementById('strengthValue');
    const requirements = document.querySelectorAll('.requirement');

    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            checkPasswordStrength(password);
        });
    }

    function checkPasswordStrength(password) {
        let strength = 0;
        const requirementsMet = {
            length: false,
            uppercase: false,
            lowercase: false,
            number: false
        };

        // Check length
        if (password.length >= 8) {
            strength += 25;
            requirementsMet.length = true;
        }

        // Check uppercase
        if (/[A-Z]/.test(password)) {
            strength += 25;
            requirementsMet.uppercase = true;
        }

        // Check lowercase
        if (/[a-z]/.test(password)) {
            strength += 25;
            requirementsMet.lowercase = true;
        }

        // Check numbers
        if (/[0-9]/.test(password)) {
            strength += 25;
            requirementsMet.number = true;
        }

        // Update progress bar
        strengthProgress.style.width = `${strength}%`;

        // Update strength value text and color
        if (strength === 0) {
            strengthValue.textContent = 'Lemah';
            strengthProgress.style.background = '#ef4444';
        } else if (strength <= 50) {
            strengthValue.textContent = 'Cukup';
            strengthProgress.style.background = '#f59e0b';
        } else if (strength <= 75) {
            strengthValue.textContent = 'Baik';
            strengthProgress.style.background = '#10b981';
        } else {
            strengthValue.textContent = 'Sangat Baik';
            strengthProgress.style.background = '#059669';
        }

        // Update requirements
        requirements.forEach(req => {
            const requirementType = req.dataset.requirement;
            const icon = req.querySelector('i');

            if (requirementsMet[requirementType]) {
                req.classList.add('valid');
                icon.classList.remove('fa-check-circle');
                icon.classList.add('fa-check-circle');
            } else {
                req.classList.remove('valid');
                icon.classList.remove('fa-check-circle');
                icon.classList.add('fa-check-circle');
            }
        });
    }

    // Form validation enhancement
    const forms = document.querySelectorAll('.profile-form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Add loading state
            submitBtn.innerHTML = '<div class="spinner"></div> Memproses...';
            submitBtn.disabled = true;

            // Re-enable after 3 seconds if still on page (fallback)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 3000);
        });
    });

    // Add spinner style
    const spinnerStyle = document.createElement('style');
    spinnerStyle.textContent = `
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(spinnerStyle);
});
</script>
@endpush
