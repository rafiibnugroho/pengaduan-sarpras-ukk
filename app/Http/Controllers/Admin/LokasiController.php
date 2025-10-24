<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Models\Item;

class LokasiController extends Controller
{
    public function index()
{
    $lokasi = \App\Models\Lokasi::with('items')->get();
    return view('admin.lokasi.index', compact('lokasi'));
}

    public function create()
    {
        return view('admin.lokasi.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_lokasi' => 'required|string|max:255|unique:lokasi,nama_lokasi',
    ]);

    \App\Models\Lokasi::create($validated);

    return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi baru berhasil ditambahkan.');
}

    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $items = Item::all();
        return view('admin.lokasi.edit', compact('lokasi', 'items'));
    }

     // Simpan barang-barang yang dipilih ke lokasi
    public function update(Request $request, $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        // Validasi: pastikan ada minimal 1 item dipilih
        $validated = $request->validate([
            'items' => 'array',
            'items.*' => 'exists:items,id_item',
        ]);

        // Simpan relasi ke tabel pivot
        $lokasi->items()->sync($request->items ?? []);

        return redirect()->route('admin.lokasi.index')
            ->with('success', 'Barang di lokasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Lokasi::destroy($id);
        return redirect()->route('admin.lokasi.index')->with('success','Lokasi berhasil dihapus');
    }
}
