<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rps extends Model
{
    use HasFactory;

    protected $table = 'rps';
    protected $primaryKey = 'id_rps';

    protected $fillable = [
        'pertemuan',
        'deskripsi_rps',
        'certification_target',
        'schedule',
        'total_duration',
        'id_mapel'
    ];

    public function mapel() {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

    public function modul()
    {
        return $this->hasMany(Modul::class, 'id_rps', 'id_rps');
    }
}
