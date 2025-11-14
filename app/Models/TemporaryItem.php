<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryItem extends Model
{
    use HasFactory;

    protected $table = 'temporary_item';
    public $incrementing = true;
    protected $primaryKey = 'id_temp';
    protected $fillable = [
        'id_temp',
        'id_user',
        'id_pengaduan',
        'id_item',
        'nama_barang_baru',
        'lokasi_baru',
        'status',
        'note_admin'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user');
    }

    public function pengaduan()
    {
        return $this->belongsTo(\App\Models\Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }

    public function item()
    {
        return $this->belongsTo(\App\Models\Item::class, 'id_item', 'id_item');
    }
}
