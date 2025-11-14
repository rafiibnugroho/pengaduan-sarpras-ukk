@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <!-- Header Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="header-icon bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-plus-circle text-primary fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Tambah Lokasi Baru</h4>
                            <p class="text-muted mb-0">Buat lokasi baru untuk pengelolaan barang dan sarana prasarana</p>
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

                    <form action="{{ route('admin.lokasi.store') }}" method="POST">

                        @csrf

                        <!-- Nama Lokasi Field -->
                        <div class="form-group-modern mb-4">
                            <label for="nama_lokasi" class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Nama Lokasi
                            </label>
                            <div class="input-group-modern">
                                <input type="text"
                                       name="nama_lokasi"
                                       id="nama_lokasi"
                                       class="form-control-modern @error('nama_lokasi') is-invalid @enderror"
                                       value="{{ old('nama_lokasi') }}"
                                       placeholder="Masukkan nama lokasi (contoh: Gudang Utama, Ruang Server)"
                                       required
                                       autofocus>

                            </div>
                            @error('nama_lokasi')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                            <div class="form-text text-muted small mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Gunakan nama yang deskriptif dan mudah diidentifikasi
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 pt-3">
                            <button type="submit" class="btn btn-primary-modern flex-fill">
                                <i class="fas fa-plus-circle me-2"></i>
                                Buat Lokasi
                            </button>
                           
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-lightbulb text-warning me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-semibold mb-2">Tips Penamaan Lokasi</h6>
                            <ul class="text-muted small mb-0 ps-3">
                                <li>Gunakan nama yang jelas dan mudah dipahami</li>
                                <li>Hindari penamaan yang terlalu umum</li>
                                <li>Pertimbangkan hierarki lokasi (Gedung A - Lantai 1 - Ruang 101)</li>
                                <li>Gunakan konsistensi dalam penamaan semua lokasi</li>
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

/* Form Text Styling */
.form-text {
    font-size: 0.8rem;
}

/* Info Card Styling */
.card:last-child {
    background: linear-gradient(135deg, #fffaf0 0%, #fefce8 100%);
    border: 1px solid rgba(251, 191, 36, 0.1);
}

.card:last-child h6 {
    color: #d97706;
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

/* Focus Animation */
.form-control-modern:focus {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.15);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(67, 97, 238, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(67, 97, 238, 0);
    }
}

/* Success State Preview */
.form-control-modern:valid:not(:focus) {
    border-color: #10b981;
    background: rgba(16, 185, 129, 0.02);
}

.form-control-modern:valid:not(:focus) + .input-icon {
    color: #10b981;
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

    // Real-time validation
    const namaLokasiInput = document.getElementById('nama_lokasi');
    if (namaLokasiInput) {
        namaLokasiInput.addEventListener('input', function() {
            if (this.value.trim().length > 0) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
            }
        });

        namaLokasiInput.addEventListener('blur', function() {
            this.classList.add('validated');
        });
    }

    // Add loading state to submit button
    const submitBtn = document.querySelector('.btn-primary-modern');
    if (submitBtn) {
        submitBtn.addEventListener('click', function() {
            if (document.querySelector('.needs-validation').checkValidity()) {
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuat...';
                this.disabled = true;

                // Re-enable after 5 seconds in case of error
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-plus-circle me-2"></i>Buat Lokasi';
                    this.disabled = false;
                }, 5000);
            }
        });
    }

    // Character counter for nama lokasi
    const updateCharacterCount = () => {
        const count = namaLokasiInput.value.length;
        const counter = document.getElementById('charCount') || createCharacterCounter();
        counter.textContent = `${count}/100 karakter`;

        if (count > 80) {
            counter.style.color = '#e53e3e';
        } else if (count > 50) {
            counter.style.color = '#f59e0b';
        } else {
            counter.style.color = '#6b7280';
        }
    };

    const createCharacterCounter = () => {
        const counter = document.createElement('div');
        counter.id = 'charCount';
        counter.className = 'form-text text-muted small mt-1 text-end';
        counter.textContent = '0/100 karakter';
        namaLokasiInput.parentNode.appendChild(counter);
        return counter;
    };

    if (namaLokasiInput) {
        namaLokasiInput.addEventListener('input', updateCharacterCount);
        namaLokasiInput.maxLength = 100;
        updateCharacterCount(); // Initialize counter
    }
});
</script>
@endpush
@endsection
