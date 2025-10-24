@extends('layouts.petugas')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4 animate-fadeIn">
        <div class="card-header bg-gradient bg-primary text-white border-0 rounded-top-4 p-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-list-alt me-2"></i> Daftar Pengaduan
                </h4>
                <small class="text-white-50">Kelola semua laporan pengguna dengan mudah</small>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table align-middle modern-table">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Pengguna</th>
                            <th>Item</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Bukti Foto</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengaduan as $p)
                        <tr>
                            <td class="text-center fw-semibold text-muted">#{{ $p->id_pengaduan }}</td>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td>{{ $p->item->nama_item ?? '-' }}</td>
                            <td style="max-width: 250px;">
                                <span class="d-inline-block text-truncate text-secondary" style="max-width: 230px;">
                                    {{ $p->deskripsi }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 py-2
                                    @if($p->status == 'Selesai') bg-success
                                    @elseif($p->status == 'Diproses') bg-info text-dark
                                    @elseif($p->status == 'Ditolak') bg-danger
                                    @elseif($p->status == 'Disetujui') bg-primary
                                    @else bg-warning text-dark @endif">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($p->foto)
                                    <a href="{{ asset('storage/'.$p->foto) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$p->foto) }}" width="70" class="img-thumbnail rounded shadow-sm hover-zoom">
                                    </a>
                                @else
                                    <span class="text-muted fst-italic">Tidak ada foto</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('petugas.pengaduan.show', $p->id_pengaduan) }}"
                                   class="btn btn-sm btn-light shadow-sm rounded-pill px-3 hover-scale">
                                    <i class="fas fa-eye text-primary me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .modern-table thead {
        background: #f8f9fa;
    }
    .modern-table thead th {
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }
    .modern-table tbody td {
        vertical-align: middle;
        font-size: 0.92rem;
    }
    .modern-table tbody tr {
        transition: all 0.2s ease;
    }
    .modern-table tbody tr:hover {
        background: #f9fbfd;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-zoom:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }
    .hover-scale {
        transition: all 0.2s ease;
    }
    .hover-scale:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
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
