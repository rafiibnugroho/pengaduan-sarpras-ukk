@extends('layouts.user')

@section('title', 'Buat Pengaduan Baru - ' . config('app.name'))

@section('content')
<div class="min-vh-100 bg-light">
    <!-- Background Elements -->
    <div class="position-fixed w-100 h-100 top-0 start-0" style="z-index: -1;">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
        <div class="floating-shape shape-4"></div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <!-- Header Section -->
                <div class="text-center mb-6">
                    <div class="header-icon mb-4">
                        <div class="icon-wrapper">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                    <h1 class="display-5 fw-bold text-dark mb-3">Buat Pengaduan Baru</h1>
                    <p class="lead text-muted fs-5">Laporkan masalah dengan mudah melalui formulir yang intuitif</p>
                </div>

                <!-- Progress Steps -->
                <div class="modern-progress mb-6">
                    <div class="progress-container">
                        <div class="progress-bar" id="progressBar"></div>
                        <div class="steps">
                            <div class="step active" data-step="1">
                                <div class="step-circle">
                                    <span>1</span>
                                </div>
                                <span class="step-label">Informasi</span>
                            </div>
                            <div class="step" data-step="2">
                                <div class="step-circle">
                                    <span>2</span>
                                </div>
                                <span class="step-label">Lokasi</span>
                            </div>
                            <div class="step" data-step="3">
                                <div class="step-circle">
                                    <span>3</span>
                                </div>
                                <span class="step-label">Lampiran</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form Card -->
                <div class="modern-form-card">
                    <form id="pengaduanForm" action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Step 1: Basic Information -->
                        <div class="form-step active" data-step="1">
                            <div class="step-header">
                                <h3 class="step-title">
                                    <i class="fas fa-info-circle me-3"></i>
                                    Informasi Pengaduan
                                </h3>
                                <p class="step-subtitle">Berikan detail tentang masalah yang Anda temui</p>
                            </div>

                            <div class="form-content">
                                <!-- Judul Pengaduan -->
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <span class="label-text">Judul Pengaduan</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <i class="input-icon fas fa-heading"></i>
                                        <input type="text"
                                               name="nama_pengaduan"
                                               class="form-input-modern"
                                               placeholder="Contoh: Kerusakan PC di Lab Komputer DKV"
                                               required
                                               maxlength="100">
                                    </div>
                                    <div class="form-hint">Buat judul yang jelas dan deskriptif</div>
                                </div>

                                <!-- Deskripsi -->
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <span class="label-text">Deskripsi Lengkap</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="textarea-group-modern">
                                        <i class="input-icon fas fa-align-left"></i>
                                        <textarea name="deskripsi"
                                                  class="form-textarea-modern"
                                                  rows="5"
                                                  placeholder="Jelaskan secara detail masalah yang ditemukan, kapan pertama kali terjadi."
                                                  required
                                                  maxlength="500"></textarea>
                                        <div class="textarea-footer">
                                            <div class="form-hint">Jelaskan dengan detail untuk memudahkan penanganan</div>
                                            <div class="char-counter">
                                                <span id="charCount">0</span>/500 karakter
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="step-actions" style="display: flex; justify-content: flex-end;">
                                <button type="button" class="btn-next" data-next="2">
                                    Lanjut
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Location & Item -->
                        <div class="form-step" data-step="2">
                            <div class="step-header">
                                <h3 class="step-title">
                                    <i class="fas fa-map-marker-alt me-3"></i>
                                    Lokasi & Barang
                                </h3>
                                <p class="step-subtitle">Tentukan dimana masalah terjadi dan barang yang bermasalah</p>
                            </div>

                            <div class="form-content">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern">
                                                <span class="label-text">Lokasi Kejadian</span>
                                                <span class="label-optional">(Opsional)</span>
                                            </label>
                                            <div class="input-group-modern">
                                                <i class="input-icon fas fa-location-dot"></i>
                                                <select id="id_lokasi" name="id_lokasi" class="form-select-modern">
                                                    <option value="">Pilih lokasi atau isi manual di bawah</option>
                                                    @foreach($lokasi as $l)
                                                        <option value="{{ $l->id_lokasi }}">{{ $l->nama_lokasi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-hint">Pilih lokasi dimana masalah terjadi</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern">
                                                <span class="label-text">Barang yang Bermasalah</span>
                                                <span class="label-optional">(Opsional)</span>
                                            </label>
                                            <div class="input-group-modern">
                                                <i class="input-icon fas fa-cube"></i>
                                                <select id="id_item" name="id_item" class="form-select-modern" disabled>
                                                    <option value="">Pilih barang atau isi manual di bawah</option>
                                                </select>
                                                <div class="loading-indicator">
                                                    <div class="spinner"></div>
                                                </div>
                                            </div>
                                            <div class="form-hint">Barang akan tersedia setelah memilih lokasi</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Request Baru -->
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern">
                                                <span class="label-text">Request Barang Baru</span>
                                            </label>
                                            <div class="input-group-modern">
                                                <i class="input-icon fas fa-plus-circle"></i>
                                                <input type="text" name="nama_barang_baru" class="form-input-modern" placeholder="Nama Barang Baru">
                                            </div>
                                            <div class="form-hint">Jika barang yang diinginkan tidak ada dalam daftar</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern">
                                                <span class="label-text">Lokasi Baru</span>
                                            </label>
                                            <div class="input-group-modern">
                                                <i class="input-icon fas fa-map-marker-alt"></i>
                                                <input type="text" name="lokasi_baru" class="form-input-modern" placeholder="Lokasi Baru">
                                            </div>
                                            <div class="form-hint">Jika lokasi baru untuk barang yang diminta</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="step-actions">
                                <button type="button" class="btn-prev" data-prev="1">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali
                                </button>
                                <button type="button" class="btn-next" data-next="3">
                                    Lanjut
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Attachment & Submit -->
                        <div class="form-step" data-step="3">
                            <div class="step-header">
                                <h3 class="step-title">
                                    <i class="fas fa-paperclip me-3"></i>
                                    Lampiran & Pengiriman
                                </h3>
                                <p class="step-subtitle">Lampirkan bukti foto dan kirim pengaduan Anda</p>
                            </div>

                            <div class="form-content">
                                <!-- File Upload -->
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <span class="label-text">Bukti Foto</span>
                                        <span class="label-optional">(Opsional)</span>
                                    </label>

                                    <div class="file-upload-modern">
                                        <input type="file" name="foto" id="foto" class="file-input" accept="image/*" hidden>
                                        <div class="upload-area" id="uploadArea">
                                            <div class="upload-content">
                                                <i class="upload-icon fas fa-cloud-upload-alt"></i>
                                                <h4 class="upload-title">Unggah Bukti Foto</h4>
                                                <p class="upload-subtitle">Seret atau klik untuk memilih file</p>
                                                <div class="upload-requirements">
                                                    <span class="requirement">Format: JPG, PNG, JPEG</span>
                                                    <span class="requirement">Maksimal: 5MB</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="file-preview-modern" id="filePreview">
                                            <div class="preview-content">
                                                <img class="preview-image" id="previewImage">
                                                <div class="preview-info">
                                                    <div class="preview-name" id="previewName"></div>
                                                    <div class="preview-size" id="previewSize"></div>
                                                </div>
                                                <button type="button" class="btn-remove" onclick="removeFile()">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tips Section -->
                                <div class="tips-card">
                                    <div class="tips-header">
                                        <i class="fas fa-lightbulb"></i>
                                        <span>Tips Foto yang Baik</span>
                                    </div>
                                    <div class="tips-content">
                                        <div class="tip-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Ambil foto dalam kondisi pencahayaan yang baik</span>
                                        </div>
                                        <div class="tip-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Fokus pada area yang rusak atau bermasalah</span>
                                        </div>
                                        <div class="tip-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Sertakan objek sekitarnya sebagai referensi</span>
                                        </div>
                                        <div class="tip-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Ambil dari berbagai sudut pandang jika memungkinkan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="step-actions">
                                <button type="button" class="btn-prev" data-prev="2">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali
                                </button>
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Kirim Pengaduan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-body text-center p-5">
                <div class="success-icon mb-4">
                    <i class="fas fa-check"></i>
                </div>
                <h4 class="modal-title mb-3">Pengaduan Berhasil Dikirim!</h4>
                <p class="text-muted mb-4">Pengaduan Anda telah berhasil direkam dan akan segera diproses oleh tim terkait.</p>
                <button type="button" class="btn-modal" data-bs-dismiss="modal">Tutup</button>
            </div>
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
.floating-shape {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-light), var(--primary));
    opacity: 0.03;
    animation: float 20s ease-in-out infinite;
}

.shape-1 {
    width: 300px;
    height: 300px;
    top: 10%;
    left: 5%;
    animation-delay: 0s;
}

.shape-2 {
    width: 200px;
    height: 200px;
    top: 60%;
    right: 10%;
    animation-delay: 5s;
}

.shape-3 {
    width: 150px;
    height: 150px;
    bottom: 20%;
    left: 15%;
    animation-delay: 10s;
}

.shape-4 {
    width: 250px;
    height: 250px;
    top: 20%;
    right: 15%;
    animation-delay: 15s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-30px) rotate(180deg); }
}

/* Header Section */
.header-icon {
    display: flex;
    justify-content: center;
}

.icon-wrapper {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-xl);
    position: relative;
}

.icon-wrapper::before {
    content: '';
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(99, 102, 241, 0.1);
    animation: pulse 2s ease-in-out infinite;
}

.icon-wrapper i {
    font-size: 2.5rem;
    color: white;
    position: relative;
    z-index: 2;
}

@keyframes pulse {
    0%, 100% { transform: scale(0.8); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.5; }
}

/* Progress Steps */
.modern-progress {
    max-width: 600px;
    margin: 0 auto;
}

.progress-container {
    position: relative;
    padding: 0 80px;
}

.progress-bar {
    position: absolute;
    top: 25px;
    left: 80px;
    right: 80px;
    height: 4px;
    background: var(--gray-200);
    border-radius: 2px;
    overflow: hidden;
    z-index: 1;
}

.progress-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, var(--primary), var(--secondary));
    transition: width 0.6s ease;
    border-radius: 2px;
}

.steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 2;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.step-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: white;
    border: 3px solid var(--gray-300);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: var(--gray-400);
    transition: all 0.4s ease;
    box-shadow: var(--shadow);
    margin-bottom: 12px;
}

.step.active .step-circle {
    border-color: var(--primary);
    background: var(--primary);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
}

.step.completed .step-circle {
    border-color: var(--secondary);
    background: var(--secondary);
    color: white;
}

.step.completed .step-circle::after {
    content: '✓';
    font-weight: bold;
}

.step-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-400);
    transition: all 0.3s ease;
}

.step.active .step-label {
    color: var(--primary);
    font-weight: 700;
}

/* Main Form Card */
.modern-form-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    margin-bottom: 3rem;
}

/* Form Steps */
.form-step {
    display: none;
    padding: 3rem;
    animation: slideIn 0.5s ease;
}

.form-step.active {
    display: block;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Step Header */
.step-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--gray-200);
}

.step-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.step-title i {
    color: var(--primary);
}

.step-subtitle {
    color: var(--gray-500);
    font-size: 1.1rem;
    margin: 0;
}

/* Form Elements */
.form-group-modern {
    margin-bottom: 2rem;
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

.label-optional {
    color: var(--gray-400);
    margin-left: 4px;
    font-weight: 400;
}

.input-group-modern, .textarea-group-modern {
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

.form-input-modern, .form-select-modern, .form-textarea-modern {
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

.form-textarea-modern {
    resize: vertical;
    min-height: 120px;
}

.form-input-modern:focus, .form-select-modern:focus, .form-textarea-modern:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.form-input-modern:focus + .input-icon,
.form-select-modern:focus + .input-icon,
.form-textarea-modern:focus + .input-icon {
    color: var(--primary);
}

.textarea-group-modern .input-icon {
    top: 1.5rem;
    transform: none;
}

.textarea-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.5rem;
}

.char-counter {
    font-size: 0.875rem;
    color: var(--gray-400);
    font-weight: 600;
}

.form-hint {
    font-size: 0.875rem;
    color: var(--gray-400);
    margin-top: 0.5rem;
}

/* Loading Indicator */
.loading-indicator {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    display: none;
}

.loading-indicator.active {
    display: block;
}

.spinner {
    width: 20px;
    height: 20px;
    border: 2px solid var(--gray-200);
    border-top: 2px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* File Upload Modern - PERBAIKAN UTAMA */
.file-upload-modern {
    position: relative;
    width: 100%;
}

.file-input {
    display: none;
}

.upload-area {
    border: 2px dashed var(--gray-300);
    border-radius: var(--radius-lg);
    padding: 3rem 2rem;
    text-align: center;
    background: var(--gray-100);
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    width: 100%;
    display: block;
}

.upload-area:hover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.02);
}

.upload-area.dragover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
    transform: scale(1.02);
}

.upload-content {
    pointer-events: none;
}

.upload-icon {
    font-size: 3rem;
    color: var(--gray-400);
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.upload-area:hover .upload-icon {
    color: var(--primary);
    transform: translateY(-5px);
}

.upload-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.upload-subtitle {
    color: var(--gray-500);
    margin-bottom: 1.5rem;
}

.upload-requirements {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.requirement {
    font-size: 0.875rem;
    color: var(--gray-400);
    padding: 0.25rem 0.75rem;
    background: white;
    border-radius: 20px;
    border: 1px solid var(--gray-200);
}

.file-preview-modern {
    display: none;
    margin-top: 1rem;
    width: 100%;
}

.preview-content {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: white;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    width: 100%;
}

.preview-content:hover {
    border-color: var(--primary);
    transform: translateY(-2px);
}

.preview-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
}

.preview-info {
    flex: 1;
}

.preview-name {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.preview-size {
    font-size: 0.875rem;
    color: var(--gray-400);
}

.btn-remove {
    width: 40px;
    height: 40px;
    border: none;
    background: var(--gray-100);
    border-radius: var(--radius);
    color: var(--gray-500);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-remove:hover {
    background: var(--danger);
    color: white;
    transform: rotate(90deg);
}

/* Tips Card */
.tips-card {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    border: 1px solid #bae6fd;
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    margin-top: 2rem;
}

.tips-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    font-weight: 600;
    color: var(--dark);
}

.tips-header i {
    color: var(--accent);
    margin-right: 0.75rem;
    font-size: 1.25rem;
}

.tip-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    color: var(--gray-600);
}

.tip-item i {
    color: var(--secondary);
    margin-right: 0.75rem;
    font-size: 0.875rem;
}

.tip-item:last-child {
    margin-bottom: 0;
}

/* Step Actions */
.step-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid var(--gray-200);
}

.btn-prev, .btn-next, .btn-submit {
    padding: 1rem 2rem;
    border: none;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.btn-prev {
    background: var(--gray-100);
    color: var(--gray-600);
}

.btn-prev:hover {
    background: var(--gray-200);
    transform: translateX(-2px);
}

.btn-next {
    background: var(--primary);
    color: white;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

.btn-next:hover {
    background: var(--primary-dark);
    transform: translateX(2px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
}

.btn-submit {
    background: linear-gradient(135deg, var(--secondary), #059669);
    color: white;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

/* Success Modal */
.modern-modal {
    border: none;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
}

.success-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--secondary), #059669);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
}

.success-icon i {
    font-size: 2rem;
    color: white;
}

.btn-modal {
    padding: 0.75rem 2rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: var(--radius);
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-modal:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    .modern-form-card {
        margin: 0 -1rem;
        border-radius: 0;
    }

    .form-step {
        padding: 2rem 1.5rem;
    }

    .progress-container {
        padding: 0 40px;
    }

    .progress-bar {
        left: 40px;
        right: 40px;
    }

    .step-circle {
        width: 40px;
        height: 40px;
    }

    .step-label {
        font-size: 0.75rem;
    }

    .step-actions {
        flex-direction: column;
        gap: 1rem;
    }

    .btn-prev, .btn-next, .btn-submit {
        width: 100%;
        justify-content: center;
    }

    .upload-area {
        padding: 2rem 1rem;
    }

    .upload-requirements {
        flex-direction: column;
        gap: 0.5rem;
    }

    .preview-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
}

@media (max-width: 576px) {
    .step-title {
        font-size: 1.5rem;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-input-modern, .form-select-modern, .form-textarea-modern {
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
    // Initialize variables
    const formSteps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('.step');
    const progressBar = document.getElementById('progressBar');
    let currentStep = 1;

    // Character counter
    const descTextarea = document.querySelector('textarea[name="deskripsi"]');
    const charCount = document.getElementById('charCount');

    if (descTextarea && charCount) {
        descTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }

    // Step navigation functions
    function showStep(stepNumber) {
        // Hide all steps
        formSteps.forEach(step => step.classList.remove('active'));

        // Show current step
        const currentStepElement = document.querySelector(`.form-step[data-step="${stepNumber}"]`);
        if (currentStepElement) {
            currentStepElement.classList.add('active');
        }

        // Update progress steps
        progressSteps.forEach((step, index) => {
            step.classList.remove('active', 'completed');
            if (index + 1 < stepNumber) {
                step.classList.add('completed');
            } else if (index + 1 === stepNumber) {
                step.classList.add('active');
            }
        });

        // Update progress bar
        const progressPercentage = ((stepNumber - 1) / (formSteps.length - 1)) * 100;
        if (progressBar) {
            progressBar.style.width = `${progressPercentage}%`;
        }

        currentStep = stepNumber;
    }

    // Next step buttons
    document.querySelectorAll('.btn-next').forEach(button => {
        button.addEventListener('click', function() {
            const nextStep = parseInt(this.dataset.next);

            if (validateStep(currentStep)) {
                showStep(nextStep);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });

    // Previous step buttons
    document.querySelectorAll('.btn-prev').forEach(button => {
        button.addEventListener('click', function() {
            const prevStep = parseInt(this.dataset.prev);
            showStep(prevStep);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    // Step validation
    function validateStep(stepNumber) {
        let isValid = true;
        let errorMessage = '';

        switch(stepNumber) {
            case 1:
                const judul = document.querySelector('input[name="nama_pengaduan"]');
                const deskripsi = document.querySelector('textarea[name="deskripsi"]');

                if (!judul || !judul.value.trim()) {
                    errorMessage = 'Judul pengaduan harus diisi';
                    isValid = false;
                } else if (judul.value.trim().length < 5) {
                    errorMessage = 'Judul pengaduan terlalu pendek (minimal 5 karakter)';
                    isValid = false;
                } else if (!deskripsi || !deskripsi.value.trim()) {
                    errorMessage = 'Deskripsi pengaduan harus diisi';
                    isValid = false;
                } else if (deskripsi.value.trim().length < 10) {
                    errorMessage = 'Deskripsi terlalu pendek (minimal 10 karakter)';
                    isValid = false;
                }
                break;

            case 2:
                const lokasi = document.querySelector('select[name="id_lokasi"]');
                const item = document.querySelector('select[name="id_item"]');
                const lokasiBaru = document.querySelector('input[name="lokasi_baru"]');
                const barangBaru = document.querySelector('input[name="nama_barang_baru"]');

                if ((!lokasi || !lokasi.value) && (!lokasiBaru || !lokasiBaru.value.trim() || !barangBaru || !barangBaru.value.trim())) {
                    errorMessage = 'Harap pilih lokasi kejadian atau isi Lokasi Baru dan Barang Baru';
                    isValid = false;
                } else if ((!item || !item.value) && (!lokasiBaru || !lokasiBaru.value.trim() || !barangBaru || !barangBaru.value.trim())) {
                    errorMessage = 'Harap pilih barang yang bermasalah atau isi Barang Baru';
                    isValid = false;
                }
                break;
        }

        if (!isValid) {
            showToast(errorMessage, 'error');
        }

        return isValid;
    }

    // File upload functionality - PERBAIKAN UTAMA
    const fileInput = document.getElementById('foto');
    const uploadArea = document.getElementById('uploadArea');
    const filePreview = document.getElementById('filePreview');
    const previewImage = document.getElementById('previewImage');
    const previewName = document.getElementById('previewName');
    const previewSize = document.getElementById('previewSize');

    if (fileInput && uploadArea) {
        // Click to upload
        uploadArea.addEventListener('click', () => fileInput.click());

        // Drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => uploadArea.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => uploadArea.classList.remove('dragover'), false);
        });

        uploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const files = e.dataTransfer.files;
            fileInput.files = files;
            handleFileSelect(files);
        }

        // File input change
        fileInput.addEventListener('change', function() {
            handleFileSelect(this.files);
        });

        function handleFileSelect(files) {
            if (files.length > 0) {
                const file = files[0];

                // Validate file type
                if (!file.type.match('image.*')) {
                    showToast('Harap pilih file gambar yang valid (JPG, PNG, JPEG)', 'error');
                    return;
                }

                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showToast('Ukuran file maksimal 5MB', 'error');
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImage) previewImage.src = e.target.result;
                    if (previewName) previewName.textContent = file.name;
                    if (previewSize) previewSize.textContent = formatFileSize(file.size);
                    if (filePreview) filePreview.style.display = 'block';
                    if (uploadArea) uploadArea.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    }

    // Remove file function - dibuat global
    window.removeFile = function() {
        if (fileInput) fileInput.value = '';
        if (filePreview) filePreview.style.display = 'none';
        if (uploadArea) uploadArea.style.display = 'block';
    };

    // Dynamic item loading
    const lokasiSelect = document.querySelector('select[name="id_lokasi"]');
    const itemSelect = document.querySelector('select[name="id_item"]');
    const loadingIndicator = document.querySelector('.loading-indicator');

    if (lokasiSelect && itemSelect && loadingIndicator) {
        lokasiSelect.addEventListener('change', function() {
            const lokasiId = this.value;

            if (!lokasiId) {
                itemSelect.innerHTML = '<option value="">Pilih barang...</option>';
                itemSelect.disabled = true;
                return;
            }

            // Show loading
            loadingIndicator.classList.add('active');
            itemSelect.disabled = true;
            itemSelect.innerHTML = '<option value="">Memuat data barang...</option>';

            // Fetch items based on selected location
            fetch(`/get-items/${lokasiId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    itemSelect.innerHTML = '<option value="">Pilih barang...</option>';
                    data.forEach(item => {
                        itemSelect.innerHTML += `<option value="${item.id_item}">${item.nama_item}</option>`;
                    });
                    itemSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    itemSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                    showToast('Gagal memuat data barang', 'error');
                })
                .finally(() => {
                    loadingIndicator.classList.remove('active');
                });
        });
    }

    // Form submission
    const pengaduanForm = document.getElementById('pengaduanForm');
    if (pengaduanForm) {
        pengaduanForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate all steps
            let formValid = true;
            for (let i = 1; i <= 3; i++) {
                if (!validateStep(i)) {
                    formValid = false;
                    showStep(i); // Go to the step with error
                    break;
                }
            }

            if (!formValid) {
                showToast('Harap lengkapi semua data yang diperlukan', 'error');
                return;
            }

            // Add loading state
            const submitBtn = document.querySelector('.btn-submit');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<div class="spinner"></div> Mengirim...';
                submitBtn.disabled = true;

                // Submit form
                setTimeout(() => {
                    this.submit();
                }, 2000);
            } else {
                this.submit();
            }
        });
    }

    // Toast notification
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `position-fixed top-0 end-0 p-3`;
        toast.style.zIndex = '9999';

        const bgColor = type === 'error' ? 'bg-danger' : 'bg-primary';

        toast.innerHTML = `
            <div class="toast show" role="alert">
                <div class="toast-header ${bgColor} text-white">
                    <i class="fas ${type === 'error' ? 'fa-exclamation-triangle' : 'fa-info-circle'} me-2"></i>
                    <strong class="me-auto">${type === 'error' ? 'Error' : 'Info'}</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;

        document.body.appendChild(toast);

        // Remove toast after 5 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 5000);
    }

    // Initialize first step
    showStep(1);
});
</script>
@endpush
