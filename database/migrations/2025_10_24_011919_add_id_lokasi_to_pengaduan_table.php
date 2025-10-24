<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pengaduan', function (Blueprint $table) {
        if (!Schema::hasColumn('pengaduan', 'id_lokasi')) {
            $table->unsignedBigInteger('id_lokasi')->nullable()->after('id_item');
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('set null');
        }
    });
}

public function down()
{
    Schema::table('pengaduan', function (Blueprint $table) {
        $table->dropForeign(['id_lokasi']);
        $table->dropColumn('id_lokasi');
    });
}

};
