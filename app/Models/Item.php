<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ListLokasi;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $primaryKey = 'id_item';
    protected $fillable = ['nama_item','stok', 'deskripsi', 'foto'];

   public function lokasi()
{
    return $this->belongsToMany(Lokasi::class, 'list_lokasi', 'id_item', 'id_lokasi')
                ->withTimestamps(); // Hapus ->withTimestamps()
}

}
