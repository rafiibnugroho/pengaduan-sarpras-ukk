<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';
    protected $primaryKey = 'id_lokasi';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = ['nama_lokasi'];

    public function items()
{
    return $this->belongsToMany(
        Item::class,
        'list_lokasi', // ✅ kembali seperti aslinya
        'id_lokasi',
        'id_item'
    )->withTimestamps();
}
}
