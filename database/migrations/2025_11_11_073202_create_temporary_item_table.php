<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('temporary_item', function (Blueprint $table) {
            $table->id('id_temp');
            $table->unsignedBigInteger('id_user'); // siapa yang request
            $table->unsignedBigInteger('id_pengaduan')->nullable(); // nanti relasi ke pengaduan (opsional)
            $table->unsignedBigInteger('id_item')->nullable(); // kalau request update existing (tidak wajib)
            // nama item baru jika user request item baru
            $table->string('nama_barang_baru')->nullable();
            // nama lokasi baru jika user request lokasi baru
            $table->string('lokasi_baru')->nullable();
            $table->integer('jumlah')->nullable(); // optional
            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->text('note_admin')->nullable(); // catatan admin
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_pengaduan')->references('id_pengaduan')->on('pengaduan')->onDelete('cascade');
            // id_item foreign key optional
            $table->foreign('id_item')->references('id_item')->on('items')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temporary_item');
    }
};
