<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('temporary_item', function (Blueprint $table) {
            $table->dropColumn('jumlah');
        });
    }

    public function down(): void
    {
        Schema::table('temporary_item', function (Blueprint $table) {
            $table->integer('jumlah')->nullable();
        });
    }
};
