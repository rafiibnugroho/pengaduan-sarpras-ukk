@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Tambah Lokasi Baru</h3>
    <form action="{{ route('admin.lokasi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
            <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
