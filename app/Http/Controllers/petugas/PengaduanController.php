<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        // Mengambil semua pengaduan dengan status Diterima, Diproses, atau Selesai
        $pengaduan = Pengaduan::with(['user','item'])
            ->whereIn('status', ['Diterima', 'Diproses', 'Selesai']) // Query lebih efisien
            ->get();

        // Menghitung statistik dari koleksi
        $openReports = $pengaduan->filter(function ($report) {
            return $report->status !== 'Selesai';
        });
        $doneReports = $pengaduan->filter(function ($report) {
            return $report->status === 'Selesai';
        });

        $recentReports = $pengaduan->sortByDesc('created_at')->take(5);
        $total = $pengaduan->count();
        $open  = $openReports->count();
        $done  = $doneReports->count();

        return view('petugas.pengaduan.index', compact('pengaduan', 'recentReports', 'total', 'open', 'done'));
    }

    public function show($id)
    {
        // PENTING: Memuat relasi 'petugas' agar nama petugas bisa ditampilkan
        $pengaduan = Pengaduan::with(['user','item', 'petugas'])->findOrFail($id);
        return view('petugas.pengaduan.show', compact('pengaduan'));
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Jika ada foto selesai, hapus
        if ($pengaduan->bukti_selesai && Storage::disk('public')->exists($pengaduan->bukti_selesai)) {
            Storage::disk('public')->delete($pengaduan->bukti_selesai);
        }

        // Jika ada foto aduan, hapus
        if ($pengaduan->foto && Storage::disk('public')->exists($pengaduan->foto)) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->route('petugas.pengaduan.index')
        ->with('success', 'Pengaduan berhasil dihapus!');
    }

    public function updateStatus(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // 1. Definisikan aturan validasi dasar
        $rules = [
            'status' => 'required|in:Diproses,Selesai,Ditolak',
            'saran_petugas' => 'nullable|string|max:500',
        ];

        // 2. Tambahkan aturan khusus untuk bukti_selesai (Wajib jika status Selesai dan bukti lama kosong)
        if ($request->status === 'Selesai' && !$pengaduan->bukti_selesai) {
            $rules['bukti_selesai'] = 'required|image|mimes:jpg,png,jpeg|max:5120';
        } else {
            $rules['bukti_selesai'] = 'nullable|image|mimes:jpg,png,jpeg|max:5120';
        }

        $request->validate($rules);

        $pengaduan->status = $request->status;
        $pengaduan->id_petugas = auth()->id(); // Mengisi ID petugas yang sedang login

        // 🆕 CLOSED-LOOP: Update timestamp berdasarkan status
        $timestampUpdates = [];
        if ($request->status === 'Diproses' && !$pengaduan->diproses_at) {
            $timestampUpdates['diproses_at'] = now();
        } elseif ($request->status === 'Selesai' && !$pengaduan->selesai_at) {
            $timestampUpdates['selesai_at'] = now();
        }

        // LOGIKA 'Selesai'
        if ($request->status === 'Selesai') {
            // Upload bukti HANYA jika ada file baru di-upload.
            if ($request->hasFile('bukti_selesai')) {
                // Hapus bukti lama (jika ada)
                if ($pengaduan->bukti_selesai && Storage::disk('public')->exists($pengaduan->bukti_selesai)) {
                    Storage::disk('public')->delete($pengaduan->bukti_selesai);
                }

                // Proses upload bukti baru
                $file = $request->file('bukti_selesai');
                $filename = time().'_'.$file->getClientOriginalName();
                $path = 'bukti_selesai/'.$filename;

                $image = \Intervention\Image\Facades\Image::make($file)
                    ->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->encode('jpg', 80);

                Storage::disk('public')->put($path, (string) $image);
                $pengaduan->bukti_selesai = $path;
            }

            // Simpan tanggal & saran petugas
            $pengaduan->tgl_selesai = now();
            $pengaduan->saran_petugas = $request->saran_petugas;

        // LOGIKA 'Diproses' atau 'Ditolak'
        } else {
            // Kosongkan tanggal selesai, bukti, dan saran jika status diubah
            $pengaduan->tgl_selesai = null;
            $pengaduan->bukti_selesai = null;
            $pengaduan->saran_petugas = $request->saran_petugas;
        }

        // 🆕 CLOSED-LOOP: Gabungkan semua update
        $updateData = array_merge([
            'status' => $request->status,
            'id_petugas' => auth()->id(),
            'saran_petugas' => $request->saran_petugas
        ], $timestampUpdates);

        $pengaduan->update($updateData);

        return redirect()->route('petugas.pengaduan.index')
            ->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    // 🆕 CLOSED-LOOP: Update progress dengan timestamp
    public function updateProgress(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Diproses,Selesai',
            'saran_petugas' => 'nullable|string|max:500'
        ]);

        $updateData = [
            'status' => $request->status,
            'id_petugas' => auth()->id(),
            'saran_petugas' => $request->saran_petugas
        ];

        // Update timestamp berdasarkan status
        if ($request->status === 'Diproses' && !$pengaduan->diproses_at) {
            $updateData['diproses_at'] = now();
        } elseif ($request->status === 'Selesai' && !$pengaduan->selesai_at) {
            $updateData['selesai_at'] = now();
            $updateData['tgl_selesai'] = now()->toDateString();
        }

        $pengaduan->update($updateData);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Progress pengaduan berhasil diperbarui',
                'data' => $pengaduan
            ]);
        }

        return redirect()->route('petugas.pengaduan.show', $pengaduan->id_pengaduan)
            ->with('success', 'Progress pengaduan berhasil diperbarui.');
    }

    // 🆕 CLOSED-LOOP: Upload bukti perbaikan
    public function uploadBukti(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $request->validate([
            'bukti_selesai' => 'required|image|mimes:jpg,png,jpeg|max:5120'
        ]);

        // Hapus bukti lama (jika ada)
        if ($pengaduan->bukti_selesai && Storage::disk('public')->exists($pengaduan->bukti_selesai)) {
            Storage::disk('public')->delete($pengaduan->bukti_selesai);
        }

        // Proses upload bukti baru
        $file = $request->file('bukti_selesai');
        $filename = time().'_'.$file->getClientOriginalName();
        $path = 'bukti_selesai/'.$filename;

        $image = Image::make($file)
            ->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->encode('jpg', 80);

        Storage::disk('public')->put($path, (string) $image);

        $pengaduan->update([
            'bukti_selesai' => $path
        ]);

        return redirect()->route('petugas.pengaduan.show', $pengaduan->id_pengaduan)
            ->with('success', 'Bukti perbaikan berhasil diupload.');
    }
}
