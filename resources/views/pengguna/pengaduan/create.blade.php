@extends('layouts.user')

@section('title', 'Buat Pengaduan Baru - ' . config('app.name'))

@section('content')
<div class="container-fluid py-5">
    <!-- Floating Elements -->
    <div class="floating-element floating-1"></div>
    <div class="floating-element floating-2"></div>

    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <!-- Header Section -->
            <div class="text-center mb-5 animate-fadeInUp">
                <h1 class="h1 fw-bold text-gradient mb-3">Buat Pengaduan Baru</h1>
                <p class="text-muted lead fs-5">Laporkan masalah sarana dan prasarana dengan mudah dan cepat</p>
            </div>

            <!-- Form Card -->
            <div class="glass-card animate-fadeInUp animate-delay-1">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" id="pengaduanForm">
                        @csrf

                        <!-- Step 1: Informasi Dasar -->
                        <div class="step-content active" data-step="1">
                            <h3 class="section-title fw-bold mb-4">Informasi Pengaduan</h3>

                            <div class="mb-4">
                                <label for="nama_pengaduan" class="form-label fw-semibold">
                                    <i class="fas fa-heading me-2 text-primary"></i>
                                    Judul Pengaduan
                                </label>
                                <input type="text"
                                       name="nama_pengaduan"
                                       id="nama_pengaduan"
                                       class="form-control modern-input"
                                       placeholder="Contoh: Kerusakan Kursi Kelas X IPA 1"
                                       required
                                       maxlength="100">
                                <div class="form-text text-muted mt-2">Masukkan judul yang jelas dan deskriptif</div>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-semibold">
                                    <i class="fas fa-align-left me-2 text-primary"></i>
                                    Deskripsi Lengkap
                                </label>
                                <textarea name="deskripsi"
                                          id="deskripsi"
                                          class="form-control modern-input"
                                          rows="5"
                                          placeholder="Jelaskan detail kerusakan atau masalah yang ditemukan..."
                                          required
                                          maxlength="500"></textarea>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="form-text text-muted">Jelaskan secara detail untuk memudahkan penanganan</div>
                                    <small class="text-muted char-counter"><span id="charCount">0</span>/500</small>
                                </div>
                            </div>

                        <!-- Step 2: Lokasi dan Barang -->
                        <div class="step-content" data-step="2">
                            <h3 class="section-title fw-bold mb-4">Lokasi & Barang</h3>

                            <div class="mb-4">
                                <label for="id_lokasi" class="form-label fw-semibold">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    Pilih Lokasi
                                </label>
                                <select name="id_lokasi" id="id_lokasi" class="form-select modern-select" required>
                                    <option value="">-- Pilih Lokasi --</option>
                                    @foreach($lokasi as $l)
                                        <option value="{{ $l->id_lokasi }}">{{ $l->nama_lokasi }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text text-muted mt-2">Pilih lokasi dimana masalah terjadi</div>
                            </div>

                            <div class="mb-4">
                                <label for="id_item" class="form-label fw-semibold">
                                    <i class="fas fa-box me-2 text-primary"></i>
                                    Pilih Barang
                                </label>
                                <select name="id_item" id="id_item" class="form-select modern-select" required disabled>
                                    <option value="">-- Pilih Barang --</option>
                                </select>
                                <div class="loading-spinner d-none mt-2">
                                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                                    <small class="text-muted">Memuat data barang...</small>
                                </div>
                                <div class="form-text text-muted mt-2">Pilih barang yang mengalami kerusakan</div>
                            </div>


                        </div>

                        <!-- Step 3: Lampiran dan Submit -->
                        <div class="step-content" data-step="3">
                            <h3 class="section-title fw-bold mb-4">Lampiran & Pengiriman</h3>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-camera me-2 text-primary"></i>
                                    Bukti Foto
                                </label>

                                <!-- File Upload Area -->
                                <div class="file-upload-area">
                                    <input type="file" name="foto" id="foto" class="file-input" accept="image/*" hidden>
                                    <div class="upload-placeholder text-center p-5 border-2 border-dashed rounded-3">
                                        <i class="fas fa-cloud-upload-alt text-muted mb-3 fa-2x"></i>
                                        <h6 class="fw-semibold mb-2">Unggah Bukti Foto</h6>
                                        <p class="text-muted small mb-3">Seret atau klik untuk mengunggah foto</p>
                                        <button type="button" class="btn btn-modern btn-outline-primary btn-sm upload-trigger">
                                            Pilih File
                                        </button>
                                        <div class="form-text text-muted mt-2">Format: JPG, PNG, JPEG (Maks. 5MB)</div>
                                    </div>
                                    <div class="file-preview mt-3 d-none">
                                        <div class="preview-card">
                                            <img id="previewImage" class="preview-img">
                                            <div class="preview-info">
                                                <div class="preview-name fw-semibold"></div>
                                                <div class="preview-size text-muted small"></div>
                                            </div>
                                            <button type="button" class="btn-remove" onclick="removeImage()">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-modern btn-success submit-btn">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Kirim Pengaduan
                                </button>
                            </div>
                        </div>
                    </br>
                        <!-- Tips Section -->
                        <div class="alert alert-modern alert-info mb-4">
                            <div class="d-flex">
                                <i class="fas fa-lightbulb text-info me-3 fa-lg mt-1"></i>
                                <div>
                                    <h6 class="alert-title mb-2 fw-bold">Tips Foto yang Baik</h6>
                                    <ul class="mb-0 small ps-3">
                                        <li>Pastikan foto jelas dan terang</li>
                                        <li>Ambil dari berbagai angle</li>
                                        <li>Tunjukkan bagian yang rusak secara detail</li>
                                        <li>Sertakan objek sekitar sebagai referensi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{--
            <!-- Features Section -->
            <div class="row mt-5 g-4">
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInUp animate-delay-2">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Proses Cepat</h6>
                        <p class="text-muted small mb-0">Pengaduan akan diproses dalam waktu 24 jam</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInUp animate-delay-3">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Data Aman</h6>
                        <p class="text-muted small mb-0">Informasi Anda terlindungi dengan enkripsi</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInUp animate-delay-4">
                        <div class="feature-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Update Real-time</h6>
                        <p class="text-muted small mb-0">Pantau status pengaduan secara langsung</p>
                    </div>
                </div>
                --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --primary: #6366f1;
        --primary-light: #818cf8;
        --primary-dark: #4f46e5;
        --secondary: #10b981;
        --accent: #f59e0b;
        --dark: #1e293b;
        --light: #f8fafc;
        --gray: #64748b;
        --gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        --gradient-light: linear-gradient(135deg, #818cf8 0%, #a78bfa 100%);
        --shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 25px 50px rgba(0, 0, 0, 0.12);
        --radius: 16px;
        --radius-lg: 24px;
    }

    body {
        background: linear-gradient(135deg, #f0f4ff 0%, #f8faff 100%);
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(255, 255, 255, 0.4);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .glass-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }

    .text-gradient {
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .btn-modern {
        background: var(--gradient);
        border: none;
        border-radius: 12px;
        padding: 14px 32px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
        display: inline-flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-modern:hover::before {
        left: 100%;
    }

    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
        color: white;
    }

    .btn-modern.btn-secondary {
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        box-shadow: 0 6px 20px rgba(100, 116, 139, 0.3);
    }

    .btn-modern.btn-secondary:hover {
        box-shadow: 0 10px 25px rgba(100, 116, 139, 0.4);
    }

    .btn-modern.btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-modern.btn-success:hover {
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
    }

    .btn-modern.btn-outline-primary {
        background: transparent;
        border: 2px solid var(--primary);
        color: var(--primary);
        box-shadow: none;
    }

    .btn-modern.btn-outline-primary:hover {
        background: var(--primary);
        color: white;
    }

    .modern-input, .modern-select {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
    }

    .modern-input:focus, .modern-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        background: white;
    }

    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 50px;
        position: relative;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .step-indicator::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 0;
        right: 0;
        height: 6px;
        background: #f1f5f9;
        z-index: 1;
        border-radius: 3px;
    }



    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 3;
    }

    .step-number {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: white;
        border: 4px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-bottom: 12px;
        transition: all 0.4s ease;
        color: var(--gray);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        font-size: 18px;
    }

    .step.active .step-number {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        transform: scale(1.1);
    }

    .step.completed .step-number {
        background: var(--secondary);
        border-color: var(--secondary);
        color: white;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    .step.completed .step-number::after {
        content: '✓';
        font-weight: bold;
    }

    .step-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--gray);
        transition: all 0.3s ease;
        text-align: center;
    }

    .step.active .step-label, .step.completed .step-label {
        color: var(--primary);
        font-weight: 700;
    }

    .step-content {
        display: none;
        animation: fadeInSlide 0.5s ease forwards;
    }

    .step-content.active {
        display: block;
    }

    @keyframes fadeInSlide {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .file-upload-area {
        position: relative;
    }

    .upload-placeholder {
        background: rgba(248, 250, 252, 0.8);
        border: 2px dashed #c7d2fe;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 50px 20px;
        text-align: center;
    }

    .upload-placeholder:hover {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.03);
        transform: scale(1.01);
    }

    .upload-placeholder.dragover {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.05);
        transform: scale(1.02);
    }

    .file-preview .preview-card {
        display: flex;
        align-items: center;
        background: white;
        padding: 20px;
        border-radius: 16px;
        border: 2px solid #e2e8f0;
        gap: 16px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .file-preview .preview-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .preview-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .preview-info {
        flex: 1;
    }

    .btn-remove {
        background: none;
        border: none;
        color: #94a3b8;
        padding: 10px;
        border-radius: 10px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-remove:hover {
        background: #fef2f2;
        color: #ef4444;
        transform: rotate(90deg);
    }

    .alert-modern {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(99, 102, 241, 0.2);
        border-radius: 16px;
        backdrop-filter: blur(10px);
        border-left: 5px solid var(--primary-light);
        padding: 20px;
    }

    .feature-card {
        text-align: center;
        padding: 25px 20px;
        border-radius: 16px;
        transition: all 0.4s ease;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .feature-card:hover {
        transform: translateY(-8px);
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        margin: 0 auto 20px;
        background: var(--gradient);
        color: white;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 25px rgba(99, 102, 241, 0.4);
    }

    .feature-icon i {
        font-size: 28px;
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.8s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-delay-1 {
        animation-delay: 0.2s;
    }

    .animate-delay-2 {
        animation-delay: 0.4s;
    }

    .animate-delay-3 {
        animation-delay: 0.6s;
    }

    .char-counter {
        font-size: 0.875rem;
        font-weight: 600;
    }

    .loading-spinner {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .spinner-border {
        width: 1.2rem;
        height: 1.2rem;
    }

    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 20px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 50px;
        height: 4px;
        background: var(--gradient);
        border-radius: 2px;
    }

    /* Floating Elements */
    .floating-element {
        position: absolute;
        border-radius: 50%;
        background: var(--gradient-light);
        opacity: 0.1;
        z-index: -1;
    }

    .floating-1 {
        width: 200px;
        height: 200px;
        top: 10%;
        right: 5%;
        animation: float 15s ease-in-out infinite;
    }

    .floating-2 {
        width: 150px;
        height: 150px;
        bottom: 15%;
        left: 5%;
        animation: float 18s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .step-indicator {
            flex-direction: column;
            gap: 25px;
        }

        .step {
            flex-direction: row;
            gap: 15px;
            width: 100%;
        }

        .step-indicator::before {
            display: none;
        }

        .progress-line {
            display: none;
        }

        .step-number {
            margin-bottom: 0;
        }

        .glass-card .card-body {
            padding: 1.5rem;
        }

        .floating-element {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for description
        const descTextarea = document.getElementById('deskripsi');
        const charCount = document.getElementById('charCount');

        descTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });

        // Step navigation
        const stepContents = document.querySelectorAll('.step-content');
        const steps = document.querySelectorAll('.step');
        const progressLine = document.querySelector('.progress-line');

        function goToStep(stepNumber) {
            // Update step contents
            stepContents.forEach(content => {
                content.classList.remove('active');
                if (content.dataset.step == stepNumber) {
                    content.classList.add('active');
                }
            });

            // Update step indicators
            steps.forEach(step => {
                step.classList.remove('active', 'completed');

                if (parseInt(step.dataset.step) < stepNumber) {
                    step.classList.add('completed');
                } else if (parseInt(step.dataset.step) == stepNumber) {
                    step.classList.add('active');
                }
            });

            // Update progress line
            const progressWidth = ((stepNumber - 1) / 2) * 100;
            progressLine.style.width = `${progressWidth}%`;
        }

        // Next step buttons
        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', function() {
                const nextStep = this.dataset.next;

                // Validate current step before proceeding
                if (validateStep(parseInt(nextStep) - 1)) {
                    goToStep(parseInt(nextStep));
                }
            });
        });

        // Previous step buttons
        document.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', function() {
                const prevStep = this.dataset.prev;
                goToStep(parseInt(prevStep));
            });
        });

        // Step validation
        function validateStep(stepNumber) {
            let isValid = true;

            if (stepNumber === 1) {
                const judul = document.getElementById('nama_pengaduan').value.trim();
                const deskripsi = document.getElementById('deskripsi').value.trim();

                if (!judul) {
                    showValidationError('Judul pengaduan harus diisi');
                    isValid = false;
                } else if (!deskripsi) {
                    showValidationError('Deskripsi pengaduan harus diisi');
                    isValid = false;
                }
            }

            return isValid;
        }

        function showValidationError(message) {
            // Create toast notification
            const toast = document.createElement('div');
            toast.className = 'position-fixed top-0 end-0 p-3';
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <div class="toast show" role="alert">
                    <div class="toast-header bg-danger text-white">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong class="me-auto">Validasi Gagal</strong>
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
                toast.remove();
            }, 5000);
        }

        // File upload functionality
        const fileInput = document.getElementById('foto');
        const uploadPlaceholder = document.querySelector('.upload-placeholder');
        const filePreview = document.querySelector('.file-preview');
        const previewImage = document.getElementById('previewImage');
        const previewName = document.querySelector('.preview-name');
        const previewSize = document.querySelector('.preview-size');
        const uploadTrigger = document.querySelector('.upload-trigger');

        // Trigger file input
        uploadTrigger.addEventListener('click', () => fileInput.click());
        uploadPlaceholder.addEventListener('click', () => fileInput.click());

        // Drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadPlaceholder.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadPlaceholder.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadPlaceholder.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            uploadPlaceholder.classList.add('dragover');
        }

        function unhighlight() {
            uploadPlaceholder.classList.remove('dragover');
        }

        uploadPlaceholder.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFiles(files);
        }

        // File input change
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];

                // Validate file type
                if (!file.type.match('image.*')) {
                    showValidationError('Harap pilih file gambar yang valid (JPG, PNG, JPEG)');
                    return;
                }

                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showValidationError('Ukuran file maksimal 5MB');
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewName.textContent = file.name;
                    previewSize.textContent = formatFileSize(file.size);
                    filePreview.classList.remove('d-none');
                    uploadPlaceholder.style.display = 'none';
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

        // Remove image
        window.removeImage = function() {
            fileInput.value = '';
            filePreview.classList.add('d-none');
            uploadPlaceholder.style.display = 'block';
        };

        // Dynamic item loading based on location
        const lokasiSelect = document.getElementById('id_lokasi');
        const itemSelect = document.getElementById('id_item');
        const loadingSpinner = document.querySelector('.loading-spinner');

        lokasiSelect.addEventListener('change', function() {
            const lokasiId = this.value;

            if (!lokasiId) {
                itemSelect.innerHTML = '<option value="">-- Pilih Barang --</option>';
                itemSelect.disabled = true;
                return;
            }

            // Show loading
            loadingSpinner.classList.remove('d-none');
            itemSelect.disabled = true;
            itemSelect.innerHTML = '<option value="">Memuat data...</option>';

            // Fetch items based on selected location
            fetch(`/get-items/${lokasiId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    itemSelect.innerHTML = '<option value="">-- Pilih Barang --</option>';
                    data.forEach(item => {
                        itemSelect.innerHTML += `<option value="${item.id_item}">${item.nama_item}</option>`;
                    });
                    itemSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    itemSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                })
                .finally(() => {
                    loadingSpinner.classList.add('d-none');
                });
        });

        // Form validation before submit
        document.getElementById('pengaduanForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate all steps
            if (!validateStep(1) || !validateStep(2) || !validateStep(3)) {
                showValidationError('Harap lengkapi semua data yang diperlukan');
                return;
            }

            // Add loading state to submit button
            const submitBtn = document.querySelector('.submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div> Mengirim...';
            submitBtn.disabled = true;

            // Submit form after short delay to show loading state
            setTimeout(() => {
                this.submit();
            }, 1500);
        });
    });
</script>
@endpush
