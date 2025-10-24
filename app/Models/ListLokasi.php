<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListLokasi extends Model
{
    use HasFactory;

    protected $table = 'list_lokasi';
    protected $primaryKey = 'id_list';
    protected $fillable = ['id_lokasi', 'id_item', 'jumlah'];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
}
