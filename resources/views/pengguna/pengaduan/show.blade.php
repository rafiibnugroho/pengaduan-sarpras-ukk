@extends('layouts.user')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Card utama -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0 text-primary">
                            <i class="fas fa-file-alt me-2"></i> Detail Pengaduan
                        </h4>
                        <span class="badge rounded-pill px-3 py-2
                            @if($pengaduan->status === 'Selesai') bg-success
                            @elseif($pengaduan->status === 'Diproses') bg-warning text-dark
                            @elseif($pengaduan->status === 'Ditolak') bg-danger
                            @else bg-primary @endif">
                            {{ ucfirst($pengaduan->status) }}
                        </span>
                    </div>

                    <!-- Judul -->
                    <div class="mb-3">
                        <h6 class="text-muted">Judul Pengaduan</h6>
                        <p class="fw-semibold fs-5">{{ $pengaduan->nama_pengaduan }}</p>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <h6 class="text-muted">Deskripsi</h6>
                        <p>{{ $pengaduan->deskripsi }}</p>
                    </div>

                    <!-- Tanggal -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Tanggal</h6>
                            <p><i class="fas fa-calendar-alt me-2"></i>{{ $pengaduan->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Waktu</h6>
                            <p><i class="fas fa-clock me-2"></i>{{ $pengaduan->created_at->format('H:i') }} WIB</p>
                        </div>
                    </div>

                    <!-- Foto -->
                    @if($pengaduan->foto)
                    <div class="mb-4">
                        <h6 class="text-muted">Bukti Foto</h6>
                        <img src="{{ asset('storage/'.$pengaduan->foto) }}"
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 300px; object-fit: contain;">
                    </div>
                    @endif

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Buat Laporan Baru
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
