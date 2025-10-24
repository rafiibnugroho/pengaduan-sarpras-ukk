<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        // Ambil 5 aktivitas terbaru
        $pengaduan = Pengaduan::with(['user','item'])
                        ->orderBy('created_at','desc')
                        ->take(5)
                        ->get();

        // Hitung statistik
        $stats = [
            'diajukan'   => Pengaduan::where('status', 'Diajukan')->count(),
            'disetujui'  => Pengaduan::where('status', 'Disetujui')->count(),
            'ditolak'    => Pengaduan::where('status', 'Ditolak')->count(),
            'proses'     => Pengaduan::where('status', 'Diproses')->count(),
            'selesai'    => Pengaduan::where('status', 'Selesai')->count(),
            'total'      => Pengaduan::count(),
        ];

        return view('admin.dashboard', compact('pengaduan','stats'));
    }
}
