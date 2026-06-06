<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';
    protected $primaryKey = 'id_tugas';

    protected $fillable = [
        'judul_tugas',
        'deskripsi_tugas',
        'waktu_pengumpulan',
        'status_tugas',
        'id_rps'
    ];

    public function rps() {
        return $this->belongsTo(Rps::class, 'id_rps', 'id_rps');
    }

    // Relasi ke Modul
    public function modul() {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }

    // Relasi ke Pengiriman Tugas
    public function submissions() { 
        return $this->hasMany(Pengiriman_Tugas::class, 'id_tugas', 'id_tugas');
    }
}
