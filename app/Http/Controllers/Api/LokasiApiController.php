<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LokasiApiController extends Controller
{
    // ✅ Ambil semua lokasi
    public function index()
    {
        $lokasi = Lokasi::select('id_lokasi', 'nama_lokasi')->get();

        return response()->json([
            'success' => true,
            'data' => $lokasi
        ]);
    }

    // ✅ Ambil semua barang berdasarkan lokasi (dari tabel lists)
    public function getItems($id_lokasi)
{
    try {
        // Ganti nama tabel jadi nama tabel yang benar
        $items = DB::table('list_lokasi')
            ->join('items', 'list_lokasi.id_item', '=', 'items.id_item')
            ->where('list_lokasi.id_lokasi', $id_lokasi)
            ->select('items.id_item', 'items.nama_item')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

}
