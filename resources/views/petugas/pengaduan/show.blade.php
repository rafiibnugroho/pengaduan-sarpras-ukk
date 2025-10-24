@extends('layouts.petugas')

@section('content')
<div class="container py-4">
    <!-- Detail Pengaduan -->
    <div class="card shadow-lg border-0 rounded-4 mb-4 animate-fadeIn">
        <div class="card-header bg-gradient bg-primary text-white border-0 rounded-top-4 p-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-info-circle me-2"></i> Detail Pengaduan
            </h4>
            <span class="badge rounded-pill px-3 py-2 fs-6 bg-{{ $pengaduan->status == 'Selesai' ? 'success' :
                    ($pengaduan->status == 'Ditolak' ? 'danger' :
                    ($pengaduan->status == 'Diproses' ? 'info' : 'warning')) }}">
                {{ $pengaduan->status }}
            </span>
        </div>

        <div class="card-body p-4">
            <!-- Judul -->
            <h5 class="fw-bold text-dark mb-4">{{ $pengaduan->nama_pengaduan }}</h5>

            <!-- Detail Grid -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="detail-box">
                        <p class="mb-1 fw-semibold text-secondary"><i class="fas fa-align-left me-2 text-primary"></i>Deskripsi</p>
                        <p class="text-muted mb-0">{{ $pengaduan->deskripsi }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-box">
                        <p class="mb-1 fw-semibold text-secondary"><i class="fas fa-map-marker-alt me-2 text-danger"></i>Lokasi</p>
                        <p class="text-muted mb-0">{{ $pengaduan->lokasi }}</p>
                    </div>
                </div>
            </div>

            <!-- Foto -->
            @if($pengaduan->foto)
                <div class="mt-4">
                    <p class="fw-semibold text-secondary mb-2">
                        <i class="fas fa-image me-2 text-success"></i>Bukti Foto
                    </p>
                    <a href="{{ asset('storage/'.$pengaduan->foto) }}" target="_blank">
                        <img src="{{ asset('storage/'.$pengaduan->foto) }}"
                             alt="Bukti Foto"
                             class="img-fluid rounded-4 shadow-sm hover-zoom"
                             style="max-width: 500px;">
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Update Status -->
    <div class="card shadow-lg border-0 rounded-4 animate-fadeIn" style="animation-delay: 0.1s;">
        <div class="card-header bg-gradient bg-light border-0 rounded-top-4 p-3">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="fas fa-edit me-2"></i> Ubah Status Pengaduan
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('petugas.pengaduan.updateStatus', $pengaduan->id_pengaduan) }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Pilih Status</label>
                    <select name="status" id="status" class="form-select shadow-sm">
                        <option value="Diajukan" {{ $pengaduan->status == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="Disetujui" {{ $pengaduan->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ $pengaduan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-success px-4 py-2 shadow-sm rounded-3">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .detail-box {
        background: #f9fafb;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }
    .detail-box:hover {
        background: #eef2f7;
    }
    .hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-zoom:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .animate-fadeIn {
        animation: fadeInUp 0.5s ease both;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection
