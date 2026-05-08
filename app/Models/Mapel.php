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
        'id_guru',
        'jp',
        'jumlah_modul',
        'status'
    ];

    public function guru() {
        return $this->belongsTo(User::class, 'id_guru');
    }

}
