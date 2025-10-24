@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Tambah Pengaduan</h2>
    <form action="{{ route('admin.pengaduan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Pengguna</label>
            <select name="id_user" class="form-control">
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Item</label>
            <select name="id_item" class="form-control">
                @foreach($items as $i)
                    <option value="{{ $i->id_item }}">{{ $i->nama_item }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="diajukan">Diajukan</option>
                <option value="diproses">Diproses</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
