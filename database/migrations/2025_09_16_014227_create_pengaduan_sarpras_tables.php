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
        // Lokasi
        Schema::create('lokasi', function (Blueprint $table) {
            $table->id('id_lokasi');
            $table->string('nama_lokasi');
            $table->timestamps();
        });

        // Items
        Schema::create('items', function (Blueprint $table) {
            $table->id('id_item');
            $table->string('nama_item');
            $table->integer('stok')->default(0);
            $table->timestamps();
        });

        // List Lokasi (relasi lokasi dan item)
        Schema::create('list_lokasi', function (Blueprint $table) {
            $table->id('id_list');
            $table->unsignedBigInteger('id_lokasi');
            $table->unsignedBigInteger('id_item');
            $table->integer('jumlah')->default(0);
            $table->timestamps();

            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('cascade');
            $table->foreign('id_item')->references('id_item')->on('items')->onDelete('cascade');
        });


        // Petugas
        Schema::create('petugas', function (Blueprint $table) {
            $table->id('id_petugas');
            $table->string('nama_petugas');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('petugas');
            $table->timestamps();
        });

        // Pengaduan
      // database/migrations/xxxx_xx_xx_create_pengaduan_table.php
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->string('nama_pengaduan');
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['Diajukan','Disetujui','Ditolak','Diproses','Selesai'])->default('Diajukan');

            // foreign key ke tabel users
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_petugas')->nullable();

            // foreign key ke tabel items (INI YANG KURANG DI KAMU)
            $table->unsignedBigInteger('id_item');

            // tanggal & saran
            $table->date('tgl_pengajuan')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->text('saran_petugas')->nullable();

            // relasi
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_item')->references('id_item')->on('items')->onDelete('cascade');

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
        Schema::dropIfExists('petugas');
        Schema::dropIfExists('temporary_item');
        Schema::dropIfExists('list_lokasi');
        Schema::dropIfExists('items');
        Schema::dropIfExists('lokasi');
    }
};
