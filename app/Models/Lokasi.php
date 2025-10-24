<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ListLokasi;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';
    protected $primaryKey = 'id_lokasi';
    protected $fillable = ['nama_lokasi'];

     // relasi many-to-many ke Item
      public function items()
{
    return $this->belongsToMany(
        Item::class,
        'list_lokasi',
        'id_lokasi',
        'id_item'
    )->withPivot('jumlah')->withTimestamps();
}

}
