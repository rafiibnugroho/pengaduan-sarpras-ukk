<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TemporaryItem;
use App\Models\Item;
use App\Models\Lokasi;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TemporaryItemController extends Controller
{
    /**
     * Display a listing of the resource - SAMA PERSIS DENGAN ADMIN
     */
    public function index(Request $request)
    {
        try {
            // 🔥 SAMA DENGAN ADMIN: Ambil semua data tanpa filter
            $requests = TemporaryItem::with(['user','pengaduan','item'])
                ->orderBy('created_at','desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $requests,
                'message' => 'Data temporary items berhasil diambil'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource - SAMA DENGAN ADMIN + AUTO-GENERATE ID
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id',
            'id_pengaduan' => 'nullable|exists:pengaduan,id_pengaduan',
            'id_item' => 'nullable|exists:items,id_item',
            'nama_barang_baru' => 'nullable|string|max:255',
            'lokasi_baru' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = $validator->validated();

            // 🔥 TAMBAHAN: AUTO-GENERATE ID_PENGADUAN UNTUK REQUEST BARU DARI FLUTTER
            if (empty($data['id_pengaduan']) && (empty($data['id_item']) || !empty($data['nama_barang_baru']))) {
                $pengaduanBaru = Pengaduan::create([
                    'nama_pengaduan' => !empty($data['nama_barang_baru'])
                        ? 'Permintaan Item Baru: ' . $data['nama_barang_baru']
                        : 'Permintaan Update Item/Lokasi',
                    'deskripsi' => 'Permintaan melalui mobile app',
                    'id_user' => $data['id_user'],
                    'status' => 'Diajukan',
                    'tgl_pengajuan' => now(),
                    'id_item' => $data['id_item'] ?? null,
                ]);

                $data['id_pengaduan'] = $pengaduanBaru->id_pengaduan;
            }

            // 🔥 SAMA DENGAN ADMIN: Create data
            $temporaryItem = TemporaryItem::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $temporaryItem->load(['user', 'pengaduan', 'item']),
                'message' => 'Permintaan berhasil disimpan'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource - SAMA DENGAN ADMIN
     */
    public function show($id)
    {
        try {
            $request = TemporaryItem::with(['user','pengaduan','item'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $request,
                'message' => 'Data temporary item berhasil diambil'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Approve request - SAMA DENGAN ADMIN
     */
    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $tempItem = TemporaryItem::findOrFail($id);

            // 🔥 SAMA PERSIS DENGAN LOGIC ADMIN
            if ($tempItem->nama_barang_baru) {
                $item = Item::create([
                    'nama_item' => $tempItem->nama_barang_baru,
                    'deskripsi' => null,
                ]);
                $tempItem->id_item = $item->id_item;
            }

            if ($tempItem->lokasi_baru) {
                $lokasi = Lokasi::create([
                    'nama_lokasi' => $tempItem->lokasi_baru
                ]);

                if ($tempItem->pengaduan) {
                    $pengaduan = Pengaduan::find($tempItem->id_pengaduan);
                    if ($pengaduan) {
                        $pengaduan->id_lokasi = $lokasi->id_lokasi;
                        $pengaduan->save();
                    }
                }
            }

            if ($tempItem->id_pengaduan && $tempItem->id_item) {
                $pengaduan = Pengaduan::find($tempItem->id_pengaduan);
                if ($pengaduan) {
                    $pengaduan->id_item = $tempItem->id_item;
                    $pengaduan->save();
                }
            }

            $tempItem->status = 'approved';
            $tempItem->note_admin = $request->note_admin ?? null;
            $tempItem->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $tempItem->load(['user', 'pengaduan', 'item']),
                'message' => 'Request berhasil disetujui'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui request: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject request - SAMA DENGAN ADMIN
     */
    public function reject(Request $request, $id)
    {
        try {
            $tempItem = TemporaryItem::findOrFail($id);

            // 🔥 SAMA DENGAN ADMIN
            $tempItem->status = 'rejected';
            $tempItem->note_admin = $request->note_admin ?? null;
            $tempItem->save();

            return response()->json([
                'success' => true,
                'data' => $tempItem->load(['user', 'pengaduan', 'item']),
                'message' => 'Request berhasil ditolak'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak request: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's temporary items - UNTUK FLUTTER
     */
    public function userItems(Request $request)
    {
        try {
            $temporaryItems = TemporaryItem::with(['user', 'pengaduan', 'item'])
                ->where('id_user', $request->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $temporaryItems,
                'message' => 'Data temporary items user berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }
}
