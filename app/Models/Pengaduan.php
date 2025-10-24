<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';
    protected $primaryKey = 'id_pengaduan';

    protected $fillable = [
    'nama_pengaduan',
    'deskripsi',
    'lokasi',
    'id_lokasi',
    'status',
    'id_user',
    'id_item',
    'foto',
    'tgl_pengajuan',
    'tgl_selesai',
    'saran_petugas',
    ];

    /* -------------------------
       🔗 RELASI MODEL
    --------------------------*/

    // Relasi ke User (pelapor)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Relasi ke Petugas (yang menangani)
    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas', 'id');
    }

    // Relasi ke Item
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }

    // Relasi ke Lokasi (melalui Item)
public function lokasi()
{
    return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
}
}
