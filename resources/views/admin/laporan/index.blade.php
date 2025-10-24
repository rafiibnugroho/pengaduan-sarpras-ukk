@extends('layouts.admin')

@section('title', 'Laporan Pengaduan')

@section('content')
<div class="container py-5">
    {{-- Mengganti shadow menjadi lebih dalam (shadow-lg) dan menggunakan background putih --}}
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden fade-in">
        {{-- CARD HEADER: Gradient (Elegant) --}}
        <div class="card-header text-white d-flex justify-content-between align-items-center p-4"
             style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-file-alt me-2"></i> Laporan Pengaduan
            </h4>
            {{-- Tombol Export diperhalus --}}
            <a href="{{ route('admin.laporan.exportPdf', request()->query()) }}"
            class="btn btn-light btn-sm rounded-pill px-4 py-2 fw-semibold shadow-sm export-btn">
                <i class="fas fa-file-pdf me-1 text-danger"></i> Export PDF
            </a>
        </div>

        <div class="card-body bg-white p-4">
            {{-- =================== FILTER & SEARCH CONTAINER =================== --}}
            <div class="p-4 bg-light rounded-3 mb-4 shadow-sm">

                {{-- Filter Section (Date & Status) --}}
                <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-sliders-h me-2"></i> Filter Data</h6>
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-primary">Status</label>
                        <select name="status" class="form-select shadow-sm">
                            <option value="">Semua</option>
                            <option value="Diajukan" {{ request('status') == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-primary">Dari Tanggal</label>
                        <input type="date" name="from" class="form-control shadow-sm" value="{{ request('from') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-primary">Sampai Tanggal</label>
                        <input type="date" name="to" class="form-control shadow-sm" value="{{ request('to') }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 shadow-sm rounded-pill py-2 apply-filter-btn">
                            <i class="fas fa-filter me-1"></i> Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            {{-- Search Bar (Client-Side Multi-Search) --}}
            {{-- Mengubah form GET menjadi div biasa agar tidak bentrok dengan filter utama --}}
            <div class="d-flex justify-content-end mb-4">
                <form method="GET" class="input-group search-group" style="max-width: 450px;">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="hidden" name="from" value="{{ request('from') }}">
                    <input type="hidden" name="to" value="{{ request('to') }}">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    {{-- ID: searchInput digunakan oleh JS untuk multi-search --}}
                   <input
                        type="text"
                        name="search"
                        id="searchInput"
                        class="form-control border-start-0 shadow-sm search-input"
                        placeholder="Cari Judul, Pelapor, atau Nama Item..."
                        value="{{ request('search') }}"
                    >
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    </form>
                </div>
            </div>

            {{-- =================== TABEL =================== --}}
            <div class="table-responsive">
                {{-- Menambahkan table-striped untuk visual yang lebih jelas --}}
                <table class="table table-hover align-middle mb-0 table-striped" id="laporanTable">
                    {{-- Menggunakan class custom untuk header yang elegan --}}
                    <thead class="table-custom-header">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Nama Pengaduan</th>
                            <th>Pelapor</th>
                            <th>Lokasi</th>
                            <th>Item</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tanggal Pengajuan</th>
                            <th class="text-center">Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $l)
                            <tr>
                                <td class="text-center fw-semibold text-muted">#{{ $l->id_pengaduan }}</td>
                                {{-- Penambahan fw-medium untuk Judul Pengaduan --}}
                                <td class="pengaduan fw-medium">{{ $l->nama_pengaduan }}</td>
                                <td class="pelapor">{{ $l->user->name ?? '-' }}</td>
                               <!-- ✅ Tambahkan bagian ini -->
                                <td class="lokasi">
                                    {{ $l->lokasi->nama_lokasi ?? '-' }}
                                </td>
                                <!-- ✅ Akhir tambahan -->
                                <td class="item">{{ $l->item->nama_item ?? '-' }}</td>
                                <td class="text-center">
                                    {{-- Status badge dengan warna yang lebih kontras --}}
                                    <span class="badge rounded-pill status-badge
                                        @if($l->status == 'Selesai') bg-success text-white
                                        @elseif($l->status == 'Ditolak') bg-danger text-white
                                        @elseif($l->status == 'Diproses') bg-warning text-dark
                                        @elseif($l->status == 'Disetujui') bg-info text-white
                                        @else bg-secondary text-white @endif">
                                        {{ ucfirst($l->status) }}
                                    </span>
                                </td>
                                <td class="text-center text-muted">{{ \Carbon\Carbon::parse($l->tgl_pengajuan)->format('d M Y') }}</td>
                                <td class="text-center text-muted">
                                    {{ $l->tgl_selesai ? \Carbon\Carbon::parse($l->tgl_selesai)->format('d M Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                                    <p class="mb-0 mt-2">Tidak ada data laporan yang ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- End Table --}}
        </div>
    </div>
</div>
@endsection

{{-- =================== STYLE =================== --}}
@push('styles')
<style>
/* Font dan Warna Dasar */
:root {
    --primary: #667eea; /* Indigo/Violet */
    --secondary: #764ba2;
}

body {
    background-color: #f8f9fa; /* Background halaman yang lebih cerah */
}

/* Transisi dan Animasi */
.fade-in { animation: fadeIn 0.5s ease-in; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Header Table Custom */
.table-custom-header {
    background-color: var(--primary); /* Menggunakan warna primary */
}
.table-custom-header th {
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--secondary); /* Garis bawah yang elegan */
}

/* Tabel Body */
.table-hover tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05); /* Soft highlight saat hover */
    transition: 0.2s ease;
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #fcfdff; /* Striping yang sangat tipis */
}

/* Badge Status (Diperjelas) */
.status-badge {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
    min-width: 90px; /* Lebar seragam untuk tampilan rapi */
    display: inline-block;
}

/* Input Search (Desain modern dan melengkung) */
.search-group .form-control {
    border-radius: 0 0.5rem 0.5rem 0;
}
.search-group .input-group-text {
    border-radius: 0.5rem 0 0 0.5rem;
    border-right: 0;
    background-color: #f8f9fa;
    border-color: #ced4da;
}
.search-input:focus {
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25); /* Focus ring dari warna primary */
}

/* Empty State (Tampilan saat tidak ada data) */
.empty-state {
    padding: 3rem 1rem;
    text-align: center;
    color: #64748b;
    font-size: 1.1rem;
}

/* Buttons */
.export-btn {
    color: var(--primary);
}
.export-btn:hover {
    background-color: #f1f2f5;
}
</style>
@endpush

{{-- =================== SCRIPT (Multi-Search) =================== --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Client-Side Multi-Search Logic
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('#laporanTable tbody tr');

    // Kosongkan input search saat DOM dimuat agar tidak membingungkan dengan filter server-side
    if (searchInput) {
        searchInput.value = '';
    }

    // Listener untuk pencarian dinamis pada saat tombol keyboard dilepas (keyup)
    searchInput?.addEventListener('keyup', function() {
        const keyword = this.value.toLowerCase().trim();

        rows.forEach(row => {
            // Mengambil teks dari kolom-kolom yang sudah Anda tandai dengan kelas:
            const pengaduan = row.querySelector('.pengaduan')?.textContent.toLowerCase() || ''; // Nama Pengaduan
            const pelapor = row.querySelector('.pelapor')?.textContent.toLowerCase() || '';     // Nama Pelapor
            const item = row.querySelector('.item')?.textContent.toLowerCase() || '';           // Nama Item

            // Cek apakah keyword ada di kolom Pengaduan, Pelapor, ATAU Item
            const matches =
                pengaduan.includes(keyword) ||
                pelapor.includes(keyword) ||
                item.includes(keyword);

            // Tampilkan atau sembunyikan baris
            row.style.display = matches ? '' : 'none';
        });
    });

    // 2. Row Fade-In Animation (Aesthetic)
    rows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.03}s`; // Animasi masuk yang lebih cepat
        row.classList.add('fade-in');
    });
});
</script>
@endpush
