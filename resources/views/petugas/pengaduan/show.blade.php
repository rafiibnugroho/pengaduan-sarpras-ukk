@extends('layouts.petugas')

@section('title', 'Detail Pengaduan - ' . config('app.name'))

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="detail-header bg-gradient-primary text-white rounded-4 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="header-icon bg-white-20 rounded-3 p-3 me-3">
                            <i class="fas fa-info-circle fa-lg text-white"></i>
                        </div>
                        <div>
                            <h1 class="h3 fw-bold mb-1">Detail Pengaduan</h1>
                            <p class="mb-0 opacity-90">Informasi lengkap pengaduan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Pengaduan Details -->
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-clipboard-list text-primary fs-5 me-2"></i>
                        <h5 class="fw-bold mb-0">Informasi Pengaduan</h5>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Judul -->
                    <div class="mb-4">
                        <h2 class="h4 fw-bold text-dark mb-2">{{ $pengaduan->nama_pengaduan }}</h2>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $pengaduan->created_at->format('d M Y, H:i') }}
                            </span>
                            <span class="badge bg-info bg-opacity-10 text-info">
                                <i class="fas fa-user me-1"></i>
                                {{ $pengaduan->user->name ?? 'Unknown' }}
                            </span>
                            @if($pengaduan->status == 'Selesai' && $pengaduan->rating)
                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-star me-1"></i>
                                Rating: {{ $pengaduan->rating }}/5
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Detail Grid -->
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="detail-item">
                                <i class="fas fa-align-left text-primary"></i>
                                <div>
                                    <h6 class="fw-semibold mb-1">Deskripsi</h6>
                                    <p class="text-muted mb-0">{{ $pengaduan->deskripsi }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-item">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                <div>
                                    <h6 class="fw-semibold mb-1">Lokasi</h6>
                                    <p class="text-muted mb-0">
                                        {{ is_object($pengaduan->lokasi) ? $pengaduan->lokasi->nama_lokasi : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-item">
                                <i class="fas fa-cube text-success"></i>
                                <div>
                                    <h6 class="fw-semibold mb-1">Item</h6>
                                    <p class="text-muted mb-0">{{ $pengaduan->item->nama_item ?? '-' }}</p>
                                </div>
                            </div>
                        </div>



                        <!-- Saran Petugas -->
                        @if($pengaduan->saran_petugas)
                        <div class="col-12">
                            <div class="detail-item">
                                <i class="fas fa-comment-alt text-info"></i>
                                <div>
                                    <h6 class="fw-semibold mb-1">Saran Petugas</h6>
                                    <p class="text-muted mb-0">{{ $pengaduan->saran_petugas }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Rating & Ulasan -->
                        @if($pengaduan->status == 'Selesai')
                        <div class="col-12">
                            <div class="rating-section">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-star text-warning fs-5 me-2"></i>
                                    <h6 class="fw-bold mb-0">Rating & Ulasan</h6>
                                </div>

                                @if($pengaduan->rating)
                                <div class="rating-display-card">
                                    <div class="rating-stars-display">
                                        @for($i = 1; $i <= 5; $i++)
                                            <div class="star-display {{ $i <= $pengaduan->rating ? 'active' : '' }}">
                                                <i class="fas fa-star"></i>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="rating-info">
                                        <div class="rating-score">
                                            <span class="score">{{ $pengaduan->rating }}</span>
                                            <span class="score-max">/5</span>
                                        </div>
                                        <div class="rating-text">
                                            @if($pengaduan->rating == 5)
                                                Sangat Memuaskan
                                            @elseif($pengaduan->rating == 4)
                                                Memuaskan
                                            @elseif($pengaduan->rating == 3)
                                                Cukup
                                            @elseif($pengaduan->rating == 2)
                                                Kurang
                                            @else
                                                Sangat Kurang
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($pengaduan->ulasan)
                                <div class="ulasan-content mt-3">
                                    <div class="ulasan-header">
                                        <i class="fas fa-comment me-2"></i>
                                        <h6 class="fw-semibold mb-0">Ulasan Pelanggan</h6>
                                    </div>
                                    <div class="ulasan-text">
                                        <p class="mb-0">"{{ $pengaduan->ulasan }}"</p>
                                    </div>
                                </div>
                                @endif
                                @else
                                <div class="no-rating">
                                    <i class="fas fa-star fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Belum ada rating dan ulasan untuk pengaduan ini.</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Bukti Foto -->
                    @if($pengaduan->foto)
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-image text-success fs-5 me-2"></i>
                            <h6 class="fw-bold mb-0">Bukti Foto Pengaduan</h6>
                        </div>
                        <a href="{{ asset('storage/'.$pengaduan->foto) }}" class="evidence-link" data-fancybox>
                            <img src="{{ asset('storage/'.$pengaduan->foto) }}"
                                 alt="Bukti Foto"
                                 class="evidence-img rounded-3">
                        </a>
                    </div>
                    @endif

                    <!-- Bukti Selesai -->
                    @if($pengaduan->bukti_selesai)
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-primary fs-5 me-2"></i>
                            <h6 class="fw-bold mb-0">Bukti Penyelesaian</h6>
                        </div>
                        <a href="{{ asset('storage/'.$pengaduan->bukti_selesai) }}" class="evidence-link" data-fancybox>
                            <img src="{{ asset('storage/'.$pengaduan->bukti_selesai) }}"
                                 alt="Bukti Selesai"
                                 class="evidence-img rounded-3">
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- Status Update -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-edit text-warning fs-5 me-2"></i>
                        <h5 class="fw-bold mb-0">Update Status</h5>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('petugas.pengaduan.updateStatus', $pengaduan->id_pengaduan) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-sync-alt me-1"></i>Status Saat Ini
                            </label>
                            <div class="current-status p-2 bg-light rounded-2 text-center">
                                <span class="status-badge status-{{ strtolower($pengaduan->status) }}">
                                    {{ $pengaduan->status }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-arrow-right me-1"></i>Ubah Status Ke
                            </label>
                            <select name="status" id="status" class="form-select">
    <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>
        ⚙ Diproses
    </option>
    <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>
        ✔ Selesai
    </option>
    <option value="Ditolak" {{ $pengaduan->status == 'Ditolak' ? 'selected' : '' }}>
        ✖ Ditolak
    </option>
</select>

                        </div>

                        <div class="mb-3" id="uploadBuktiContainer" style="display: none;">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-camera me-1"></i>Upload Bukti Selesai
                            </label>
                            <input type="file" name="bukti_selesai" id="bukti_selesai"
                                   class="form-control" accept="image/*">
                            <small class="text-muted">Max 5MB - JPG/PNG</small>
                        </div>

                        <div class="mb-3" id="saranContainer" style="display: none;">
                            <label for="saran_petugas" class="form-label fw-semibold text-primary">
                                <i class="fas fa-comment-dots me-2"></i> Saran Petugas
                            </label>
                            <textarea name="saran_petugas" id="saran_petugas" rows="3"
                                      class="form-control shadow-sm"
                                      placeholder="Tuliskan saran atau catatan untuk pelapor...">{{ old('saran_petugas', $pengaduan->saran_petugas) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2">
                            <i class="fas fa-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* Optimized CSS - Minimal animations */
.detail-header {
    background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
}

.header-icon {
    background: rgba(255, 255, 255, 0.2);
}

.bg-white-20 {
    background: rgba(255, 255, 255, 0.2);
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.status-diajukan {
    background: rgba(245, 158, 11, 0.15);
    color: #D97706;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.status-diproses {
    background: rgba(59, 130, 246, 0.15);
    color: #2563EB;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.status-selesai {
    background: rgba(16, 185, 129, 0.15);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.status-ditolak {
    background: rgba(239, 68, 68, 0.15);
    color: #DC2626;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.detail-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: background-color 0.2s ease;
}

.detail-item:hover {
    background: #e9ecef;
}

.detail-item i {
    font-size: 1.1rem;
    margin-top: 0.2rem;
    flex-shrink: 0;
    width: 20px;
}

.evidence-link {
    display: block;
    transition: transform 0.2s ease;
}

.evidence-link:hover {
    transform: scale(1.02);
}

.evidence-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card {
    transition: box-shadow 0.2s ease;
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

/* Rating Section Styles */
.rating-section {
    background: linear-gradient(135deg, #fefce8 0%, #fef9c3 100%);
    border-radius: 12px;
    padding: 1.5rem;
    border-left: 4px solid #f59e0b;
}

.rating-display-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.rating-stars-display {
    display: flex;
    gap: 0.25rem;
}

.star-display {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #f3f4f6;
    transition: all 0.3s ease;
}

.star-display.active {
    background: #f59e0b;
    transform: scale(1.1);
}

.star-display i {
    font-size: 1rem;
    color: #d1d5db;
    transition: all 0.3s ease;
}

.star-display.active i {
    color: white;
}

.rating-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.rating-score {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
}

.score {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
}

.score-max {
    font-size: 1rem;
    color: #6b7280;
    font-weight: 500;
}

.rating-text {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
    margin-top: 0.25rem;
}

.ulasan-content {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-left: 3px solid #3b82f6;
}

.ulasan-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.ulasan-header i {
    color: #3b82f6;
}

.ulasan-header h6 {
    margin: 0;
    font-weight: 600;
    color: #1f2937;
}

.ulasan-text p {
    margin: 0;
    font-style: italic;
    color: #4b5563;
    line-height: 1.6;
    font-size: 0.95rem;
}

.no-rating {
    text-align: center;
    padding: 2rem;
    color: #6b7280;
}

.no-rating i {
    margin-bottom: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .detail-header .d-flex {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .detail-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .evidence-img {
        height: 150px;
    }

    .rating-display-card {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .rating-info {
        align-items: center;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const uploadContainer = document.getElementById('uploadBuktiContainer');
    const saranContainer = document.getElementById('saranContainer');

    if (!statusSelect || !uploadContainer || !saranContainer) {
        console.error('Elemen yang diperlukan tidak ditemukan di DOM.');
        return;
    }

    function toggleFields() {
        console.log('Status saat ini:', statusSelect.value);
        if (statusSelect.value === 'Selesai') {
            uploadContainer.style.display = 'block';
            saranContainer.style.display = 'block';
        } else {
            uploadContainer.style.display = 'none';
            saranContainer.style.display = 'none';
        }
    }

    toggleFields(); // Periksa awal
    statusSelect.addEventListener('change', toggleFields);

    // Inisialisasi Fancybox
    if (typeof $ !== 'undefined') {
        $('[data-fancybox]').fancybox({
            buttons: ["zoom", "close"],
            animationEffect: "fade"
        });
    } else {
        console.error('jQuery tidak ditemukan. Fancybox tidak dapat diinisialisasi.');
    }
});
</script>
@endpush
@endsection
