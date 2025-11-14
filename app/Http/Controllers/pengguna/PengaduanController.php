<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Item;
use App\Models\User;
use App\Models\Lokasi;
use App\Models\TemporaryItem;
use App\Models\ListLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PengaduanController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $pengaduan = Pengaduan::where('id_user', $userId)
            ->with('item')
            ->latest()
            ->get();

        $recentReports = $pengaduan->take(5);

        // Menghitung statistik berdasarkan status
        $selesai  = Pengaduan::where('id_user', $userId)->whereRaw('LOWER(status) = "selesai"')->count();
        $diproses = Pengaduan::where('id_user', $userId)->whereRaw('LOWER(status) = "diproses"')->count();
        $diajukan = Pengaduan::where('id_user', $userId)->whereRaw('LOWER(status) = "diajukan"')->count();
        $total    = Pengaduan::where('id_user', $userId)->count();

        $stats = [
            'selesai'  => $selesai,
            'proses'   => $diproses,
            'diajukan' => $diajukan,
            'total'    => $total,
        ];

        return view('pengguna.pengaduan.index', compact('pengaduan', 'recentReports', 'stats'));
    }

    public function edit($id)
    {
        $pengaduan = Pengaduan::where('id_user', auth()->id())->findOrFail($id);
        $lokasi = Lokasi::all();
        $items = Item::all();
        return view('pengguna.pengaduan.edit', compact('pengaduan', 'lokasi', 'items'));
    }

    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::where('id_user', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'lokasi'         => 'nullable|string|max:255',
            'id_item'        => 'required|exists:items,id_item',
            'foto'           => 'nullable|image|mimes:jpg,png|max:5120',
        ]);

        // Handle foto baru kalau ada
        if ($request->hasFile('foto')) {
            // hapus foto lama kalau ada
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

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::where('id_user', auth()->id())->findOrFail($id);

        // hapus foto kalau ada
        if ($pengaduan->foto && Storage::disk('public')->exists($pengaduan->foto)) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }

    public function show($id)
    {
        // PENTING: Eager load relasi 'petugas' untuk menampilkan detail penyelesaian
        $pengaduan = Pengaduan::with(['item','user', 'petugas'])->findOrFail($id);

        return view('pengguna.pengaduan.show', compact('pengaduan'));
    }

    // 🆕 CLOSED-LOOP: Public ticket status (bisa diakses tanpa login)
    public function showPublic($ticket_number)
    {
        $pengaduan = Pengaduan::with(['item','user', 'petugas'])
            ->where('ticket_number', $ticket_number)
            ->firstOrFail();

        return view('pengguna.pengaduan.public-status', compact('pengaduan'));
    }

    // 🆕 CLOSED-LOOP: Track ticket dengan UI khusus
    public function trackTicket($ticket_number)
    {
        $pengaduan = Pengaduan::with(['item','user', 'petugas'])
            ->where('ticket_number', $ticket_number)
            ->where('id_user', auth()->id())
            ->firstOrFail();

        return view('pengguna.pengaduan.track', compact('pengaduan'));
    }

    // 🆕 CLOSED-LOOP: Submit rating & feedback
    public function submitRating(Request $request, $id)
    {
        $pengaduan = Pengaduan::where('id_user', auth()->id())
            ->where('status', 'Selesai')
            ->findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000'
        ]);

        $pengaduan->update([
            'rating' => $request->rating,
            'feedback' => $request->feedback
        ]);

        return redirect()->route('pengaduan.show', $pengaduan->id_pengaduan)
            ->with('success', 'Terima kasih atas rating dan feedback Anda!');
    }

    // 🆕 CLOSED-LOOP: Submit feedback
    public function submitFeedback(Request $request, $id)
    {
        return $this->submitRating($request, $id);
    }

    public function create()
    {
        $lokasi = Lokasi::all(); // Ambil semua lokasi
        return view('pengguna.pengaduan.create', compact('lokasi'));
    }

    public function getItemsByLokasi($id_lokasi)
    {
        $items = \App\Models\Item::whereHas('lokasi', function ($q) use ($id_lokasi) {
            $q->where('lokasi.id_lokasi', $id_lokasi);
        })->get(['id_item', 'nama_item']);

        return response()->json($items);
    }

    public function store(Request $request)
    {
        // 1. VALIDASI INPUT BARU (gabungan dari kedua versi)
        $validated = $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            // id_lokasi & id_item: nullable agar bisa diisi oleh request baru (__new_lokasi__)
            'id_lokasi'      => 'nullable|exists:lokasi,id_lokasi',
            'id_item'        => 'nullable|exists:items,id_item',
            // 🆕 CLOSED-LOOP: Tambah priority


            // Kolom untuk Request Item/Lokasi Baru (Wajib Nullable)
            'nama_barang_baru' => 'nullable|string|max:255',
            'lokasi_baru'      => 'nullable|string|max:255',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Cek apakah user request item/lokasi baru.
        $isNewRequest = (!empty($request->nama_barang_baru) || !empty($request->lokasi_baru));

        // 2. VALIDASI RELASI LAMA (Hanya dijalankan jika user TIDAK request item/lokasi baru)
        if (!$isNewRequest) {

            // Validasi: pastikan id_lokasi dan id_item diisi (jika tidak request baru, ini wajib diisi)
            $request->validate([
                'id_lokasi' => 'required|exists:lokasi,id_lokasi',
                'id_item'   => 'required|exists:items,id_item',
            ]);

            // Pastikan Anda sudah mengimpor ListLokasi atau menggunakan namespace penuh
            $validRelasi = ListLokasi::where('id_lokasi', $request->id_lokasi)
                ->where('id_item', $request->id_item)
                ->exists();

            if (!$validRelasi) {
                return back()->withErrors(['id_item' => 'Barang tidak tersedia di lokasi yang dipilih.'])->withInput();
            }
        }

        // 3. HANDLE FOTO UPLOAD
        $fotoPath = null;
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
            $fotoPath = $path;
        }

        // 4. SIAPKAN DATA PENGADUAN
        $pengaduanData = [
            'nama_pengaduan' => $validated['nama_pengaduan'],
            'deskripsi'      => $validated['deskripsi'],
            'id_user'        => auth()->id(),
            'tgl_pengajuan'  => now()->toDateString(),
            'status'         => 'Diajukan',
            'foto'           => $fotoPath,
            // 🆕 CLOSED-LOOP: Tambah priority
           
        ];

        // Tentukan ID Item/Lokasi untuk tabel Pengaduan
        if (!$isNewRequest) {
            // Jika memilih dari dropdown yang sudah ada
            $pengaduanData['id_item']   = $request->id_item;
            $pengaduanData['id_lokasi'] = $request->id_lokasi;
        } else {
            // FIX: JIKA REQUEST BARU, SET ID ITEM DAN ID LOKASI SECARA EKSPLISIT KE NULL
            // Ini memastikan kolom disertakan dalam query INSERT dengan nilai NULL,
            // sehingga menghindari error "doesn't have a default value"
            $pengaduanData['id_item']   = null;
            $pengaduanData['id_lokasi'] = null;

            // Opsional: Jika Anda punya kolom 'lokasi' (string) di tabel pengaduan,
            // isi dengan teks request baru agar admin bisa langsung melihatnya di detail pengaduan
            if (!empty($request->lokasi_baru)) {
                 $pengaduanData['lokasi'] = $request->lokasi_baru;
            }
        }

        // 5. SIMPAN PENGADUAN (Ticket number auto-generate via Model boot method)
        $pengaduan = Pengaduan::create($pengaduanData);

        // 6. BUAT RECORD TEMPORARY ITEM JIKA ADA REQUEST BARU
        if ($isNewRequest) {
            TemporaryItem::create([
                'id_user'          => auth()->id(),
                'id_pengaduan'     => $pengaduan->id_pengaduan,
                'id_item'          => $request->id_item ?? null,
                'nama_barang_baru' => $request->nama_barang_baru ?? null,
                'lokasi_baru'      => $request->lokasi_baru ?? null,
                'status'           => 'pending',
            ]);
        }

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil diajukan. Ticket Number: ' . $pengaduan->ticket_number);
    }

    public function approveRequest($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Tambahkan lokasi baru jika ada
        if (!empty($pengaduan->lokasi_baru)) {
            $lokasi = Lokasi::create([
                'nama_lokasi' => $pengaduan->lokasi_baru,
            ]);
            $pengaduan->id_lokasi = $lokasi->id_lokasi;
        }

        // Tambahkan barang baru jika ada
        if (!empty($pengaduan->nama_barang_baru)) {
            $item = Item::create([
                'nama_item' => $pengaduan->nama_barang_baru,
            ]);
            $pengaduan->id_item = $item->id_item;
        }

        // Perbarui status pengaduan menjadi diterima
        $pengaduan->status = 'Diterima';
        $pengaduan->save();

        return redirect()->route('admin.pengaduan.index')->with('success', 'Permintaan berhasil disetujui.');
    }
}
