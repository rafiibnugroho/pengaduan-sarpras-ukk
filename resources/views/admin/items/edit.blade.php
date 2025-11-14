@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <!-- Main Edit Card -->
            <div class="card modern-edit-card">
                <div class="card-header modern-edit-header">
                    <div class="d-flex align-items-center">
                        <div class="edit-icon-wrapper">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="header-content">
                            <h4 class="mb-1 text-white">Edit Item</h4>
                            <p class="mb-0 text-white opacity-85">Perbarui informasi item yang sudah ada</p>
                        </div>
                    </div>
                    <div class="header-badge">
                        <span class="badge bg-white text-primary">ID: {{ $item->id_item }}</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Success Message -->
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

                    <!-- Error Alert -->
                    @if($errors->any())
                        <div class="alert modern-alert-error mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-3"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Terjadi Kesalahan</h6>
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li class="small">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.items.update', $item->id_item) }}" method="POST" class="modern-edit-form">
                        @csrf
                        @method('PUT')

                        <!-- Nama Item Field -->
                        <div class="form-group-modern mb-4">
                            <div class="form-label-wrapper">
                                <label for="nama_item" class="form-label">
                                    <i class="fas fa-tag"></i>
                                    <span>Nama Item</span>
                                    <span class="required-badge">*</span>
                                </label>
                                <div class="form-tooltip">
                                    <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                       title="Nama item harus unik dan mudah dipahami"></i>
                                </div>
                            </div>
                            <div class="input-group-modern">
                                <input type="text"
                                       name="nama_item"
                                       id="nama_item"
                                       class="form-control modern-input @error('nama_item') error @enderror"
                                       placeholder="Masukkan nama item"
                                       value="{{ old('nama_item', $item->nama_item) }}"
                                       required>
                                <div class="input-state">
                                    <i class="fas fa-check valid-icon"></i>
                                    <i class="fas fa-times invalid-icon"></i>
                                </div>
                            </div>
                            @error('nama_item')
                                <div class="form-error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Deskripsi Field -->
                        <div class="form-group-modern mb-4">
                            <div class="form-label-wrapper">
                                <label for="deskripsi" class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    <span>Deskripsi Barang</span>
                                </label>
                                <div class="form-tooltip">
                                    <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                       title="Deskripsi yang jelas membantu identifikasi item"></i>
                                </div>
                            </div>
                            <div class="textarea-container">
                                <textarea class="form-control modern-textarea @error('deskripsi') error @enderror"
                                          id="deskripsi"
                                          name="deskripsi"
                                          rows="4"
                                          placeholder="Masukkan deskripsi lengkap tentang item ini...">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
                                <div class="textarea-footer">
                                    <div class="form-hint">
                                        <i class="fas fa-lightbulb"></i>
                                        Opsional namun disarankan untuk deskripsi yang jelas
                                    </div>
                                    <div class="char-count">
                                        <span id="charCount">0</span>/500
                                    </div>
                                </div>
                            </div>
                            @error('deskripsi')
                                <div class="form-error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="form-actions">
                            <div class="action-buttons">
                               
                                <button type="submit" class="btn btn-primary btn-modern">
                                    <i class="fas fa-save"></i>
                                    <span>Update Item</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Information Sidebar -->
            <div class="row mt-4">
                <div class="col-12">
                    <!-- Item Info Card -->
                    <div class="card info-card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Item
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-calendar"></i>
                                    Dibuat
                                </div>
                                <div class="info-value">
                                    {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-history"></i>
                                    Diupdate
                                </div>
                                <div class="info-value">
                                    {{ $item->updated_at ? $item->updated_at->format('d M Y, H:i') : '-' }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-database"></i>
                                    Status
                                </div>
                                <div class="info-value">
                                    <span class="status-badge active">Aktif</span>
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

    /* Modern Edit Card */
    .modern-edit-card {
        border: none;
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        background: white;
        overflow: hidden;
        transition: var(--transition);
    }

    .modern-edit-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .modern-edit-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-bottom: none;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .modern-edit-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .edit-icon-wrapper {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .edit-icon-wrapper i {
        font-size: 1.5rem;
        color: white;
    }

    .header-content h4 {
        font-weight: 700;
        font-size: 1.5rem;
    }

    .header-content p {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .header-badge {
        position: absolute;
        top: 1.5rem;
        right: 2rem;
    }

    /* Form Styles */
    .modern-edit-form {
        padding: 0.5rem;
    }

    .form-group-modern {
        margin-bottom: 2rem;
    }

    .form-label-wrapper {
        display: flex;
        align-items: center;
        justify-content: between;
        margin-bottom: 0.75rem;
    }

    .form-label {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.95rem;
        flex-grow: 1;
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

    .form-tooltip {
        margin-left: 0.5rem;
    }

    .form-tooltip i {
        color: var(--secondary);
        cursor: help;
        opacity: 0.7;
        transition: var(--transition);
    }

    .form-tooltip i:hover {
        opacity: 1;
        color: var(--primary);
    }

    /* Input Styles */
    .input-group-modern {
        position: relative;
    }

    .modern-input {
        border: 2px solid var(--border);
        border-radius: 10px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        width: 100%;
    }

    .modern-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        outline: none;
        transform: translateY(-1px);
    }

    .modern-input.error {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .input-state {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0;
        transition: var(--transition);
    }

    .modern-input:valid + .input-state .valid-icon {
        opacity: 1;
        color: var(--success);
    }

    .modern-input:invalid:not(:placeholder-shown) + .input-state .invalid-icon {
        opacity: 1;
        color: var(--danger);
    }

    /* Textarea Styles */
    .modern-textarea {
        border: 2px solid var(--border);
        border-radius: 10px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        width: 100%;
        resize: vertical;
        min-height: 120px;
    }

    .modern-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        outline: none;
    }

    .textarea-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.75rem;
        font-size: 0.875rem;
    }

    .form-hint {
        color: var(--secondary);
        display: flex;
        align-items: center;
    }

    .form-hint i {
        margin-right: 0.5rem;
        color: var(--warning);
    }

    .char-count {
        color: var(--secondary);
        font-weight: 500;
    }

    /* Button Styles */
    .form-actions {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border);
    }

    .action-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .btn-modern {
        border: none;
        border-radius: 10px;
        padding: 0.875rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        box-shadow: var(--shadow);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    }

    .btn-secondary {
        background: var(--light);
        color: var(--secondary);
        border: 1px solid var(--border);
    }

    .btn-secondary:hover {
        background: var(--border);
        transform: translateY(-2px);
        color: var(--dark);
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

    /* Info Card */
    .info-card {
        border: none;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .info-card .card-header {
        background: var(--primary-light);
        border-bottom: 1px solid var(--border);
        color: var(--primary);
        font-weight: 600;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--secondary);
        font-size: 0.875rem;
    }

    .info-value {
        font-weight: 500;
        color: var(--dark);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-badge.active {
        background: var(--primary-light);
        color: var(--primary);
    }

    /* Form Error Message */
    .form-error-message {
        color: var(--danger);
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .modern-edit-header {
            padding: 1.5rem;
            text-align: center;
        }

        .edit-icon-wrapper {
            margin: 0 auto 1rem auto;
        }

        .header-content {
            width: 100%;
        }

        .header-badge {
            position: static;
            margin-top: 1rem;
            text-align: center;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-modern {
            width: 100%;
            justify-content: center;
        }

        .textarea-footer {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {
        .modern-edit-header {
            padding: 1.25rem;
        }

        .header-content h4 {
            font-size: 1.25rem;
        }

        .form-label-wrapper {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .form-tooltip {
            align-self: flex-end;
        }
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Character counter
    const textarea = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');

    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;

            if (length > 450) {
                charCount.style.color = 'var(--danger)';
            } else if (length > 400) {
                charCount.style.color = 'var(--warning)';
            } else {
                charCount.style.color = 'var(--secondary)';
            }
        });

        charCount.textContent = textarea.value.length;
    }

    // Form submission
    const form = document.querySelector('.modern-edit-form');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function() {
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memperbarui...</span>';
        }
    });

    // Input validation states
    const inputs = form.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            this.classList.add('touched');
        });
    });

    // Auto-focus on first input
    const firstInput = document.getElementById('nama_item');
    if (firstInput) {
        firstInput.focus();
        firstInput.select();
    }
});
</script>
@endpush
@endsection
