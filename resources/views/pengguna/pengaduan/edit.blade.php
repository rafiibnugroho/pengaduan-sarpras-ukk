@extends('layouts.user')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-secondary me-3 rounded-circle">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-primary mb-1">
                        <i class="fas fa-edit me-2"></i>Edit Pengaduan
                    </h2>
                    <p class="text-muted mb-0">Perbarui informasi pengaduan Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="{{ route('pengaduan.update', $pengaduan->id_pengaduan) }}" method="POST" enctype="multipart/form-data" id="editPengaduanForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Pengaduan
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <!-- Nama Pengaduan -->
                                <div class="mb-4">
                                    <label for="nama_pengaduan" class="form-label fw-semibold">
                                        <i class="fas fa-tag text-primary me-2"></i>Judul Pengaduan
                                    </label>
                                    <input type="text" name="nama_pengaduan" class="form-control form-control-lg"
                                           value="{{ $pengaduan->nama_pengaduan }}" required>
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-4">
                                    <label for="deskripsi" class="form-label fw-semibold">
                                        <i class="fas fa-align-left text-info me-2"></i>Deskripsi Masalah
                                    </label>
                                    <textarea name="deskripsi" class="form-control" rows="6" required>{{ $pengaduan->deskripsi }}</textarea>
                                    <div class="form-text">Jelaskan masalah dengan detail</div>
                                </div>

                                <!-- Lokasi -->
                                <div class="mb-4">
                                    <label for="lokasi" class="form-label fw-semibold">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>Lokasi
                                    </label>
                                    <input type="text" name="lokasi" class="form-control form-control-lg"
                                           value="{{ $pengaduan->lokasi }}" required>
                                </div>

                                <!-- Item -->
                                <div class="mb-4">
                                    <label for="id_item" class="form-label fw-semibold">
                                        <i class="fas fa-tools text-warning me-2"></i>Item Sarana/Prasarana
                                    </label>
                                    <select name="id_item" class="form-select form-select-lg">
                                        @foreach($items as $i)
                                            <option value="{{ $i->id_item }}" {{ $pengaduan->id_item == $i->id_item ? 'selected' : '' }}>
                                                {{ $i->nama_item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tanggal Pengajuan -->
                                <div class="mb-4">
                                    <label for="tgl_pengajuan" class="form-label fw-semibold">
                                        <i class="fas fa-calendar text-success me-2"></i>Tanggal Pengajuan
                                    </label>
                                    <input type="date" name="tgl_pengajuan" class="form-control form-control-lg"
                                           value="{{ $pengaduan->tgl_pengajuan }}" required>
                                </div>

                                @if(auth()->user()->role === 'petugas' || auth()->user()->role === 'admin')
                                    <!-- Tanggal Selesai (Admin/Petugas only) -->
                                    <div class="mb-4">
                                        <label for="tgl_selesai" class="form-label fw-semibold">
                                            <i class="fas fa-check-circle text-success me-2"></i>Tanggal Selesai
                                        </label>
                                        <input type="date" name="tgl_selesai" class="form-control form-control-lg"
                                               value="{{ $pengaduan->tgl_selesai }}">
                                        <div class="form-text">Kosongkan jika belum selesai</div>
                                    </div>

                                    <!-- Saran Petugas -->
                                    <div class="mb-4">
                                        <label for="saran_petugas" class="form-label fw-semibold">
                                            <i class="fas fa-comment-dots text-info me-2"></i>Saran/Catatan Petugas
                                        </label>
                                        <textarea name="saran_petugas" class="form-control" rows="4">{{ $pengaduan->saran_petugas }}</textarea>
                                        <div class="form-text">Berikan saran atau catatan untuk pengaju</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <!-- Status Card -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-tasks me-2"></i>Status & Pengelolaan
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-semibold">Status</label>
                                    <select name="status" class="form-select" required id="statusSelect">
                                        <option value="Diajukan" {{ $pengaduan->status == 'Diajukan' ? 'selected' : '' }}>
                                            Diajukan
                                        </option>
                                        @if(auth()->user()->role === 'petugas' || auth()->user()->role === 'admin')
                                            <option value="Disetujui" {{ $pengaduan->status == 'Disetujui' ? 'selected' : '' }}>
                                                Disetujui
                                            </option>
                                            <option value="Ditolak" {{ $pengaduan->status == 'Ditolak' ? 'selected' : '' }}>
                                                Ditolak
                                            </option>
                                            <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>
                                                Diproses
                                            </option>
                                            <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>
                                                Selesai
                                            </option>
                                        @endif
                                    </select>
                                </div>

                                @if(auth()->user()->role === 'petugas' || auth()->user()->role === 'admin')
                                    <!-- Pengguna -->
                                    <div class="mb-3">
                                        <label for="id_user" class="form-label fw-semibold">Pengaju</label>
                                        <select name="id_user" class="form-select" required>
                                            @foreach($users as $u)
                                                <option value="{{ $u->id }}" {{ $pengaduan->id_user == $u->id ? 'selected' : '' }}>
                                                    {{ $u->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Petugas -->
                                    <div class="mb-3">
                                        <label for="id_petugas" class="form-label fw-semibold">Petugas Penanganan</label>
                                        <select name="id_petugas" class="form-select">
                                            <option value="">-- Belum Ditentukan --</option>
                                            @foreach($petugas as $p)
                                                <option value="{{ $p->id }}" {{ $pengaduan->id_petugas == $p->id ? 'selected' : '' }}>
                                                    {{ $p->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="id_user" value="{{ $pengaduan->id_user }}">
                                    <input type="hidden" name="id_petugas" value="{{ $pengaduan->id_petugas }}">
                                @endif

                                <!-- Status Indicator -->
                                <div class="mt-3 p-3 rounded" id="statusIndicator">
                                    <div class="d-flex align-items-center">
                                        <div class="status-dot me-3"></div>
                                        <div>
                                            <small class="fw-semibold status-text"></small>
                                            <br>
                                            <small class="text-muted status-desc"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Photo Card -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-camera me-2"></i>Bukti Foto
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                @if($pengaduan->foto)
                                    <div class="current-photo mb-3">
                                        <img src="{{ asset('storage/'.$pengaduan->foto) }}"
                                             class="img-fluid rounded shadow-sm"
                                             style="max-height: 200px;"
                                             id="currentPhotoPreview">
                                        <div class="mt-2">
                                            <small class="text-muted">Foto saat ini</small>
                                        </div>
                                    </div>
                                @endif

                                <div class="upload-area">
                                    <label for="foto" class="form-label fw-semibold">
                                        {{ $pengaduan->foto ? 'Ganti Foto' : 'Upload Foto' }}
                                    </label>
                                    <div class="photo-upload-zone border-2 border-dashed rounded-3 p-4 text-center" style="cursor: pointer;">
                                        <input type="file" name="foto" class="form-control d-none" accept="image/*" id="fotoInput">
                                        <div class="upload-placeholder">
                                            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                            <p class="mb-1 small">Klik untuk pilih foto</p>
                                            <small class="text-muted">JPG, PNG, GIF (Max: 2MB)</small>
                                        </div>
                                        <div class="upload-preview d-none">
                                            <img src="" alt="Preview" class="img-fluid rounded mb-2" style="max-height: 120px;">
                                            <p class="text-success mb-0 small">
                                                <i class="fas fa-check-circle me-1"></i>Foto baru siap diupload
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <button type="submit" class="btn btn-success btn-lg w-100 mb-2">
                                    <i class="fas fa-save me-2"></i>Update Pengaduan
                                </button>
                                <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
}

.photo-upload-zone {
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.photo-upload-zone:hover {
    background-color: #e9ecef;
    border-color: #0d6efd !important;
}

.card {
    animation: slideInUp 0.5s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.current-photo {
    position: relative;
}

.current-photo img {
    transition: all 0.3s ease;
}

.current-photo:hover img {
    transform: scale(1.05);
}

@media (max-width: 991px) {
    .col-lg-4 {
        margin-top: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('statusSelect');
    const statusIndicator = document.getElementById('statusIndicator');
    const photoUploadZone = document.querySelector('.photo-upload-zone');
    const fotoInput = document.getElementById('fotoInput');

    // Status configurations
    const statusConfig = {
        'Diajukan': {
            color: '#0d6efd',
            bgColor: '#cfe2ff',
            text: 'Pengaduan Diajukan',
            desc: 'Menunggu review dari petugas'
        },
        'Disetujui': {
            color: '#20c997',
            bgColor: '#d1ecf1',
            text: 'Pengaduan Disetujui',
            desc: 'Siap untuk diproses'
        },
        'Ditolak': {
            color: '#dc3545',
            bgColor: '#f8d7da',
            text: 'Pengaduan Ditolak',
            desc: 'Tidak dapat diproses'
        },
        'Diproses': {
            color: '#ffc107',
            bgColor: '#fff3cd',
            text: 'Sedang Diproses',
            desc: 'Petugas sedang menangani'
        },
        'Selesai': {
            color: '#198754',
            bgColor: '#d4edda',
            text: 'Pengaduan Selesai',
            desc: 'Masalah telah diselesaikan'
        }
    };

    // Update status indicator
    function updateStatusIndicator() {
        const selectedStatus = statusSelect.value;
        const config = statusConfig[selectedStatus];

        if (config) {
            const statusDot = statusIndicator.querySelector('.status-dot');
            const statusText = statusIndicator.querySelector('.status-text');
            const statusDesc = statusIndicator.querySelector('.status-desc');

            statusIndicator.style.backgroundColor = config.bgColor;
            statusDot.style.backgroundColor = config.color;
            statusText.textContent = config.text;
            statusText.style.color = config.color;
            statusDesc.textContent = config.desc;
        }
    }

    // Initialize status indicator
    updateStatusIndicator();
    statusSelect.addEventListener('change', updateStatusIndicator);

    // Photo upload handling
    photoUploadZone.addEventListener('click', () => fotoInput.click());

    photoUploadZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        photoUploadZone.classList.add('border-primary');
    });

    photoUploadZone.addEventListener('dragleave', () => {
        photoUploadZone.classList.remove('border-primary');
    });

    photoUploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        photoUploadZone.classList.remove('border-primary');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fotoInput.files = files;
            handleFilePreview(files[0]);
        }
    });

    fotoInput.addEventListener('change', function() {
        if (this.files[0]) {
            handleFilePreview(this.files[0]);
        }
    });

    function handleFilePreview(file) {
        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            fotoInput.value = '';
            return;
        }

        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar.');
            fotoInput.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            photoUploadZone.querySelector('.upload-placeholder').classList.add('d-none');
            const preview = photoUploadZone.querySelector('.upload-preview');
            preview.classList.remove('d-none');
            preview.querySelector('img').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Form validation
    document.getElementById('editPengaduanForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
        }
    });

    // Auto-resize textarea
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });

    // Character counter for description
    const deskripsiTextarea = document.querySelector('textarea[name="deskripsi"]');
    if (deskripsiTextarea) {
        const maxLength = 1000; // Set maximum length

        // Create character counter
        const counterDiv = document.createElement('div');
        counterDiv.className = 'form-text text-end';
        counterDiv.id = 'charCounter';
        deskripsiTextarea.parentNode.appendChild(counterDiv);

        function updateCounter() {
            const remaining = maxLength - deskripsiTextarea.value.length;
            counterDiv.textContent = `${deskripsiTextarea.value.length}/${maxLength} karakter`;

            if (remaining < 50) {
                counterDiv.className = 'form-text text-end text-warning';
            } else if (remaining < 0) {
                counterDiv.className = 'form-text text-end text-danger';
            } else {
                counterDiv.className = 'form-text text-end';
            }
        }

        updateCounter();
        deskripsiTextarea.addEventListener('input', updateCounter);
    }

    // Smooth scroll to top after form submission
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('updated') === 'success') {
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Show success message
        const successAlert = document.createElement('div');
        successAlert.className = 'alert alert-success alert-dismissible fade show position-fixed';
        successAlert.style.cssText = 'top: 20px; right: 20px; z-index: 1050; min-width: 300px;';
        successAlert.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            Pengaduan berhasil diupdate!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(successAlert);

        setTimeout(() => {
            successAlert.remove();
        }, 5000);
    }

    // Confirm before leaving page with unsaved changes
    let formChanged = false;
    const formElements = document.querySelectorAll('#editPengaduanForm input, #editPengaduanForm select, #editPengaduanForm textarea');

    formElements.forEach(element => {
        element.addEventListener('change', () => {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Reset form changed flag when form is submitted
    document.getElementById('editPengaduanForm').addEventListener('submit', () => {
        formChanged = false;
    });

    // Enhanced file input styling
    fotoInput.addEventListener('focus', () => {
        photoUploadZone.classList.add('border-primary');
    });

    fotoInput.addEventListener('blur', () => {
        photoUploadZone.classList.remove('border-primary');
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        // Ctrl+S to save
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            document.getElementById('editPengaduanForm').submit();
        }

        // Escape to cancel
        if (e.key === 'Escape') {
            const cancelBtn = document.querySelector('.btn-outline-secondary');
            if (cancelBtn && confirm('Yakin ingin membatalkan? Perubahan akan hilang.')) {
                cancelBtn.click();
            }
        }
    });

    // Tooltip initialization if using Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    if (window.bootstrap && window.bootstrap.Tooltip) {
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>
@endsection
