<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PengaduanApiController extends Controller
{
    // 🔹 GET /api/pengaduan
    public function index(Request $request)
    {
        $pengaduan = Pengaduan::where('id_user', $request->user()->id)
            ->with('item')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $pengaduan
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

    // 🔹 POST /api/pengaduan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'lokasi'         => 'nullable|string|max:255',
            'id_item'        => 'required|exists:items,id_item',
            'foto'           => 'nullable|image|mimes:jpg,png|max:5120',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
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

        $validated['id_user']       = $request->user()->id;
        $validated['status']        = 'Diajukan';
        $validated['tgl_pengajuan'] = now()->toDateString();

        $pengaduan = Pengaduan::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Pengaduan berhasil diajukan',
            'data'    => $pengaduan
        ], 201);
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
}
