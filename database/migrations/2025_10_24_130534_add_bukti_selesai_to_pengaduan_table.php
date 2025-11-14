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
        $table->string('bukti_selesai')->nullable()->after('foto');
    });
}

public function down(): void
{
    Schema::table('pengaduan', function (Blueprint $table) {
        $table->dropColumn('bukti_selesai');
    });
}

};
