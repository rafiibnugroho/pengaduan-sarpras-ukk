@extends('layouts.admin')

@section('content')
<div class="min-vh-100 bg-gradient-admin" data-page="pengaduan-show">
    <!-- Background Elements -->
    <div class="position-fixed w-100 h-100 top-0 start-0" style="z-index: -1;">
        <div class="admin-shape shape-1"></div>
        <div class="admin-shape shape-2"></div>
        <div class="admin-shape shape-3"></div>
        <div class="admin-shape shape-4"></div>
        <div class="admin-shape shape-5"></div>
    </div>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <div class="admin-header-icon mb-4">
                        <div class="icon-wrapper-admin">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <h1 class="display-5 fw-bold text-dark mb-2">Detail Pengaduan</h1>
                    <p class="lead text-muted">Informasi lengkap dan status pengaduan</p>
                </div>

                <!-- Main Content Card -->
                <div class="modern-admin-card">
                    <!-- Status Header -->
                    <div class="complaint-header">
                        <div class="complaint-title-section">
                            <h2 class="complaint-title">
                                <i class="fas fa-file-alt me-3"></i>
                                {{ $pengaduan->nama_pengaduan }}
                            </h2>
                            <div class="complaint-meta">
                                <span class="complaint-id">#{{ $pengaduan->id }}</span>
                                <span class="complaint-date">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="status-badge-wrapper">
                            <div class="status-badge status-{{ strtolower($pengaduan->status) }}">
                                <div class="status-indicator"></div>
                                <span class="status-text">{{ $pengaduan->status }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="complaint-content">
                        <!-- Informasi Utama -->
                        <div class="info-grid">
                            <div class="info-card">
                                <div class="info-icon primary">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="info-content">
                                    <label>Pelapor</label>
                                    <h4>{{ $pengaduan->user->name ?? 'Tidak Diketahui' }}</h4>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="info-icon success">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <label>Lokasi</label>
                                    <h4>{{ $pengaduan->lokasi->nama_lokasi ?? 'Tidak Diketahui' }}</h4>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="info-icon warning">
                                    <i class="fas fa-cube"></i>
                                </div>
                                <div class="info-content">
                                    <label>Barang</label>
                                    <h4>{{ $pengaduan->item->nama_item ?? 'Tidak Diketahui' }}</h4>
                                </div>
                            </div>

                            <!-- Rating Card -->
                            @if($pengaduan->status == 'Selesai' && $pengaduan->rating)
                            <div class="info-card">
                                <div class="info-icon rating">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="info-content">
                                    <label>Rating</label>
                                    <div class="rating-display">
                                        <div class="stars-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $pengaduan->rating ? 'active' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="rating-value">{{ $pengaduan->rating }}/5</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Deskripsi Pengaduan -->
                        <div class="description-section">
                            <div class="section-header">
                                <i class="fas fa-align-left me-2"></i>
                                <h5>Deskripsi Pengaduan</h5>
                            </div>
                            <div class="description-content">
                                <p>{{ $pengaduan->deskripsi }}</p>
                            </div>
                        </div>

                        <!-- Saran Petugas -->
                        @if($pengaduan->saran_petugas)
                        <div class="saran-section">
                            <div class="section-header">
                                <i class="fas fa-comment-alt me-2"></i>
                                <h5>Saran Petugas</h5>
                            </div>
                            <div class="saran-content">
                                <p>{{ $pengaduan->saran_petugas }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Temporary Items Section -->
                        @php
                            $temporaryItems = \App\Models\TemporaryItem::where('id_pengaduan', $pengaduan->getKey())->get();
                        @endphp
                        @if($temporaryItems->count() > 0)
                        <div class="temporary-section">
                            <div class="section-header">
                                <i class="fas fa-clock me-2"></i>
                                <h5>Permintaan Barang & Lokasi Baru</h5>
                            </div>
                            <div class="temporary-content">
                                <div class="table-responsive">
                                    <table class="temporary-table">
                                        <thead>
                                            <tr>
                                                <th>Barang yang Diminta</th>
                                                <th>Lokasi Baru</th>
                                                <th>Status</th>
                                                <th>Tanggal Permintaan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($temporaryItems as $temporary)
                                            <tr id="temporary-row-{{ $temporary->id_temp }}">
                                                <td>
                                                    <strong>{{ $temporary->nama_barang_baru ?? 'Tidak ada data' }}</strong>
                                                </td>
                                                <td>{{ $temporary->lokasi_baru ?? '-' }}</td>
                                                <td>
                                                    <span class="status-badge status-{{ strtolower($temporary->status ?? 'pending') }}" id="status-{{ $temporary->id_temp }}">
                                                        <div class="status-indicator"></div>
                                                        <span class="status-text">
                                                            @if($temporary->status == 'pending')
                                                                Menunggu
                                                            @elseif($temporary->status == 'approved')
                                                                Disetujui
                                                            @elseif($temporary->status == 'rejected')
                                                                Ditolak
                                                            @else
                                                                {{ $temporary->status }}
                                                            @endif
                                                        </span>
                                                    </span>
                                                </td>
                                                <td>{{ $temporary->created_at ? \Carbon\Carbon::parse($temporary->created_at)->translatedFormat('d F Y H:i') : '-' }}</td>
                                                <td>
                                                    @if($temporary->status == 'pending')
                                                    <div class="action-buttons-small">
                                                        <form action="{{ route('admin.temporary.approve', $temporary->id_temp) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.temporary.reject', $temporary->id_temp) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    @else
                                                    <span class="text-muted small">Sudah diproses</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Media Section -->
                        <div class="media-grid">
                            <!-- Foto Pengaduan -->
                            @if($pengaduan->foto)
                            <div class="media-card">
                                <div class="media-header">
                                    <i class="fas fa-camera me-2"></i>
                                    <h6>Foto Pengaduan</h6>
                                </div>
                                <div class="media-content">
                                    <a href="{{ asset('storage/'.$pengaduan->foto) }}" class="image-preview" data-fancybox="gallery">
                                        <img src="{{ asset('storage/'.$pengaduan->foto) }}"
                                             alt="Foto Pengaduan"
                                             class="preview-image">
                                        <div class="image-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endif

                            <!-- Bukti Selesai -->
                            @if($pengaduan->bukti_selesai)
                            <div class="media-card">
                                <div class="media-header completed">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <h6>Bukti Penyelesaian</h6>
                                </div>
                                <div class="media-content">
                                    <a href="{{ asset('storage/'.$pengaduan->bukti_selesai) }}" class="image-preview" data-fancybox="gallery">
                                        <img src="{{ asset('storage/'.$pengaduan->bukti_selesai) }}"
                                             alt="Bukti Selesai"
                                             class="preview-image">
                                        <div class="image-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </a>
                                    <div class="completion-badge">
                                        <i class="fas fa-check me-1"></i>
                                        Telah Diselesaikan
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Timeline Status -->
                        <div class="timeline-section">
                            <div class="section-header">
                                <i class="fas fa-history me-2"></i>
                                <h5>Timeline Status</h5>
                            </div>
                            <div class="timeline">
                                <div class="timeline-item {{ $pengaduan->status != 'Ditolak' ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Dilaporkan</h6>
                                        <p>{{ \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->translatedFormat('d M Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="timeline-item {{ in_array($pengaduan->status, ['Diproses', 'Selesai']) ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Sedang Diproses</h6>
                                        <p>Dalam penanganan petugas</p>
                                    </div>
                                </div>

                                <div class="timeline-item {{ $pengaduan->status == 'Selesai' ? 'completed' : ($pengaduan->status == 'Ditolak' ? 'rejected' : '') }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>
                                            @if($pengaduan->status == 'Selesai')
                                            Selesai
                                            @elseif($pengaduan->status == 'Ditolak')
                                            Ditolak
                                            @else
                                            Menunggu
                                            @endif
                                        </h6>
                                        <p>
                                            @if($pengaduan->status == 'Selesai')
                                            Pengaduan telah diselesaikan
                                            @elseif($pengaduan->status == 'Ditolak')
                                            Pengaduan ditolak
                                            @else
                                            Menunggu penyelesaian
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Footer -->
                    <div class="complaint-footer">
                        <a href="{{ route('admin.pengaduan.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali ke Daftar
                        </a>

                        <div class="action-buttons">
                            @if($pengaduan->status == 'Menunggu')
                            <form action="{{ route('admin.pengaduan.update', $pengaduan->id_pengaduan) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Diproses">
                                <button type="submit" class="btn-action btn-process" onclick="return confirm('Apakah Anda yakin ingin memproses pengaduan ini?')">
                                    <i class="fas fa-play me-2"></i>
                                    Proses
                                </button>
                            </form>
                            @endif

                            @if(in_array($pengaduan->status, ['Menunggu', 'Diproses']))
                            <form action="{{ route('admin.pengaduan.update', $pengaduan->id_pengaduan) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Selesai">
                                <button type="submit" class="btn-action btn-complete" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan pengaduan ini?')">
                                    <i class="fas fa-check me-2"></i>
                                    Selesaikan
                                </button>
                            </form>
                            @endif

                            <a href="{{ route('admin.pengaduan.edit', $pengaduan->id_pengaduan) }}" class="btn-action btn-edit">
                                <i class="fas fa-edit me-2"></i>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<style>
:root {
    --primary: #4f46e5;
    --primary-light: #6366f1;
    --primary-dark: #4338ca;
    --secondary: #8b5cf6;
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
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --radius: 12px;
    --radius-lg: 16px;
}

/* Background Elements */
.bg-gradient-admin {
    background: linear-gradient(135deg, #f0f4ff 0%, #f8faff 50%, #f0f9ff 100%);
}

.admin-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.03;
    animation: adminFloat 30s ease-in-out infinite;
}

.shape-1 {
    width: 300px;
    height: 300px;
    top: 5%;
    right: 5%;
    background: linear-gradient(135deg, var(--primary-light), var(--primary));
    animation-delay: 0s;
}

.shape-2 {
    width: 200px;
    height: 200px;
    top: 60%;
    left: 8%;
    background: linear-gradient(135deg, var(--secondary), var(--primary));
    animation-delay: 10s;
}

.shape-3 {
    width: 150px;
    height: 150px;
    bottom: 10%;
    right: 15%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    animation-delay: 20s;
}

.shape-4 {
    width: 100px;
    height: 100px;
    top: 30%;
    left: 15%;
    background: linear-gradient(135deg, var(--secondary), var(--primary-light));
    animation-delay: 5s;
}

.shape-5 {
    width: 120px;
    height: 120px;
    bottom: 20%;
    left: 70%;
    background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
    animation-delay: 15s;
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
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-lg);
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
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

.modern-admin-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 25px 30px -10px rgba(0, 0, 0, 0.15);
}

/* Complaint Header */
.complaint-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 2.5rem 3rem;
    background: linear-gradient(135deg, var(--gray-50), white);
    border-bottom: 1px solid var(--gray-200);
}

.complaint-title-section {
    flex: 1;
}

.complaint-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.complaint-title i {
    color: var(--primary);
}

.complaint-meta {
    display: flex;
    gap: 1.5rem;
    align-items: center;
}

.complaint-id {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.complaint-date {
    color: var(--gray-500);
    font-size: 0.95rem;
    display: flex;
    align-items: center;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.875rem;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}

.status-badge:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 0.5rem;
    animation: statusPulse 2s infinite;
}

.status-selesai {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.status-selesai .status-indicator {
    background: var(--success);
}

.status-diproses {
    background: rgba(6, 182, 212, 0.1);
    color: var(--info);
    border: 1px solid rgba(6, 182, 212, 0.2);
}

.status-diproses .status-indicator {
    background: var(--info);
}

.status-ditolak {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.status-ditolak .status-indicator {
    background: var(--danger);
}

.status-menunggu {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.status-menunggu .status-indicator {
    background: var(--warning);
}

/* Complaint Content */
.complaint-content {
    padding: 2rem 3rem;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.info-card {
    background: var(--gray-50);
    padding: 1.5rem;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    border: 1px solid var(--gray-200);
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    background: white;
}

.info-icon {
    width: 60px;
    height: 60px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.info-card:hover .info-icon {
    transform: scale(1.1);
}

.info-icon.primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
}

.info-icon.success {
    background: linear-gradient(135deg, var(--success), #059669);
}

.info-icon.warning {
    background: linear-gradient(135deg, var(--warning), #d97706);
}

.info-icon.rating {
    background: linear-gradient(135deg, var(--warning), #d97706);
}

.info-content label {
    display: block;
    font-size: 0.875rem;
    color: var(--gray-500);
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.info-content h4 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
}

/* Rating Styles */
.rating-display {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.stars-rating {
    display: flex;
    gap: 0.125rem;
}

.stars-rating .fa-star {
    font-size: 1.1rem;
    color: var(--gray-300);
    transition: all 0.3s ease;
}

.stars-rating .fa-star.active {
    color: var(--warning);
}

.rating-value {
    font-weight: 600;
    color: var(--dark);
    font-size: 1rem;
}

/* Section Styles */
.description-section, .saran-section, .temporary-section {
    background: linear-gradient(135deg, var(--gray-50), white);
    border-radius: var(--radius);
    padding: 1.5rem;
    margin-bottom: 2rem;
    border-left: 4px solid var(--primary);
    transition: all 0.3s ease;
}

.saran-section {
    border-left-color: var(--info);
}

.temporary-section {
    border-left-color: var(--warning);
}

.description-section:hover, .saran-section:hover, .temporary-section:hover {
    box-shadow: var(--shadow);
    transform: translateY(-2px);
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--gray-200);
}

.section-header i {
    color: var(--primary);
    font-size: 1.25rem;
}

.saran-section .section-header i {
    color: var(--info);
}

.temporary-section .section-header i {
    color: var(--warning);
}

.section-header h5 {
    margin: 0;
    font-weight: 600;
    color: var(--dark);
}

.description-content, .saran-content {
    background: white;
    padding: 1.5rem;
    border-radius: var(--radius);
    margin-top: 1rem;
    border: 1px solid var(--gray-200);
}

.description-content p, .saran-content p {
    margin: 0;
    line-height: 1.6;
    color: var(--gray-700);
}

/* Temporary Table */
.temporary-table {
    width: 100%;
    background: white;
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    border-collapse: collapse;
}

.temporary-table th {
    background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
    padding: 1rem;
    font-weight: 600;
    color: var(--dark);
    border-bottom: 1px solid var(--gray-200);
    text-align: left;
}

.temporary-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--gray-200);
}

.temporary-table tr:last-child td {
    border-bottom: none;
}

.temporary-table tr:hover {
    background: var(--gray-50);
}

.action-buttons-small {
    display: flex;
    gap: 0.25rem;
}

.action-buttons-small .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.status-pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.status-pending .status-indicator {
    background: var(--warning);
}

.status-approved {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.status-approved .status-indicator {
    background: var(--success);
}

.status-rejected {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.status-rejected .status-indicator {
    background: var(--danger);
}

/* Media Grid */
.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.media-card {
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}

.media-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.media-header {
    padding: 1rem 1.5rem;
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    align-items: center;
}

.media-header i {
    color: var(--primary);
}

.media-header.completed i {
    color: var(--success);
}

.media-header h6 {
    margin: 0;
    font-weight: 600;
    color: var(--dark);
}

.media-content {
    padding: 1.5rem;
    position: relative;
}

.image-preview {
    display: block;
    position: relative;
    border-radius: var(--radius);
    overflow: hidden;
    transition: all 0.3s ease;
}

.image-preview:hover {
    transform: scale(1.02);
}

.preview-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: var(--radius);
    transition: all 0.3s ease;
}

.image-preview:hover .preview-image {
    filter: brightness(0.9);
}

.image-overlay {
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
    border-radius: var(--radius);
}

.image-preview:hover .image-overlay {
    opacity: 1;
}

.image-overlay i {
    color: white;
    font-size: 2rem;
}

.completion-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--success);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    box-shadow: var(--shadow);
}

/* Timeline Section */
.timeline-section {
    margin-bottom: 2rem;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--gray-300);
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

.timeline-item:hover {
    transform: translateX(5px);
}

.timeline-marker {
    position: absolute;
    left: -2.4rem;
    top: 0.5rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--gray-400);
    border: 3px solid white;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}

.timeline-item:hover .timeline-marker {
    transform: scale(1.2);
}

.timeline-item.completed .timeline-marker {
    background: var(--success);
}

.timeline-item.rejected .timeline-marker {
    background: var(--danger);
}

.timeline-content {
    background: var(--gray-50);
    padding: 1rem 1.5rem;
    border-radius: var(--radius);
    border-left: 3px solid var(--gray-300);
    transition: all 0.3s ease;
}

.timeline-item:hover .timeline-content {
    background: white;
    box-shadow: var(--shadow);
}

.timeline-item.completed .timeline-content {
    border-left-color: var(--success);
}

.timeline-item.rejected .timeline-content {
    border-left-color: var(--danger);
}

.timeline-content h6 {
    margin: 0 0 0.25rem 0;
    font-weight: 600;
    color: var(--dark);
}

.timeline-content p {
    margin: 0;
    font-size: 0.875rem;
    color: var(--gray-500);
}

/* Footer Actions */
.complaint-footer {
    padding: 2rem 3rem;
    background: var(--gray-50);
    border-top: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-back {
    background: var(--gray-200);
    color: var(--gray-700);
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.btn-back:hover {
    background: var(--gray-300);
    color: var(--dark);
    transform: translateX(-5px);
}

.action-buttons {
    display: flex;
    gap: 1rem;
}

.btn-action {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: var(--radius);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.btn-process {
    background: var(--info);
    color: white;
}

.btn-process:hover {
    background: #0891b2;
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.btn-complete {
    background: var(--success);
    color: white;
}

.btn-complete:hover {
    background: #059669;
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.btn-edit {
    background: var(--primary);
    color: white;
    text-decoration: none;
}

.btn-edit:hover {
    background: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    color: white;
    text-decoration: none;
}

@keyframes statusPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
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

    .complaint-header {
        flex-direction: column;
        gap: 1rem;
        padding: 2rem 1.5rem;
        text-align: center;
    }

    .complaint-title {
        font-size: 1.5rem;
        justify-content: center;
    }

    .complaint-meta {
        justify-content: center;
    }

    .complaint-content {
        padding: 1.5rem;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .media-grid {
        grid-template-columns: 1fr;
    }

    .temporary-table {
        font-size: 0.875rem;
    }

    .temporary-table th,
    .temporary-table td {
        padding: 0.75rem;
    }

    .complaint-footer {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .action-buttons {
        width: 100%;
        justify-content: center;
        flex-wrap: wrap;
    }

    .timeline {
        padding-left: 1.5rem;
    }

    .timeline-marker {
        left: -1.9rem;
    }
}

@media (max-width: 576px) {
    .complaint-header,
    .complaint-content,
    .complaint-footer {
        padding: 1.5rem 1rem;
    }

    .info-card {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }

    .action-buttons {
        flex-direction: column;
        width: 100%;
    }

    .btn-action {
        width: 100%;
        justify-content: center;
    }

    .temporary-table {
        display: block;
        overflow-x: auto;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script>
// Simple initialization for Fancybox
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Fancybox for image preview
    if (typeof jQuery !== 'undefined' && typeof $.fancybox !== 'undefined') {
        $('[data-fancybox="gallery"]').fancybox({
            buttons: ["zoom", "close"],
            animationEffect: "fade",
            transitionEffect: "slide"
        });
    }
});
</script>
@endpush
