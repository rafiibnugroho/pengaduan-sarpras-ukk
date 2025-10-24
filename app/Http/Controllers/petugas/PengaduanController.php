<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::with(['user','item'])->get(); // tambahin ini

        $recentReports = Pengaduan::with(['user','item'])
            ->latest()
            ->take(5)
            ->get();


        // beberapa statistik singkat (opsional, dipakai di dashboard)
        $total = Pengaduan::count();
        $open  = Pengaduan::where('status', '!=', 'Selesai')->count();
        $done  = Pengaduan::where('status', 'Selesai')->count();

        return view('petugas.pengaduan.index', compact('pengaduan','recentReports','total','open','done'));
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with(['user','item'])->findOrFail($id);
        return view('petugas.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diajukan,Disetujui,Ditolak,Diproses,Selesai'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = $request->status;

        if ($request->status == 'Selesai') {
            $pengaduan->tgl_selesai = now();
        }

        $pengaduan->save();

        return redirect()->route('petugas.pengaduan.index')
                        ->with('success','Status berhasil diperbarui');
    }
}
