<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->string('lokasi_baru')->nullable()->after('id_lokasi');
            $table->string('nama_barang_baru')->nullable()->after('id_item');
            $table->integer('jumlah')->nullable()->after('nama_barang_baru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->dropColumn(['lokasi_baru', 'nama_barang_baru', 'jumlah']);
        });
    }
};
