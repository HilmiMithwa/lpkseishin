<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'id_mapel';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'deskripsi_mapel',
        'id_guru',  
        'jp',
        'jumlah_modul',
        'status'
    ];

    public function guru() {
        return $this->belongsTo(User::class, 'id_guru');
    }

    public function rps() {
        return $this->hasMany(Rps::class, 'id_mapel', 'id_mapel');
    }

    public function modul() {
        return $this->hasMany(Modul::class, 'id_mapel', 'id_mapel');
    }

    

}
