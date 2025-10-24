@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Tambah Item</h2>
    <form action="{{ route('admin.items.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Item</label>
            <input type="text" name="nama_item" class="form-control" required>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
