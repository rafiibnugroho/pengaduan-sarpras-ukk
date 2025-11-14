@extends('layouts.petugas')

@section('title', 'Pengaturan Akun - ' . config('app.name'))

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="profile-header-card bg-gradient-primary text-white rounded-4 p-5 position-relative overflow-hidden">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="profile-avatar-container me-4">
                                <div class="profile-avatar bg-white text-primary">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="online-status"></div>
                            </div>
                            <div>
                                <h1 class="fw-bold mb-2 display-6">{{ $user->name }}</h1>
                                <p class="mb-1 opacity-90">
                                    <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                                </p>
                                <p class="mb-0 opacity-75">
                                    <i class="fas fa-user-shield me-2"></i>Petugas Sarpras
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="profile-stats">

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

    <div class="row g-4">
        <!-- Update Profil Section -->
        <div class="col-xl-6">
            <div class="card modern-card border-0 rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="section-icon-container bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-user-edit text-primary fs-4"></i>
                        </div>
                        <div>
                            <h4 class="card-title fw-bold mb-1">Informasi Profil</h4>
                            <p class="text-muted mb-0">Kelola informasi profil akun Anda</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert-modern alert-success">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-content">
                            <h6 class="alert-title">Berhasil!</h6>
                            <p class="alert-message">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="alert-close" data-bs-dismiss="alert">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endif

                    <form action="{{ route('petugas.pengaturan.update', $user->id) }}" method="POST" class="modern-form">
                        @csrf
                        @method('PUT')

                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-user me-2"></i>Nama Lengkap
                            </label>
                            <div class="input-group-modern">
                                <input type="text" name="name" class="form-control-modern" value="{{ $user->name }}" required>
                                <div class="input-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            @error('name')
                            <div class="form-error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-envelope me-2"></i>Alamat Email
                            </label>
                            <div class="input-group-modern">
                                <input type="email" name="email" class="form-control-modern" value="{{ $user->email }}" required>
                                <div class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            @error('email')
                            <div class="form-error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-calendar me-2"></i>Bergabung Sejak
                            </label>
                            <div class="readonly-field">
                                {{ $user->created_at->format('d F Y') }}
                            </div>
                        </div>

                        <button type="submit" class="btn-modern btn-primary w-100">
                            <i class="fas fa-save me-2"></i>
                            Simpan Perubahan Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Password Section -->
        <div class="col-xl-6">
            <div class="card modern-card border-0 rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="section-icon-container bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-lock text-danger fs-4"></i>
                        </div>
                        <div>
                            <h4 class="card-title fw-bold mb-1">Keamanan Akun</h4>
                            <p class="text-muted mb-0">Perbarui kata sandi untuk keamanan</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('error'))
                    <div class="alert-modern alert-danger">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="alert-content">
                            <h6 class="alert-title">Error!</h6>
                            <p class="alert-message">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="alert-close" data-bs-dismiss="alert">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endif

                    @if(session('success_password'))
                    <div class="alert-modern alert-success">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-content">
                            <h6 class="alert-title">Berhasil!</h6>
                            <p class="alert-message">{{ session('success_password') }}</p>
                        </div>
                        <button type="button" class="alert-close" data-bs-dismiss="alert">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endif

                    <form action="{{ route('petugas.pengaturan.updatePassword') }}" method="POST" class="modern-form">
                        @csrf

                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-key me-2"></i>Password Saat Ini
                            </label>
                            <div class="input-group-modern">
                                <input type="password" name="password_lama" class="form-control-modern password-input" required>
                                <div class="input-icon">
                                    <i class="fas fa-key"></i>
                                </div>
                                <button type="button" class="password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password_lama')
                            <div class="form-error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-lock me-2"></i>Password Baru
                            </label>
                            <div class="input-group-modern">
                                <input type="password" name="password_baru" class="form-control-modern password-input" required>
                                <div class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <button type="button" class="password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password_baru')
                            <div class="form-error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-lock me-2"></i>Konfirmasi Password Baru
                            </label>
                            <div class="input-group-modern">
                                <input type="password" name="password_baru_confirmation" class="form-control-modern password-input" required>
                                <div class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <button type="button" class="password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="password-strength mt-3">
                            <div class="strength-bar">
                                <div class="strength-fill" id="passwordStrength"></div>
                            </div>
                            <div class="strength-text small text-muted" id="passwordText">
                                Kekuatan password: -
                            </div>
                        </div>

                        <button type="submit" class="btn-modern btn-danger w-100 mt-4">
                            <i class="fas fa-shield-alt me-2"></i>
                            Perbarui Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{--
        <!-- Additional Info Section -->
        <div class="col-12">
            <div class="card modern-card border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="section-icon-container bg-info bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-info-circle text-info fs-4"></i>
                        </div>
                        <div>
                            <h4 class="card-title fw-bold mb-1">Informasi Akun</h4>
                            <p class="text-muted mb-0">Detail lengkap tentang akun Anda</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3 col-6">
                            <div class="info-card text-center">
                                <div class="info-icon bg-primary bg-opacity-10 rounded-3 p-3 mx-auto mb-3">
                                    <i class="fas fa-user-clock text-primary fs-2"></i>
                                </div>
                                <h5 class="fw-bold mb-1">Member Since</h5>
                                <p class="text-muted mb-0">{{ $user->created_at->format('M Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-card text-center">
                                <div class="info-icon bg-success bg-opacity-10 rounded-3 p-3 mx-auto mb-3">
                                    <i class="fas fa-check-circle text-success fs-2"></i>
                                </div>
                                <h5 class="fw-bold mb-1">Pengaduan Selesai</h5>
                                <p class="text-muted mb-0">{{ $stats['selesai'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-card text-center">
                                <div class="info-icon bg-warning bg-opacity-10 rounded-3 p-3 mx-auto mb-3">
                                    <i class="fas fa-tasks text-warning fs-2"></i>
                                </div>
                                <h5 class="fw-bold mb-1">Total Ditangani</h5>
                                <p class="text-muted mb-0">{{ $stats['total'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-card text-center">
                                <div class="info-icon bg-info bg-opacity-10 rounded-3 p-3 mx-auto mb-3">
                                    <i class="fas fa-chart-line text-info fs-2"></i>
                                </div>
                                <h5 class="fw-bold mb-1">Aktivitas</h5>
                                <p class="text-muted mb-0">Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 --}}

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

/* Profile Header */
.profile-header-card {
    background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    position: relative;
    overflow: hidden;
}

.profile-avatar-container {
    position: relative;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 700;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.profile-header-card:hover .profile-avatar {
    transform: scale(1.05) rotate(5deg);
}

.online-status {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 20px;
    height: 20px;
    background: #10B981;
    border: 3px solid white;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.profile-stats {
    display: flex;
    gap: 2rem;
    justify-content: flex-end;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.25rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
    font-weight: 500;
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

/* Section Icons */
.section-icon-container {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.modern-card:hover .section-icon-container {
    transform: scale(1.1);
}

/* Modern Form Styles */
.modern-form {
    margin-top: 1.5rem;
}

.form-group-modern {
    margin-bottom: 1.5rem;
}

.form-label-modern {
    display: block;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.input-group-modern {
    position: relative;
    display: flex;
    align-items: center;
}

.form-control-modern {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 3rem;
    border: 2px solid rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    background: #fff;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.form-control-modern:focus {
    outline: none;
    border-color: #3B82F6;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.15);
    transform: translateY(-1px);
}

.input-icon {
    position: absolute;
    left: 1rem;
    color: var(--text-light);
    transition: all 0.3s ease;
}

.form-control-modern:focus + .input-icon {
    color: #3B82F6;
    transform: scale(1.1);
}

.password-toggle {
    position: absolute;
    right: 1rem;
    background: none;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    transition: all 0.3s ease;
}

.password-toggle:hover {
    color: #3B82F6;
    transform: scale(1.1);
}

.readonly-field {
    padding: 0.875rem 1rem;
    background: rgba(0, 0, 0, 0.04);
    border-radius: 12px;
    border: 2px solid transparent;
    color: var(--text-medium);
    font-weight: 500;
}

/* Password Strength */
.password-strength {
    margin-top: 1rem;
}

.strength-bar {
    width: 100%;
    height: 6px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.strength-fill {
    height: 100%;
    width: 0%;
    border-radius: 3px;
    transition: all 0.3s ease;
    background: #EF4444;
}

.strength-fill.weak { width: 33%; background: #EF4444; }
.strength-fill.medium { width: 66%; background: #F59E0B; }
.strength-fill.strong { width: 100%; background: #10B981; }

/* Buttons */
.btn-modern {
    padding: 0.875rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.btn-primary {
    background: linear-gradient(135deg, #3B82F6, #1D4ED8);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563EB, #1E40AF);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
}

.btn-danger {
    background: linear-gradient(135deg, #EF4444, #DC2626);
    color: white;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #DC2626, #B91C1C);
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.3);
}

/* Alert Modern */
.alert-modern {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    border: 1px solid transparent;
    animation: slideIn 0.3s ease;
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    border-color: rgba(16, 185, 129, 0.2);
    color: #065F46;
}

.alert-danger {
    background: rgba(239, 68, 68, 0.1);
    border-color: rgba(239, 68, 68, 0.2);
    color: #7F1D1D;
}

.alert-icon {
    font-size: 1.25rem;
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.alert-content {
    flex: 1;
}

.alert-title {
    font-weight: 700;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.alert-message {
    margin-bottom: 0;
    font-size: 0.875rem;
}

.alert-close {
    background: none;
    border: none;
    color: inherit;
    opacity: 0.7;
    cursor: pointer;
    padding: 0;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.alert-close:hover {
    opacity: 1;
    transform: scale(1.1);
}

/* Form Error Message */
.form-error-message {
    color: #EF4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    animation: shake 0.3s ease;
}

/* Info Cards */
.info-card {
    padding: 1.5rem 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.info-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    background: white;
}

.info-icon {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.info-card:hover .info-icon {
    transform: scale(1.1) rotate(5deg);
}

/* Animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }

    .profile-header-card {
        padding: 2rem 1.5rem;
        text-align: center;
    }

    .profile-header-card .d-flex {
        flex-direction: column;
        text-align: center;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
    }

    .profile-stats {
        justify-content: center;
        margin-top: 1.5rem;
    }

    .stat-number {
        font-size: 2rem;
    }

    .section-icon-container {
        width: 50px;
        height: 50px;
        margin: 0 auto 1rem;
    }

    .card-header .d-flex {
        flex-direction: column;
        text-align: center;
    }

    .input-group-modern {
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-control-modern {
        padding: 0.75rem 1rem;
    }

    .input-icon {
        position: static;
        margin-bottom: 0.5rem;
    }

    .password-toggle {
        position: static;
        align-self: flex-end;
        margin-top: 0.5rem;
    }
}

@media (max-width: 576px) {
    .profile-stats {
        flex-direction: column;
        gap: 1rem;
    }

    .info-card {
        padding: 1rem 0.5rem;
    }

    .btn-modern {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }

    .alert-modern {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .alert-close {
        align-self: flex-end;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.closest('.input-group-modern').querySelector('.password-input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });
    });

    // Password strength indicator
    const passwordInputs = document.querySelectorAll('input[name="password_baru"]');
    passwordInputs.forEach(input => {
        input.addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('passwordText');

            let strength = 0;
            let text = '';
            let color = '';

            if (password.length === 0) {
                strength = 0;
                text = 'Kekuatan password: -';
                color = '';
            } else if (password.length < 6) {
                strength = 1;
                text = 'Kekuatan password: Lemah';
                color = 'weak';
            } else if (password.length < 8) {
                strength = 2;
                text = 'Kekuatan password: Sedang';
                color = 'medium';
            } else {
                // Check for complexity
                const hasUpperCase = /[A-Z]/.test(password);
                const hasLowerCase = /[a-z]/.test(password);
                const hasNumbers = /\d/.test(password);
                const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

                let complexity = 0;
                if (hasUpperCase) complexity++;
                if (hasLowerCase) complexity++;
                if (hasNumbers) complexity++;
                if (hasSpecial) complexity++;

                if (complexity >= 3) {
                    strength = 3;
                    text = 'Kekuatan password: Kuat';
                    color = 'strong';
                } else {
                    strength = 2;
                    text = 'Kekuatan password: Sedang';
                    color = 'medium';
                }
            }

            strengthBar.className = `strength-fill ${color}`;
            strengthText.textContent = text;
        });
    });

    // Add smooth animations to cards
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

    // Form submission loading states
    const forms = document.querySelectorAll('.modern-form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
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
});
</script>
@endpush
@endsection
