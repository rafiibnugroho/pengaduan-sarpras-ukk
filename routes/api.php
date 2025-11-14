<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PengaduanApiController;
use App\Http\Controllers\Api\LokasiApiController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Api\TemporaryItemController; // ✅ CONTROLLER BARU

// ================= TEST CONNECTION =================
Route::get('/test-connection', function () {
    return response()->json(['message' => 'API connected!']);
});

// ================= AUTH =================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ================= PROTECTED ROUTES =================
Route::middleware('auth:sanctum')->group(function () {

    // ========== AUTH ==========
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', fn (Request $request) => response()->json($request->user()));
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // ========== TEMPORARY ITEMS ==========  CONTROLLER BARU
    Route::get('/temporary-items', [TemporaryItemController::class, 'index']);
    Route::post('/temporary-items', [TemporaryItemController::class, 'store']);
    Route::get('/temporary-items/{id}', [TemporaryItemController::class, 'show']);
    Route::put('/temporary-items/{id}/approve', [TemporaryItemController::class, 'approve']);
    Route::put('/temporary-items/{id}/reject', [TemporaryItemController::class, 'reject']);
    Route::get('/my-temporary-items', [TemporaryItemController::class, 'userItems']);

    // ========== DROPDOWN DATA ==========
    Route::get('/pengaduan-list', function (Request $request) {
        $pengaduan = \App\Models\Pengaduan::where('id_user', $request->user()->id)
            ->select('id_pengaduan', 'nama_pengaduan', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $pengaduan
        ]);
    });

    Route::get('/items-list', function () {
        $items = \App\Models\Item::select('id_item', 'nama_item')->get();
        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    });

    // ========== PENGADUAN ==========
    Route::get('/pengaduan', [PengaduanApiController::class, 'index']);
    Route::get('/pengaduan/{id}', [PengaduanApiController::class, 'show']);
    Route::post('/pengaduan', [PengaduanApiController::class, 'store']);
    Route::put('/pengaduan/{id}', [PengaduanApiController::class, 'update']);
    Route::delete('/pengaduan/{id}', [PengaduanApiController::class, 'destroy']);
    Route::post('/request-baru', [PengaduanApiController::class, 'requestBaru']);

    // ========== USER ==========
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::post('/users', [UserController::class, 'store']);

    // ========== LOKASI & ITEM ==========
    Route::get('/lokasi', [LokasiApiController::class, 'index']);
    Route::get('/lokasi/{id}/items', [LokasiApiController::class, 'getItems']);

    Route::get('/storage/pengaduan/{filename}', function ($filename) {
    $path = storage_path('app/public/pengaduan/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('pengaduan.image');

Route::get('/images/pengaduan/{filename}', function ($filename) {
    $path = storage_path('app/public/pengaduan/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    $file = file_get_contents($path);
    $type = mime_content_type($path);

    return Response::make($file, 200)
        ->header('Content-Type', $type)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET')
        ->header('Cache-Control', 'public, max-age=31536000');
})->name('pengaduan.image');
});
