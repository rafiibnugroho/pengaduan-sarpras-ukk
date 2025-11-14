<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE pengaduan
            MODIFY COLUMN status
            ENUM('Diajukan','Diterima','Ditolak','Diproses','Selesai')
            DEFAULT 'Diajukan'
        ");
    }

    public function down(): void
    {
        // biarkan tetap bisa rollback tanpa error
        DB::statement("
            ALTER TABLE pengaduan
            MODIFY COLUMN status
            ENUM('Diajukan','Diterima','Ditolak','Diproses','Selesai')
            DEFAULT 'Diajukan'
        ");
    }
};
