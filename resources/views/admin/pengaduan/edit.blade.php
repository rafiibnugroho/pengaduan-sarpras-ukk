@extends('layouts.admin')

@section('content')
<div class="container py-4">

    <!-- Judul Halaman -->
    <div class="card shadow-lg border-0 rounded-4 mb-4 animate-fadeIn">
        <div class="card-header bg-gradient bg-primary text-white border-0 rounded-top-4 p-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-edit me-2"></i> Edit Pengaduan
            </h4>
            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-light btn-sm rounded-pill shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('admin.pengaduan.update', $pengaduan->id_pengaduan) }}"
                  method="POST" enctype="multipart/form-data" class="row g-4">
                @csrf
                @method('PUT')

                <!-- Nama Pengaduan -->
                <div class="col-md-6">
                    <label for="nama_pengaduan" class="form-label fw-semibold text-secondary">
                        <i class="fas fa-file-alt me-1 text-primary"></i>Nama Pengaduan
                    </label>
                    <input type="text" name="nama_pengaduan" id="nama_pengaduan"
                           class="form-control rounded-3 shadow-sm"
                           value="{{ old('nama_pengaduan', $pengaduan->nama_pengaduan) }}" required>
                </div>

                <!-- Lokasi (Dropdown) -->
                <div class="col-md-6">
                    <label for="id_lokasi" class="form-label fw-semibold text-secondary">
                        <i class="fas fa-map-marker-alt me-1 text-danger"></i>Lokasi
                    </label>
                    <select name="id_lokasi" id="id_lokasi" class="form-select rounded-3 shadow-sm" required>
                        <option value="" disabled selected>Pilih Lokasi</option>
                        @foreach($lokasi as $l)
                            <option value="{{ $l->id_lokasi }}"
                                {{ $pengaduan->id_lokasi == $l->id_lokasi ? 'selected' : '' }}>
                                {{ $l->nama_lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Deskripsi -->
                <div class="col-12">
                    <label for="deskripsi" class="form-label fw-semibold text-secondary">
                        <i class="fas fa-align-left me-1 text-success"></i>Deskripsi
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="form-control rounded-3 shadow-sm"
                              required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold text-secondary">
                        <i class="fas fa-flag me-1 text-info"></i>Status
                    </label>
                    <select name="status" id="status" class="form-select rounded-3 shadow-sm">
                        @foreach(['Diajukan','Disetujui','Ditolak','Diproses','Selesai'] as $status)
                            <option value="{{ $status }}" {{ $pengaduan->status == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pengguna -->
                <div class="col-md-6">
                    <label for="id_user" class="form-label fw-semibold text-secondary">
                        <i class="fas fa-user me-1 text-primary"></i>Pengguna
                    </label>
                    <select name="id_user" id="id_user" class="form-select rounded-3 shadow-sm" required>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ $pengaduan->id_user == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Item -->
                <div class="col-md-6">
                    <label for="id_item" class="form-label fw-semibold text-secondary">
                        <i class="fas fa-box me-1 text-warning"></i>Barang / Item
                    </label>
                    <select name="id_item" id="id_item" class="form-select rounded-3 shadow-sm" required>
                        @foreach($items as $i)
                            <option value="{{ $i->id_item }}" {{ $pengaduan->id_item == $i->id_item ? 'selected' : '' }}>
                                {{ $i->nama_item }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Foto -->
                <div class="col-md-6">
                    <label for="foto" class="form-label fw-semibold text-secondary">
                        <i class="fas fa-image me-1 text-success"></i>Foto
                    </label>
                    @if($pengaduan->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$pengaduan->foto) }}"
                                 alt="Foto Pengaduan"
                                 class="img-fluid rounded-4 shadow-sm"
                                 style="max-width: 200px;">
                        </div>
                    @endif
                    <input type="file" name="foto" id="foto" class="form-control rounded-3 shadow-sm">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                </div>

                <!-- Tombol Aksi -->
                <div class="col-12 text-end mt-3">
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-secondary rounded-3 px-4 me-2">
                        <i class="fas fa-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .animate-fadeIn {
        animation: fadeInUp 0.4s ease both;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection
