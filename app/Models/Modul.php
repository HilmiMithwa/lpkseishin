<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    //

    protected $table = 'modul';
    protected $primaryKey = 'id_modul';

    protected $fillable = [
        'nama_modul',
        'kode_modul',
        'teori',
        'praktik',
        'module_description',
        'id_mapel',
        'id_rps'
    ];

    public function mapel() {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

    public function rps() {
        return $this->belongsTo(Rps::class, 'id_rps', 'id_rps');
    }
}
