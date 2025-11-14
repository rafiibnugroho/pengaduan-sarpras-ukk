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
    $request->validate([
        'nama_lokasi' => 'required|string|max:100'
    ]);

    Lokasi::create([
        'nama_lokasi' => $request->nama_lokasi
    ]);

    return redirect()->route('admin.lokasi.index')
                     ->with('success', 'Lokasi berhasil ditambahkan ✅');
}


    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $items = Item::all();
        return view('admin.lokasi.edit', compact('lokasi', 'items'));
    }

     // Simpan barang-barang yang dipilih ke lokasi
public function update(Request $request, Lokasi $lokasi)
{
    $request->validate([
        'nama_lokasi' => 'required|string|max:100',
        'items' => 'nullable|array',
        'items.*' => 'exists:items,id_item',
    ]);

    // Update nama lokasi
    $lokasi->update([
        'nama_lokasi' => $request->nama_lokasi
    ]);

    // Update many-to-many pivot
    $lokasi->items()->sync($request->items ?? []);

    return redirect()->route('admin.lokasi.index')
        ->with('success', 'Lokasi berhasil diperbarui!');
}



    public function destroy($id)
    {
        Lokasi::destroy($id);
        return redirect()->route('admin.lokasi.index')->with('success','Lokasi berhasil dihapus');
    }
}
