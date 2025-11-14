<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            // Kolom untuk closed-loop system (TANPA QR CODE)
            $table->string('ticket_number')->unique()->nullable()->after('id_pengaduan');
            $table->enum('priority', ['low', 'medium', 'high', 'emergency'])->default('medium')->after('status');
            $table->integer('rating')->nullable()->after('status');
            $table->text('feedback')->nullable()->after('rating');

            // Track waktu setiap status
            $table->timestamp('disetujui_at')->nullable()->after('tgl_pengajuan');
            $table->timestamp('diproses_at')->nullable()->after('disetujui_at');
            $table->timestamp('selesai_at')->nullable()->after('diproses_at');
        });
    }

    public function down()
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->dropColumn([
                'ticket_number',
                'priority',
                'rating',
                'feedback',
                'disetujui_at',
                'diproses_at',
                'selesai_at'
            ]);
        });
    }
};
