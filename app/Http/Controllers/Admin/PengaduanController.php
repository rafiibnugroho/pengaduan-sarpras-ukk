<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Item;
use App\Models\User;
use App\Models\Lokasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::with(['user','item'])->get();
        return view('admin.pengaduan.index', compact('pengaduan'));
    }

    public function create()
    {
        $items = Item::all();
        $users = User::all();
        return view('admin.pengaduan.create', compact('items','users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'id_lokasi'      => 'required|exists:lokasi,id_lokasi',
            'id_item'        => 'required|exists:items,id_item',
            'foto'           => 'nullable|image|mimes:jpg,png|max:5120',
        ]);

        $status = $request->status;

        if ($status === 'pending') $status = 0;
        elseif ($status === 'diproses') $status = 1;
        elseif ($status === 'selesai') $status = 2;

        $validated['status'] = $status;

        $validated['id_user']       = auth()->id();
        $validated['status']        = 'Diajukan';
        $validated['tgl_pengajuan'] = now()->toDateString();


        Pengaduan::create($validated);
        return redirect()->route('admin.pengaduan.index')->with('success','Pengaduan berhasil ditambahkan');
    }

    public function edit($id)
{
    // Ambil pengaduan beserta relasi
    $pengaduan = Pengaduan::with(['item','user'])->findOrFail($id);

    // Ambil data pendukung
    $users  = User::all();
    $items  = Item::all();
    $lokasi = Lokasi::all();

    // Tampilkan view edit
    return view('admin.pengaduan.edit', compact('pengaduan', 'users', 'items', 'lokasi'));
}

 public function update(Request $request, $id)
{
    $pengaduan = Pengaduan::findOrFail($id);

    $validated = $request->validate([
        'nama_pengaduan' => 'nullable|string|max:255',
        'deskripsi'      => 'nullable|string',
        'lokasi'         => 'nullable|string|max:255',
        'status'         => 'required|string',
        'id_user'        => 'required|exists:users,id',
        'id_item'        => 'required|exists:items,id_item',
        'foto'           => 'nullable|image|mimes:jpg,png|max:5120',
    ]);

    // handle foto
    if ($request->hasFile('foto')) {
        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }
        $path = $request->file('foto')->store('pengaduan', 'public');
        $validated['foto'] = $path;
    }

    $pengaduan->update($validated);

    return redirect()->route('admin.pengaduan.index')
                     ->with('success', 'Pengaduan berhasil diupdate.');
}



    public function destroy($id)
    {
        Pengaduan::destroy($id);
        return redirect()->route('admin.pengaduan.index')->with('success','Pengaduan berhasil dihapus');
    }

    // Laporan khusus admin
    public function laporan(Request $request)
{
    // Ambil query dasar
    $query = Pengaduan::with(['user', 'item', 'lokasi']);

    // Filter berdasarkan status
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan rentang tanggal
    if ($request->from && $request->to) {
        $query->whereBetween('tgl_pengajuan', [$request->from, $request->to]);
    }

    // ✅ Filter pencarian (nama pengaduan, pelapor, atau item)
    if ($request->search) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nama_pengaduan', 'like', "%{$search}%")
              ->orWhereHas('user', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('item', function ($q3) use ($search) {
                  $q3->where('nama_item', 'like', "%{$search}%");
              });
        });
    }

    // Ambil hasil
    $laporan = $query->orderBy('tgl_pengajuan', 'desc')->get();

    return view('admin.laporan.index', compact('laporan'));
}

public function exportPdf(Request $request)
{
    // Gunakan logika filter yang sama seperti di laporan()
    $query = Pengaduan::with(['user', 'item', 'lokasi']);

    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->from && $request->to) {
        $query->whereBetween('tgl_pengajuan', [$request->from, $request->to]);
    }

    if ($request->search) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nama_pengaduan', 'like', "%{$search}%")
              ->orWhereHas('user', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('item', function ($q3) use ($search) {
                  $q3->where('nama_item', 'like', "%{$search}%");
              });
        });
    }

    $laporan = $query->orderBy('tgl_pengajuan', 'desc')->get();

    // ✅ Load tampilan khusus untuk PDF
    $pdf = Pdf::loadView('admin.laporan.pdf', compact('laporan'))
        ->setPaper('a4', 'portrait');

    // Download PDF
    return $pdf->download('laporan_pengaduan.pdf');
}


}
