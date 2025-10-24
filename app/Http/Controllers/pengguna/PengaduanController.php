<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Item;
use App\Models\User;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PengaduanController extends Controller
{
 public function index()
{
    $userId = auth()->id();

    $pengaduan = Pengaduan::where('id_user', $userId)
        ->with('item')
        ->latest()
        ->get();

    $recentReports = $pengaduan->take(5);

    // ✅ pakai LOWER biar aman dari case-sensitive
    $selesai  = Pengaduan::where('id_user', $userId)
        ->whereRaw('LOWER(status) = "selesai"')
        ->count();

    $diproses = Pengaduan::where('id_user', $userId)
        ->whereRaw('LOWER(status) = "diproses"')
        ->count();

    $diajukan = Pengaduan::where('id_user', $userId)
        ->whereRaw('LOWER(status) = "diajukan"')
        ->count();

    $total    = Pengaduan::where('id_user', $userId)->count();

    $stats = [
        'selesai'  => $selesai,
        'proses'   => $diproses,
        'diajukan' => $diajukan,
        'total'    => $total,
    ];

    return view('pengguna.pengaduan.index', compact('pengaduan', 'recentReports', 'stats'));
}
    public function edit($id)
{
    $pengaduan = Pengaduan::where('id_user', auth()->id())->findOrFail($id);
    $items     = Item::all();

    return view('pengguna.pengaduan.edit', compact('pengaduan', 'items'));
}

public function update(Request $request, $id)
{
    $pengaduan = Pengaduan::where('id_user', auth()->id())->findOrFail($id);

    $validated = $request->validate([
        'nama_pengaduan' => 'required|string|max:255',
        'deskripsi'      => 'required|string',
        'lokasi'         => 'nullable|string|max:255',
        'id_item'        => 'required|exists:items,id_item',
        'foto'           => 'nullable|image|mimes:jpg,png|max:5120',
    ]);

    // ✅ handle foto baru kalau ada
    if ($request->hasFile('foto')) {
        // hapus foto lama kalau ada
        if ($pengaduan->foto && Storage::disk('public')->exists($pengaduan->foto)) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $file = $request->file('foto');
        $image = Image::make($file)
            ->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 75);

        $path = 'pengaduan/' . time() . '-' . $file->getClientOriginalName();
        Storage::disk('public')->put($path, $image);

        $validated['foto'] = $path;
    }

    $pengaduan->update($validated);

    return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
}

public function destroy($id)
{
    $pengaduan = Pengaduan::where('id_user', auth()->id())->findOrFail($id);

    // hapus foto kalau ada
    if ($pengaduan->foto && Storage::disk('public')->exists($pengaduan->foto)) {
        Storage::disk('public')->delete($pengaduan->foto);
    }

    $pengaduan->delete();

    return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
}


    public function show($id)
{
    $pengaduan = Pengaduan::with('item','user')->findOrFail($id);

    return view('pengguna.pengaduan.show', compact('pengaduan'));
}


    public function create()
    {
        $lokasi = Lokasi::all(); // Ambil semua lokasi
        return view('pengguna.pengaduan.create', compact('lokasi'));
    }

       public function getItemsByLokasi($id_lokasi)
{
    $items = \App\Models\Item::whereHas('lokasi', function ($q) use ($id_lokasi) {
        $q->where('lokasi.id_lokasi', $id_lokasi);
    })->get(['id_item', 'nama_item']);

    return response()->json($items);
}


  public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'nama_pengaduan' => 'required|string|max:255',
        'deskripsi'      => 'required|string',
        'id_lokasi'      => 'required|exists:lokasi,id_lokasi',
        'id_item'        => 'required|exists:items,id_item',
        'foto'           => 'nullable|image|mimes:jpg,png|max:5120',
    ]);

    // ✅ Validasi tambahan: pastikan item benar-benar milik lokasi tersebut
    $validRelasi = \App\Models\ListLokasi::where('id_lokasi', $request->id_lokasi)
        ->where('id_item', $request->id_item)
        ->exists();

    if (!$validRelasi) {
        return back()->withErrors(['id_item' => 'Barang tidak tersedia di lokasi yang dipilih.'])->withInput();
    }

    // ✅ Handle foto upload
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');

        $image = \Intervention\Image\Facades\Image::make($file)
            ->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 75);

        $path = 'pengaduan/' . time() . '-' . $file->getClientOriginalName();
        \Illuminate\Support\Facades\Storage::disk('public')->put($path, $image);

        $validated['foto'] = $path;
    }

    // ✅ Tambahan data otomatis
    $validated['id_user']       = auth()->id();
    $validated['status']        = 'Diajukan';
    $validated['tgl_pengajuan'] = now()->toDateString();

    // Simpan pengaduan
    \App\Models\Pengaduan::create($validated);

    return redirect()->route('pengaduan.index')
        ->with('success', 'Pengaduan berhasil diajukan.');
}


}
