@extends('layouts.user')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xxl-8 col-xl-10 col-lg-12">

            <!-- Main Card -->
            <div class="card elegant-card">
                <div class="card-header elegant-card-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="header-text">
                            <h5 class="mb-1">Detail Pengaduan</h5>
                            <p class="mb-0 opacity-75">Informasi lengkap mengenai pengaduan Anda</p>
                        </div>
                    </div>
                    <div class="status-display">
                        <span class="status-badge status-{{ strtolower($pengaduan->status) }}">
                            <i class="status-icon fas
                                @if($pengaduan->status === 'Selesai') fa-check-circle
                                @elseif($pengaduan->status === 'Diproses') fa-spinner
                                @elseif($pengaduan->status === 'Ditolak') fa-times-circle
                                @elseif($pengaduan->status === 'Diterima') fa-check
                                @else fa-paper-plane @endif
                            "></i>
                            {{ ucfirst($pengaduan->status) }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Ticket Number & Status Info -->
                    <div class="ticket-header-info mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-badge ticket-number-badge">
                                    <i class="fas fa-ticket-alt me-2"></i>
                                    <strong>Ticket:</strong>
                                    <span class="ticket-value">{{ $pengaduan->ticket_number ?? 'SRP-GENERATING' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-badge status-info-badge">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Status:</strong>
                                    <span class="status-value">{{ ucfirst($pengaduan->status) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Timeline Tracker -->
                    <div class="status-tracker-section mb-4">
                        <div class="tracker-header">
                            <i class="fas fa-road me-2"></i>
                            <h6>Progress Pengaduan</h6>
                        </div>
                        <div class="timeline-tracker">
                            <div class="tracker-steps">
                                <div class="tracker-step {{ $pengaduan->tgl_pengajuan ? 'completed' : '' }} {{ $pengaduan->status === 'Diajukan' ? 'current' : '' }}">
                                    <div class="step-icon">
                                        <i class="fas fa-paper-plane"></i>
                                    </div>
                                    <div class="step-info">
                                        <span class="step-title">Diajukan</span>
                                        <span class="step-date">
                                            @if($pengaduan->tgl_pengajuan)
                                                {{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->format('d M Y, H:i') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="tracker-step {{ $pengaduan->disetujui_at ? 'completed' : '' }} {{ $pengaduan->status === 'Diterima' ? 'current' : '' }}">
                                    <div class="step-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="step-info">
                                        <span class="step-title">Disetujui</span>
                                        <span class="step-date">
                                            @if($pengaduan->disetujui_at)
                                                {{ \Carbon\Carbon::parse($pengaduan->disetujui_at)->format('d M Y, H:i') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="tracker-step {{ $pengaduan->diproses_at ? 'completed' : '' }} {{ $pengaduan->status === 'Diproses' ? 'current' : '' }}">
                                    <div class="step-icon">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <div class="step-info">
                                        <span class="step-title">Diproses</span>
                                        <span class="step-date">
                                            @if($pengaduan->diproses_at)
                                                {{ \Carbon\Carbon::parse($pengaduan->diproses_at)->format('d M Y, H:i') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="tracker-step {{ $pengaduan->selesai_at ? 'completed' : '' }} {{ $pengaduan->status === 'Selesai' ? 'current' : '' }}">
                                    <div class="step-icon">
                                        <i class="fas fa-flag-checkered"></i>
                                    </div>
                                    <div class="step-info">
                                        <span class="step-title">Selesai</span>
                                        <span class="step-date">
                                            @if($pengaduan->selesai_at)
                                                {{ \Carbon\Carbon::parse($pengaduan->selesai_at)->format('d M Y, H:i') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Information Grid -->
                    <div class="row">
                        <!-- Left Column - Main Details -->
                        <div class="col-lg-8">
                            <!-- Complaint Title -->
                            <div class="info-section">
                                <div class="info-header">
                                    <i class="fas fa-heading"></i>
                                    <h6>Judul Pengaduan</h6>
                                </div>
                                <div class="info-content">
                                    <h4 class="complaint-title">{{ $pengaduan->nama_pengaduan }}</h4>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="info-section">
                                <div class="info-header">
                                    <i class="fas fa-align-left"></i>
                                    <h6>Deskripsi Pengaduan</h6>
                                </div>
                                <div class="info-content">
                                    <p class="description-text">{{ $pengaduan->deskripsi }}</p>
                                </div>
                            </div>

                            <!-- Initial Photo -->
                            @if($pengaduan->foto)
                            <div class="info-section">
                                <div class="info-header">
                                    <i class="fas fa-camera"></i>
                                    <h6>Bukti Foto Awal</h6>
                                </div>
                                <div class="info-content">
                                    <div class="photo-container">
                                        <img src="{{ asset('storage/'.$pengaduan->foto) }}"
                                             class="evidence-photo"
                                             alt="Bukti Foto Awal"
                                             onclick="openModal(this.src)">
                                    </div>
                                    <small class="text-muted mt-2 d-block">Klik gambar untuk memperbesar</small>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Right Column - Side Information -->
                        <div class="col-lg-4">
                            <!-- Timeline Information -->
                            <div class="side-card">
                                <div class="side-card-header">
                                    <i class="fas fa-history"></i>
                                    <h6>Timeline Pengaduan</h6>
                                </div>
                                <div class="timeline">
                                    <div class="timeline-item {{ $pengaduan->created_at ? 'active' : '' }}">
                                        <div class="timeline-marker">
                                            <i class="fas fa-paper-plane"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <span class="timeline-title">Diajukan</span>
                                            <span class="timeline-date">
                                                {{ $pengaduan->created_at->format('d M Y') }}
                                            </span>
                                            <span class="timeline-time">
                                                {{ $pengaduan->created_at->format('H:i') }} WIB
                                            </span>
                                        </div>
                                    </div>

                                    @if($pengaduan->tgl_selesai)
                                    <div class="timeline-item active">
                                        <div class="timeline-marker">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <span class="timeline-title">Selesai</span>
                                            <span class="timeline-date">
                                                {{ \Carbon\Carbon::parse($pengaduan->tgl_selesai)->format('d M Y') }}
                                            </span>
                                            <span class="timeline-time">
                                                {{ \Carbon\Carbon::parse($pengaduan->tgl_selesai)->format('H:i') }} WIB
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Location & Item Info -->
                            <div class="side-card">
                                <div class="side-card-header">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h6>Lokasi dan Item</h6>
                                </div>
                                <div class="location-info">
                                    <div class="location-item">
                                        <i class="fas fa-warehouse text-primary"></i>
                                        <div>
                                            <span class="label">Lokasi</span>
                                            <span class="value">{{ $pengaduan->lokasi->nama_lokasi ?? 'Tidak tersedia' }}</span>
                                        </div>
                                    </div>
                                    <div class="location-item">
                                        <i class="fas fa-box text-success"></i>
                                        <div>
                                            <span class="label">Item</span>
                                            <span class="value">{{ $pengaduan->item->nama_item ?? 'Tidak tersedia' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Handling Information -->
                    @if($pengaduan->status === 'Selesai' || $pengaduan->id_petugas)
                    <div class="handling-section">
                        <div class="section-header">
                            <i class="fas fa-tools text-success"></i>
                            <h5>Informasi Penanganan</h5>
                        </div>

                        <div class="row">
                            @if($pengaduan->petugas)
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-card-icon bg-primary">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <div class="info-card-content">
                                        <span class="info-card-label">Petugas Penanggung Jawab</span>
                                        <span class="info-card-value">{{ $pengaduan->petugas->name }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($pengaduan->tgl_selesai)
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-card-icon bg-success">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="info-card-content">
                                        <span class="info-card-label">Tanggal Selesai</span>
                                        <span class="info-card-value">
                                            {{ \Carbon\Carbon::parse($pengaduan->tgl_selesai)->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Officer Notes -->
                        @if($pengaduan->saran_petugas)
                        <div class="officer-notes">
                            <div class="notes-header">
                                <i class="fas fa-comment-dots"></i>
                                <h6>Saran / Catatan Petugas</h6>
                            </div>
                            <div class="notes-content">
                                {{ $pengaduan->saran_petugas }}
                            </div>
                        </div>
                        @endif

                        <!-- Completion Evidence -->
                        @if($pengaduan->bukti_selesai)
                        <div class="evidence-section">
                            <div class="evidence-header">
                                <i class="fas fa-camera-retro"></i>
                                <h6>Bukti Penyelesaian</h6>
                            </div>
                            <div class="evidence-content">
                                <div class="photo-container">
                                    <img src="{{ asset('storage/'.$pengaduan->bukti_selesai) }}"
                                         class="evidence-photo"
                                         alt="Bukti Selesai"
                                         onclick="openModal(this.src)">
                                </div>
                                <small class="text-muted mt-2 d-block">Klik gambar untuk memperbesar</small>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- 🎯 FITUR RATING - TAMPIL JIKA SELESAI DAN BELUM ADA RATING -->
                    @if($pengaduan->status === 'Selesai' && !$pengaduan->rating)
                    <div class="rating-section mb-4">
                        <div class="rating-card">
                            <div class="rating-header">
                                <i class="fas fa-star text-warning me-2"></i>
                                <h6>Beri Penilaian untuk Layanan Perbaikan</h6>
                            </div>
                            <div class="rating-content">
                                <p class="rating-description mb-3">
                                    Bagaimana pengalaman Anda dengan layanan perbaikan ini? Penilaian Anda membantu kami meningkatkan kualitas layanan.
                                </p>

                                <form action="{{ route('pengaduan.rating', $pengaduan->id_pengaduan) }}" method="POST" id="ratingForm">
                                    @csrf

                                    <!-- Star Rating -->
                                    <div class="rating-stars mb-4">
                                        <div class="star-rating">
                                            <input type="radio" id="star5" name="rating" value="5" required>
                                            <label for="star5" title="Sangat Puas">
                                                <i class="fas fa-star"></i>
                                                <span class="star-label">Sangat Puas</span>
                                            </label>

                                            <input type="radio" id="star4" name="rating" value="4">
                                            <label for="star4" title="Puas">
                                                <i class="fas fa-star"></i>
                                                <span class="star-label">Puas</span>
                                            </label>

                                            <input type="radio" id="star3" name="rating" value="3">
                                            <label for="star3" title="Cukup">
                                                <i class="fas fa-star"></i>
                                                <span class="star-label">Cukup</span>
                                            </label>

                                            <input type="radio" id="star2" name="rating" value="2">
                                            <label for="star2" title="Kurang Puas">
                                                <i class="fas fa-star"></i>
                                                <span class="star-label">Kurang Puas</span>
                                            </label>

                                            <input type="radio" id="star1" name="rating" value="1">
                                            <label for="star1" title="Sangat Tidak Puas">
                                                <i class="fas fa-star"></i>
                                                <span class="star-label">Sangat Tidak Puas</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Feedback Input -->
                                    <div class="form-group mb-3">
                                        <label class="form-label">Feedback (Opsional)</label>
                                        <textarea name="feedback" class="form-control" rows="3"
                                                  placeholder="Ceritakan pengalaman Anda dengan layanan perbaikan ini..."></textarea>
                                        <small class="form-text text-muted">Komentar Anda sangat berharga untuk perbaikan layanan kami</small>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-warning btn-lg w-100">
                                        <i class="fas fa-paper-plane me-2"></i>Kirim Penilaian
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Rating Display (Jika sudah ada rating) -->
                    @if($pengaduan->rating)
                    <div class="rating-display mb-4">
                        <div class="rating-result-card">
                            <div class="rating-result-header">
                                <i class="fas fa-star text-warning me-2"></i>
                                <h6>Penilaian Anda</h6>
                                <span class="rating-date ms-auto">
                                    Dinilai pada: {{ \Carbon\Carbon::parse($pengaduan->updated_at)->format('d M Y, H:i') }}
                                </span>
                            </div>
                            <div class="rating-result-content">
                                <!-- Star Display -->
                                <div class="rating-stars-display mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $pengaduan->rating ? 'text-warning' : 'text-muted' }} fa-lg"></i>
                                    @endfor
                                    <span class="rating-score ms-2 fw-bold fs-5">{{ $pengaduan->rating }}/5</span>
                                </div>

                                <!-- Rating Label -->
                                <div class="rating-label mb-3">
                                    @if($pengaduan->rating >= 4)
                                        <span class="badge bg-success">
                                            <i class="fas fa-smile me-1"></i>Sangat Memuaskan
                                        </span>
                                    @elseif($pengaduan->rating >= 3)
                                        <span class="badge bg-info">
                                            <i class="fas fa-meh me-1"></i>Cukup Memuaskan
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-frown me-1"></i>Perlu Perbaikan
                                        </span>
                                    @endif
                                </div>

                                <!-- Feedback Display -->
                                @if($pengaduan->feedback)
                                    <div class="feedback-section">
                                        <h6 class="feedback-title">
                                            <i class="fas fa-comment me-2"></i>Feedback Anda:
                                        </h6>
                                        <div class="feedback-text">
                                            "{{ $pengaduan->feedback }}"
                                        </div>
                                    </div>
                                @else
                                    <div class="no-feedback">
                                        <i class="fas fa-comment-slash text-muted me-2"></i>
                                        <span class="text-muted">Tidak ada feedback tambahan</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        
                        <a href="{{ route('pengaduan.create') }}" class="btn btn-primary btn-elegant">
                            <i class="fas fa-plus me-2"></i>
                            Buat Pengaduan Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="modalImage" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary: #4361ee;
    --primary-dark: #3a56d4;
    --secondary: #6c757d;
    --success: #28a745;
    --warning: #ffc107;
    --danger: #dc3545;
    --info: #17a2b8;
    --light: #f8f9fa;
    --dark: #343a40;
    --border-radius: 12px;
    --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Card Styles */
.elegant-card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    background: #ffffff;
    transition: var(--transition);
    overflow: hidden;
}

.elegant-card:hover {
    box-shadow: var(--shadow-hover);
}

/* Card Header */
.elegant-card-header {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-bottom: none;
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.header-text h5 {
    color: white;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.header-text p {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 0;
    font-size: 0.875rem;
}

/* Status Badge */
.status-display .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.875rem;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.status-selesai { background: linear-gradient(135deg, var(--success), #1e7e34); }
.status-diproses { background: linear-gradient(135deg, var(--warning), #e0a800); color: #000 !important; }
.status-ditolak { background: linear-gradient(135deg, var(--danger), #c82333); }
.status-diterima { background: linear-gradient(135deg, var(--info), #138496); }
.status-diajukan { background: linear-gradient(135deg, var(--secondary), #545b62); }

/* Ticket Header Info */
.ticket-header-info {
    background: linear-gradient(135deg, #f8f9ff, #f0f4ff);
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e6f0ff;
    margin-bottom: 1.5rem;
}

.info-badge {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    background: white;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    font-size: 0.9rem;
}

.ticket-number-badge {
    border-left: 4px solid #4361ee;
}

.status-info-badge {
    border-left: 4px solid #4361ee;
}

.ticket-value, .status-value {
    font-weight: 600;
    margin-left: 0.5rem;
}

/* Status Timeline Tracker */
.status-tracker-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
    margin-bottom: 1.5rem;
}

.tracker-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    color: #343a40;
    font-weight: 600;
}

.timeline-tracker {
    position: relative;
}

.tracker-steps {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    position: relative;
}

.tracker-steps::before {
    content: '';
    position: absolute;
    top: 30px;
    left: 50px;
    right: 50px;
    height: 3px;
    background: #e9ecef;
    z-index: 1;
}

.tracker-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    z-index: 2;
}

.step-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
}

.step-icon i {
    color: #6c757d;
    font-size: 1.25rem;
}

.tracker-step.completed .step-icon {
    background: #28a745;
}

.tracker-step.completed .step-icon i {
    color: white;
}

.tracker-step.current .step-icon {
    background: #4361ee;
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
}

.tracker-step.current .step-icon i {
    color: white;
}

.step-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.step-title {
    font-weight: 600;
    font-size: 0.875rem;
    color: #343a40;
}

.step-date {
    font-size: 0.75rem;
    color: #6c757d;
}

/* Rating Section Styles */
.rating-card {
    background: linear-gradient(135deg, #fff9ed, #fff3e0);
    border-radius: 16px;
    padding: 2rem;
    border: 2px solid #ffe0b2;
    box-shadow: 0 8px 25px rgba(255, 152, 0, 0.1);
    margin-bottom: 1.5rem;
}

.rating-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    color: #343a40;
    font-weight: 700;
    font-size: 1.1rem;
}

.rating-description {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.5;
    margin-bottom: 1.5rem;
}

/* Enhanced Star Rating */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.star-rating input {
    display: none;
}

.star-rating label {
    cursor: pointer;
    font-size: 2.5rem;
    color: #ddd;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem;
    border-radius: 8px;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    color: #ffc107;
    transform: scale(1.1);
}

.star-rating input:checked ~ label {
    animation: bounce 0.5s ease;
}

.star-label {
    font-size: 0.75rem;
    color: #666;
    font-weight: 500;
    text-align: center;
}

.star-rating label:hover .star-label,
.star-rating input:checked ~ label .star-label {
    color: #ffc107;
    font-weight: 600;
}

@keyframes bounce {
    0%, 100% { transform: scale(1.1); }
    50% { transform: scale(1.2); }
}

/* Rating Result Display */
.rating-result-card {
    background: linear-gradient(135deg, #f8f9ff, #f0f4ff);
    border-radius: 16px;
    padding: 2rem;
    border: 2px solid #4361ee;
    box-shadow: 0 8px 25px rgba(67, 97, 238, 0.1);
    margin-bottom: 1.5rem;
}

.rating-result-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    color: #343a40;
    font-weight: 700;
}

.rating-date {
    font-size: 0.875rem;
    color: #666;
    font-weight: normal;
    margin-left: auto;
}

.rating-stars-display {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.rating-score {
    font-weight: 700;
    color: #343a40;
    font-size: 1.25rem;
}

.rating-label .badge {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
}

.feedback-section {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid #4361ee;
    margin-top: 1rem;
}

.feedback-title {
    color: #343a40;
    font-weight: 600;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
}

.feedback-text {
    color: #555;
    font-style: italic;
    line-height: 1.5;
    font-size: 0.95rem;
}

.no-feedback {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    color: #666;
}

/* Info Sections */
.info-section {
    background: var(--light);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e9ecef;
}

.info-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.info-header i {
    color: var(--primary);
    font-size: 1.1rem;
}

.info-header h6 {
    color: var(--dark);
    font-weight: 600;
    margin-bottom: 0;
}

.complaint-title {
    color: var(--dark);
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 0;
}

.description-text {
    color: var(--secondary);
    line-height: 1.6;
    margin-bottom: 0;
}

/* Side Cards */
.side-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.side-card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.side-card-header i {
    color: var(--primary);
    font-size: 1.1rem;
}

.side-card-header h6 {
    color: var(--dark);
    font-weight: 600;
    margin-bottom: 0;
}

/* Timeline */
.timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 0.75rem 0;
    position: relative;
}

.timeline-item:not(:last-child):after {
    content: '';
    position: absolute;
    left: 1.25rem;
    top: 3rem;
    bottom: -0.75rem;
    width: 2px;
    background: #e9ecef;
}

.timeline-marker {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    background: var(--light);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    z-index: 2;
}

.timeline-marker i {
    color: var(--secondary);
    font-size: 0.875rem;
}

.timeline-item.active .timeline-marker {
    background: var(--primary);
}

.timeline-item.active .timeline-marker i {
    color: white;
}

.timeline-content {
    flex: 1;
}

.timeline-title {
    display: block;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.timeline-date,
.timeline-time {
    display: block;
    font-size: 0.875rem;
    color: var(--secondary);
}

/* Location Info */
.location-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.location-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    background: var(--light);
    border-radius: 8px;
}

.location-item i {
    font-size: 1.25rem;
    width: 1.5rem;
    text-align: center;
}

.location-item div {
    flex: 1;
}

.location-item .label {
    display: block;
    font-size: 0.75rem;
    color: var(--secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.location-item .value {
    display: block;
    font-weight: 600;
    color: var(--dark);
}

/* Handling Section */
.handling-section {
    background: linear-gradient(135deg, #f8f9ff, #f0f4ff);
    border-radius: var(--border-radius);
    padding: 2rem;
    margin: 2rem 0;
    border: 1px solid #e6f0ff;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.section-header i {
    font-size: 1.5rem;
}

.section-header h5 {
    color: var(--dark);
    font-weight: 700;
    margin-bottom: 0;
}

/* Info Cards */
.info-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: white;
    border-radius: var(--border-radius);
    border: 1px solid #e9ecef;
    height: 100%;
}

.info-card-icon {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    flex-shrink: 0;
}

.info-card-content {
    flex: 1;
}

.info-card-label {
    display: block;
    font-size: 0.875rem;
    color: var(--secondary);
    margin-bottom: 0.25rem;
}

.info-card-value {
    display: block;
    font-weight: 600;
    color: var(--dark);
    font-size: 1.1rem;
}

/* Officer Notes */
.officer-notes {
    background: white;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin: 1.5rem 0;
    border-left: 4px solid var(--info);
}

.notes-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.notes-header i {
    color: var(--info);
    font-size: 1.1rem;
}

.notes-header h6 {
    color: var(--dark);
    font-weight: 600;
    margin-bottom: 0;
}

.notes-content {
    color: var(--secondary);
    line-height: 1.6;
    margin-bottom: 0;
}

/* Evidence Section */
.evidence-section {
    margin-top: 1.5rem;
}

.evidence-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.evidence-header i {
    color: var(--success);
    font-size: 1.1rem;
}

.evidence-header h6 {
    color: var(--dark);
    font-weight: 600;
    margin-bottom: 0;
}

/* Photo Container */
.photo-container {
    position: relative;
    display: inline-block;
    border-radius: var(--border-radius);
    overflow: hidden;
    cursor: pointer;
    transition: var(--transition);
}

.photo-container:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.evidence-photo {
    max-width: 100%;
    max-height: 300px;
    object-fit: contain;
    border-radius: var(--border-radius);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: space-between;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
}

.btn-elegant {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: var(--transition);
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-elegant:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-accent {
    background: var(--secondary);
    color: white;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

/* Responsive Design untuk Tracker */
@media (max-width: 768px) {
    .tracker-steps {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .tracker-steps::before {
        display: none;
    }

    .tracker-step {
        flex-direction: row;
        text-align: left;
        gap: 1rem;
    }

    .step-icon {
        margin-bottom: 0;
        flex-shrink: 0;
    }

    .star-rating label {
        font-size: 2rem;
    }

    .star-label {
        font-size: 0.7rem;
    }

    .rating-card,
    .rating-result-card {
        padding: 1.5rem;
    }

    .rating-result-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .rating-date {
        align-self: flex-start;
        margin-left: 0;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .elegant-card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem;
    }

    .header-content {
        width: 100%;
    }

    .status-display {
        align-self: flex-start;
    }

    .action-buttons {
        flex-direction: column;
    }

    .info-card {
        flex-direction: column;
        text-align: center;
    }

    .timeline-item:after {
        left: 1.5rem;
    }

    .handling-section {
        padding: 1.5rem;
        margin: 1.5rem 0;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .info-section,
    .side-card {
        padding: 1.25rem;
    }

    .header-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }

    .ticket-header-info {
        padding: 1rem;
    }

    .info-badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
    }
}
</style>

@push('scripts')
<script>
function openModal(src) {
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    document.getElementById('modalImage').src = src;
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Rating form interaction
    const ratingForm = document.getElementById('ratingForm');
    const starInputs = document.querySelectorAll('.star-rating input');

    if (ratingForm) {
        // Star hover effect
        starInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Remove all active classes
                document.querySelectorAll('.star-rating label').forEach(label => {
                    label.classList.remove('active');
                });

                // Add active class to selected and previous stars
                const selectedValue = this.value;
                for (let i = 5; i >= selectedValue; i--) {
                    const label = document.querySelector(`.star-rating label[for="star${i}"]`);
                    if (label) {
                        label.classList.add('active');
                    }
                }
            });
        });

        // Form submission
        ratingForm.addEventListener('submit', function(e) {
            const selectedRating = document.querySelector('input[name="rating"]:checked');

            if (!selectedRating) {
                e.preventDefault();
                showToast('Harap pilih rating terlebih dahulu', 'error');
                return;
            }

            // Add loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div> Mengirim...';
            submitBtn.disabled = true;

            // Form will submit normally
        });
    }

    // Add animation to elements
    const elements = document.querySelectorAll('.info-section, .side-card, .info-card');
    elements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.1}s`;
        element.classList.add('animate__animated', 'animate__fadeInUp');
    });
});

// Toast notification function
function showToast(message, type = 'info') {
    // Implementasi toast sesuai kebutuhan
    alert(message); // Temporary simple alert
}
</script>
@endpush
@endsection
