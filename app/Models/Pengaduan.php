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
    'id_lokasi',
    'status',
    'id_user',
    'id_item',
    'foto',
    'bukti_selesai',
    'tgl_pengajuan',
    'tgl_selesai',
    'saran_petugas',
    'id_petugas',
    'lokasi_baru',
    'nama_barang_baru',
    'ticket_number',
    // TAMBAHAN UNTUK CLOSED-LOOP
    'priority',
    'rating',
    'feedback',
    'qr_code',
    'disetujui_at',
    'diproses_at',
    'selesai_at'
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

    // app/Models/Pengaduan.php
public function temporaryItems()
{
    return $this->hasMany(TemporaryItem::class, 'pengaduan_id');
}

    // Relasi ke Lokasi (melalui Item)
public function lokasi()
{
    return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
}
/* -------------------------
       🆕 CLOSED-LOOP FEATURES
    --------------------------*/

    // Auto-generate ticket number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengaduan) {
            if (empty($pengaduan->ticket_number)) {
                   $count = static::count() + 1;
                $pengaduan->ticket_number = 'SRP-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // Status tracker methods
    public function getStatusTimelineAttribute()
    {
        return [
            'Diajukan' => $this->tgl_pengajuan,
            'Disetujui' => $this->disetujui_at,
            'Diproses' => $this->diproses_at,
            'Selesai' => $this->selesai_at
        ];
    }

    // Check if completed
    public function getIsCompletedAttribute()
    {
        return $this->status === 'Selesai' && !empty($this->selesai_at);
    }

    // Get completion time in days
    public function getCompletionTimeAttribute()
    {
        if ($this->is_completed) {
            return $this->tgl_pengajuan->diffInDays($this->selesai_at);
        }
        return null;
    }

}
