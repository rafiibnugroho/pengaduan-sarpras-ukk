@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="header-icon bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-user-plus text-primary fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Tambah Pengguna Baru</h4>
                            <p class="text-muted mb-0">Buat akun pengguna baru dengan hak akses yang sesuai</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if($errors->any())
                    <div class="alert alert-danger alert-modern" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3 fs-5"></i>
                            <div>
                                <h6 class="alert-heading mb-1">Terjadi Kesalahan</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                    <li class="small">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.store') }}" class="needs-validation" novalidate>
                        @csrf

                        <!-- Nama Field -->
                        <div class="form-group-modern mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                            </label>
                            <div class="input-group-modern">
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control-modern @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}"
                                       placeholder="Masukkan nama lengkap "
                                       required
                                       autofocus>
                                <div class="input-icon">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                            </div>
                            @error('name')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-group-modern mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-primary"></i>Alamat Email
                            </label>
                            <div class="input-group-modern">
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control-modern @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"
                                       placeholder="Masukkan alamat email yang valid"
                                       required>
                                <div class="input-icon">
                                    <i class="fas fa-envelope text-muted"></i>
                                </div>
                            </div>
                            @error('email')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group-modern mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Password
                            </label>
                            <div class="input-group-modern">
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control-modern @error('password') is-invalid @enderror"
                                       placeholder="Buat password yang kuat"
                                       required>
                                <div class="input-icon">
                                    <i class="fas fa-lock text-muted"></i>
                                </div>
                                <button type="button" class="password-toggle" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="passwordToggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" id="passwordStrengthBar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted" id="passwordStrengthText">Kekuatan password</small>
                            </div>
                        </div>

                        <!-- Role Field -->
                        <div class="form-group-modern mb-4">
                            <label for="role" class="form-label fw-semibold">
                                <i class="fas fa-user-tag me-2 text-primary"></i>Peran Pengguna
                            </label>
                            <div class="input-group-modern">
                                <select name="role"
                                        id="role"
                                        class="form-control-modern @error('role') is-invalid @enderror"
                                        required>
                                    <option value="">Pilih peran pengguna</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }} class="role-option">
                                        <i class="fas fa-crown me-2"></i>Administrator
                                    </option>
                                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }} class="role-option">
                                        <i class="fas fa-user-shield me-2"></i>Petugas
                                    </option>
                                    <option value="pengguna" {{ old('role') == 'pengguna' ? 'selected' : '' }} class="role-option">
                                        <i class="fas fa-user me-2"></i>Pengguna
                                    </option>
                                </select>
                                <div class="input-icon">
                                    <i class="fas fa-user-tag text-muted"></i>
                                </div>
                            </div>
                            @error('role')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Role Description -->
                        <div class="role-info-card p-3 rounded-3 bg-light mb-4">
                            <h6 class="fw-semibold mb-2">Deskripsi Peran:</h6>
                            <div class="role-descriptions">
                                <div class="role-desc admin-desc" style="display: none;">
                                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Administrator</span>
                                    <p class="small text-muted mb-0">Akses penuh ke semua fitur sistem, termasuk manajemen pengguna, lokasi, barang, dan laporan.</p>
                                </div>
                                <div class="role-desc petugas-desc" style="display: none;">
                                    <span class="badge bg-warning bg-opacity-10 text-warning mb-2">Petugas</span>
                                    <p class="small text-muted mb-0">Dapat mengelola pengaduan dan memproses laporan, tetapi tidak dapat mengelola pengguna.</p>
                                </div>
                                <div class="role-desc pengguna-desc" style="display: none;">
                                    <span class="badge bg-info bg-opacity-10 text-info mb-2">Pengguna</span>
                                    <p class="small text-muted mb-0">Hanya dapat melihat dan membuat pengaduan, tidak dapat mengakses fitur administrasi.</p>
                                </div>
                                <div class="role-desc default-desc">
                                    <p class="small text-muted mb-0">Pilih peran untuk melihat deskripsi hak akses</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 pt-3">
                            <button type="submit" class="btn btn-primary-modern flex-fill">
                                <i class="fas fa-user-plus me-2"></i>
                                Buat Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Tips Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-shield-alt text-success me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-semibold mb-2">Tips Keamanan Akun</h6>
                            <ul class="text-muted small mb-0 ps-3">
                                <li>Gunakan password yang kuat dengan kombinasi huruf, angka, dan simbol</li>
                                <li>Pastikan email yang digunakan valid dan aktif</li>
                                <li>Berikan peran yang sesuai dengan tanggung jawab pengguna</li>
                                <li>Hindari memberikan akses administrator kecuali benar-benar diperlukan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Card Styles */
.card {
    border-radius: 16px;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.08);
}

.card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.header-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Modern Form Styles */
.form-group-modern {
    position: relative;
}

.form-label {
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
    color: #2d3748;
}

.input-group-modern {
    position: relative;
}

.form-control-modern {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.875rem 1rem 0.875rem 3rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #ffffff;
    height: 52px;
}

.form-control-modern:focus {
    border-color: #4361ee;
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    background: #ffffff;
}

.form-control-modern.is-invalid {
    border-color: #e53e3e;
    background: rgba(229, 62, 62, 0.02);
}

.form-control-modern.is-invalid:focus {
    border-color: #e53e3e;
    box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.15);
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #718096;
    z-index: 2;
}

.form-control-modern:focus + .input-icon {
    color: #4361ee;
}

.form-control-modern.is-invalid + .input-icon {
    color: #e53e3e;
}

/* Password Toggle */
.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #718096;
    cursor: pointer;
    z-index: 2;
    padding: 0.5rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.password-toggle:hover {
    background: rgba(0, 0, 0, 0.05);
    color: #4361ee;
}

/* Password Strength */
.password-strength {
    margin-top: 0.5rem;
}

.progress {
    background: #e2e8f0;
    border-radius: 2px;
}

.progress-bar {
    transition: all 0.3s ease;
    border-radius: 2px;
}

/* Modern Select Styles */
select.form-control-modern {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 1rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 3rem;
}

/* Role Info Card */
.role-info-card {
    border: 1px solid rgba(0, 0, 0, 0.08);
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.role-desc {
    transition: all 0.3s ease;
}

/* Modern Button Styles */
.btn-primary-modern {
    background: linear-gradient(135deg, #4361ee, #3a0ca3);
    border: none;
    border-radius: 12px;
    padding: 0.875rem 1.5rem;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    height: 52px;
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
    color: white;
}

.btn-secondary-modern {
    background: #ffffff;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.875rem 1.5rem;
    font-weight: 600;
    color: #4a5568;
    transition: all 0.3s ease;
    height: 52px;
}

.btn-secondary-modern:hover {
    background: #f7fafc;
    border-color: #cbd5e0;
    transform: translateY(-2px);
    color: #4a5568;
}

/* Modern Alert Styles */
.alert-modern {
    border: none;
    border-radius: 12px;
    padding: 1.25rem;
    background: rgba(254, 226, 226, 0.1);
    border-left: 4px solid #e53e3e;
}

.alert-modern .alert-heading {
    font-size: 0.95rem;
    font-weight: 600;
    color: #c53030;
    margin-bottom: 0.5rem;
}

.alert-modern ul {
    margin-bottom: 0;
}

.alert-modern li {
    font-size: 0.85rem;
    color: #742a2a;
}

/* Invalid Feedback Modern */
.invalid-feedback-modern {
    display: flex;
    align-items: center;
    width: 100%;
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: #e53e3e;
    font-weight: 500;
}

/* Security Tips Card */
.card:last-child {
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
    border: 1px solid rgba(16, 185, 129, 0.1);
}

.card:last-child h6 {
    color: #059669;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    .card-body {
        padding: 1.5rem !important;
    }

    .d-flex.gap-3 {
        flex-direction: column;
    }

    .btn-primary-modern,
    .btn-secondary-modern {
        width: 100%;
    }

    .header-icon {
        width: 48px;
        height: 48px;
    }

    .header-icon i {
        font-size: 1.25rem !important;
    }
}

@media (max-width: 576px) {
    .form-control-modern {
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        height: 48px;
    }

    .input-icon {
        left: 0.75rem;
    }

    .password-toggle {
        right: 0.75rem;
    }

    select.form-control-modern {
        background-position: right 0.75rem center;
        padding-right: 2.5rem;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.6s ease-out;
}

.card:nth-child(2) {
    animation-delay: 0.1s;
}

.card:nth-child(3) {
    animation-delay: 0.2s;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });

    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('passwordStrengthBar');
    const strengthText = document.getElementById('passwordStrengthText');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = calculatePasswordStrength(password);

        strengthBar.style.width = strength.percentage + '%';
        strengthBar.className = 'progress-bar ' + strength.class;
        strengthText.textContent = strength.text;
        strengthText.className = 'text-muted ' + strength.textClass;
    });

    function calculatePasswordStrength(password) {
        let score = 0;

        // Length check
        if (password.length >= 8) score += 25;
        if (password.length >= 12) score += 15;

        // Character variety
        if (/[a-z]/.test(password)) score += 10;
        if (/[A-Z]/.test(password)) score += 10;
        if (/[0-9]/.test(password)) score += 10;
        if (/[^a-zA-Z0-9]/.test(password)) score += 10;

        // Bonus for mixed case and numbers
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score += 10;
        if (/[0-9]/.test(password) && /[^a-zA-Z0-9]/.test(password)) score += 10;

        // Cap at 100
        score = Math.min(score, 100);

        if (score < 40) {
            return { percentage: score, class: 'bg-danger', text: 'Password lemah', textClass: 'text-danger' };
        } else if (score < 70) {
            return { percentage: score, class: 'bg-warning', text: 'Password cukup', textClass: 'text-warning' };
        } else {
            return { percentage: score, class: 'bg-success', text: 'Password kuat', textClass: 'text-success' };
        }
    }

    // Role description display
    const roleSelect = document.getElementById('role');
    const roleDescriptions = document.querySelectorAll('.role-desc');

    roleSelect.addEventListener('change', function() {
        const selectedRole = this.value;

        // Hide all descriptions
        roleDescriptions.forEach(desc => {
            desc.style.display = 'none';
        });

        // Show selected role description
        if (selectedRole) {
            document.querySelector(`.${selectedRole}-desc`).style.display = 'block';
        } else {
            document.querySelector('.default-desc').style.display = 'block';
        }
    });

    // Tombol submit loading + submit form beneran
    const submitBtn = document.querySelector('.btn.btn-primary-modern');

    submitBtn.addEventListener('click', function(event) {
        const form = document.querySelector('.needs-validation');

            if (form.checkValidity()) {
            event.preventDefault(); // stop submit default
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuat...';
            this.disabled = true;

        form.submit(); // ✅ submit beneran
    }
});


    // Real-time validation
    const inputs = document.querySelectorAll('.form-control-modern');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            this.classList.add('validated');
        });

        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.classList.remove('is-invalid');
            }
        });
    });
});

// Password visibility toggle
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('passwordToggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        toggleIcon.className = 'fas fa-eye';
    }
}
</script>
@endpush
@endsection
