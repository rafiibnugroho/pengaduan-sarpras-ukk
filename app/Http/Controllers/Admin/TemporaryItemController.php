<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemporaryItem;
use App\Models\Item;
use App\Models\Lokasi;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TemporaryItemController extends Controller
{
    public function index()
    {
        $requests = TemporaryItem::with(['user','pengaduan','item'])->orderBy('created_at','desc')->get();
        return view('admin.temporary.index', compact('requests'));
    }

    public function show($id)
    {
        $req = TemporaryItem::with(['user','pengaduan','item'])->findOrFail($id);
        return view('admin.temporary.show', compact('req'));
    }
/**
 * Approve temporary item - untuk AJAX request
 */
public function approveAjax(Request $request, $id)
{
    try {
        Log::info('Approve AJAX called for temporary item:', ['id' => $id]);

        $req = TemporaryItem::findOrFail($id);
        Log::info('Found temporary item:', ['item' => $req]);

        DB::transaction(function() use ($req, $request) {
            Log::info('Starting transaction for approve');

            // Jika ada nama_barang_baru -> buat item baru
            if (!empty($req->nama_barang_baru)) {
                Log::info('Creating new item:', ['nama_item' => $req->nama_barang_baru]);

                $item = Item::create([
                    'nama_item' => $req->nama_barang_baru,
                    'deskripsi' => 'Barang baru dari permintaan pengaduan #' . $req->id_pengaduan,
                    'jumlah' => $req->jumlah ?? 1,
                ]);
                $req->id_item = $item->id_item;
                Log::info('New item created:', ['item_id' => $item->id_item]);
            }

            // Jika ada lokasi_baru -> buat lokasi baru
            if (!empty($req->lokasi_baru)) {
                Log::info('Creating new location:', ['lokasi' => $req->lokasi_baru]);

                $lokasi = Lokasi::create([
                    'nama_lokasi' => $req->lokasi_baru,
                    'deskripsi' => 'Lokasi baru dari permintaan pengaduan #' . $req->id_pengaduan,
                ]);

                // update pengaduan id_lokasi jika perlu
                if ($req->id_pengaduan) {
                    $pengaduan = Pengaduan::find($req->id_pengaduan);
                    if ($pengaduan) {
                        $pengaduan->id_lokasi = $lokasi->id_lokasi;
                        $pengaduan->save();
                        Log::info('Updated pengaduan location:', ['pengaduan_id' => $pengaduan->id_pengaduan]);
                    }
                }
            }

            // Update pengaduan agar pakai id_item baru jika ada
            if ($req->id_pengaduan && $req->id_item) {
                $pengaduan = Pengaduan::find($req->id_pengaduan);
                if ($pengaduan) {
                    $pengaduan->id_item = $req->id_item;
                    $pengaduan->save();
                    Log::info('Updated pengaduan item:', ['pengaduan_id' => $pengaduan->id_pengaduan]);
                }
            }

            $req->status = 'approved';
            $req->note_admin = $request->note_admin ?? 'Disetujui via sistem';
            $req->save();

            Log::info('Temporary item approved successfully');
        });

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil disetujui dan data baru telah dibuat.'
        ]);

    } catch (\Exception $e) {
        Log::error('Error in approveAjax:', [
            'id' => $id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Reject temporary item - untuk AJAX request
 */
public function rejectAjax(Request $request, $id)
{
    try {
        Log::info('Reject AJAX called for temporary item:', ['id' => $id]);

        $req = TemporaryItem::findOrFail($id);

        $req->status = 'rejected';
        $req->note_admin = $request->note_admin ?? 'Ditolak via sistem';
        $req->save();

        Log::info('Temporary item rejected successfully');

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil ditolak.'
        ]);

    } catch (\Exception $e) {
        Log::error('Error in rejectAjax:', [
            'id' => $id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }

}

}
