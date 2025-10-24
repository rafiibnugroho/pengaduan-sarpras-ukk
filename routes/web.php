<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;

// ================= ADMIN Controllers =================
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;

// ================= PETUGAS Controllers =================
use App\Http\Controllers\Petugas\PengaduanController as PetugasPengaduanController;
use App\Http\Controllers\Petugas\DashboardController;

// ================= PENGGUNA Controllers =================
use App\Http\Controllers\Pengguna\PengaduanController as UserPengaduanController;
use App\Http\Controllers\Pengguna\ProfileController;

Auth::routes();

Auth::routes(['verify' => false]);


// ================= ROOT =================
Route::get('/', function () {
    return redirect()->route('login');
});

// ================= GOOGLE AUTH =================
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('auth/google/unlink', [GoogleController::class, 'unlinkGoogle'])->name('google.unlink');
Route::get('auth/google/link', [GoogleController::class, 'linkGoogle'])->name('google.link');
Route::get('auth/google/link/callback', [GoogleController::class, 'handleGoogleLink'])->name('google.link.callback');

// ================= ADMIN =================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // ✅ dashboard admin
    })->name('dashboard');

       Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('items', ItemController::class);
    Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
    Route::get('/lokasi/create', [LokasiController::class, 'create'])->name('lokasi.create');
    Route::post('/lokasi', [LokasiController::class, 'store'])->name('lokasi.store');
    Route::get('/lokasi/{id}/edit', [LokasiController::class, 'edit'])->name('lokasi.edit');
    Route::put('/lokasi/{id}', [LokasiController::class, 'update'])->name('lokasi.update');
    Route::delete('/lokasi/{id}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');
    Route::get('laporan', [\App\Http\Controllers\Admin\PengaduanController::class, 'laporan'])
        ->name('laporan.index');
    Route::get('laporan/export-pdf', [\App\Http\Controllers\Admin\PengaduanController::class, 'exportPdf'])
    ->name('laporan.exportPdf');
    Route::resource('pengaduan', AdminPengaduanController::class);

    // kalau butuh laporan admin, bisa tambahkan:
    // Route::get('laporan', [AdminPengaduanController::class, 'laporan'])->name('laporan.index');
});

// ================= PETUGAS =================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('pengaduan', [PetugasPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('pengaduan/{id}', [PetugasPengaduanController::class, 'show'])->name('pengaduan.show');
    Route::post('pengaduan/{id}/update-status', [PetugasPengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');
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
    Route::get('/home/stats', [HomeController::class, 'stats'])->name('home.stats');
     // AJAX untuk ambil barang berdasarkan lokasi
    Route::get('/get-items/{id}', [UserPengaduanController::class, 'getItemsByLokasi'])->name('get.items');

    Route::get('/get-items/{id_lokasi}', [UserPengaduanController::class, 'getItemsByLokasi'])
        ->name('get.items');
});

// ================= HOME =================
Route::get('/home', [HomeController::class, 'index'])->name('home');
