<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Jika ingin petugas lihat semua laporan:
        // Hapus bagian where('id_petugas', ...) di bawah

        $userId = Auth::id();

        $stats = [
            'diajukan'  => Pengaduan::where('status', 'Diajukan')
                                    ->where(function($q) use ($userId) {
                                        $q->whereNull('id_petugas')
                                          ->orWhere('id_petugas', $userId);
                                    })->count(),
            'disetujui' => Pengaduan::where('status', 'Disetujui')
                                    ->where(function($q) use ($userId) {
                                        $q->whereNull('id_petugas')
                                          ->orWhere('id_petugas', $userId);
                                    })->count(),
            'ditolak'   => Pengaduan::where('status', 'Ditolak')
                                    ->where(function($q) use ($userId) {
                                        $q->whereNull('id_petugas')
                                          ->orWhere('id_petugas', $userId);
                                    })->count(),
            'proses'    => Pengaduan::where('status', 'Diproses')
                                    ->where(function($q) use ($userId) {
                                        $q->whereNull('id_petugas')
                                          ->orWhere('id_petugas', $userId);
                                    })->count(),
            'selesai'   => Pengaduan::where('status', 'Selesai')
                                    ->where(function($q) use ($userId) {
                                        $q->whereNull('id_petugas')
                                          ->orWhere('id_petugas', $userId);
                                    })->count(),
            'total'     => Pengaduan::where(function($q) use ($userId) {
                                        $q->whereNull('id_petugas')
                                          ->orWhere('id_petugas', $userId);
                                    })->count(),
        ];

        $recentActivities = Pengaduan::where(function($q) use ($userId) {
                $q->whereNull('id_petugas')
                  ->orWhere('id_petugas', $userId);
            })
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('petugas.dashboard', compact('stats', 'recentActivities'));
    }
}
