@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-primary">
                <i class="fas fa-box me-2"></i> Daftar Sarpras
            </h4>
            <a href="{{ route('admin.items.create') }}" class="btn btn-sm btn-primary rounded-pill shadow-sm">
                <i class="fas fa-plus me-1"></i> Tambah Sarpras
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Nama Item</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td class="text-center fw-semibold text-muted">#{{ $item->id_item }}</td>
                                <td>{{ $item->nama_item }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.items.edit', $item->id_item) }}"
                                       class="btn btn-sm btn-outline-warning rounded-pill me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.items.destroy', $item->id_item) }}"
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                            onclick="return confirm('Yakin hapus item {{ $item->nama_item }}?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fas fa-exclamation-circle me-2"></i> Belum ada data item.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table thead th {
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .table-hover tbody tr:hover {
        background-color: #f9fbfd;
        transition: 0.2s;
    }
</style>
@endpush
@endsection
