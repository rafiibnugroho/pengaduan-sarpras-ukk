@extends('layouts.admin')

@section('content')
<div class="min-vh-100 bg-gradient-admin">
    <!-- Background Elements -->
    <div class="position-fixed w-100 h-100 top-0 start-0" style="z-index: -1;">
        <div class="admin-shape shape-1"></div>
        <div class="admin-shape shape-2"></div>
        <div class="admin-shape shape-3"></div>
    </div>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <div class="admin-header-icon mb-4">
                        <div class="icon-wrapper-admin">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                    <h1 class="display-5 fw-bold text-dark mb-2">Edit Pengaduan</h1>
                    <p class="lead text-muted">Perbarui informasi pengaduan dengan data terbaru</p>
                </div>

                <!-- Main Form Card -->
                <div class="modern-admin-card">
                    <div class="card-header-modern">
                        <div class="header-content">
                            <div class="header-text">
                                <h4 class="mb-1">
                                    <i class="fas fa-clipboard-list me-2"></i>
                                    Form Edit Pengaduan
                                </h4>
                                <p class="mb-0">Kelola dan perbarui data pengaduan</p>
                            </div>
                        </div>
                     
                    </div>

                    <div class="card-body-modern">
                        @if($errors->any())
                            <div class="alert-modern error">
                                <div class="alert-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="alert-content">
                                    <h6>Terjadi Kesalahan</h6>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

                        <form action="{{ route('admin.pengaduan.update', $pengaduan->id_pengaduan) }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="admin-form-modern"
                              id="editPengaduanForm">
                            @csrf
                            @method('PUT')

                            <div class="form-grid-modern">
                                <!-- Nama Pengaduan -->
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <span class="label-text">Nama Pengaduan</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <i class="input-icon-modern fas fa-file-alt"></i>
                                        <input type="text"
                                               name="nama_pengaduan"
                                               class="form-input-modern"
                                               value="{{ old('nama_pengaduan', $pengaduan->nama_pengaduan) }}"
                                               placeholder="Masukkan nama pengaduan"
                                               required>
                                    </div>
                                </div>

                                <!-- Lokasi -->
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <span class="label-text">Lokasi</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <i class="input-icon-modern fas fa-map-marker-alt"></i>
                                        <select name="id_lokasi" class="form-input-modern" required>
                                            <option value="" disabled>Pilih Lokasi</option>
                                            @foreach($lokasi as $l)
                                                <option value="{{ $l->id_lokasi }}"
                                                    {{ $pengaduan->id_lokasi == $l->id_lokasi ? 'selected' : '' }}>
                                                    {{ $l->nama_lokasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Pengguna -->
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <span class="label-text">Pelapor</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <i class="input-icon-modern fas fa-user"></i>
                                        <select name="id_user" class="form-input-modern" required>
                                            @foreach($users as $u)
                                                <option value="{{ $u->id }}"
                                                    {{ $pengaduan->id_user == $u->id ? 'selected' : '' }}>
                                                    {{ $u->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Item -->
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <span class="label-text">Barang / Item</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <i class="input-icon-modern fas fa-cube"></i>
                                        <select name="id_item" class="form-input-modern" required>
                                            @foreach($items as $i)
                                                <option value="{{ $i->id_item }}"
                                                    {{ $pengaduan->id_item == $i->id_item ? 'selected' : '' }}>
                                                    {{ $i->nama_item }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <span class="label-text">Status</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <i class="input-icon-modern fas fa-flag"></i>
                                        <select name="status" class="form-input-modern" required id="statusSelect">
                                            @foreach(['Menunggu', 'Diterima', 'Ditolak', 'Diproses', 'Selesai'] as $status)
                                                <option value="{{ $status }}"
                                                    {{ $pengaduan->status == $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Saran Petugas -->
                                <div class="form-group-modern full-width">
                                    <label class="form-label-modern">
                                        <span class="label-text">Saran Petugas</span>
                                        <span class="label-optional">(Opsional)</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <i class="input-icon-modern fas fa-comment-alt"></i>
                                        <textarea name="saran_petugas"
                                                  class="form-input-modern"
                                                  rows="3"
                                                  placeholder="Masukkan saran atau catatan untuk pengaduan ini">{{ old('saran_petugas', $pengaduan->saran_petugas) }}</textarea>
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                <div class="form-group-modern full-width">
                                    <label class="form-label-modern">
                                        <span class="label-text">Deskripsi Pengaduan</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <i class="input-icon-modern fas fa-align-left"></i>
                                        <textarea name="deskripsi"
                                                  class="form-input-modern"
                                                  rows="4"
                                                  placeholder="Jelaskan detail pengaduan secara lengkap"
                                                  required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                                    </div>
                                </div>

                                <!-- Rating Section - Only show when status is Selesai -->
                                <div class="form-group-modern full-width" id="ratingSection" style="display: {{ $pengaduan->status == 'Selesai' ? 'block' : 'none' }};">
                                    <label class="form-label-modern">
                                        <span class="label-text">Rating & Ulasan</span>
                                        <span class="label-optional">(Opsional)</span>
                                    </label>

                                    <div class="rating-input-container">
                                        <!-- Rating Stars -->
                                        <div class="rating-stars mb-3">
                                            <div class="stars-wrapper">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <input type="radio"
                                                           id="star{{ $i }}"
                                                           name="rating"
                                                           value="{{ $i }}"
                                                           {{ old('rating', $pengaduan->rating) == $i ? 'checked' : '' }}
                                                           class="star-input">
                                                    <label for="star{{ $i }}" class="star-label">
                                                        <i class="fas fa-star"></i>
                                                    </label>
                                                @endfor
                                            </div>
                                            <div class="rating-text">
                                                <span id="ratingValue">{{ old('rating', $pengaduan->rating) ?: 0 }}</span>/5
                                            </div>
                                        </div>

                                        <!-- Ulasan -->
                                        <div class="input-group-modern">
                                            <i class="input-icon-modern fas fa-comment"></i>
                                            <textarea name="ulasan"
                                                      class="form-input-modern"
                                                      rows="3"
                                                      placeholder="Berikan ulasan tentang pelayanan pengaduan ini...">{{ old('ulasan', $pengaduan->ulasan) }}</textarea>
                                        </div>

                                        <small class="form-text-modern">
                                            Rating dan ulasan hanya dapat diisi ketika status pengaduan "Selesai"
                                        </small>
                                    </div>
                                </div>

                                <!-- Foto Upload -->
                                <div class="form-group-modern full-width">
                                    <label class="form-label-modern">
                                        <span class="label-text">Foto Pengaduan</span>
                                        <span class="label-optional">(Opsional)</span>
                                    </label>

                                    <!-- Current Photo Preview -->
                                    @if($pengaduan->foto)
                                    <div class="current-photo-section">
                                        <div class="current-photo-label">Foto Saat Ini:</div>
                                        <div class="photo-preview-container">
                                            <img src="{{ asset('storage/'.$pengaduan->foto) }}"
                                                 alt="Foto Pengaduan Saat Ini"
                                                 class="current-photo">
                                            <div class="photo-overlay">
                                                <a href="{{ asset('storage/'.$pengaduan->foto) }}"
                                                   target="_blank"
                                                   class="photo-action view">
                                                    <i class="fas fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- File Upload -->
                                    <div class="file-upload-modern">
                                        <input type="file"
                                               name="foto"
                                               id="foto"
                                               class="file-input-modern"
                                               accept="image/*"
                                               onchange="previewImage(this)">
                                        <label for="foto" class="file-label-modern">
                                            <div class="file-icon">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <div class="file-content">
                                                <span class="file-title">Pilih file foto</span>
                                                <span class="file-subtitle">PNG, JPG, JPEG (Max 2MB)</span>
                                            </div>
                                        </label>

                                        <!-- Image Preview -->
                                        <div class="image-preview-modern" id="imagePreview">
                                            <img id="previewImage" class="preview-img">
                                            <button type="button" class="preview-remove" onclick="removeImage()">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text-modern">Kosongkan jika tidak ingin mengganti foto</small>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="form-actions-modern">
                                <a href="{{ route('admin.pengaduan.index') }}" class="btn-modern outline">
                                    <i class="fas fa-times me-2"></i> Batal
                                </a>
                                <button type="submit" class="btn-modern primary" id="submitBtn">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css?v={{ time() }}" />
<style>
/* Modern Design System */
:root {
    --primary: #4f46e5;
    --primary-light: #6366f1;
    --primary-dark: #4338ca;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #06b6d4;
    --dark: #1e293b;
    --light: #f8fafc;
    --gray-50: #f8fafc;
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
.bg-gradient-admin {
    background: linear-gradient(135deg, #f0f4ff 0%, #f8faff 50%, #f0f9ff 100%);
}

.admin-shape {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-light), var(--primary));
    opacity: 0.03;
    animation: adminFloat 30s ease-in-out infinite;
}

.shape-1 {
    width: 300px;
    height: 300px;
    top: 5%;
    right: 5%;
    animation-delay: 0s;
}

.shape-2 {
    width: 200px;
    height: 200px;
    top: 60%;
    left: 8%;
    animation-delay: 10s;
}

.shape-3 {
    width: 150px;
    height: 150px;
    bottom: 10%;
    right: 15%;
    animation-delay: 20s;
}

@keyframes adminFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
    33% { transform: translateY(-25px) rotate(120deg) scale(1.1); }
    66% { transform: translateY(15px) rotate(240deg) scale(0.9); }
}

/* Header Section */
.admin-header-icon {
    display: flex;
    justify-content: center;
}

.icon-wrapper-admin {
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

.icon-wrapper-admin::before {
    content: '';
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(79, 70, 229, 0.1);
    animation: adminPulse 3s ease-in-out infinite;
}

.icon-wrapper-admin i {
    font-size: 2.5rem;
    color: white;
    position: relative;
    z-index: 2;
}

@keyframes adminPulse {
    0%, 100% { transform: scale(0.8); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.5; }
}

/* Main Card */
.modern-admin-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    margin-bottom: 2rem;
}

/* Card Header */
.card-header-modern {
    padding: 2rem 2.5rem;
    background: linear-gradient(135deg, var(--gray-50), white);
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-content h4 {
    margin: 0;
    font-weight: 700;
    color: var(--dark);
    display: flex;
    align-items: center;
}

.header-content h4 i {
    color: var(--primary);
}

.header-content p {
    margin: 0.25rem 0 0 0;
    color: var(--gray-500);
}

.header-actions {
    display: flex;
    gap: 1rem;
}

.btn-modern {
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    border: none;
    cursor: pointer;
}

.btn-modern.primary {
    background: var(--primary);
    color: white;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.btn-modern.primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
}

.btn-modern.outline {
    background: transparent;
    color: var(--primary);
    border: 2px solid var(--primary);
}

.btn-modern.outline:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
}

/* Card Body */
.card-body-modern {
    padding: 2.5rem;
}

/* Alert */
.alert-modern {
    display: flex;
    align-items: flex-start;
    padding: 1.5rem;
    border-radius: var(--radius-lg);
    margin-bottom: 2rem;
    animation: slideIn 0.5s ease;
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

.alert-modern.error .alert-icon {
    color: var(--danger);
}

.alert-content h6 {
    margin: 0 0 0.5rem 0;
    font-weight: 600;
    color: var(--dark);
}

.alert-content ul {
    margin: 0;
    padding-left: 1rem;
}

.alert-content li {
    color: var(--gray-600);
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.alert-close {
    background: none;
    border: none;
    color: var(--gray-400);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: var(--radius);
    margin-left: auto;
    flex-shrink: 0;
}

.alert-close:hover {
    background: rgba(0, 0, 0, 0.05);
    color: var(--dark);
}

/* Form Styles */
.admin-form-modern {
    width: 100%;
}

.form-grid-modern {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.form-group-modern {
    position: relative;
}

.form-group-modern.full-width {
    grid-column: 1 / -1;
}

.form-label-modern {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: var(--dark);
}

.label-text {
    font-size: 0.95rem;
}

.label-required {
    color: var(--danger);
    margin-left: 4px;
    font-size: 0.875rem;
}

.label-optional {
    color: var(--gray-400);
    margin-left: 4px;
    font-size: 0.875rem;
    font-style: italic;
}

.input-group-modern {
    position: relative;
}

.input-icon-modern {
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
    font-family: inherit;
}

.form-input-modern:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
}

.form-input-modern:focus + .input-icon-modern {
    color: var(--primary);
}

.form-input-modern::placeholder {
    color: var(--gray-400);
}

/* Textarea specific */
.form-input-modern[rows] {
    resize: vertical;
    min-height: 80px;
}

/* Select specific */
.form-input-modern select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1rem;
    padding-right: 2.5rem;
}

/* Rating Styles */
.rating-input-container {
    background: var(--gray-50);
    padding: 1.5rem;
    border-radius: var(--radius);
    border: 1px solid var(--gray-200);
}

.rating-stars {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stars-wrapper {
    display: flex;
    gap: 0.25rem;
}

.star-input {
    display: none;
}

.star-label {
    cursor: pointer;
    font-size: 1.5rem;
    color: var(--gray-300);
    transition: all 0.2s ease;
    padding: 0.25rem;
}

.star-label:hover,
.star-input:checked ~ .star-label {
    color: var(--warning);
}

.star-input:checked + .star-label {
    color: var(--warning);
}

.rating-text {
    font-weight: 600;
    color: var(--dark);
    font-size: 1.1rem;
}

/* File Upload */
.file-upload-modern {
    position: relative;
    margin-top: 0.5rem;
}

.file-input-modern {
    position: absolute;
    left: -9999px;
    opacity: 0;
}

.file-label-modern {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border: 2px dashed var(--gray-300);
    border-radius: var(--radius);
    background: var(--gray-50);
    cursor: pointer;
    transition: all 0.3s ease;
}

.file-label-modern:hover {
    border-color: var(--primary);
    background: rgba(79, 70, 229, 0.02);
}

.file-icon {
    width: 48px;
    height: 48px;
    background: var(--primary);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.file-content {
    flex: 1;
}

.file-title {
    display: block;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.file-subtitle {
    color: var(--gray-500);
    font-size: 0.875rem;
}

/* Image Preview */
.image-preview-modern {
    display: none;
    position: relative;
    margin-top: 1rem;
    border-radius: var(--radius);
    overflow: hidden;
    border: 2px solid var(--gray-200);
}

.preview-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.preview-remove {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    width: 32px;
    height: 32px;
    background: rgba(0, 0, 0, 0.7);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.preview-remove:hover {
    background: var(--danger);
    transform: scale(1.1);
}

/* Current Photo */
.current-photo-section {
    margin-bottom: 1rem;
}

.current-photo-label {
    font-weight: 500;
    color: var(--gray-600);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.photo-preview-container {
    position: relative;
    display: inline-block;
    border-radius: var(--radius);
    overflow: hidden;
    border: 2px solid var(--gray-200);
}

.current-photo {
    width: 200px;
    height: 150px;
    object-fit: cover;
}

.photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.photo-preview-container:hover .photo-overlay {
    opacity: 1;
}

.photo-action {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dark);
    text-decoration: none;
    transition: all 0.3s ease;
}

.photo-action:hover {
    background: var(--primary);
    color: white;
    transform: scale(1.1);
}

/* Form Text */
.form-text-modern {
    display: block;
    margin-top: 0.5rem;
    color: var(--gray-500);
    font-size: 0.875rem;
}

/* Form Actions */
.form-actions-modern {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding-top: 2rem;
    border-top: 1px solid var(--gray-200);
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

/* Loading State */
.btn-modern.loading {
    position: relative;
    color: transparent;
}

.btn-modern.loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    .modern-admin-card {
        margin: 0 -1rem;
        border-radius: 0;
    }

    .card-header-modern {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.5rem;
    }

    .header-actions {
        width: 100%;
        justify-content: flex-start;
    }

    .card-body-modern {
        padding: 1.5rem;
    }

    .form-grid-modern {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .form-actions-modern {
        flex-direction: column;
    }

    .btn-modern {
        width: 100%;
        justify-content: center;
    }

    .file-label-modern {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }

    .rating-stars {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}

@media (max-width: 576px) {
    .admin-header-icon {
        margin-bottom: 2rem;
    }

    .current-photo {
        width: 100%;
        height: 120px;
    }

    .photo-preview-container {
        width: 100%;
    }

    .input-group-modern {
        flex-direction: column;
    }

    .form-input-modern {
        padding-left: 1rem;
    }

    .input-icon-modern {
        display: none;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Fancybox
        $('[data-fancybox]').fancybox({
            buttons: [
                'zoom',
                'close'
            ]
        });

        // Status change handler
        $('#statusSelect').change(function() {
            const ratingSection = $('#ratingSection');
            if ($(this).val() === 'Selesai') {
                ratingSection.slideDown(300);
            } else {
                ratingSection.slideUp(300);
                // Reset rating when status is not Selesai
                $('input[name="rating"]').prop('checked', false);
                $('#ratingValue').text('0');
            }
        });

        // Rating stars interaction
        $('input[name="rating"]').change(function() {
            const rating = $(this).val();
            $('#ratingValue').text(rating);
        });

        // Character counter for textareas
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            const maxLength = textarea.getAttribute('maxlength');
            if (maxLength) {
                const counter = document.createElement('div');
                counter.className = 'char-counter';
                counter.style.cssText = 'text-align: right; font-size: 0.75rem; color: var(--gray-400); margin-top: 0.25rem;';
                textarea.parentNode.appendChild(counter);

                function updateCounter() {
                    const currentLength = textarea.value.length;
                    counter.textContent = `${currentLength}/${maxLength}`;
                    counter.style.color = currentLength > maxLength * 0.9 ? 'var(--danger)' : 'var(--gray-400)';
                }

                textarea.addEventListener('input', updateCounter);
                updateCounter();
            }
        });
    });

    // Image preview functionality
    function previewImage(input) {
        const preview = document.getElementById('previewImage');
        const previewContainer = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const input = document.getElementById('foto');
        const previewContainer = document.getElementById('imagePreview');

        input.value = '';
        previewContainer.style.display = 'none';
    }
</script>
@endpush
