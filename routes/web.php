<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;

// ================= ADMIN Controllers =================
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\TemporaryItemController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;

// ================= PETUGAS Controllers =================
use App\Http\Controllers\Petugas\PengaduanController as PetugasPengaduanController;
use App\Http\Controllers\Petugas\DashboardController;
use App\Http\Controllers\Petugas\PengaturanController;

// ================= PENGGUNA Controllers =================
use App\Http\Controllers\Pengguna\PengaduanController as UserPengaduanController;
use App\Http\Controllers\Pengguna\ProfileController;

// ================= LANDING PAGE =================
Route::get('/', [HomeController::class, 'landing'])->name('landing');

// ================= AUTH ROUTES =================
Auth::routes(['verify' => false]);

// ================= GOOGLE AUTH =================
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('auth/google/unlink', [GoogleController::class, 'unlinkGoogle'])->name('google.unlink');
Route::get('auth/google/link', [GoogleController::class, 'linkGoogle'])->name('google.link');
Route::get('auth/google/link/callback', [GoogleController::class, 'handleGoogleLink'])->name('google.link.callback');

// ================= CLOSED-LOOP TICKET SYSTEM ROUTES =================
Route::middleware(['auth'])->group(function () {
    // Public ticket status check (bisa diakses tanpa login untuk track status)
    Route::get('/ticket/{ticket_number}', [UserPengaduanController::class, 'showPublic'])
        ->name('ticket.status');

    // Rating & feedback setelah selesai
    Route::post('/pengaduan/{id}/rating', [UserPengaduanController::class, 'submitRating'])
        ->name('pengaduan.rating');

    // Update progress dengan timestamp (Admin)
    Route::post('/admin/pengaduan/{id}/update-progress', [AdminPengaduanController::class, 'updateProgress'])
        ->name('admin.pengaduan.updateProgress');

    // Update progress dengan timestamp (Petugas)
    Route::post('/petugas/pengaduan/{id}/update-progress', [PetugasPengaduanController::class, 'updateProgress'])
        ->name('petugas.pengaduan.updateProgress');
});

// ================= ADMIN =================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('items', ItemController::class);
    Route::resource('lokasi', LokasiController::class);

    // Route untuk temporary items
    Route::resource('temporary', TemporaryItemController::class);
    Route::put('/temporary/{id}/approve-ajax', [TemporaryItemController::class, 'approveAjax'])->name('temporary.approve.ajax');
    Route::put('/temporary/{id}/reject-ajax', [TemporaryItemController::class, 'rejectAjax'])->name('temporary.reject.ajax');

    Route::get('laporan', [\App\Http\Controllers\Admin\PengaduanController::class, 'laporan'])
        ->name('laporan.index');
    Route::get('laporan/export-pdf', [\App\Http\Controllers\Admin\PengaduanController::class, 'exportPdf'])
        ->name('laporan.exportPdf');
    Route::get('/pengaturan', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/pengaturan/update-password', [\App\Http\Controllers\Admin\SettingController::class, 'updatePassword'])->name('settings.updatePassword');

    // Route untuk pengaduan
    Route::resource('pengaduan', AdminPengaduanController::class);
    Route::get('/pengaduan/{id}', [AdminPengaduanController::class, 'show'])->name('pengaduan.show');
    Route::post('/pengaduan/{id}/approve-request', [AdminPengaduanController::class, 'approveRequest'])->name('pengaduan.approveRequest');
});

// ================= PETUGAS =================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('pengaduan', [PetugasPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('pengaduan/{id}', [PetugasPengaduanController::class, 'show'])->name('pengaduan.show');
    Route::post('pengaduan/{id}/update-status', [PetugasPengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/{id}', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::post('/pengaturan/update-password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.updatePassword');
    Route::delete('pengaduan/{id}', [PetugasPengaduanController::class, 'destroy'])->name('pengaduan.destroy');

    // 🔄 CLOSED-LOOP: Upload bukti perbaikan
    Route::post('/pengaduan/{id}/upload-bukti', [PetugasPengaduanController::class, 'uploadBukti'])
        ->name('pengaduan.uploadBukti');
});

// ================= PENGGUNA =================
Route::middleware(['auth', 'role:pengguna'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\Pengguna\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [App\Http\Controllers\Pengguna\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [App\Http\Controllers\Pengguna\ProfileController::class, 'changePassword'])->name('profile.password');
    Route::get('/pengaduan', [UserPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [UserPengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [UserPengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('pengaduan/{id}/edit', [UserPengaduanController::class, 'edit'])->name('pengaduan.edit');
    Route::get('pengaduan/{id}', [UserPengaduanController::class, 'show'])->name('pengaduan.show');
    Route::put('pengaduan/{id}', [UserPengaduanController::class, 'update'])->name('pengaduan.update');
    Route::post('pengaduan/{id}/approve-request', [\App\Http\Controllers\Pengguna\PengaduanController::class, 'approveRequest'])->name('pengaduan.approveRequest');

    // 🔄 CLOSED-LOOP: Track ticket status
    Route::get('/pengaduan/ticket/{ticket_number}', [UserPengaduanController::class, 'trackTicket'])
        ->name('pengaduan.track');

    // 🔄 CLOSED-LOOP: Submit feedback setelah selesai
    Route::post('/pengaduan/{id}/feedback', [UserPengaduanController::class, 'submitFeedback'])
        ->name('pengaduan.feedback');

    // AJAX untuk ambil barang berdasarkan lokasi
    Route::get('/get-items/{id}', [UserPengaduanController::class, 'getItemsByLokasi'])->name('get.items');
    Route::get('/get-items/{id_lokasi}', [UserPengaduanController::class, 'getItemsByLokasi'])
        ->name('get.items');
});

// ================= HOME =================
Route::middleware(['auth'])->get('/home', [HomeController::class, 'index'])->name('home');

// AJAX Stats untuk semua user yang terauth
Route::middleware(['auth'])->get('/home/stats', function () {
    try {
        $data = [
            'total'    => \App\Models\Pengaduan::count(),
            'selesai'  => \App\Models\Pengaduan::where('status', 'Selesai')->count(),
            'proses'   => \App\Models\Pengaduan::where('status', 'Diproses')->count(),
            'diajukan' => \App\Models\Pengaduan::where('status', 'Diajukan')->count(),
        ];
        return response()->json($data);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => 'Gagal memuat statistik',
            'message' => $e->getMessage(),
        ], 500);
    }
})->name('home.stats');

// 🔄 CLOSED-LOOP: Public API untuk check ticket status (untuk embed di website sekolah)
Route::get('/api/ticket/{ticket_number}/status', function ($ticket_number) {
    try {
        $pengaduan = \App\Models\Pengaduan::where('ticket_number', $ticket_number)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'ticket_number' => $pengaduan->ticket_number,
                'nama_pengaduan' => $pengaduan->nama_pengaduan,
                'status' => $pengaduan->status,
                'priority' => $pengaduan->priority,
                'created_at' => $pengaduan->tgl_pengajuan,
                'completed_at' => $pengaduan->selesai_at,
                'rating' => $pengaduan->rating,
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ticket tidak ditemukan'
        ], 404);
    }
})->name('api.ticket.status');
