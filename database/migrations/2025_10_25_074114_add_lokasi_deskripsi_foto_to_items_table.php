<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi (tambah kolom ke tabel items)
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Tambah kolom baru sesuai desain UKK
            $table->string('lokasi')->nullable()->after('nama_item');
            $table->text('deskripsi')->nullable()->after('lokasi');
            $table->string('foto')->nullable()->after('deskripsi');
        });
    }

    /**
     * Balikkan migrasi (hapus kolom kalau di-rollback)
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['lokasi', 'deskripsi', 'foto']);
        });
    }
};
