<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Item;
use App\Models\User;
use App\Models\Lokasi;
use Intervention\Image\Facades\Image;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    public function index()
    {
        // ambil data termasuk relasi yang perlu (user, item, lokasi)
        $pengaduan = Pengaduan::with(['user','item','lokasi'])
                ->orderBy('tgl_pengajuan','desc')
                ->get();

        return view('admin.pengaduan.index', compact('pengaduan'));
    }

    public function create()
    {
        $items = Item::all();
        $users = User::all();
        $lokasi = Lokasi::all();
        return view('admin.pengaduan.create', compact('items','users','lokasi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'id_lokasi'      => 'required|exists:lokasi,id_lokasi',
            'id_item'        => 'required|exists:items,id_item',
            'foto'           => 'nullable|image|mimes:jpg,png|max:5120',
            // 🆕 CLOSED-LOOP: Tambah priority
            'priority'       => 'required|in:low,medium,high,emergency',
        ]);

        $validated['id_user']       = auth()->id();
        $validated['status']        = 'Diajukan';
        $validated['tgl_pengajuan'] = now()->toDateString();

        Pengaduan::create($validated);
        return redirect()->route('admin.pengaduan.index')->with('success','Pengaduan berhasil ditambahkan');
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with(['user','item','lokasi'])
            ->findOrFail($id);

        // Debug data
        Log::info('Pengaduan Show Data:', [
            'id' => $pengaduan->id,
            'lokasi_baru' => $pengaduan->lokasi_baru,
            'nama_barang_baru' => $pengaduan->nama_barang_baru,
            'jumlah' => $pengaduan->jumlah
        ]);

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function edit($id)
    {
        $pengaduan = Pengaduan::with(['item','user','lokasi'])->findOrFail($id);
        $users  = User::all();
        $items  = Item::all();
        $lokasi = Lokasi::all();

        return view('admin.pengaduan.edit', compact('pengaduan', 'users', 'items', 'lokasi'));
    }

    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Jika hanya update status (dari tombol Diterima/Ditolak)
        if ($request->has('status') && $request->filled('status') && !$request->has('nama_pengaduan')) {
            $request->validate([
                'status' => 'required|in:Diterima,Ditolak,Selesai,Diajukan'
            ]);

            // 🆕 CLOSED-LOOP: Update timestamp berdasarkan status
            $updateData = ['status' => $request->status];

            if ($request->status === 'Diterima') {
                $updateData['disetujui_at'] = now();
            } elseif ($request->status === 'Selesai') {
                $updateData['selesai_at'] = now();
            }

            $pengaduan->update($updateData);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status pengaduan berhasil diperbarui',
                    'data' => $pengaduan
                ]);
            }

            return redirect()->route('admin.pengaduan.index')->with('success', 'Status pengaduan berhasil diperbarui.');
        }

        // Kode update yang lama untuk edit data lengkap
        $validated = $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'id_lokasi' => 'required|exists:lokasi,id_lokasi',
            'id_user' => 'required|exists:users,id',
            'id_item' => 'required|exists:items,id_item',
            'status' => 'required|in:Menunggu,Diterima,Ditolak,Diproses,Selesai',
            'saran_petugas' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 🆕 CLOSED-LOOP: Tambah priority
            'priority' => 'required|in:low,medium,high,emergency',
        ]);

        // Prepare data for update
        $updateData = [
            'nama_pengaduan' => $validated['nama_pengaduan'],
            'deskripsi' => $validated['deskripsi'],
            'id_lokasi' => $validated['id_lokasi'],
            'id_user' => $validated['id_user'],
            'id_item' => $validated['id_item'],
            'status' => $validated['status'],
            'saran_petugas' => $validated['saran_petugas'] ?? null,
            // 🆕 CLOSED-LOOP: Tambah priority
            'priority' => $validated['priority'],
        ];

        // 🆕 CLOSED-LOOP: Update timestamp berdasarkan status
        if ($validated['status'] === 'Diterima' && !$pengaduan->disetujui_at) {
            $updateData['disetujui_at'] = now();
        } elseif ($validated['status'] === 'Diproses' && !$pengaduan->diproses_at) {
            $updateData['diproses_at'] = now();
        } elseif ($validated['status'] === 'Selesai' && !$pengaduan->selesai_at) {
            $updateData['selesai_at'] = now();
        }

        // Handle file upload if new photo is provided
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($pengaduan->foto) {
                Storage::delete($pengaduan->foto);
            }

            // Store new photo
            $fotoPath = $request->file('foto')->store('pengaduan', 'public');
            $updateData['foto'] = $fotoPath;
        }

        // Update pengaduan
        $pengaduan->update($updateData);

        // Response based on request type
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengaduan berhasil diperbarui',
                'data' => $pengaduan
            ]);
        }

        // Redirect for normal form submission
        return redirect()
            ->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    // 🆕 CLOSED-LOOP: Update progress dengan timestamp
    public function updateProgress(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Diterima,Diproses,Selesai',
            'saran_petugas' => 'nullable|string|max:500'
        ]);

        $updateData = [
            'status' => $request->status,
            'saran_petugas' => $request->saran_petugas
        ];

        // Update timestamp berdasarkan status
        if ($request->status === 'Diterima' && !$pengaduan->disetujui_at) {
            $updateData['disetujui_at'] = now();
        } elseif ($request->status === 'Diproses' && !$pengaduan->diproses_at) {
            $updateData['diproses_at'] = now();
        } elseif ($request->status === 'Selesai' && !$pengaduan->selesai_at) {
            $updateData['selesai_at'] = now();
        }

        $pengaduan->update($updateData);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Progress pengaduan berhasil diperbarui',
                'data' => $pengaduan
            ]);
        }

        return redirect()->route('admin.pengaduan.show', $pengaduan->id_pengaduan)
            ->with('success', 'Progress pengaduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hapus foto jika ada
        if ($pengaduan->foto) {
            Storage::delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')->with('success','Pengaduan berhasil dihapus');
    }

    /**
     * Approve request for new location and item
     */
    public function approveRequest($id)
    {
        try {
            $pengaduan = Pengaduan::findOrFail($id);

            DB::beginTransaction();

            $changes = [];

            // Process new location request
            if (!empty($pengaduan->lokasi_baru)) {
                $lokasiBaru = Lokasi::create([
                    'nama_lokasi' => $pengaduan->lokasi_baru,
                    'deskripsi' => 'Lokasi baru dari pengaduan #' . $pengaduan->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $changes['id_lokasi'] = $lokasiBaru->id_lokasi;
                $changes['lokasi_baru'] = null;
            }

            // Process new item request
            if (!empty($pengaduan->nama_barang_baru)) {
                $itemBaru = Item::create([
                    'nama_item' => $pengaduan->nama_barang_baru,
                    'deskripsi' => 'Barang baru dari pengaduan #' . $pengaduan->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $changes['id_item'] = $itemBaru->id_item;
                $changes['nama_barang_baru'] = null;
            }

            // Update pengaduan dengan changes
            if (!empty($changes)) {
                $pengaduan->update($changes);
            }

            DB::commit();

            return redirect()->route('admin.pengaduan.show', $pengaduan->id)
                ->with('success', 'Permintaan barang/lokasi baru berhasil disetujui dan telah ditambahkan ke database');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error approving request: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyetujui permintaan: ' . $e->getMessage());
        }
    }

    // Laporan khusus admin
    public function laporan(Request $request)
    {
        // Ambil query dasar
        $query = Pengaduan::with(['user', 'item', 'lokasi']);

        // Filter berdasarkan status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->from && $request->to) {
            $query->whereBetween('tgl_pengajuan', [$request->from, $request->to]);
        }

        // ✅ Filter pencarian (nama pengaduan, pelapor, atau item)
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengaduan', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('item', function ($q3) use ($search) {
                      $q3->where('nama_item', 'like', "%{$search}%");
                  });
            });
        }

        // Ambil hasil
        $laporan = $query->orderBy('tgl_pengajuan', 'desc')->get();

        return view('admin.laporan.index', compact('laporan'));
    }

    public function exportPdf(Request $request)
    {
        // Gunakan logika filter yang sama seperti di laporan()
        $query = Pengaduan::with(['user', 'item', 'lokasi']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->from && $request->to) {
            $query->whereBetween('tgl_pengajuan', [$request->from, $request->to]);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengaduan', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('item', function ($q3) use ($search) {
                      $q3->where('nama_item', 'like', "%{$search}%");
                  });
            });
        }

        $laporan = $query->orderBy('tgl_pengajuan', 'desc')->get();

        // ✅ Load tampilan khusus untuk PDF
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('laporan'))
            ->setPaper('a4', 'portrait');

        // Download PDF
        return $pdf->download('laporan_pengaduan.pdf');
    }
}
