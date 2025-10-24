@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Atur Barang di Lokasi: <strong>{{ $lokasi->nama_lokasi }}</strong></h3>
    <form method="POST" action="{{ route('admin.lokasi.update', $lokasi->id_lokasi) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="items" class="form-label">Pilih Barang di Lokasi Ini</label>
            <div class="form-check">
                @foreach($items as $item)
                    <div>
                        <input class="form-check-input"
                               type="checkbox"
                               name="items[]"
                               value="{{ $item->id_item }}"
                               id="item{{ $item->id_item }}"
                               {{ $lokasi->items->contains($item->id_item) ? 'checked' : '' }}>
                        <label class="form-check-label" for="item{{ $item->id_item }}">
                            {{ $item->nama_item }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
