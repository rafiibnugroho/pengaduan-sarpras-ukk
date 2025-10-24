@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Daftar Lokasi</h5>
            <a href="{{ route('admin.lokasi.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Lokasi
            </a>
        </div>

        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Nama Lokasi</th>
                        <th>Barang yang Tersedia</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lokasi as $l)
                        <tr>
                            <td>#{{ $l->id_lokasi }}</td>
                            <td class="fw-semibold">{{ ucfirst($l->nama_lokasi) }}</td>
                            <td>
                                @if($l->items->count() > 0)
                                    <ul class="mb-0">
                                        @foreach($l->items as $item)
                                            <li>{{ $item->nama_item }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted fst-italic">Belum ada barang</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.lokasi.edit', $l->id_lokasi) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.lokasi.destroy', $l->id_lokasi) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus lokasi ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data lokasi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
