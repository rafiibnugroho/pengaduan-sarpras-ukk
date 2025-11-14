@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card modern-card">
                <div class="card-header modern-card-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon-wrapper bg-primary bg-opacity-10 rounded p-3 me-3">
                            <i class="fas fa-cube text-primary fs-5"></i>
                        </div>
                        <div class="header-content">
                            <h4 class="mb-1 text-white">Tambah Item Baru</h4>
                            <p class="mb-0 text-white opacity-75 small">Tambahkan item baru ke dalam sistem inventory</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.items.store') }}" method="POST" class="modern-form">
                        @csrf

                        <!-- Nama Item Field -->
                        <div class="form-group-modern mb-4">
                            <label for="nama_item" class="form-label fw-semibold mb-3">
                                <i class="fas fa-tag me-2 text-primary"></i>Nama Item
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group-modern">
                                <input type="text"
                                       name="nama_item"
                                       id="nama_item"
                                       class="form-control modern-input py-3 px-3"
                                       placeholder="Masukkan nama item"
                                       value="{{ old('nama_item') }}"
                                       required>
                                <div class="input-icon">
                                    <i class="fas fa-asterisk text-danger small"></i>
                                </div>
                            </div>
                            @error('nama_item')
                                <div class="form-error-message mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Deskripsi Field -->
                        <div class="form-group-modern mb-4">
                            <label for="deskripsi" class="form-label fw-semibold mb-3">
                                <i class="fas fa-align-left me-2 text-primary"></i>Deskripsi Barang
                            </label>
                            <div class="textarea-container">
                                <textarea class="form-control modern-textarea py-3 px-3"
                                          id="deskripsi"
                                          name="deskripsi"
                                          rows="5"
                                          placeholder="Masukkan deskripsi lengkap tentang item ini...">{{ old('deskripsi') }}</textarea>
                                <div class="textarea-footer d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Deskripsi opsional namun disarankan
                                    </small>
                                    <small class="char-count text-muted">
                                        <span id="charCount">0</span>/500 karakter
                                    </small>
                                </div>
                            </div>
                            @error('deskripsi')
                                <div class="form-error-message mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="form-actions pt-3 mt-4 border-top">
                            <div class="d-flex gap-3 justify-content-end">
                                
                                <button type="submit" class="btn btn-primary btn-modern">
                                    <i class="fas fa-save me-2"></i>
                                    Simpan Item
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card modern-info-card mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="info-icon me-3">
                            <i class="fas fa-lightbulb text-warning fs-4"></i>
                        </div>
                        <div class="info-content">
                            <h6 class="mb-2">Tips Pengisian Item</h6>
                            <ul class="list-unstyled mb-0 small">
                                <li class="mb-1">
                                    <i class="fas fa-check-circle text-success me-2 small"></i>
                                    Gunakan nama item yang jelas dan mudah dipahami
                                </li>
                                <li class="mb-1">
                                    <i class="fas fa-check-circle text-success me-2 small"></i>
                                    Deskripsi membantu identifikasi item yang lebih detail
                                </li>
                                <li>
                                    <i class="fas fa-check-circle text-success me-2 small"></i>
                                    Pastikan item belum terdaftar sebelumnya
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #4f46e5;
        --secondary-color: #4338ca;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --light-bg: #f8fafc;
        --border-radius: 16px;
        --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    /* Modern Card Styling */
    .modern-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        overflow: hidden;
        background: white;
    }

    .modern-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .modern-card-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-bottom: none;
        padding: 1.5rem 2rem;
    }

    .header-icon-wrapper {
        transition: var(--transition);
    }

    .modern-card-header:hover .header-icon-wrapper {
        transform: scale(1.05);
        background: rgba(255, 255, 255, 0.15) !important;
    }

    /* Form Styling */
    .modern-form {
        padding: 0.5rem;
    }

    .form-group-modern {
        position: relative;
    }

    .form-label {
        color: #374151;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
    }

    .form-label i {
        width: 20px;
        text-align: center;
    }

    .input-group-modern {
        position: relative;
    }

    .modern-input, .modern-textarea {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .modern-input:focus, .modern-textarea:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        background: white;
    }

    .modern-input {
        padding-left: 3rem !important;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        z-index: 5;
    }

    .modern-input:focus + .input-icon {
        color: var(--primary-color);
    }

    .modern-textarea {
        resize: vertical;
        min-height: 120px;
        border-radius: 12px;
    }

    /* Character Count */
    .char-count {
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Buttons */
    .btn-modern {
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .btn-primary.btn-modern {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
    }

    .btn-primary.btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
    }

    .btn-outline-secondary.btn-modern {
        border-color: #d1d5db;
        color: #6b7280;
    }

    .btn-outline-secondary.btn-modern:hover {
        background: #f9fafb;
        border-color: #9ca3af;
        color: #374151;
        transform: translateY(-2px);
    }

    /* Form Error Styling */
    .form-error-message {
        color: var(--danger-color);
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.5rem 0.75rem;
        background: rgba(239, 68, 68, 0.05);
        border-radius: 8px;
        border-left: 3px solid var(--danger-color);
    }

    /* Info Card */
    .modern-info-card {
        border: none;
        border-radius: var(--border-radius);
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border-left: 4px solid var(--info-color);
        box-shadow: var(--box-shadow);
    }

    .info-icon {
        margin-top: 0.25rem;
    }

    .modern-info-card h6 {
        color: #1e40af;
        font-weight: 600;
    }

    .modern-info-card li {
        color: #475569;
        line-height: 1.5;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .modern-card-header {
            padding: 1.25rem 1.5rem;
        }

        .header-content h4 {
            font-size: 1.25rem;
        }

        .form-actions {
            flex-direction: column;
            gap: 1rem !important;
        }

        .btn-modern {
            width: 100%;
            justify-content: center;
        }

        .modern-input, .modern-textarea {
            font-size: 16px; /* Prevent zoom on iOS */
        }

        .textarea-footer {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .modern-card-header {
            text-align: center;
            padding: 1.5rem 1rem;
        }

        .header-icon-wrapper {
            margin: 0 auto 1rem auto !important;
        }

        .header-content {
            width: 100%;
        }

        .modern-input {
            padding-left: 2.5rem !important;
        }

        .input-icon {
            left: 0.75rem;
        }
    }

    /* Loading State */
    .btn-modern:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Success State Animation */
    @keyframes successPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }

    .modern-card.success {
        animation: successPulse 0.6s ease-in-out;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter for description
    const textarea = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');

    if (textarea && charCount) {
        // Update character count on input
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;

            // Change color when approaching limit
            if (length > 450) {
                charCount.classList.add('text-danger');
            } else {
                charCount.classList.remove('text-danger');
            }
        });

        // Initialize character count
        charCount.textContent = textarea.value.length;
    }

    // Form submission enhancement
    const form = document.querySelector('.modern-form');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function() {
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        }
    });

    // Add success animation on page load if there's a success message
    @if(session('success'))
        const card = document.querySelector('.modern-card');
        card.classList.add('success');
        setTimeout(() => {
            card.classList.remove('success');
        }, 600);
    @endif

    // Auto-focus on first input
    const firstInput = document.querySelector('input[type="text"]');
    if (firstInput) {
        firstInput.focus();
    }
});
</script>
@endpush
@endsection
