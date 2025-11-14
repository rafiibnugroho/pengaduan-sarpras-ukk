<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;


use App\Models\Item;

use Illuminate\Http\Request;

use App\Models\TemporaryItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PengaduanApiController extends Controller
{
    // 🔹 GET /api/pengaduan
   public function index(Request $request)
{
    $pengaduan = Pengaduan::where('id_user', $request->user()->id)
        ->with(['item', 'lokasi'])
        ->latest()
        ->get()
        ->map(function ($p) {
            return [
                'id_pengaduan'   => $p->id_pengaduan,
                'nama_pengaduan' => $p->nama_pengaduan,
                'deskripsi'      => $p->deskripsi,
                'lokasi'         => $p->lokasi->nama_lokasi ?? '-', // ✅ ambil nama lokasi langsung
                'status'         => $p->status,
                'tgl_pengajuan'  => $p->tgl_pengajuan,
                'item'           => $p->item->nama_item ?? '-',
                'foto'           => $p->foto ? url('storage/' . $p->foto) : null, // ✅ URL lengkap
            ];
        });

    return response()->json([
        'status' => true,
        'data'   => $pengaduan,
    ]);
}



    // 🔹 GET /api/pengaduan/{id}
    public function show(Request $request, $id)
    {
        $pengaduan = Pengaduan::where('id_user', $request->user()->id)
            ->with('item','user')
            ->findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => $pengaduan
        ]);
    }

public function requestBaru(Request $request)
{
    $validated = $request->validate([
        'nama_item' => 'required|string|max:255',
        'nama_lokasi' => 'required|string|max:255',
    ]);

    // Simpan ke tabel temporary_item
    TemporaryItem::create([
        'nama_item' => $validated['nama_item'],
        'nama_lokasi' => $validated['nama_lokasi'],
        'status' => 'pending', // Default status
    ]);

    return response()->json(['message' => 'Request berhasil diajukan!'], 201);
}

  // 🔹 POST /api/pengaduan
public function store(Request $request)
{
    try {
        // ✅ VALIDASI - SESUAI DENGAN YANG DIKIRIM FLUTTER
        $validated = $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'id_lokasi' => 'nullable|integer',
            'id_item' => 'nullable|integer',
            'lokasi_baru' => 'nullable|string|max:255', // 🔥 PERBAIKI: 'nama_lokasi_baru' -> 'lokasi_baru'
            'nama_barang_baru' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // ✅ BUAT PENGADUAN DULU
        $pengaduan = Pengaduan::create([
            'nama_pengaduan' => $validated['nama_pengaduan'], // 🔥 PERBAIKI: $validated['nama'] -> $validated['nama_pengaduan']
            'deskripsi' => $validated['deskripsi'],
            'id_lokasi' => $validated['id_lokasi'] ?? null,
            'id_item' => $validated['id_item'] ?? null,
            'id_user' => $request->user()->id,
            'status' => 'Diajukan',
            'tgl_pengajuan' => now()->toDateString(),
            'foto' => $this->handleFotoUpload($request), // 🔥 PINDAH KE METHOD TERPISAH
        ]);

        // ✅ SIMPAN KE TEMPORARY_ITEM JIKA ADA LOKASI/BARANG BARU
        if ($request->filled('lokasi_baru') || $request->filled('nama_barang_baru')) {
            TemporaryItem::create([
                'id_user' => $request->user()->id,
                'id_pengaduan' => $pengaduan->id_pengaduan, // 🔥 ISI ID_PENGADUAN YANG BARU DIBUAT
                'id_item' => null,
                'nama_barang_baru' => $request->nama_barang_baru,
                'lokasi_baru' => $request->lokasi_baru,
                'jumlah' => null,
                'status' => 'pending',
                'note_admin' => null,
            ]);

            Log::info('Temporary Item Created:', [
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'id_user' => $request->user()->id,
                'nama_barang_baru' => $request->nama_barang_baru,
                'lokasi_baru' => $request->lokasi_baru
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Pengaduan berhasil diajukan',
            'data' => [
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'nama_pengaduan' => $pengaduan->nama_pengaduan,
                'deskripsi' => $pengaduan->deskripsi,
                'id_lokasi' => $pengaduan->id_lokasi,
                'id_item' => $pengaduan->id_item,
                'status' => $pengaduan->status,
                'tgl_pengajuan' => $pengaduan->tgl_pengajuan,
                'foto' => $pengaduan->foto ? asset('storage/' . $pengaduan->foto) : null,
            ],
        ], 201);

    } catch (\Exception $e) {
        Log::error('Error in store method:', [
            'error' => $e->getMessage(),
            'request_data' => $request->all()
        ]);

        return response()->json([
            'status' => false,
            'message' => 'Gagal mengajukan pengaduan: ' . $e->getMessage()
        ], 500);
    }
}

// 🔹 METHOD UNTUK HANDLE FOTO UPLOAD
private function handleFotoUpload(Request $request)
{
    if (!$request->hasFile('foto')) {
        return null;
    }

    try {
        $file = $request->file('foto');
        $image = Image::make($file)
            ->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 75);

        $path = 'pengaduan/' . time() . '-' . uniqid() . '.jpg';
        Storage::disk('public')->put($path, $image);

        return $path;

    } catch (\Exception $e) {
        Log::error('Foto upload error: ' . $e->getMessage());
        return null;
    }
}

    // 🔹 PUT /api/pengaduan/{id}
    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::where('id_user', $request->user()->id)->findOrFail($id);

        $validated = $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'lokasi'         => 'nullable|string|max:255',
            'id_item'        => 'required|exists:items,id_item',
            'foto'           => 'nullable|image|mimes:jpg,png|max:5120',
        ]);

        // Handle foto baru
        if ($request->hasFile('foto')) {
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

        return response()->json([
            'status'  => true,
            'message' => 'Pengaduan berhasil diperbarui',
            'data'    => $pengaduan
        ]);
    }

    // 🔹 DELETE /api/pengaduan/{id}
    public function destroy(Request $request, $id)
    {
        $pengaduan = Pengaduan::where('id_user', $request->user()->id)->findOrFail($id);

        if ($pengaduan->foto && Storage::disk('public')->exists($pengaduan->foto)) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Pengaduan berhasil dihapus'
        ]);
    }

    public function getLokasi() {
    return response()->json(['data' => \App\Models\Lokasi::all()]);
}

public function getItemsByLokasi($id) {
    return response()->json(\App\Models\Item::where('id_lokasi', $id)->get());
}

}
