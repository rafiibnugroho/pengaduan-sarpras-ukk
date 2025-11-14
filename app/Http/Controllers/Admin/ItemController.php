<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_item' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Item::create($validated);
        return redirect()->route('admin.items.index')->with('success','Item berhasil ditambahkan');
    }

    public function edit($id)
    {

        $item = Item::findOrFail($id);

        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_item' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $item = Item::findOrFail($id);
        $item->update($validated);

        return redirect()->route('admin.items.index')->with('success','Item berhasil diperbarui');
    }

    public function destroy($id)
    {
        Item::destroy($id);
        return redirect()->route('admin.items.index')->with('success','Item berhasil dihapus');
    }
}
