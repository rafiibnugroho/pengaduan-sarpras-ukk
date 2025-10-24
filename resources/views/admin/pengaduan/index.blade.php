@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-3">
        <div class="card-body">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Daftar Pengaduan</h2>
                <a href="{{ route('admin.pengaduan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Pengaduan
                </a>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Pengguna</th>
                            <th>Lokasi</th>
                            <th>Item</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Bukti Foto</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduan as $p)
                            <tr>
                                <td>{{ $p->id_pengaduan }}</td>
                                <td>{{ $p->user->name ?? '-' }}</td>
                                 <!-- ✅ Kolom Lokasi -->
                                <td>
                                    @if($p->lokasi)
                                        {{ $p->lokasi->nama_lokasi ?? '-' }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $p->item->nama_item ?? '-' }}</td>
                                <td>{{ $p->deskripsi }}</td>
                                <td>
                                    <span class="badge
                                        @if($p->status == 'pending') bg-warning
                                        @elseif($p->status == 'selesai') bg-success
                                        @else bg-secondary @endif">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($p->foto)
                                        <img src="{{ asset('storage/'.$p->foto) }}"
                                             alt="Bukti Foto" width="100" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.pengaduan.edit',$p->id_pengaduan) }}"
                                           class="btn btn-sm btn-warning">
                                           <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.pengaduan.destroy',$p->id_pengaduan) }}"
                                              method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button onclick="return confirm('Hapus data?')"
                                                    class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada pengaduan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
