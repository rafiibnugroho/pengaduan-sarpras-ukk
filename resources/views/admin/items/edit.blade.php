@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-3">
        <div class="card-body">
            <h2 class="mb-4">Edit Sarpras</h2>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.items.update', $item->id_item) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label for="nama_item" class="form-label">Nama Sarpras</label>
                    <input type="text" name="nama_item" id="nama_item"
                           value="{{ old('nama_item', $item->nama_item) }}"
                           class="form-control @error('nama_item') is-invalid @enderror" required>
                    @error('nama_item')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    {{--  Keterangan 
                    <textarea name="keterangan" id="keterangan"
                    class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $item->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                --}}
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.items.index') }}" class="btn btn-secondary ms-2">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
