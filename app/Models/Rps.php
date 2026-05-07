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
        'kode_kelas',
        'id_mapel'
    ];

    public function mapel() {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

}
