<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Admin -> redirect
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $userId = auth()->id();

        // Ambil semua pengaduan user (bisa pake paginate jika banyak)
        $pengaduan = Pengaduan::where('id_user', $userId)
            ->with('item') // optional, jika ada relasi
            ->latest()
            ->get();

        // 5 laporan terbaru
        $recentReports = $pengaduan->take(5);

        // Hitung statistik (gunakan value sesuai ENUM di migration)
        $selesai  = Pengaduan::where('id_user', $userId)->where('status', 'Selesai')->count();
        $diproses = Pengaduan::where('id_user', $userId)->where('status', 'Diproses')->count();
        $diajukan = Pengaduan::where('id_user', $userId)->where('status', 'Diajukan')->count();
        $total    = Pengaduan::where('id_user', $userId)->count();

        $stats = [
            'selesai' => $selesai,
            'proses'  => $diproses,
            'diajukan'=> $diajukan,
            'total'   => $total,
        ];

        return view('home', compact('pengaduan', 'recentReports', 'stats'));
    }
}
